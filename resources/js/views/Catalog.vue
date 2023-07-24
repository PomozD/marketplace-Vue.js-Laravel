<template>
  <div class="container__breadCrumbs">
    <router-link class="nav__main" to="/">Главная</router-link>
    <div v-if="type == null" class="breadCrumbs">
      <img class="arrow__right" src="../assets/arrowright.svg">
      <h1 class="breadCrumbs__current_page">{{category}}</h1>
    </div>
    <div v-else-if="type !== null" class="breadCrumbs">
      <img class="arrow__right" src="../assets/arrowright.svg">
      <router-link class="nav__children" :to="/catalog/ + category">{{category}}</router-link>

      <img class="arrow__right" src="../assets/arrowright.svg">
      <h1 class="breadCrumbs__current_page">{{type}}</h1>
    </div>
  </div>

  <div class="container__view">
    <div class="container__filtres">
      <div class="size">
        <hr>
        <details close>
          <summary>
            <h1>Размер</h1>
          </summary>
          <div class="container__size" style="height: 120px; overflow:auto;">
            <label v-for="size in sizes" :key="size">
              <input class="input__size" name="sizes" :value="size['Size']" type="checkbox" v-model="sizess"/>
              {{size["Size"]}}
            </label>
          </div>
        </details>
        <hr>
      </div>
    </div>
    <div class="container__catalog">
      <div class="number__sorting">
            <div class="number" v-if="cards?.length"><h1>Количество: {{cards?.length}}</h1></div>
<!--        <div class="number" v-else-if="sizess.length"><h1>Количество: {{filtredSizesCards.length}}</h1></div>-->
        <div class="number" v-else><h1>Количество: 0</h1></div>

        <div class="sorting">
          <h1>Сортировать по</h1>
          <select class="sorting__list" v-model="selected">
<!--            <option value="sorted__popular">По популярности</option>-->
            <option v-for="option in sortedOptions" :key="option" :value="option.value">
              {{option.text}}
            </option>
<!--            <option value="sorted__rating">По рейтингу</option>-->
          </select>
        </div>
      </div>
      <div class="catalog">
        <div class="catalog__cards">
            <template v-if="cards?.length">
            <div class="card" v-for="card in cards" :key="card">
              <button @click.prevent="toItemPage(card[0])" style="background: none; border: none;">
                <v-card-item :name="card['Name']" :price="card['Price']" :mainPhoto="card['Main_Photo']" />
              </button>
            </div>
          </template>

          <template v-else>
            <p>Нет товаров</p>
          </template>
        </div>
      </div>
    </div>
  </div>
<footer>
    <v-footer/>
</footer>
</template>

<script>
import VFooter from "../components/v-footer.vue";
import VCardItem from "../components/v-card-item.vue";
import { getItem } from "../services/catalog.js";
import { getSize } from "../services/catalog.js";
export default {
  name: "CatalogView",
  components: {
    VCardItem,
    VFooter
  },

  data() {
    return {
      cards: [],
      inCorrectCards: [],
      filtredCards: [],
      count: 0,
      category: null,
      type: null,
      sizes: null,
      filtres: [],
      sizess: [],

      selected: 'asc',

      sortedOptions: [
        {text: 'По возрастанию', value: 'asc'},
        {text: 'По убыванию', value: 'desc'},
      ],

      filtredSizesCards: null,

      queryCards: [],


      searchValue: '',
      selectValue: 'asc',


      //search: this.searchText,
    }
  },

  props: ['searchText'],

  methods: {
    async getItems() {
      //console.log(this.filtres);
      const response = await getItem(this.category, this.type, this.selectValue, this.filtres, this.searchValue);
      console.log(response);

      let newresponse = [];
      for (let i = 0; i < response?.length; i++) {
        console.log(i);
        if(response[i + 1] === undefined) {
          i = response.length - 1;
          newresponse.push(response[i]);
        }
        else {
          console.log(response[i][1]);
          /*if(response[i][1] === response[i + 1][1]) {
            continue;
          }*/
          newresponse.push(response[i]);
        }
        // console.log(response[i][1] === response[i++][1]);
      }

      console.log(newresponse);
      return newresponse;
    },

    async getSizes() {
      const size = await getSize();
      console.log(size);
      return size.size;
    },

    async toItemPage(id){
      console.log(this.$router.push("/catalog/item?id=" + id));
    }

  },

  async created() {

    this.sizes = await this.getSizes();

    this.cards = await this.getItems();
    console.log(this.cards);

    this.count = this.filtredCards.length;
    //console.log(this.sizes);
  },

  watch: {
    "$route.params": {
      handler: async function () {
        this.category = this.$route.params.category;
        console.log('категория', this.category);

        this.type = this.$route.params.type;
        console.log('тип', this.type);

        this.cards = await this.getItems();
      },
      immediate: true
    },

    async sizess() {
      this.filtres = this.sizess;
      console.log('размер', this.filtres);

      this.cards = await this.getItems();

      console.log(this.cards);
    },

    async selected(value) {

      this.selectValue = value;
      this.cards = await this.getItems();

      // this.cards.push(this.inCorrectCards[0]);

      //console.log(this.cards);
    },

     async searchText(value) {
      if(value !== '') {
        this.searchValue = value;

        this.cards = await this.getItems();
      }
      else if(value === ''){
        console.log('пустой');
        this.cards = await this.getItems();
      }
      else {
        this.searchValue = ' ';
        this.cards = await this.getItems();
      }
    },

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
.nav__children:hover {
  color: #9b9b9b;
}
.nav__main:hover {
  color: #9b9b9b;
}
.arrow__right {
  margin-right: 12px;
}
.container__breadCrumbs h1 {
  font-family: "DIN PRO Medium";
  font-size: 14px;
  font-weight: 600;
}

/* catalog */

.container__view {
  display: flex;
  margin-left: 50px;
}

.container__catalog {
  margin-left: 50px;
  margin-right: 50px;
  width: 100%;
}
.number__sorting {
  display: flex;
  justify-content: space-between;
}
.sorting {
  display: flex;
  align-items: center;
}

.sorting__list {
  margin-left: 20px;
  padding: 0 5px 0 5px;
  height: 40px;
  border: 1px solid black;
  color: #9b9b9b;
}

.catalog__cards {
  display: flex;
  flex-wrap: wrap;
}
.catalog__cards p {
  font-family: "DIN PRO Medium";
}
.card {
  width: 300px;
}

/* filtres */

.container__filtres {
  margin-top: 20px;
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
hr {
  width: 300px;
  margin-bottom: 0px;
}

.container__size {
  display: flex;
  flex-direction: column;
}
label {
  font-family: "DIN PRO Regular";
  font-size: 16px;
}
label input {
  margin-right: 20px;
}

</style>
