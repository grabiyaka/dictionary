import { createStore } from 'vuex'
import { token } from './modules/token'
import { loading } from './modules/loading'

const store = createStore({
    modules: {
        loading,
        token,
    }
})

export default store