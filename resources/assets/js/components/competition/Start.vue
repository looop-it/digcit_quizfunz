<template>
    <div id="main_container" class="container">
        <div class="row">
            <div class="col-md-12 question-order">
                <b>問題 {{ question.id }}</b>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 question-title">
                <b :class="titleFontClass(question.name)">{{ question.name }}</b>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 question-progress">
                <div class="row">
                    <div class="col-md-11">
                        <div class="progress small-progress">
                            <div class="progress-bar" role="progressbar" :aria-valuenow="completePercent" aria-valuemin="0" aria-valuemax="100" :style="'width:' + completePercent  + '%'">
                                <span class="sr-only">{{completePercent}}% Complete</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1 counter">
                        {{ question.id }}/{{ totalQuestions }}
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
             <div class="col-md-offset-1 col-md-2">
            </div>
            <div class="col-md-6 message-container text-center">
                <span v-show="showError">
                    {{ errorText }}
                </span>
            </div>
            <div class="col-md-2 question-timer text-right">
                <b>計時</b> <span class="countdown">{{ remainSeconds }}</span>
            </div>
        </div>

        <div class="row question-options">
            <div v-for="(option, index) in question.options"
                :key="index"
                :class="'col-md-6 option-container' + fontClass(option) + ' ' + optionClass(option)"
                @click="setAnswer(option)"
            >
                {{ option }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <input type="button" class="submit" @click="submitAnswer(false)">
            </div>
        </div>

    </div>
</template>

<script>
import { captureMessage } from '@sentry/browser'
import Stat from '../mixins/stat.js'
import ResponseTime from '../mixins/response_time.js'

export default {
    mixins: [Stat, ResponseTime],

    created() {
        this.sendStats()
        this.initialize()
    },

    computed: {
        isEmptyAnswer() {
            return _.isEmpty(this.answer);
        },

        submitText() {
            return this.submitting ? "提交中..." : "提交"
        },

        completePercent() {
            let percent = parseInt((this.question.id / this.totalQuestions) * 100);

            return percent;
        }
    },

    data() {
        return {
            'page': 'competition-start',
            'isLoading': false,
            'showError': false,
            'errorText': '請選擇答案',
            'submitting': false,
            'questionTimer': null,
            'remainSeconds': "--",
            'answer': null,
            'correctAnswer': null,

            // Paper
            'secondsPerQuestion': 0,
            'totalQuestions': 0,
            'paperStartTime': '--',
            'paperStartTimeOffset': 0,
            
            // Question
            'question': {
                'id': 0,
                'multiple_select': false,
                'paper_question_id': 1,
                'name': '--',
                'options': [
                    '--',
                    '--',
                    '--',
                    '--',
                ],
                'start_time': '2018-12-13 12:39:00',
                'start_time_offset': 0
            }
        }
    },

    methods: {
        initialize() {
            axios.post("/api/initialize")
                .then((response) => {
                    let data = response.data

                    if (data.status == 200) {
                        // Initialize data
                        this.paperStartTime = data.paper_start_time
                        this.paperStartTimeOffset = data.paper_start_time_offset
                        this.secondsPerQuestion = data.seconds_per_questions
                        this.totalQuestions = data.questions_per_paper

                        this.getQuestion()

                        return
                    }
                    
                    if (data.status == 404) {
                        // No assigned paper.
                        captureMessage(`Check paper availability. Error: ${data.message}`)

                        // window.location.href = '/';

                        return
                    }

                    this.redirectTo()
                })
                .catch((error) => {
                    console.log(error.message)
                });
        },

        getQuestion() {
            let startTime = moment()

            axios.post("/api/question")
                .then((response) => {
                    // Success
                    if (response.data.status == 200) {
                        this.resetAnswer()
                        this.resetCorrectAnswer()

                        this.setQuestion(response.data.question)
                        this.setQuestionTimer()

                        this.submitting = false

                        return
                    }

                    // No processing paper || Paper timeout || no more question
                    this.redirectTo();
                })
                .catch((error) => {
                    console.log(error.message)
                })
                .then(() => {
                    this.sendResponseTime(startTime)
                })
        },

        setQuestion(data) {
            // Random the order of options
            data.options  = _.shuffle(data.options);

            this.question = data;
        },

        setAnswer(option) {
            this.resetError()

            this.answer = option;
        },

        submitAnswer(force) {
            if (this.submitting) {
                return
            }

            if (force == false && this.answer == null) {
                this.setError("請選擇答案")

                return
            }
            
            this.submitting = true

            this.resetError()

            axios.post("/api/question/submit", {
                'paper_question_id': this.question.paper_question_id,
                'answer': force ? null : (this.answer ? [this.answer] : null)
            }).then((response) => {
                this.clearQuestionTimer()
                
                let data = response.data

                // Success.
                if (data.status == 200) {
                    

                    this.setCorrectAnswer(data.correct_answer)

                    if (!data.finished) {
                        // Delay for showing correct answer.
                        setTimeout(() => {
                            this.getQuestion()
                        }, 500)

                        return
                    }
                }

                // Paper finished || Paper id cache cleared by clean-timeout job || Paper timeout
                this.redirectTo();
            }).catch((error) => {
                this.submitting = false

                if (error.message == 'Network Error') {
                    this.setError("請檢查網絡連線")

                    return
                }
                
                if (error.response.status == 422) {
                    let data = error.response.data

                    if (data.status == 422 && data.message == 'Invalid request data.') {
                        this.clearQuestionTimer()

                        this.getQuestion()

                        return
                    }
                }

                this.setError("發生錯誤，請重試")
            })
        },

        setCorrectAnswer(answer) {
            this.correctAnswer = answer
        },

        resetCorrectAnswer() {
            this.correctAnswer = null
        },

        resetAnswer() {
            this.answer = null;
        },

        setQuestionTimer() {
            this.resetRemainSeconds()

            this.questionTimer = setInterval(() => {
                this.remainSeconds = this.remainSeconds - 1

                if (this.remainSeconds < 0) {
                    this.remainSeconds = 0
                }
            }, 1000)
        },

        resetRemainSeconds() {
            this.remainSeconds = this.secondsPerQuestion - this.question.start_time_offset;
            
            if (this.remainSeconds < 0) {
                this.remainSeconds = 0
            }
        },

        clearQuestionTimer() {
            clearInterval(this.questionTimer);
        },
        
        redirectTo() {
            window.location.href = '/competition/result';
        },

        titleFontClass(text) {
            let length = text.length;
            let size = 30;

            if (length > 70) {
                size = 25;
            }

            return ' title-font-size-' + size;
        },

        fontClass(option) {
            return ' option-font-size-' + this.getOptimalFontSize(option)
        },

        optionClass(option) {
            if (this.correctAnswer) {
                if (this.correctAnswer == option) {
                    return "correct";
                } else {
                    if (this.answer == option) {
                        return "wrong";
                    }
                }
            }

            if (this.answer == option) {
                return "selected";
            }
        },

        getOptimalFontSize(text) {
            // let length = text.length;

            // if (length <= 11) {
            //     return 25;
            // }

            // if (length > 11 && length <= 13) {
            //     return 20;
            // }

            // if (length > 13 && length <= 16) {
            //     return 18;
            // }

            // if (length > 16 && length <= 19) {
            //     return 16;
            // }

            // return 14;

            return 18;
        },

        setError(message) {
            this.showError = true
            this.errorText = message
        },

        resetError() {
            this.showError = false
        }
    },

    watch: {
        // whenever question changes, this function will be executed.
        remainSeconds: function (newSeconds, oldSeconds) {
            if (newSeconds <= 0) {
                console.log('auto submit answer');

                this.submitAnswer(true)
            }
        }
    },
}
</script>

<style>
html, body {
    background-color: black !important;
}
</style>

<style lang="scss" scoped>

$question-text-color : #3F4A50;

#main_container {
    width: 800px;
    height: 600px;
    background: url("/images/competition/bg.jpg") no-repeat;

    .question-order {
        color: black;
        font-size: 22px;
        padding: 25px 0 0 360px;
        height: 85px;
    }

    .question-title {
        color: $question-text-color;
        padding: 30px 110px;
        height: 238px;
    }

    .title-font-size-25 {
        font-size: 25px;
    }

    .title-font-size-30 {
        font-size: 30px;
    }

    .question-progress {
        padding: 0 110px;
        height: 20px;

        .progress-bar {
            background: #231f20;
        }

        .small-progress {
            height: 5px !important;
        }

        .counter {
            position: absolute;
            right: 90px;
            bottom: 8px;
            font-weight: bold;
        }
    }

    .message-container {
        color: red;
        font-size: 20px;
        height: 41px;
        padding: 5px 0 0 0;

        @keyframes color-change {
            0% { color: red; }
            50% { color: white; }
            100% { color: red; }
        }
        
        span {
            -webkit-animation: color-change 1s infinite;
            -moz-animation: color-change 1s infinite;
            -o-animation: color-change 1s infinite;
            -ms-animation: color-change 1s infinite;
            animation: color-change 1s infinite;
        }
    }

    .question-timer {
        color: #231f20;
        font-size: 20px;
        padding: 5px 13px 0 0;
        height: 40px;
        background: #fff46d;
        width: 110px;

        .countdown {
            background-color: rgba(255,255,255,0.85);
            color: #231f20;
            padding: 0 6px;
            border-radius: 5px;
            margin: 0 1px;
        }
    }

    .question-options {
        height: 144px;

        .option-container {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 382px;
            height: 78px;
            margin: 0 8px;

            text-align: center;

            color: $question-text-color;
            background: url("/images/competition/option.png") no-repeat;

            cursor: pointer;
        }

        .selected {
            background: url("/images/competition/option_active.png") no-repeat !important;
        }

        .correct {
            background: url("/images/competition/correct_answer.png") no-repeat !important;
        }

        .wrong {
            background: url("/images/competition/wrong_answer.png") no-repeat !important;
        }

        .option-font-size-25 {
            font-size: 25px;
            padding: 18px 20px;
        }

        .option-font-size-20 {
            font-size: 20px;
            padding: 22px 20px;
        }

        .option-font-size-18 {
            font-size: 18px;
            padding: 0 40px;
        }

        .option-font-size-16 {
            font-size: 16px;
            padding: 18px 40px;
        }

        .option-font-size-14 {
            font-size: 14px;
            padding: 0 40px;
        }
    }

    .submit {
        background: url('/images/competition/submit.png') no-repeat;
        width: 135px;
        height: 53px;
        border: none;

        &:focus{
            outline: none;
        }
    }
}



.urgent {
    font-weight: bold;
    color:red;
}

</style>


