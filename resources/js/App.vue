<template>
  <header>
    <v-menu @search="searchItems"/>
  </header>
    <RouterView :searchText="searchText"/>
</template>

<script>
import { RouterView } from "vue-router";
import vMenu from '../js/components/v-menu.vue';

export default {
  name: 'app',

  data() {
    return {
      searchText: '',
    }
  },

  methods: {
    searchItems(data){
      if(data.searchText !== ''){
        this.searchText = data.searchText;
      }

      //console.log(this.searchText);
    }
  },

  components: {
    vMenu
  }
}
</script>

<style>
  body {
    margin: 0;
  }
</style>
