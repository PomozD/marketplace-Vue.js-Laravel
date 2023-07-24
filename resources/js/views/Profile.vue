<template>
  <div v-if="state.user" class="container">
<!--    User-->
    <div v-if="state.user.Role === 'user'">
      <div class="info__and__cart">
        <div class="container__profile">
          <h1>Профиль</h1>
          <h2>Имя</h2>
          <form @submit.prevent="editData">
            <input v-if="state.edit" v-model.trim="state.newName" :placeholder="state.user.Name" class="input__editInfo"/>
            <p v-if="v$.newName.$error && state.edit" class="invalid__data">Проверьте правильность полей</p>
            <p v-if="!state.edit">{{state.user.Name}}</p>

            <h2>Фамилия</h2>
            <input v-if="state.edit" v-model.trim="state.newSurname" :placeholder="state.user.Surname" class="input__editInfo"/>
            <p v-if="v$.newSurname.$error && state.edit" class="invalid__data">Проверьте правильность полей</p>
            <p v-if="!state.edit">{{state.user.Surname}}</p>

            <h2>Email</h2>
            <input v-if="state.edit" v-model.trim="state.newEmail" :placeholder="state.user.Email" class="input__editInfo"/>
            <p v-if="v$.newEmail.$error && state.edit" class="invalid__data">Проверьте правильность полей</p>
            <p v-if="!state.edit">{{state.user.Email}}</p>

            <h2 v-if="state.edit">Password</h2>
            <input v-if="state.edit" v-model.trim="state.newPassword" placeholder="Введите пароль" class="input__editInfo"/>
            <p v-if="v$.newPassword.$error && state.edit" class="invalid__data">Проверьте правильность полей</p>
<!--            <p v-if="!state.edit">{{state.user.Password}}</p>-->
            <div v-if="state.edit" class="button__logout">
              <button id="submit" style="margin-top: 20px; margin-bottom: -30px; width: 100%;">Сохранить</button>
            </div>
            <div class="buttons">
              <div v-if="!state.edit" class="button__edit">
                <button @click="editInfo()">Редактировать</button>
              </div>
              <div v-if="state.edit" class="button__edit">
                <button @click="backEdit()">Отменить</button>
              </div>
              <div class="button__logout">
                <button @click="logout()">Выйти</button>
              </div>
            </div>
          </form>
          <hr>
        </div>
        <div class="container__cart" style="height: 400px;">
          <h1>Корзина</h1>
          <div v-if="!state.cart.length"><p style="font-family: 'DIN PRO Regular'">Корзина пустая</p></div>
          <div v-if="state.cart.length" style="height: 400px; overflow-y: scroll">
            <div v-for="item in state.cart" :key="item">
              <h2>Название товара</h2>
              <p>{{item[1]}}</p>

              <h2>Цена</h2>
              <p>{{item[2]}} BYN</p>

              <h2>Размер</h2>
              <p>{{item[3]}}</p>

              <h2>Количество</h2>
              <div class="div__count">
                <div class="counter__minus" @click="itemMinusFunction(item)">-</div>
                <div class="count">{{item[4]}}</div>
                <div class="counter__plus" @click="itemPlusFunction(item)">+</div>
              </div>

              <div class="buttons">
                <div class="button__order" @click="orderItemFunction(item)">
                  <button>Заказать</button>
                </div>
                <div class="button__delete" @click="deleteItemFunction(item)">
                  <button>Удалить</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container__orders">
        <h1>Покупки</h1>
        <div v-if="!userOrders?.length"><p>Вы еще ничего не заказывали</p></div>
        <div v-if="userOrders?.length" style="height: 250px; overflow-y: scroll">
          <div v-for="order in userOrders" :key="order" style="margin-top: 25px">
            <h2>Название товара</h2>
            <p>{{order.Name}}</p>

            <h2>Размер</h2>
            <p>{{order.Size}}</p>

            <h2>Количество</h2>
            <p>{{order.Count}}</p>

            <h2>Номер заказа</h2>
            <p style="margin-bottom: 35px">{{order.Number_order}}</p>
            <hr>
          </div>
        </div>
      </div>
    </div>

<!--Admin-->
    <div v-if="state.user.Role === 'admin'">
      <hr>
      <div style="width: 100%">
        <details close>
          <summary>
            <h2 style="font-family: 'DIN PRO Medium'">Продукты</h2>
          </summary>
          <table style="width: 100%; table-layout: fixed;">
            <tr>
              <th class="thProducts">ID</th>
              <th class="thProducts">Название</th>
              <th class="thProducts">Размер</th>
              <th class="thProducts">Пол</th>
              <th class="thProducts">Категория</th>
              <th class="thProducts">Тип</th>
              <th class="thProducts">Цена</th>
              <th class="thProducts">Количество</th>
              <th class="thProducts">Описание</th>
              <th class="thProducts">Главное фото</th>
              <th class="thProducts">Первое доп. фото</th>
              <th class="thProducts">Второе доп. фото</th>
              <th class="thProducts">Редактирование</th>
              <th class="thProducts">Удаление</th>
            </tr>
            <tr v-for="item in allProducts" :key="item">
              <td class="tdProducts"><p class="input__products">{{item['ID']}}</p></td>
              <td class="tdProducts"><input class="input__products" v-model.trim="item['Name']" :placeholder="item['Name']" type="text"/></td>
              <td class="tdProducts"><input class="input__products" v-model.trim="item['Size']" pattern="\D [^0-9]" :placeholder="item['Size']" type="text"/></td>
              <td class="tdProducts"><input class="input__products" v-model.trim="item['Sex']" pattern="\D [^0-9]" :placeholder="item['Sex']" type="text"/></td>
              <td class="tdProducts"><p class="input__products">{{item['Category']}}</p></td>
              <td class="tdProducts"><input class="input__products" v-model.trim="item['Type']" pattern="\D [^0-9]" :placeholder="item['Type']" type="text"/></td>
              <td class="tdProducts"><input class="input__products" v-model.trim="item['Price']" min="0" pattern="^[ 0-9]+$" :placeholder="item['Price']" type="text"/></td>
              <td class="tdProducts"><input class="input__products" v-model.trim="item['Count']" min="0" pattern="^[ 0-9]+$" :placeholder="item['Count']" type="text"/></td>
              <td class="tdProducts"><input class="input__products" v-model.trim="item['Composition']" :placeholder="item['Composition']"/></td>
              <td class="tdProducts"><input class="input__products" v-model.trim="item['Main_Photo']" :placeholder="item['Main_Photo']"/></td>
              <td class="tdProducts"><input class="input__products" v-model.trim="item['Secondary_Photo_first']" :placeholder="item['Secondary_Photo_first']"/></td>
              <td class="tdProducts"><input class="input__products" v-model.trim="item['Secondary_Photo_second']" :placeholder="item['Secondary_Photo_second']"/></td>
              <td class="tdProducts"><button @click="saveEditProduct(item)">Save</button></td>
              <td class="tdProducts"><button @click="deleteProduct(item)">Delete</button></td>
            </tr>
            <tr>
              <td class="tdProducts"><p class="input__products">ID</p></td>
              <td class="tdProducts"><input class="input__products" v-model.trim="input_newItem_name" placeholder="Название товара"/></td>
              <td class="tdProducts">
                <select v-model="selectedSize">
                  <option v-for="option in sizeOptions" :key="option">
                    {{option['Size']}}
                  </option>
                </select>
              </td>
              <td class="tdProducts">
                <select v-model="selectedSex">
                  <option v-for="option in sexOptions" :key="option">
                   {{option['Sex']}}
                  </option>
                </select>
              </td>
<!--              <td class="tdProducts"><input class="input__products" v-model.trim="input_newItem_category" placeholder="Категория"/></td>-->
              <td class="tdProducts">
                <select v-model="selectedCategory">
                  <option v-for="option in categoryOptions" :key="option">
                    {{option['Name']}}
                  </option>
                </select>
              </td>
              <td class="tdProducts" v-if="selectedCategory">
                <select v-model="selectedType">
                  <option v-for="option in typeOptions" :key="option">
                    {{option['Name']}}
                  </option>
                </select>
              </td>
              <td class="tdProducts" v-if="!selectedCategory">
                <p>Тип</p>
              </td>
              <td class="tdProducts"><input class="input__products" v-model.trim="input_newItem_price" placeholder="Цена"/></td>
              <td class="tdProducts"><input class="input__products" v-model.trim="input_newItem_count" placeholder="Количество"/></td>
              <td class="tdProducts"><input class="input__products" v-model.trim="input_newItem_composition" placeholder="Описание"/></td>
              <td class="tdProducts"><input class="input__products" v-model.trim="input_newItem_mainPhoto" placeholder="Главное фото"/></td>
              <td class="tdProducts"><input class="input__products" v-model.trim="input_newItem_fsPhoto" placeholder="Первое доп. фото"/></td>
              <td class="tdProducts"><input class="input__products" v-model.trim="input_newItem_ssPhoto" placeholder="Второе доп. фото"/></td>
              <td class="tdProducts"><button @click="saveAddProduct">Добавить</button></td>
            </tr>
          </table>
        </details>
      </div>
      <hr>
      <div style="width: 100%">
        <details close>
          <summary>
            <h2 style="font-family: 'DIN PRO Medium'">Добавление новой категории</h2>
          </summary>
          <input v-model.trim="newCategory" type="text" placeholder="Введите категорию" class="input__editInfo"/>
          <div class="buttons">
            <div class="button__add" @click="addCategoryFunction">
              <button>Добавить</button>
            </div>
          </div>
        </details>
      </div>
      <hr>
      <div style="width: 100%">
        <details close>
          <summary>
            <h2 style="font-family: 'DIN PRO Medium'">Удаление категории</h2>
          </summary>
          <input v-model.trim="deleteCategory" type="text" placeholder="Введите категорию" class="input__editInfo"/>
          <div class="buttons">
            <div class="button__add" @click="deleteCategoryFunction">
              <button>Удалить</button>
            </div>
          </div>
        </details>
      </div>
      <hr>
      <div style="width: 100%">
        <details close>
          <summary>
            <h2 style="font-family: 'DIN PRO Medium'">Добавление типа категории</h2>
          </summary>
          <div>
            <select v-model="addTypesSelectedCategory" style="margin-bottom: 20px; padding: 0 5px 0 5px; height: 40px; border: 2px solid black; color: black;">
              <option v-for="option in categoryOptions" :key="option">
                {{option['Name']}}
              </option>
            </select>
          </div>
          <input v-model.trim="newType" type="text" placeholder="Введите новый тип" class="input__editInfo"/>
          <div class="buttons">
            <div class="button__add" @click="addTypeFunction">
              <button>Добавить</button>
            </div>
          </div>
        </details>
      </div>
      <hr>
      <div style="width: 100%">
        <details close>
          <summary>
            <h2 style="font-family: 'DIN PRO Medium'">Удаление типа категории</h2>
          </summary>
          <div>
            <select v-model="deleteTypesSelectedCategory" style="margin-bottom: 20px; padding: 0 5px 0 5px; height: 40px; border: 2px solid black; color: black;">
              <option v-for="option in categoryOptions" :key="option">
                {{option['Name']}}
              </option>
            </select>
          </div>
          <div v-if="deleteTypesSelectedCategory">
            <select v-model="deleteType" style="margin-bottom: 20px; padding: 0 5px 0 5px; height: 40px; border: 2px solid black; color: black;">
              <option v-for="option in typeOptions" :key="option">
                {{option['Name']}}
              </option>
            </select>
          </div>
          <div v-if="!deleteTypesSelectedCategory">
            <div style="border: 2px solid black; width: 50px; display: flex; align-items: center; justify-content: center">
              <p style="font-family: 'DIN PRO Medium'">Тип</p>
            </div>
          </div>
          <div class="buttons">
            <div class="button__add" @click="deleteTypeFunction">
              <button>Удалить</button>
            </div>
          </div>
        </details>
      </div>
      <hr>
      <div class="buttons">
        <div class="button__logout">
          <button @click="logout()">Выйти</button>
        </div>
      </div>
    </div>
  </div>
  <p v-else>Авторизируйтесь для доступа</p>


  <footer>
    <v-footer/>
  </footer>
</template>

<script>
import VFooter from "../components/v-footer.vue";
import { getUserInfo, editUserData, getOrdersInfo } from "../services/profile.js";
import { getCountAndPrice } from "../services/cardsWithName.js";
import { order } from "../services/orders.js";
import { getAllProducts, editProducts, deleteProducts } from "../services/getAllProducts.js";

import { getSize, getSex, getCategory, getType, addProduct, addCategory, deleteCategory, addType, deleteType } from "../services/adminFunctions.js";

import {mapGetters, mapMutations} from 'vuex';

import useVuelidate from '@vuelidate/core'
import { required, email, minLength } from '@vuelidate/validators'
import { reactive, computed } from 'vue'

export default {
  name: "ProfileView",

  data() {
    return {
      edited: '',
      itemMinus: [],
      itemPlus: [],
      totalPriceInCart: 0,
      deleteItem: [],
      orderItem: [],

      userOrders: [],

      allProducts: [],
      isEditProducts: false,
      isDeleteProducts: false,
      isAddProduct: false,

      selectedSize: '',
      sizeOptions: null,
      selectedSex: '',
      sexOptions: null,
      selectedCategory: '',
      categoryOptions: null,
      selectedType: '',
      typeOptions: null,
      input_newItem_name: '',
      input_newItem_price: '',
      input_newItem_count: '',
      input_newItem_composition: '',
      input_newItem_mainPhoto: '',
      input_newItem_fsPhoto: '',
      input_newItem_ssPhoto: '',

      addTypesSelectedCategory: '',
      deleteType: '',
      deleteCategory: '',
      newCategory: '',
      newType: '',

      deleteTypesSelectedCategory: '',
      reg: /\w+/,
    }
  },

  setup() {
    const state = reactive({
      user: [],
      edit: false,

      newName: null,
      newSurname: null,
      newEmail: null,
      newPassword: null,

      cart: [],

    })

    const rules = computed(() => {
      return {
        newName: { required },
        newSurname: { required },
        newEmail: { required, email },
        newPassword: { required, minLength: minLength(6) },
      }
    })

    const v$ = useVuelidate(rules, state)

    return {
      state, v$,
    }
  },

  methods: {
    ...mapMutations(["updateUser"]),
    ...mapGetters(["isAuthorize"]),

    async getInfo() {
      const response = await getUserInfo(this.$route.query.id);
      console.log(response.userInfo[0]);
      return response.userInfo[0];
    },

    editInfo() {
      this.state.edit = true;
    },

    async editData() {
      this.v$.$validate()
      if(!this.v$.$error){
        const response = await editUserData(this.$route.query.id ,this.state.newName, this.state.newSurname, this.state.newEmail,
        this.state.newPassword, this.state.user.Email);
        //
        // const newresponse = await getUserInfo(this.$route.query.id);
        // this.updateUser(newresponse.userInfo);
        // console.log(newresponse.userInfo);
        this.state.edit = false;
        this.edited = response.message;
        // return newresponse.userInfo;
      }
      else {
        alert('Проверьте заполнение полей');
      }
    },

    logout() {
      this.$store.state.user = null;
      this.$router.push({path: '/'});
    },

    backEdit() {
      this.state.edit = false;
    },

    async getCartData() {
      let response = [];
      for (let i = 0; i < localStorage.length; i+= 1) {
        const key = localStorage.key(i);
        response.push(JSON.parse(localStorage[key]));
      }
      return response;
    },

    async itemMinusFunction(minusItem){
      this.itemMinus = minusItem;
    },

    async itemPlusFunction(plusItem){
      this.itemPlus = plusItem;
    },

    async deleteItemFunction(deleteItem){
      this.deleteItem = deleteItem;
    },

    async orderItemFunction(orderItem){
      this.orderItem = orderItem;
    },

    async getOrders() {
      const response = await getOrdersInfo(this.$route.query.id);
      return response.info;
    },

    async getProducts() {
      const response = await getAllProducts();
      console.log(response)
      return response;
    },
    async getSizes() {
      const response = await getSize();
      return response;
    },
    async getSexs() {
      const response = await getSex();
      return response;
    },
    async getCategories() {
      const response = await getCategory();
      return response;
    },

    async saveEditProduct(item) {
      if(item['Name'] !== '' && item['Size'] !== '' && item['Sex'] !== '' && item['Category'] && item['Type'] !== '' &&
      item['Price'] !== '' && Number(item['Price']) >= 0 && item['Count'] !== '' && Number(item['Count']) >= 0  && item['Composition'] !== '' &&
      item['Main_Photo'] !== '' && item['Secondary_Photo_first'] !== '' && item['Secondary_Photo_second'] !== '') {
        const response = await editProducts(item['ID'], item['Name'], item['Size'], item['Sex'], item['Category'], item['Type'],
            item['Price'], item['Count'], item['Composition'], item['Main_Photo'], item['Secondary_Photo_first'], item['Secondary_Photo_second']);
        console.log(response[0].type == 1);
        if(response[0].type == 0) {
            this.isEditProducts = true;
            alert('Продукт отредактирован');
        } else {
            alert('Проверьте правильность заполнения полей');
        }
          this.isEditProducts = true;
      }
      else {
        alert('Проверьте правильность заполнения полей');
      }
    },

    async deleteProduct(item) {
      const response = await deleteProducts(item['ID']);
      alert('Продукт удален');
      this.isDeleteProducts = true;
    },

    async saveAddProduct() {
      if(this.input_newItem_name !== '' && this.selectedSize !== '' && this.selectedSex !== '' && this.selectedCategory !== '' &&
        this.selectedType !== '' && this.input_newItem_price !== '' && Number(this.input_newItem_price) >= 0 &&
        this.input_newItem_count !== '' && Number(this.input_newItem_count) >= 0 && this.input_newItem_composition !== '' &&
        this.input_newItem_mainPhoto !== '' && this.input_newItem_fsPhoto !== '' && this.input_newItem_ssPhoto !== '') {

        const response = await addProduct(this.input_newItem_name, this.selectedSize, this.selectedSex, this.selectedCategory,
            this.selectedType, this.input_newItem_price, this.input_newItem_count, this.input_newItem_composition,
            this.input_newItem_mainPhoto, this.input_newItem_fsPhoto, this.input_newItem_ssPhoto);

        if(response[0].type === 0) {
          this.isAddProduct = true;
          alert('Продукт добавлен')
        }
        else {
          alert('Продукт не добавлен');
        }
      } else {
        alert('Проверьте правильность заполнения полей');
      }
    },

    async addCategoryFunction() {
      if(this.newCategory !== '' && !this.reg.test(this.newCategory) && this.newCategory !== undefined){
        const response = await addCategory(this.newCategory);
        console.log(response.type);
        if(response.type === 1) {
            alert('Проверьте правильность заполнения данного поля');
        } else {
            alert('Категория добавлена');
        }
      }
      else {
        alert('Проверьте правильность заполнения поля');
      }
    },

    async deleteCategoryFunction() {
      if(this.deleteCategory !== ''  && !this.reg.test(this.deleteCategory) && this.deleteCategory !== undefined){
        const response = await deleteCategory(this.deleteCategory);
        console.log(response);
        if(response.type == 0) {
          alert('Категория удалена');
        } else {
          alert('Проверьте правильность заполнения полей');
        }
      }
      else {
        alert('Проверьте правильность заполнения поля');
      }
    },

    async addTypeFunction() {
      if(this.newType !== '' && !this.reg.test(this.newType) && this.newType !== undefined){
        const response = await addType(this.addTypesSelectedCategory, this.newType);
        if(response.type == 0) {
            alert(response.message);
        } else {
            alert(response.message);
        }

        const newresponse = await getType(this.deleteTypesSelectedCategory);
        console.log(newresponse);
        // this.typeOptions = newresponse.type;
      }
      else {
        alert('Проверьте правильность заполнения поля');
      }
    },

    async deleteTypeFunction() {
      console.log(this.deleteTypesSelectedCategory, this.deleteType);
      if(this.deleteTypesSelectedCategory && this.deleteType !== '') {
        const response = await deleteType(this.deleteTypesSelectedCategory, this.deleteType);
        console.log(response.data);

        const newresponse = await getType(this.deleteTypesSelectedCategory);
        console.log(newresponse);
        this.typeOptions = newresponse.type;
        alert('Тип удален');
      }
      else {
        alert('Заполните данные');
      }
    },
  },

  async created(){
    this.state.user = await this.getInfo();

    //console.log(this.state.user);

    if(!this.isAuthorize()){
      this.$router.push("/Authorization");
    }

    this.allProducts = await this.getProducts();
    console.log(this.allProducts);
    this.sizeOptions = await this.getSizes();
    console.log(this.sizeOptions);
    this.sexOptions = await this.getSexs();
    console.log(this.sexOptions);
    this.categoryOptions = await this.getCategories();
    console.log(this.categoryOptions);

    this.userOrders = await this.getOrders();

    this.state.cart = await this.getCartData();

    for(let i = 0; i < this.state.cart.length; i++){
      this.totalPriceInCart = this.totalPriceInCart + +this.state.cart[i][2];
    }

  },

  watch: {
    "$route.params": {
      handler: async function () {
        this.sizeOptions = await this.getSizes();
        this.sexOptions = await this.getSexs();
        this.categoryOptions = await this.getCategories();
      },
      immediate: true
    },
    async edited(value) {
      if(value !== 'Пользователь с таким Email уже зарегистрирован') {
        const newresponse = await getUserInfo(this.$route.query.id);
        this.updateUser(newresponse.userInfo);
        this.state.user = newresponse.userInfo;
        alert('Данные изменены');
      }
      else {
        alert("Пользователь с таким Email уже зарегистрирован");
      }
    },

    async itemMinus(){
      var cartData = JSON.parse(localStorage.getItem(this.itemMinus[0]));

      const response = await getCountAndPrice(this.itemPlus[0]);
      let countAndPrice = response.items;

      if(cartData[4] > 1){
        cartData[4] -= 1;
        cartData[2] = +cartData[2] - +countAndPrice[0][0];

        this.totalPriceInCart = this.totalPriceInCart - +countAndPrice[0][0];
      }
      else {
        cartData[4] = 1;
      }

      console.log(this.totalPriceInCart);
      localStorage.setItem(this.itemMinus[0], JSON.stringify(cartData));
      this.state.cart = await this.getCartData();
    },
    async itemPlus(){
      var cartData = JSON.parse(localStorage.getItem(this.itemPlus[0]));

      const response = await getCountAndPrice(this.itemPlus[0]);
      let countAndPrice = response.items;

      if(cartData[4] >= 1){
        if(cartData[4] < +countAndPrice[0][1]) {
          cartData[4] += 1;
          cartData[2] = +cartData[2] + +countAndPrice[0][0];

          this.totalPriceInCart = this.totalPriceInCart + +countAndPrice[0][0];
        }
        else {
          cartData[4] = +countAndPrice[0][1];
        }
      }
      else {
        cartData[4] = 1;
      }

      console.log(this.totalPriceInCart);
      localStorage.setItem(this.itemPlus[0], JSON.stringify(cartData));
      this.state.cart = await this.getCartData();
    },
    async deleteItem(){
      localStorage.removeItem(this.deleteItem[0]);
      this.state.cart = await this.getCartData();
    },
    async orderItem(){
      function getRandomInt(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min)) + min; //Максимум не включается, минимум включается
      }
      let number_order = getRandomInt(1, 99999);

      const response = await order(this.$route.query.id, this.orderItem[0], this.orderItem[4], number_order);
      console.log(response);
      if(response.type === 0){
        alert('Товар: ' + this.orderItem[1] + '\n' +
            'Размер: ' + this.orderItem[2] + '\n' +
            'Цена: ' + this.orderItem[3] + '\n' +
            'Количество: ' + this.orderItem[4] + '\n');
        localStorage.removeItem(this.orderItem[0]);
        this.state.cart = await this.getCartData();
        this.userOrders = await this.getOrders();
      }
      else {
        alert('Произошла ошибка при оформлении товара');
      }
    },
    async isEditProducts() {
      this.allProducts = await this.getProducts();
      this.isEditProducts = false;
    },
    async isDeleteProducts(){
      this.allProducts = await this.getProducts();
      this.isDeleteProducts = false;
    },
    async selectedCategory() {
      console.log(this.selectedCategory);
      const response = await getType(this.selectedCategory);
      console.log(response);
      this.typeOptions = response;
    },
    async isAddProduct(){
      console.log(this.input_newItem_name, this.selectedSize, this.selectedSex, this.selectedCategory,
          this.selectedType, this.input_newItem_price, this.input_newItem_count, this.input_newItem_composition,
          this.input_newItem_mainPhoto, this.input_newItem_fsPhoto, this.input_newItem_ssPhoto);
      this.allProducts = await this.getProducts();
      this.isAddProduct = false;
    },

    async deleteTypesSelectedCategory(){
        const response = await getType(this.deleteTypesSelectedCategory);
        this.typeOptions = response;
        console.log(this.typeOptions);
    },
  },

  components: {
    VFooter
  },
}
</script>

<style scoped>
  .container {
    margin: 20px 50px 100px 50px;
  }

  .info__and__cart {
    width: 70%;
    display: flex;
    align-items: center;
    margin: 0 auto;
  }

  .container__profile, .container__cart {
    width: 50%;
  }

  .container__profile h1, .container__cart h1, .container__orders h1 {
    font-family: "DIN PRO Medium";
    font-size: 30px;
  }

  .container__profile h2, .container__cart h2, .container__orders h2 {
    font-family: "DIN PRO Regular";
    font-size: 18px;
  }

  .container__profile p, .container__cart p, .container__orders p {
    font-family: "DIN PRO Regular";
    font-size: 18px;
  }


  .input__editInfo {
    border: 2px solid black;
    height: 35px;
    width: 310px;
    padding-left: 20px;
    color: black;
    font-family: "DIN PRO Regular";
    font-size: 15px;
  }

  .container__cart {
    margin-left: 300px;
  }

  .div__count {
    display: flex;
  }

  .counter__minus, .count, .counter__plus {
    font-family: "DIN PRO Medium";
    margin-right: 15px;
  }

  .counter__minus, .counter__plus {
    cursor: pointer;
    border: 1px solid black;
    width: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: .2s;
  }

  .counter__minus:hover, .counter__plus:hover {
    cursor: pointer;
    border: 1px solid black;
    width: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #dadada;
  }


  hr {
    border-top: 1px solid black;
  }
  .buttons {
    display: flex;
    margin: 20px auto;
  }

  .button__edit button, .button__order button {
    padding: 12px 50px;
    color: black;
    transition: .5s;
    background-color: white;
    font-family: "DIN PRO Medium";
    font-size: 14px;
    margin-right: 20px;
    border: 2px solid black;
    cursor: pointer;
  }

  .button__edit button:hover, .button__order button:hover {
    background: #913259;
    color: #ffffff;
    border: 2px solid #913259;
  }

  .button__logout button, .button__delete button, .button__add button {
    padding: 12px 50px;
    color: white;
    text-decoration: none;
    overflow: hidden;
    transition: .5s;
    background: black;
    font-family: "DIN PRO Medium";
    font-size: 14px;
    margin: 0 auto;
    border: 2px solid black;
    cursor: pointer;
  }

  .button__logout button:hover, .button__delete button:hover, .button__add button:hover {
    background: #913259;
    color: #ffffff;
    border: 2px solid #913259;
  }

  .container__orders {
    width: 27%;
    display: flex;
    flex-direction: column;
    margin-left: 210px;
  }

  .container__orders h1 {
    font-family: "DIN PRO Medium";
    font-size: 30px;
  }

  .input__theme {
    border: 2px solid black;
    height: 35px;
    margin-bottom: 30px;
    padding-left: 20px;
    color: black;
    font-family: "DIN PRO Regular";
    font-size: 15px;
  }
  .textarea__text {
    border: 2px solid black;
    height: 120px;
    margin-bottom: 30px;
    padding: 20px;
    color: black;
    font-family: "DIN PRO Regular";
    font-size: 15px;
    resize: none;
  }

  .button__send button {
    padding: 12px 50px;
    color: white;
    text-decoration: none;
    overflow: hidden;
    transition: .5s;
    background: black;
    font-family: "DIN PRO Medium";
    font-size: 14px;
    margin: 0 auto;
    border: 2px solid black;
    cursor: pointer;
  }

  .button__send button:hover {
    background: #913259;
    color: #ffffff;
    border: 2px solid #913259;
  }

  .invalid__data {
    color: #d34339;
    margin-top: 15px;
    font-family: 'DIN PRO Regular';
    font-size: 14px;
    margin-bottom: 20px;
  }

  details {
    display: flex;
    align-items: center;
  }
  details > summary {
    list-style: none;
    cursor: pointer;
    display: flex;
    align-items: center;
  }
  summary h2 {
    margin-left:20px;
  }
  summary:before {
    content: url(../assets/arrowdown.svg);
    padding: 15px 0px 0px 0px;
  }
  details[open] summary:before {
    content: url(../assets/arrowup.svg);
  }

  .thProducts{
    border: 2px solid black;
    font-family: 'DIN PRO Medium';
    word-wrap:break-word;
  }
  .tdProducts{
    border: 2px solid black;
    font-family: 'DIN PRO Medium';
    word-wrap:break-word;
  }
  .input__products {
    width: 100%;
    box-sizing: border-box;
  }

</style>
