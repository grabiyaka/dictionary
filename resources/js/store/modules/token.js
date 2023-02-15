export const token = {
    state: () => ({
        token: null,
    }),
    getters: {
        getToken(state){
            return state.token
        }
    },
    mutations: {
        setToken(state, token){
            state.token = token;
        },
    },
    actions: {
        getToken({commit}){
            commit('setToken', localStorage.getItem('x_xsrf_token'));
        },  
    },
}