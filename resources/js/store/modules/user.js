export const token = {
    state: () => ({
        user: null,
    }),
    getters: {
        getToken(state){
            return state.user
        }
    },
    mutations: {
        setUser(state, user){
            state.user = user;
        },
    },
    actions: {
        getToken({commit}){
            commit('setUser', localStorage.getItem('x_xsrf_token'));
        },  
    },
}