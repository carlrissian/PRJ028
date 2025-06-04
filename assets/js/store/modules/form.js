export const form = {
    namespaced: true,
    state: {
        items: [],
    },
    mutations: {
        items(state, item) {
            state.items[Object.keys(item)] = item[Object.keys(item)]
        },
        empty(state) {
            state.items = [];
        },
        delete(state, key) {
            delete state.items[key];
        }
    },
    getters: {
        items: state => state.items,
    }
};