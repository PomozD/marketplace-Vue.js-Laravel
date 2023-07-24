<template>
  <div class="container__info">
    <div class="info__inner">
      <h1>Admin</h1>
      <p>10.02.2023</p>
      <div class="div__setting"></div>
    </div>
    <div class="comment__text">
      <p class="p__comment__text">Test test test test test test test test test test test test test test test test test test test test test test
        test test test test test test test test test test test test test test test test.</p>
    </div>
  </div>
</template>

<script>
export default {
  name: "v-user-comment"
}
</script>

<style scoped>

.container__info {
  background-color: #dcdcdc;
  padding: 25px;
}

.info__inner {
  display: flex;
  align-items: center;
}
.info__inner h1 {
  font-family: "DIN PRO Medium";
  font-size: 15px;
  margin-right: 20px;
}

.info__inner p {
  font-family: "DIN PRO Regular";
  font-size: 15px;
  margin-right: 20px;
}

.div__setting {
  width: 24px;
  height: 24px;
  background-image: url("../assets/setting.svg");
  cursor: pointer;
}

/* comment */

.p__comment__text {
  font-family: "DIN PRO Regular";
  font-size: 18px;
  line-height: 25px;
}

.recommend {
  display: flex;
  align-items: center;
}

.recommend h1 {
  font-family: "DIN PRO Medium";
  font-size: 18px;
  line-height: 0.1;
}

.recommend p {
  font-family: "DIN PRO Regular";
  font-size: 18px;
  margin-left: 10px;
}


</style>