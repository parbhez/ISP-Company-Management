import { createStore } from 'vuex'
import axios from 'axios'

// axios.defaults.baseURL = 'http://127.0.0.1:8000/api/v1';
// Create a new store instance.
const store = createStore({
    state: {
        search_str: '',
        roleWisePermission: [],
    },

    getters: {
        roleWisePermissionList(state) {
            return state.roleWisePermission;
        }
    },

    actions: {
        //For Filter any column
        updateSearchStr({ commit }, payload) {
            let { search_str } = payload
            commit('setSearchStr', search_str)
        },
        getRoleWisePermissionList(contex) {
            return new Promise((resolve, reject) => {
                axios.get('/role/roleWisePermissionList')
                    .then((response) => {
                        contex.commit('roleWisePermissionList', response.data.roleWisePermissionList);
                        resolve(response.data);
                    })
                    .catch((error) => {
                        reject(error);
                    })
            })
        },


    },

    mutations: {

        //For Filter
        setSearchStr(state, data) {
            state.search_str = data
        },

        roleWisePermissionList(state, data) {
            state.roleWisePermission = data;
        }
    }
})

export default store;