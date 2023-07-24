<template>
  <div class="container__info">
    <div class="item__name">
      <h1 class="h1__item__name">{{name}}</h1>
    </div>
    <div class="item__price">
      <p class="p__item__price">{{price}} BYN</p>
    </div>
    <button class="button_primary">Добавить в корзину</button>
  </div>
</template>

<script>
export default {
  name: "v-info-item",

  props: [
    "name",
    "price"
  ]
}
</script>

<style scoped>

.container__info {
  padding: 5%;
}

/* rating */

.rating-area {
  overflow: hidden;
  width: 265px;
  display: flex;
  flex-direction: row-reverse;
  justify-content: flex-end;
}
.rating-area:not(:checked) > input {
  display: none;
}
.rating-area:not(:checked) > label {
  width: 32px;
  padding: 0;
  cursor: pointer;
  font-size: 32px;
  line-height: 32px;
  color: lightgrey;
  text-shadow: 1px 1px #bbb;
}
.rating-area:not(:checked) > label:before {
  content: '★';
}
.rating-area > input:checked ~ label {
  color: #913259;
  text-shadow: 1px 1px #c60;
}
.rating-area:not(:checked) > label:hover,
.rating-area:not(:checked) > label:hover ~ label {
  color: #913259;
}
.rating-area > input:checked + label:hover,
.rating-area > input:checked + label:hover ~ label,
.rating-area > input:checked ~ label:hover,
.rating-area > input:checked ~ label:hover ~ label,
.rating-area > label:hover ~ input:checked ~ label {
  color: #913259;
  text-shadow: 1px 1px goldenrod;
}
.rate-area > label:active {
  position: relative;
}

/* info */

.item__name, .item__price {
  display: flex;
  margin-left: 5px;
}

.h1__item__name {
  font-family: "DIN PRO Medium";
  font-size: 16px;
  line-height: 0.1;
}
.p__item__price {
  font-family: "DIN PRO Regular";
  font-size: 13px;
}

/* button */

.button_primary {
  font-family: "DIN PRO Medium";
  font-size: 13px;
  font-weight: 600;
  background: #ffffff;
  padding: 10px 15px;
  border: none;
  outline: none;
  cursor: pointer;
  transition: .2s;
  border: 2px solid black;
}

.button_primary:hover {
  background: #913259FF;
  color: #ffffff;
  border: none;
}

</style>
