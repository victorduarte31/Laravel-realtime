import axios from 'axios'

export default {

    state: {
        messages: [],
        users: []
    },

    mutations: {
        LOAD_MESSAGES(state, messages) {
            state.messages = messages;
        },

        ADD_MESSAGE(state, message) {
            state.messages.push(message)
        },

        LOAD_USERS(state, users) {
            state.users = users
        },

        USER_JOIN(state, user) {
            state.users.push(user)
        },

        LEAVING_USER(state, user) {
            state.users = state.users.filter(u => {
                return u.id !== user.id
            })
        },


    },

    actions: {
        storeMessage(context, params) {

            console.log(params)

            return axios.post('/chat/message', params)
                .then(response => {
                    console.log(response.data);
                    context.commit('ADD_MESSAGE', response.data)
                })
                .catch(error => console.log(error));
        },

        loadMessages(context) {
            return axios.get('/chat/messages')
                .then(response => context.commit('LOAD_MESSAGES', response.data))
        }
    },

    getters: {
        messages(state) {
            return _.orderBy(state.messages, 'id', 'asc')
        }
    }

}
