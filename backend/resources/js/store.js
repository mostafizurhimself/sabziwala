import { createStore } from 'vuex'

// Create a new store instance.
const store = createStore({
    state() {
        return {
            isCollapsed: false
        }
    },
    mutations: {
        TOGGLE_COLLAPSED(state) {
            state.isCollapsed = !state.isCollapsed
        },

        SET_COLLAPSED(state, payload) {
            state.isCollapsed = payload
        }
    },
    actions: {
        toggleCollapsed(context) {
            context.commit('TOGGLE_COLLAPSED')
        },
        setCollapsed(context, payload) {
            context.commit('SET_COLLAPSED', payload)
        }
    }
})

export default store;