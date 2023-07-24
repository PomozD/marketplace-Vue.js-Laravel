<template>
  <div class="container__breadCrumbs">
    <router-link class="nav__main" to="/">Главная</router-link>
    <div class="breadCrumbs">
      <img class="arrow__right" src="../assets/arrowright.svg">
      <router-link class="nav__children" :to="/catalog/ + item[5]">{{item[5]}}</router-link>

      <img class="arrow__right" src="../assets/arrowright.svg">
      <router-link class="nav__children" :to="/catalog/ + item[5] + '/' + item[4]">{{item[4]}}</router-link>

      <img class="arrow__right" src="../assets/arrowright.svg">
      <h1 class="breadCrumbs__current_page">{{item[1]}}</h1>
    </div>
  </div>

  <div class="container__item">
    <div class="additionally__photos">
      <div v-if="item[9]" :style="{backgroundImage:`url(${item[9]})`}" class="additionally__photo"></div>
      <div v-if="item[10]" :style="{backgroundImage:`url(${item[10]})`}" class="additionally__photo"></div>
      <div v-if="item[11]" :style="{backgroundImage:`url(${item[11]})`}" class="additionally__photo"></div>
    </div>

    <div class="main__photo"><img :src="item[9]"></div>

    <div class="item__info">
      <h1>{{ item[1] }}</h1>
      <p class="p__price">{{item[6]}} BYN</p>
      <hr>
      <p class="p__sizes">Выберите размер:</p>
        <div class="item__sizes">
          <label v-for="size in sizes" :key="size">
            <input class="input__size" name="sizes" :value="size[0]" type="radio" v-model="sizess"/>
            {{size[0]}}
          </label>
        </div>
      <button class="button_cart" @click="addToCart">Добавить в корзину</button>
    </div>
  </div>

  <div class="item__composition">
    <h1>Информация о товаре</h1>
    <p>Состав: {{item[8]}}</p>
  </div>
  <div class="comments">
    <details close>
      <summary>
        <h1>Отзывы</h1>
      </summary>
      <div v-if="isAuthorize() && !thisUserComment && !addedComment">
        <form @submit.prevent="addComment" style="margin-bottom: 50px;">
          <h2>Оставьте отзыв</h2>
          <div class="container__info">
            <div class="info__inner">
              <div class="rating-area">
                <input type="radio" id="star-5" name="rating" value="5" v-model="checkRating">
                <label for="star-5" title="Оценка «5»"></label>
                <input type="radio" id="star-4" name="rating" value="4" v-model="checkRating">
                <label for="star-4" title="Оценка «4»"></label>
                <input type="radio" id="star-3" name="rating" value="3" v-model="checkRating">
                <label for="star-3" title="Оценка «3»"></label>
                <input type="radio" id="star-2" name="rating" value="2" v-model="checkRating">
                <label for="star-2" title="Оценка «2»"></label>
                <input type="radio" id="star-1" name="rating" value="1" v-model="checkRating">
                <label for="star-1" title="Оценка «1»"></label>
              </div>
              <h1>{{ getUser.Name }} {{ getUser.Surname }}</h1>
              <div class="div__setting"></div>
            </div>
            <textarea placeholder="Комментарий" class="textarea__comment" v-model="comment"/>
            <div class="recommend">
              <h1>Рекомендуете товар:</h1>
              <select class="select__recommend" v-model="selectRecommend">
                <option>
                  Да
                </option>
                <option>
                  Нет
                </option>
              </select>
            </div>
          </div>
          <div class="buttons">
            <div class="button__add__commment">
              <button id="submit">Сохранить</button>
            </div>
          </div>
        </form>
      </div>
      <div v-for="comment in comments" :key="comment">
        <v-user-comment :thisUserName="getUser?.Name" :itemName="itemName" :userName="comment[9]" :userSurname="comment[10]"
                        :commentText="comment[4]" :recommend="comment[5]" :rating="comment[3]" @deleteData="isDeleteComment" />
<!--        <v-admin-comment/>-->
      </div>
    </details>
  </div>
  <footer>
    <v-footer/>
  </footer>
</template>

<script>
import VUserComment from "../components/v-user-comment.vue";
import VFooter from "../components/v-footer.vue";

import { getItemInfo } from "../services/itemInfo.js";
import { getSize } from "../services/itemInfo.js";
import { postComment } from "../services/itemInfo.js";
import { getComment } from "../services/itemInfo.js";
import { getItemWithName } from "../services/cardsWithName.js";

import {mapGetters, mapMutations} from 'vuex';

export default {
  name: "ItemCard",

  data() {
    return {
      id: '',
      item: [],

      itemName: '',

      checkRating: '',
      comment: '',
      selectRecommend: 'Да',

      sizes: null,
      comments: [],

      filtres: [],
      sizess: [],

      thisUserComment: false,

      addedComment: false,
      deleteComment: false,

      allCardsWithThisName: [],
    }
  },

  computed: {
    getUser() {
      return this.$store.getters.getUser;
    },
  },

  methods: {
    ...mapMutations(["updateUser"]),
    ...mapGetters(["isAuthorize"]),

    async getInfo() {
      const response = await getItemInfo(this.$route.query.id);
      //console.log(response.itemInfo[0]);
      return response.itemInfo[0];
    },

    async getSizes() {
      const size = await getSize(this.item[1]);
      //console.log(size);
      return size.size;
    },

    async getComments() {
      //console.log(this.item[1]);
      const comments = await getComment(this.item[1]);
      //console.log(comments);
      return comments.comments;
    },

    async getCards() {
      const card = await getItemWithName(this.item[1]);
      //console.log(size);
      return card.items;
    },

    async addComment() {
      if(this.checkRating){
        if(!this.addedComment || this.deleteComment) {
          await postComment(this.getUser.ID, this.item[1], this.checkRating, this.comment, this.selectRecommend);
          alert('Спасибо за Ваш отзыв');
        }
        else {
          alert('Вы уже оставили отзыв');
        }
        this.addedComment = true;
        this.deleteComment = false;
      }
      else {
        alert('Выберите оценку');
      }
    },

    async isDeleteComment() {
      this.deleteComment = true;
      this.addedComment = false;
      this.thisUserComment = false;
    },

    async getCartData(itemid) {
      let response = JSON.parse(localStorage.getItem(itemid));
      console.log(response);
      return response;
    },
    async setCartData(itemid, data) {
      localStorage.setItem(itemid, JSON.stringify(data));
      return false;
    },

    async addToCart() {
      this.disabled = true;

      let itemid;

      if(this.cards.length > 1){
        let id = null;
        console.log(this.cards);
        for (let i=0; i<this.cards.length; i++){
          id = this.cards.filter(item => item[i] === this.sizess);
        }
        console.log(id);
        for(let i = 0; i<id.length; i++){
          itemid = id[i][0];
        }
        console.log(itemid);
      }
      else {
        console.log(this.cards);

        for(let i = 0; i<this.cards.length; i++){
          itemid = this.cards[i][0];
        }
        console.log(itemid);
      }

      var itemTitle = this.item[1],
          itemPrice = this.item[6],
          itemSize = this.sizess;

      var cartData = await this.getCartData(itemid);

      if(cartData !== null){
        console.log(cartData[3], this.sizess);
      }

      console.log(itemSize);

      cartData = [itemid, itemTitle, itemPrice, itemSize, 1];

      if(!await this.setCartData(itemid, cartData)) {
        this.disabled = false;
      }
      return false;
    },

  },

  async created(){
    this.item = await this.getInfo();
    this.itemName = this.item[1];

    this.sizes = await this.getSizes();
    this.cards = await this.getCards();
    console.log(this.cards);

    this.comments = await this.getComments();
    //console.log(this.comments);

    for(let i = 0; i < this.comments.length; i++){
      if(this.comments[i][2] === this.getUser.ID) {
        this.thisUserComment = true;
      }
    }
  },

  watch: {
    "$route.params": {
      handler: async function () {
        this.item = await this.getInfo();
        this.itemName = this.item[1];
        this.sizes = await this.getSizes();
        this.comments = await this.getComments();
        this.cards = await this.getCards();

        for(let i = 0; i < this.comments.length; i++){
          if(this.comments[i][2] === this.getUser.ID) {
            this.thisUserComment = true;
          }
        }
        console.log(this.thisUserComment);
      },
      immediate: true
    },

    async addedComment() {
      // this.addedComment = true;
      this.deleteComment = false;
      this.comments = await this.getComments();
    },

    async deleteComment() {
      this.addedComment = false;
      this.deleteComment = true;
      this.thisUserComment = false;
      this.comments = await this.getComments();
      console.log(this.addedComment, this.thisUserComment, this.isAuthorize());
    },

    async sizess(value) {
      console.log(value);
      this.filtres = this.sizess;
      console.log('размер', this.filtres);

      this.item = await this.getInfo();
    },
  },

  // Если удаление - addedcomment = false, deleteComment = true;
  // Если добавление - addedcomment = true,

  components: {
    VUserComment,
    //VAdminComment,
    VFooter,
  },
}
</script>

<style scoped>
h1 {
  font-family: "DIN PRO Medium";
  font-size: 20px;
}

/* bread crumbs */

.container__breadCrumbs {
  display: flex;
  align-items: center;
  margin-left: 50px;
}
.breadCrumbs {
  display: flex;
  justify-content: center;
  align-items: center;
}
.nav__main {
  font-family: "DIN PRO Regular";
  font-size: 14px;
  text-decoration: none;
  color: black;
  margin-right: 12px;
}
.nav__children {
  font-family: "DIN PRO Regular";
  font-size: 14px;
  text-decoration: none;
  color: black;
  margin-right: 12px;
}
.arrow__right {
  margin-right: 12px;
}
.container__breadCrumbs h1 {
  font-family: "DIN PRO Medium";
  font-size: 14px;
  font-weight: 600;
}

.container__item {
  display: flex;
  margin-top: 50px;
  margin-left: 150px;
  margin-right: 100px;
}

/* additionaly photos */

.additionally__photo {
  border: 1px solid #888888;
  background-repeat: no-repeat;
  background-position: center center;
  background-size: 70px;
  width: 100px;
  height: 100px;
  margin-bottom: 25px;
}

/* main photo */

.main__photo {
  margin: 0 auto;
}

/* item info */

.item__info {
  margin-right: 100px;
  width: 27%;
}

.p__price {
  font-family: "DIN PRO Regular";
  font-size: 13px;
  margin-top: 30px;
}

.p__sizes {
  font-family: "DIN PRO Regular";
  font-size: 16px;
  margin-top: 25px;
}

.item__sizes {
  display: flex;
  flex-direction: column;
}

label {
  font-family: "DIN PRO Medium";
  font-size: 16px;
  margin-top: 10px;
}


.button_cart {
  margin-top: 20px;
  font-family: "DIN PRO Medium";
  font-size: 13px;
  font-weight: 600;
  background: #913259;
  color: #ffffff;
  padding: 15px 25px;
  border: none;
  outline: none;
  cursor: pointer;
  transition: .2s;
}

.button_cart:hover {
  background: #9132599E;
}

/* composition item */

.item__composition {
  margin-top: 50px;
  margin-left: 150px;
  margin-right: 100px;
}
.item__composition p {
  font-family: "DIN PRO Regular";
  font-size: 15px;
}

/* comments */

form h2 {
  font-family: "DIN PRO Medium";
  margin-top: 20px;
  margin-bottom: -5px;
}

.rating-area {
  overflow: hidden;
  width: 170px;
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

.info__inner {
  display: flex;
  align-items: center;
}
.info__inner h1 {
  font-family: "DIN PRO Medium";
  font-size: 15px;
  margin-right: 20px;
  padding-top: 15px;
}

.textarea__comment {
  margin-top: 20px;
  border: 2px solid black;
  height: 200px;
  width: 500px;
  padding: 20px;
  color: black;
  font-family: "DIN PRO Regular";
  font-size: 15px;
  resize: none;
}

.recommend {
  display: flex;
  align-items: center;
}

.select__recommend {
  margin-left: 10px;
  padding: 0 5px 0 5px;
  height: 30px;
  border: 1px solid black;
  color: #9b9b9b;
}

.buttons {
  display: flex;
  margin: 20px 0;
}

.button__add__commment button {
  padding: 12px 50px;
  color: white;
  transition: .5s;
  background-color: black;
  font-family: "DIN PRO Medium";
  font-size: 14px;
  margin-right: 20px;
  border: 2px solid black;
  cursor: pointer;
}

.button__add__commment button:hover {
  background: #913259;
  border: 2px solid #913259;
}

.comments {
  margin-left: 150px;
  margin-right: 100px;
}

details {
  display: flex;
  align-items: center;
}
details > summary {
  list-style: none;
  cursor: pointer;
  display: flex;
}
summary h1 {
  margin-left:20px;
}
summary:before {
  content: url(../assets/arrowdown.svg);
  padding: 15px 0px 0px 0px;
}
details[open] summary:before {
  content: url(../assets/arrowup.svg);
}

/* popular */

.container__popular {
  margin-top: 25px;
  display: flex;
  align-items: center;
}
.popular {
  width: 93%;
  margin: 0 auto;
}

</style>
