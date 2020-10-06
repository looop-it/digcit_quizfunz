<template>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <img :src="'/images/competition/mobile/header.png'" class="img-fluid">

                    <div class="countdown-container">
                        <b>計時</b> {{ remainSeconds }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-offset-1 col-md-2">
                </div>
                
            </div>
        </div>

        <div class="container question-container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="question">
                        <div class="question-title text-center">
                            <b>問題 {{ question.id }}</b>
                        </div>
                        
                        <div class="question-content">
                            <b>{{ question.name }}</b>
                        </div>

                        <div class="question-progress">
                            <div class="progress small-progress">
                                <div class="progress-bar" role="progressbar" :aria-valuenow="completePercent" aria-valuemin="0" aria-valuemax="100" :style="'width:' + completePercent  + '%'">
                                    <span class="sr-only">{{completePercent}}% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 text-center">
                    <span v-show="showError">
                        {{ errorText }}
                    </span>
                </div>

                <div class="col-xs-12" v-for="(option, index) in question.options"
                    :key="index"
                    @click="setAnswer(option)"
                >
                    <div :class="'option' + ' ' + optionClass(option)">{{ option }}</div>
                    
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 text-center">
                    <input type="button" class="btn btn-block btn-submit" @click="submitAnswer(false)" value="答案確認">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { captureMessage } from '@sentry/browser'
import Stat from '../../mixins/stat.js'
import ResponseTime from '../../mixins/response_time.js'

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

            return '';
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

<style lang="scss" scoped>

$primary-color : rgb(11,73,106);
$secondary-color: #414449;

.countdown-container {
    position: absolute;
    top: 20px;
    right: 25px;

    width: 70px;
    background-color: #000000;

    padding: 10px;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    color: #FFFFFF;
}

.question-container {
    margin-left: 10px;
    margin-right: 10px;

    color: $secondary-color;

    .question {
        border: 2px solid #000000;
        font-size: 20px;
        margin-bottom: 10px;

        .question-title {
            color: #FFFFFF;
            background-color: $secondary-color;
        }

        .question-content {
            padding: 20px;
            min-height: 120px;
        }

        .question-progress {
            padding: 10px;

            .progress {
                height: 8px;
                background: $primary-color;
                margin-bottom: 0;
                border-radius: 0;

                .progress-bar {
                    background-color: orange;
                }
            }
        }
    }

    .option {
        background-color: #D0D0D0;
        font-size: 20px;
        padding: 10px;
        text-align: center;
        font-weight: bold;

        margin-top: 10px;

        &.selected {
            background-color: $primary-color;
            border: 2px solid black;
            color: #FFFFFF;
        }

        &.correct {
            background-color: #9DC68D;
            color: #FFFFFF;
        }

        &.wrong {
            background-color: #DC6C7B;
            color: #FFFFFF;
        }
    }

    .btn-submit {
        background-color: $secondary-color;
        color: #FFFFFF;
        font-size: 20px;
        font-weight: bold;
        border-radius: 0;
        margin-top: 20px;
    }
}
</style>


