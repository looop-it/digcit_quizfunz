@extends('layouts.competition')

@section('style')
<style>
    html, body { background-color: #000 !important; }

    @media (max-width: 860px) {
        html, body { background-color: #fff !important; }
    }

    body:has(.force-mobile) { background-color: #fff !important; }

    .answer-shell { color: #3F4A50; }

    .layout-mobile { display: none; }

    #main_container {
        width: 800px;
        height: 600px;
        margin: 0 auto;
        background: url("/images/competition/bg.png") no-repeat;
        background-size: contain;
    }

    #main_container .question-order {
        color: #fff;
        font-size: 22px;
        padding: 25px 0 0 0;
        height: 85px;
        text-align: center;
    }

    #main_container .question-title {
        color: #3F4A50;
        padding: 30px 110px;
        height: 238px;
    }

    #main_container .title-font-size-25 { font-size: 25px; }
    #main_container .title-font-size-30 { font-size: 30px; }

    #main_container .question-progress {
        padding: 0 110px;
        height: 20px;
    }

    #main_container .question-progress .progress-bar { background: #231f20; }
    #main_container .question-progress .small-progress { height: 5px !important; margin-bottom: 0; }

    #main_container .question-progress .counter {
        position: absolute;
        right: 90px;
        bottom: 8px;
        font-weight: bold;
    }

    #main_container .error-container {
        color: #b00020;
        font-size: 20px;
        height: 41px;
        padding: 5px 0 0 0;
    }

    #main_container .question-timer {
        color: #fff;
        font-size: 20px;
        padding: 5px 13px 0 0;
        height: 40px;
        background: #5A4C80;
        width: 110px;
    }

    #main_container .countdown {
        background-color: rgba(255,255,255,0.85);
        color: #231f20;
        padding: 0 6px;
        border-radius: 5px;
        margin: 0 1px;
    }

    #main_container .question-options { height: 144px; }

    #main_container .option-container {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 382px;
        height: 78px;
        margin: 0 8px;
        padding: 0 40px;
        border: 0;
        text-align: center;
        color: #000;
        background: url("/images/competition/option.png") no-repeat;
        background-color: transparent;
        font-size: 18px;
        cursor: pointer;
    }

    #main_container .option-container.selected {
        background: url("/images/competition/option_active.png") no-repeat;
    }

    #main_container .submit {
        background: url("/images/competition/submit.png") no-repeat;
        background-size: cover;
        width: 136px;
        height: 54px;
        border: none;
        color: transparent;
        margin: 0;
    }

    #main_container .submit:focus { outline: none; }

    .layout-mobile .mobile-header { position: relative; }
    .layout-mobile .mobile-header img { width: 100%; height: auto; display: block; }

    .layout-mobile .countdown-container {
        position: absolute;
        bottom: 0;
        right: 10px;
        width: 70px;
        background-color: #000;
        padding: 5px 10px;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        color: #fff;
    }

    .layout-mobile .question-container {
        margin-left: 10px;
        margin-right: 10px;
        color: #414449;
    }

    .layout-mobile .question {
        border: 2px solid #000;
        background: #fff;
        font-size: 20px;
        margin-bottom: 10px;
    }

    .layout-mobile .question-title {
        color: #fff;
        background-color: #414449;
        text-align: center;
    }

    .layout-mobile .question-content {
        padding: 20px;
        min-height: 120px;
        font-weight: bold;
    }

    .layout-mobile .question-progress { padding: 10px; }

    .layout-mobile .small-progress {
        height: 8px;
        background: rgb(11,73,106);
        margin-bottom: 0;
        border-radius: 0;
    }

    .layout-mobile .progress-bar { background-color: orange; }

    .layout-mobile .note,
    .layout-mobile .error {
        display: block;
        text-align: center;
        color: #b00020;
        min-height: 24px;
    }

    .layout-mobile .option {
        display: block;
        width: 100%;
        background-color: #D0D0D0;
        font-size: 20px;
        padding: 10px;
        text-align: center;
        font-weight: bold;
        margin-top: 10px;
        border: 0;
        color: #414449;
    }

    .layout-mobile .option.selected {
        background-color: rgb(11,73,106);
        border: 2px solid #000;
        color: #fff;
    }

    .layout-mobile .btn-submit {
        display: block;
        width: 100%;
        background-color: #414449;
        color: #fff;
        font-size: 20px;
        font-weight: bold;
        border-radius: 0;
        border: 0;
        margin-top: 20px;
        padding: 10px 16px;
    }

    @media (max-width: 860px) {
        .layout-desktop { display: none; }
        .layout-mobile { display: block; }
    }

    .force-mobile .layout-desktop { display: none; }
    .force-mobile .layout-mobile { display: block; }
</style>
@endsection

@section('content')
@php
    $percent = $totalQuestions > 0 ? (int) (($question['id'] / $totalQuestions) * 100) : 0;
    $titleSize = mb_strlen($question['name']) > 70 ? 25 : 30;
@endphp
<div class="answer-shell {{ Agent::isMobile() ? 'force-mobile' : '' }}">
    <form id="answer-form" method="post" action="{{ route('competition.page.submit') }}">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="paper_question_id" value="{{ $question['paper_question_id'] }}">
        <input type="hidden" name="answer" id="answer" value="">

        <div class="layout-desktop">
            <div id="main_container" class="container">
                <div class="row">
                    <div class="col-md-12 question-order">
                        <b>問題 {{ $question['id'] }}</b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 question-title">
                        <b class="title-font-size-{{ $titleSize }}">{{ $question['name'] }}</b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 question-progress">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="progress small-progress">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="col-md-1 counter">{{ $question['id'] }}/{{ $totalQuestions }}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-1 col-md-2"></div>
                    <div class="col-md-6 error-container text-center">
                        <span id="answer-error" hidden>請選擇答案</span>
                        @if ($previous)
                            上一題正確答案：{{ $previous['correct'] }}
                            @if ($previous['selected'] === $previous['correct'])
                                （答對）
                            @else
                                （答錯）
                            @endif
                        @endif
                        @if ($errors->any())
                            {{ $errors->first() }}
                        @endif
                    </div>
                    <div class="col-md-2 question-timer text-right">
                        <b>計時</b> <span class="countdown">{{ $remainSeconds }}</span>
                    </div>
                </div>
                <div class="row question-options">
                    @foreach ($options as $option)
                        <button type="button" class="col-md-6 option-container" data-option="{{ $option }}">{{ $option }}</button>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="submit" aria-label="答案確認"></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="layout-mobile">
            <div class="mobile-header">
                <img src="/images/competition/mobile/header.png" alt="">
                <div class="countdown-container"><b>計時</b> <span class="countdown">{{ $remainSeconds }}</span></div>
            </div>
            <div class="question-container">
                <div class="question">
                    <div class="question-title"><b>問題 {{ $question['id'] }}</b></div>
                    <div class="question-content">{{ $question['name'] }}</div>
                    <div class="question-progress">
                        <div class="progress small-progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
                <div class="note">
                    <span class="answer-error" hidden>請選擇答案</span>
                    @if ($previous)
                        上一題正確答案：{{ $previous['correct'] }}
                        @if ($previous['selected'] === $previous['correct'])
                            （答對）
                        @else
                            （答錯）
                        @endif
                    @endif
                </div>
                @if ($errors->any())
                    <div class="error">{{ $errors->first() }}</div>
                @endif
                @foreach ($options as $option)
                    <button type="button" class="option" data-option="{{ $option }}">{{ $option }}</button>
                @endforeach
                <button type="submit" class="btn-submit">答案確認</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('javascript')
<script>
    (function () {
        var form = document.getElementById('answer-form');
        var answer = document.getElementById('answer');
        var remainNodes = document.querySelectorAll('.countdown');
        var seconds = parseInt(remainNodes[0] ? remainNodes[0].textContent : '0', 10) || 0;
        var submitted = false;

        function setRemain(value) {
            Array.prototype.forEach.call(remainNodes, function (node) {
                node.textContent = value;
            });
        }

        function showChooseError() {
            var desktop = document.getElementById('answer-error');
            if (desktop) {
                desktop.hidden = false;
            }
            Array.prototype.forEach.call(document.querySelectorAll('.answer-error'), function (node) {
                node.hidden = false;
            });
        }

        function send(value) {
            if (submitted) {
                return;
            }
            submitted = true;
            answer.value = value || '';
            form.submit();
        }

        Array.prototype.forEach.call(document.querySelectorAll('[data-option]'), function (button) {
            button.addEventListener('click', function () {
                var value = button.getAttribute('data-option');
                Array.prototype.forEach.call(document.querySelectorAll('[data-option]'), function (item) {
                    if (item.getAttribute('data-option') === value) {
                        item.classList.add('selected');
                    } else {
                        item.classList.remove('selected');
                    }
                });
                answer.value = value;
            });
        });

        form.addEventListener('submit', function (event) {
            if (submitted) {
                return;
            }
            if (!answer.value) {
                event.preventDefault();
                showChooseError();
                return;
            }
            submitted = true;
        });

        var timer = setInterval(function () {
            seconds = seconds - 1;
            if (seconds < 0) {
                seconds = 0;
            }
            setRemain(seconds);
            if (seconds === 0) {
                clearInterval(timer);
                send('');
            }
        }, 1000);
    })();
</script>
@endsection
