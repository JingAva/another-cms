import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

let store = {};

store = new Vuex.Store({
  state: {
    user: null,
    setting: [],
    domain: '',
  },
  mutations: {
    setAuthUser(state, user) {
      state.user = user;
    },
    setGeneralSettings(state, setting) {
      state.setting = setting;

      setting.forEach( (item, index) => {
        if (item.name == 'Domain') {
          state.domain = item.value;
        }
      })
    },
  },
  getters: {
    isLoggedIn(state) {
        return state.user !== null;
    },
    userId(state) {
      return state.user.id;
    },
    userPhoto(state) {
      return state.user.photo;
    },
    getDomain(state) {
      return state.domain;
    }
  }
});

export const adminStore = store;