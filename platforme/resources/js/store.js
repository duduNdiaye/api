import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    user: null
  },

  mutations: {
    login(state, token) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
      state.user = {
        token: token
      }
    },

    logout(state) {
      delete axios.defaults.headers.common['Authorization']
      state.user = null
    }
  }
})
