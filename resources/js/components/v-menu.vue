<template>
  <div class="container">

    <div class="header__top">
      <div class="div__advertise">
        <p class="p__advertise">Бесплатная доставка при заказе свыше 500 бел.руб. 90-дневный бесплатный возврат.</p>
      </div>
      <div v-if="!isAuthorize()" class="div__profile"><router-link class="nav__profile" to="/authorization">Войти</router-link> | <router-link class="nav__profile" to="/registration"> Создать аккаунт</router-link></div>
      <div v-if="isAuthorize()" class="div__profile"><router-link :to="'/profile?id=' + getUser.ID">{{getUser.Name}} {{getUser.Surname}}</router-link></div>
    </div>

    <div class="header__bottom">
      <nav class="nav">
        <div class="nav__div">
          <div v-for="menuItem in menu" :key="menuItem" class="div__link button--primary" id="btn-mans">
            <router-link :to="/catalog/ + menuItem.category"><button class="nav__link">{{menuItem.category}}</button></router-link>
            <div class="dropdown-content">
              <div class="row">
                <h3>Выберите категорию</h3>
                <div v-for="type in menuItem.types" :key="type" class="column">
                  <router-link :to="/catalog/ + menuItem.category + '/' + type['Name']">{{type['Name']}}</router-link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </nav>

      <div class="header__logo">
        <router-link to="/"><img class="img__logo" src="../assets/leisure.ok.svg"></router-link>
      </div>

      <div class="div__search__cart">
        <div class="div__search">
          <input type="text" class="input__search" placeholder="Поиск" v-model.trim="searchText"/>
          <button @click="search"><img class="img__search" src="../assets/icon_search.svg"></button>
        </div>

        <router-link v-if="!isAuthorize()" to="/authorization">
          <div class="div__cart">
            <img class="img__cart" src="../assets/icon_cart.svg">
            <div class="div__info__cart"></div>
          </div>
        </router-link>
        <router-link v-if="isAuthorize()" :to="'/profile?id=' + getUser.ID">
          <div class="div__cart">
              <img class="img__cart" src="../assets/icon_cart.svg">
              <div class="div__info__cart"></div>
          </div>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>

import { getCategory } from "../services/categories.js";
import {mapGetters, mapMutations} from 'vuex';
 export  default  {
   name: 'v-menu',

   computed: {
    getUser() {
        console.log(this.$store.getters.getUser[0]);
       return this.$store.getters.getUser;
    },
   },

   data() {
     return {
       menu: null,
       searchText: '',

       cart: [],

       totalPriceInCart: 0,
     }
   },

   methods: {
       ...mapMutations(["updateUser"]),
       ...mapGetters(["isAuthorize"]),

     async getCategories(){
       return await getCategory();
       //console.log(response);
     },

     search() {
       this.$emit('search', { searchText: this.searchText })
     },

     async getCartData() {
       let response = [];
       for (let i = 0; i < localStorage.length; i+= 1) {
         const key = localStorage.key(i);
         response.push(JSON.parse(localStorage[key]));
       }
       return response;
     },

   },

   async created() {

     //console.log(this.searchText);

     this.menu = await this.getCategories();

     window.addEventListener('storage', async function() {
       this.cart = await this.getCartData();
       console.log(this.cart);

       if(this.cart.length !== 0) {
         for(let i = 0; i < this.cart.length; i++){
           this.totalPriceInCart = this.totalPriceInCart + +this.cart[i][2];
         }
       }
       else {
         this.totalPriceInCart = 0;
       }
     })

     // this.cart = await this.getCartData();
     // console.log(this.cart);
     //
     // if(this.cart.length !== 0) {
     //   for(let i = 0; i < this.cart.length; i++){
     //     this.totalPriceInCart = this.totalPriceInCart + +this.cart[i][2];
     //   }
     // }
     // else {
     //   this.totalPriceInCart = 0;
     // }
   },


   watch: {

     // localStorage(){
     //   console.log(this.totalPriceInCart);
     // },
     //
     // async totalPriceInCart(){
     //   console.log(this.totalPriceInCart);
     // }

        async isAuthorize() {
           console.log(this.isAuthorize(), this.getUser());
        }
   }
 }
</script>

<style>
  p {
    line-height: 0;
  }
  a {
    text-decoration: none;
  }
  .header__top{
    background-color: #913259;
    display: flex;
    justify-content: space-between;
  }
  .div__advertise, .div__profile, .div__search__cart, .img__logo{
    padding: 10px 50px 10px 50px;
    color: #ffffff;
  }
  .p__advertise {
    font-family: 'DIN PRO Light';
  }
  .nav {
    display: flex;
    flex-wrap: wrap;
    width: 438px;
    padding: 20px 50px 10px 44px;
  }
  .div__profile {
    margin-top: 4px;
  }
  .div__profile a {
    text-decoration: none;
    color: #ffffff;
    font-family: 'DIN PRO Medium';
  }
  .nav__profile:hover {
    transition: .2s;
  }
  .nav__profile:hover {
    color: #cecece;
  }
  .header__bottom {
    background-color: #ffffff;
    display: flex;
  }
  .nav__div{
    display: flex;
    flex-wrap: wrap;
  }
  .div__link {
    padding-right: 30px;
  }
  .nav__link {
    font-family: "DIN PRO Medium";
    font-size: 16px;
    border: none;
    background-color: white;
    cursor: pointer;
  }
  .div__link a, .div__search a, .div__cart a {
    text-decoration: none;
    color: #000000;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: white;
    box-shadow: 1px 5px 5px #dbdbdb;
    width: 31%;
    left: 0;
    z-index: 1;

    padding-top: 20px;
    padding-bottom: 20px;
  }

  .div__link:hover .dropdown-content{
    display: block;
  }

  .dropdown-content:hover {
    display: block;
  }

  .column {
    width: 33.33%;
    padding-left: 50px;
    padding-bottom: 10px;
    padding-top: 10px;
  }

  .column a {
    float: none;
    color: black;
    font-family: "DIN PRO Medium";
    text-decoration: none;
    display: block;
    text-align: left;
  }

  .column a:hover {
    color: #9b9b9b;
  }

  .row h3 {
    font-family: "DIN PRO Regular";
    padding-left: 50px;
    line-height: 0.1;
  }

  .row:after {
    content: "";
    clear: both;
  }

  .header__logo {
    margin-left: 90px;
    margin-top: 10px;
  }
  .img__logo {
    width: 120px;
    height: 20px;
  }
  .div__search__cart {
    display: flex;
  }
  .div__search {
    display: flex;
    align-items: center;
    padding-right: 30px;
  }

  .input__search {
    width: 300px;
    height: 20px;
    margin-right: 20px;
    border: none;
    border-bottom: 1px solid #9b9b9b;
  }
  .input__search:focus {
    outline: none;
    border: none;
    border-bottom: 1px solid #9b9b9b;
  }
  .img__search {
    margin-top: 5px;
    width: 34px;
    height: 34px;
    cursor: pointer;
  }

  .div__search button {
    background: none;
    border: none;
  }
  .div__cart {
    display: flex;
  }
  .img__cart {
    width: 44px;
    height: 44px;
  }
  .p__info__cart {
    font-family: "DIN PRO Regular";
  }
  .p__info__price {
    font-family: "DIN PRO Medium";
  }
  .p__info__cart, .p__info__price {
    color: black;
    font-size: 13px;
  }
</style>
