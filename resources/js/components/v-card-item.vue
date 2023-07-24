<template>
  <router-link to="/catalog/item" :id="id">
    <div class="container">
      <div class="container__image">
        <img class="item__image" :src="mainPhoto">
      </div>
      <v-info-item :name="name" :price="price" :key="info" />
    </div>
  </router-link>
</template>

<script>
import VInfoItem from "../components/v-info-item.vue";
export default {
  name: "v-card-item",
  components: {
    VInfoItem
  },

  props: [
      "id",
      "name",
      "price",
      "mainPhoto",
  ]
}
</script>

<style scoped>
router-link {
  color: black !important;
}
.container {
  margin-right: 15px;
  margin-left: 15px;

}

.container__image {
  text-align: center;
}

.item__image {
  width: 80%;
}

</style>
