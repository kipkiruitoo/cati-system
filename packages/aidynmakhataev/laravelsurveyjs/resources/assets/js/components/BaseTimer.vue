<template>
  <div class="base-timer">
    <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
      <g class="base-timer__circle">
        <circle class="base-timer__path-elapsed" cx="50" cy="50" r="46.5" />
        <path
          :stroke-dasharray="circleDasharray"
          class="base-timer__path-remaining"
          d="
            M 50, 50
            m -45, 0
            a 45,45 0 1,0 90,0
            a 45,45 0 1,0 -90,0
          "
        />
      </g>
    </svg>
    <span class="base-timer__label">{{ formattedTimeLeft }}</span>
  </div>
</template>
<script>
let FULL_DASH_ARRAY = 283;
// const WARNING_THRESHOLD = 10;
// const ALERT_THRESHOLD = 5;
export default {
  props: {
    timeLeft: {
      type: Number,
      required: true,
    },
    timePassed: Number,
    timeLimit: Number,
  },

  computed: {
    formattedTimeLeft() {
      const timeLeft = this.timeLeft;
      // The largest round integer less than or equal
      //  to the result of time divided being by 60.
      const minutes = Math.floor(timeLeft / 60);
      // Seconds are the remainder of the time divided
      //  by 60 (modulus operator)
      let seconds = timeLeft % 60;
      // If the value of seconds is less than 10,
      //  then display seconds with a leading zero
      if (seconds < 10) {
        seconds = `0${seconds}`;
      }
      // The output in MM:SS format
      return `${minutes}:${seconds}`;
    },
    circleDasharray() {
      return `${(this.timeFraction * FULL_DASH_ARRAY).toFixed(0)} 283`;
    },
    timeFraction() {
      const rawTimeFraction = this.timeLeft / this.timeLimit;

      return rawTimeFraction - (1 / this.timeLimit) * (1 - rawTimeFraction);
    },
  },
};
</script>
<style scoped lang="scss">
.base-timer {
  position: relative;
  float: right;
  width: 70px;
  box-shadow: 3px 3px 4px #999;
  border-radius: 50%;
  height: 70px;

  &__svg {
    transform: scaleX(-1);
  }

  &__circle {
    fill: none;
    stroke: none;
  }

  &__path-elapsed {
    stroke-width: 7px;
    stroke: rgb(107, 233, 195);
  }

  &__path-remaining {
    stroke-width: 7px;
    stroke-linecap: round;
    transform: rotate(90deg);
    transform-origin: center;
    transition: 1s linear all;
    fill-rule: nonzero;
    stroke: currentColor;

    &.green {
      color: rgb(65, 184, 131);
    }

    &.orange {
      color: orange;
    }

    &.red {
      color: red;
    }
  }

  &__label {
    position: absolute;
    width: 70px;
    height: 70px;
    top: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 23px;
  }
}
</style>
