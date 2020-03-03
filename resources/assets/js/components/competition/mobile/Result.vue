<template>
  <div>
    <div class="container-fluid">
      <div class="row">
        <img :src="'/images/competition/mobile/header.jpeg'" class="img-fluid">
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <div class="result-container">

            <div class="row">
              <div class="col-xs-12 text-center">
                <img :src="'/images/competition/mobile/finish_challenge.png'" class="img-fluid">
              </div>
            </div>

            <div class="row">
              <div class="col-xs-12" v-show="!ready">
                <p class="loading title text-center">得分計算中</p>
              </div>

              <div class="col-xs-6" v-show="ready">
                  <p class="text-center title"><b>總得分</b></p>
                  <div class="digital">
                    {{ score }}
                  </div>
              </div>
              <div class="col-xs-6" v-show="ready">
                  <p class="text-center title"><b>時間（秒）</b></p>
                  <div class="digital">
                    {{ secondsUsed }}
                  </div>
              </div>

            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12 footer">
            <a href="/" class="btn btn-block btn-custom">
              返回主頁
            </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "mobile-result",

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
body {
  background-color: #FFFFFF;
}
</style>

<style lang="scss" scoped>
$primary-color : #FAF016;
$secondary-color: #414449;

@font-face {
  font-family: lcd;
  src: url("/fonts/lcd.eot?#iefix") format("embedded-opentype"),
    url("/fonts/lcd.woff") format("woff"),
    url("/fonts/lcd.ttf") format("truetype"),
    url("/fonts/lcd.svg") format("svg");
}

.container {
  padding-left: 5px;
  padding-right: 5px;
}

.result-container {
  background-color: #FFFFFF;
  border: 2px solid #000000;
  padding: 10px;
  min-height: 300px;

  color: $secondary-color;

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
      color: $secondary-color;
      text-shadow: 0.25em 0 0 rgba(0, 0, 0, 0), 0.5em 0 0 rgba(0, 0, 0, 0);
    }
    60% {
      text-shadow: 0.25em 0 0 $secondary-color, 0.5em 0 0 rgba(0, 0, 0, 0);
    }
    80%,
    100% {
      text-shadow: 0.25em 0 0 $secondary-color, 0.5em 0 0 $secondary-color;
    }
  }

  .title {
    font-size: 25px;
    font-weight: bold;
  }
}

.digital {
  font-family: "lcd";
  font-size: 56px;

  display: flex;
  align-items: center;
  justify-content: center;

  border: 2px solid $secondary-color;
  border-radius: 5px;
  background: #fff;
  height: 70px;
  padding-bottom: 10px;
}

.footer {
  background: url('/images/competition/mobile/result_background.png') no-repeat;
  background-position: bottom center;
  height: 450px;
}

.btn-custom {
  color: $primary-color;
  background-color: $secondary-color;
  margin: 10px 0;

  font-size: 30px;
}

.img-fluid {
  width: 100%;
}
</style>
