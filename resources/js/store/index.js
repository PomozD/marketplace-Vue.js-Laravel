import { createStore } from 'vuex'
// import axios from "axios";

export default createStore({
  state: {
    user: null,
  },

  actions: {},

  mutations: {
    updateUser(state, user) {
      state.user = user
    }
  },

  getters: {
    getUser(state){
      return state.user
    },

    isAuthorize(state) {
      return state.user != null
    }
  },
})
