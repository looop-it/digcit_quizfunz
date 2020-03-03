<template>
  <div id="main" class="container text-center">
    <div id="result_container">
      <div class="row" v-show="!ready">
        <div class="col-md-12">
            <p class="loading">得分計算中</p>
        </div>
      </div>

      <div class="row" v-show="ready">
        <div class="col-md-4 col-md-offset-2">
            得分
            <div class="digital">
                <p class="result">{{ score }}</p>
            </div>
        </div>
        <div class="col-md-4">
            時間（秒）
            <div class="digital">
                <p class="result">{{ secondsUsed }}</p>
			      </div>
        </div>
      </div>
    </div>

    <div id="button_container">
        <div class="row button">
            <div class="col-md-12">
                <a href="/" class="btn btn-custom">
                    返回主頁
                </a>
            </div>
        </div>
    </div>

  </div>
</template>

<script>
export default {
  name: "result",

  created() {
    this.timer = setInterval(() => {
      this.getResult();
    }, 2000);
  },

  data() {
    return {
      timer: null,
      ready: false,
      attempt: 0,
      score: 0,
      secondsUsed: 0,
      questionsAnswered: 0
    };
  },

  methods: {
    getResult() {
      axios
        .post("/api/result")
        .then(response => {
          // Success
          if (response.data.status == 200) {
            this.ready = true;

            this.clearTimer();
            this.setResult(response.data);
          } else if (response.data.status == 404) {
            this.redirectTo()
          }
        })
        .catch(error => {
          if (this.attempt > 3) {
            this.redirectTo()
          }

          ++this.attempt
        })
    },

    setResult(data) {
      this.score = data.score;
      this.secondsUsed = data.seconds_used;
      this.questionsAnswered = data.questions_answered;
    },

    setTimer() {
      this.timer = setInterval(() => {
        this.getResult();
      }, 1000);
    },

    clearTimer() {
      clearInterval(this.timer);
    },

    redirectTo() {
      window.location.href = '/competition/records'
    }
  }
};
</script>

<style>
html, body {
    background-color: black !important;
}
</style>

<style lang="scss" scoped>
$text-color: #3f4a50;

@font-face {
  font-family: lcd;
  src: url("/fonts/lcd.eot?#iefix") format("embedded-opentype"),
    url("/fonts/lcd.woff") format("woff"),
    url("/fonts/lcd.ttf") format("truetype"),
    url("/fonts/lcd.svg") format("svg");
}


#main {
  width: 800px;
  height: 600px;
  background: url("/images/competition/finished_bg.jpg") no-repeat;

  #result_container {
    margin-top: 315px;
    text-align: center;
    font-size: 25px;
    color: $text-color;
    height: 130px;
    
    .loading:after {
      content: " .";
      animation: dots 1s steps(5, end) infinite;
    }

    @keyframes dots {
      0%,
      20% {
        color: rgba(0, 0, 0, 0);
        text-shadow: 0.25em 0 0 rgba(0, 0, 0, 0), 0.5em 0 0 rgba(0, 0, 0, 0);
      }
      40% {
        color: $text-color;
        text-shadow: 0.25em 0 0 rgba(0, 0, 0, 0), 0.5em 0 0 rgba(0, 0, 0, 0);
      }
      60% {
        text-shadow: 0.25em 0 0 $text-color, 0.5em 0 0 rgba(0, 0, 0, 0);
      }
      80%,
      100% {
        text-shadow: 0.25em 0 0 $text-color, 0.5em 0 0 $text-color;
      }
    }
  }

  .digital {
    border: 1px solid #004085;
    border-radius: 5px;
    background: #fff;
    height: 80px;

    font-family: "lcd";
    font-size: 56px;

    display: flex;
    align-items: center;
    justify-content: center;
  }

  #button_container {
      margin-top:50px;

      a {
        &.btn-custom {
            background-color: #231f20;
            border: 1px solid white;
            color: white;

           &:hover {
              color: $text-color;
              background-color: white;
          }
        }
      }
      
  }
}
</style>
