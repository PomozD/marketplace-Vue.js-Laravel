<template>
  <div class="container__delete" v-if="deleteComment">
    <form @submit="deleteData" class="formDelete">
      <h2>Вы хотите удалить Ваш комментарий?</h2>
      <div class="buttons" v-if="deleteComment">
        <div class="button__delete__comment">
          <input type="submit" id="submit" value="Удалить"/>
        </div>
      </div>
    </form>
  </div>

  <div class="container__info" v-if="!editComment">
      <div class="info__inner">
        <div style="display: flex; align-items: center">
          <div class="rating-area" v-for="star in countStart" :key="star">
            <input type="radio" id="radiostar">
            <label for="radiostar"></label>
          </div>
          <div class="rating-areaWhite" v-for="whiteStar in 5 - countStart" :key="whiteStar">
            <input type="radio" id="radiostar">
            <label for="radiostar"></label>
          </div>
        </div>
        <h1>{{ userName }} {{ userSurname }}</h1>
        <div class="div__setting" v-if="thisUserName === userName" @click="editOtDelite"></div>
        <select v-if="editOrDelite" style="margin-left: 20px;" v-model="select">
          <option>
            Редактировать
          </option>
          <option>
            Удалить
          </option>
        </select>
      </div>
      <div class="comment__text">
        <p class="p__comment__text">{{ commentText }}</p>
      </div>
      <div class="recommend">
        <h1>Рекомендуете товар:</h1>
        <p>{{recommend}}</p>
      </div>
  </div>


  <div class="container__info" v-if="editComment && !deleteComment">
    <form @submit="saveData">
      <div class="rating-areaEdit" v-if="editComment">
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
      <div class="info__inner">
        <h1>{{ userName }} {{ userSurname }}</h1>
        <div class="div__setting" v-if="thisUserName === userName" @click="editOtDelite"></div>
        <select v-if="editOrDelite" style="margin-left: 20px;" v-model="select">
          <option disabled value="Выберите действие"></option>
          <option>
            Редактировать
          </option>
          <option>
            Удалить
          </option>
        </select>
      </div>
      <div class="comment__text">
        <textarea v-if="editComment" :placeholder="commentText" class="textarea__comment" v-model="input__newComment"/>
      </div>
      <div class="recommend">
        <h1>Рекомендуете товар:</h1>
        <select class="select__recommend" v-model="selectRecommend" v-if="editComment">
          <option>
            Да
          </option>
          <option>
            Нет
          </option>
        </select>
      </div>
      <div class="buttons" v-if="editComment">
        <div class="button__add__comment">
          <input type="submit" id="submit" value="Сохранить"/>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import {editComment} from "../services/editComment.js";
import {deleteComment} from "../services/editComment.js";

export default {
  props: [
    "thisUserName",
    "itemName",
    "userName",
    "userSurname",
    "commentText",
    "recommend",
    "rating"
  ],

  data() {
    return {
      countStart: null,
      editOrDelite: false,

      select: 'Выберите действие',

      editComment: false,
      deleteComment: false,

      checkRating: '',
      input__newComment: '',
      selectRecommend: 'Да',

      itemThisName: '',

      newComment: null,

      deletedComment: false,
    }
  },

  computed: {
    getUser() {
      return this.$store.getters.getUser;
    },
  },

  methods: {
    editOtDelite() {
      this.editOrDelite = !this.editOrDelite;
    },

    async saveData(e) {
      e.preventDefault();
      console.log(this.selectRecommend);
      const response = await editComment(this.getUser.ID, this.itemName, this.checkRating, this.input__newComment, this.selectRecommend);
      console.log(response);
      alert('Комментарий обновлен');
      this.editComment = false;
      this.editOrDelite = false;
    },

    async deleteData(e) {
      e.preventDefault();

      await deleteComment(this.getUser.ID, this.itemName);

      this.deletedComment = true;

      this.$emit('deleteData', { deleteComment: this.deletedComment });
    }
  },

  async created() {
    //console.log(this.itemName);
    this.countStart = Number(this.rating);

    this.newComment = await this.saveData();
  },

  watch: {
    select(value) {
      if(value === 'Редактировать') {
        this.editComment = true;
        this.deleteComment = false;
      }
      if(value === 'Удалить') {
        this.deleteComment = true;
        this.editComment = false;
      }
    },

    async deletedComment() {
      this.deleteComment = false;
      this.editComment = false;
      this.editOrDelite = false;
    }

  }
}

/// в профиле показывать ошибку когда юзер с таким же мэфлом
// пароль не выводить
</script>

<style scoped>

.container__info {
  margin-bottom: 30px;
}

/* rating */

.rating-area, .rating-areaWhite {
  overflow: hidden;
  display: flex;
  flex-direction: row-reverse;
  justify-content: flex-end;
}
.rating-area > input, .rating-areaWhite > input {
  display: none;
}
.rating-area label {
  width: 32px;
  padding: 0;
  cursor: pointer;
  font-size: 32px;
  line-height: 32px;
  color: #913259;
  text-shadow: 1px 1px #c60;
}
.rating-areaWhite label {
  width: 32px;
  padding: 0;
  cursor: pointer;
  font-size: 32px;
  line-height: 32px;
  color: lightgrey;
  text-shadow: 1px 1px #bbb;
}
.rating-area > label:before, .rating-areaWhite > label:before {
  content: '★';
}

/* edit rating */

.rating-areaEdit {
  overflow: hidden;
  width: 170px;
  display: flex;
  flex-direction: row-reverse;
  justify-content: flex-end;
}
.rating-areaEdit:not(:checked) > input {
  display: none;
}
.rating-areaEdit:not(:checked) > label {
  width: 32px;
  padding: 0;
  cursor: pointer;
  font-size: 32px;
  line-height: 32px;
  color: lightgrey;
  text-shadow: 1px 1px #bbb;
}
.rating-areaEdit:not(:checked) > label:before {
  content: '★';
}
.rating-areaEdit > input:checked ~ label {
  color: #913259;
  text-shadow: 1px 1px #c60;
}
.rating-areaEdit:not(:checked) > label:hover,
.rating-areaEdit:not(:checked) > label:hover ~ label {
  color: #913259;
}
.rating-areaEdit > input:checked + label:hover,
.rating-areaEdit > input:checked + label:hover ~ label,
.rating-areaEdit > input:checked ~ label:hover,
.rating-areaEdit > input:checked ~ label:hover ~ label,
.rating-areaEdit > label:hover ~ input:checked ~ label {
  color: #913259;
  text-shadow: 1px 1px goldenrod;
}
.rating-areaEdit > label:active {
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

.textarea__comment {
  margin-top: 20px;
  margin-bottom: 20px;
  border: 2px solid black;
  height: 200px;
  width: 500px;
  padding: 20px;
  color: black;
  font-family: "DIN PRO Regular";
  font-size: 15px;
  resize: none;
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

.button__add__comment input, .button__delete__comment input {
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

.button__add__comment input:hover, .button__delete__comment input:hover {
  background: #913259;
  border: 2px solid #913259;
}

.formDelete h2 {
  font-family: "DIN PRO Medium";
  font-size: 18px;
}





</style>
