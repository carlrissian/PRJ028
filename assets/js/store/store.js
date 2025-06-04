import Vue from "vue";
import Vuex from 'vuex';
import { filter } from './modules/filter';
import { form } from './modules/form';

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        filter,
        form
    }
});