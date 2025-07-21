/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
window.Popper = require('popper.js').default;
window.$ = window.jQuery = require('jquery');
require('bootstrap');
window.Sticky = require('sticky-js');
window.Cookies = require('js-cookie');
window.PerfectScrollbar = require('perfect-scrollbar').default;
window.swal = require('sweetalert2');
require('block-ui');
require('webpack-jquery-ui');
window.validate = require('jquery-validation');
window.moment = require('moment');
require('bootstrap-select');
require('bootstrap-timepicker');
require('bootstrap-datepicker');
require('bootstrap-datetime-picker');
require('bootstrap-daterangepicker');
require('bootstrap-datepicker/js/locales/bootstrap-datepicker.es');
require('bootstrap-datepicker/js/locales/bootstrap-datepicker.en-GB');
require('select2');


import Vue from 'vue';
import '../SharedAssets/js/shared.js';
import 'bootstrap-table/dist/bootstrap-table.js';
import 'bootstrap-table/dist/bootstrap-table-locale-all';
import BootstrapTable from "bootstrap-table/dist/bootstrap-table-vue.esm";
import Notifications from 'vue-notification'
import { store } from './store/store';
const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
import { Plugin } from 'vue-fragment';
import VueImg from 'v-img';
import Axios from 'axios';

import VDraggable from 'vue-sortable-list'
Vue.use(VDraggable)

import { EventBus } from './plugins/eventBus.js';
Vue.prototype.eventBus = EventBus;

Vue.use(VueImg);
Vue.use(Plugin);
Routing.setRoutingData(routes);
Vue.prototype.routing = Routing;
Vue.prototype.axios = Axios;
Vue.component('BootstrapTable', BootstrapTable);
Vue.config.productionTip = false;
Vue.use(Notifications);

new Vue({
    el: '#app',
    store,
    components: {
        AcrissCreatePage: () => import('./pages/acriss/AcrissCreatePage'),
        AcrissEditPage: () => import('./pages/acriss/AcrissEditPage'),
        AcrissListPage: () => import('./pages/acriss/AcrissListPage'),
        AcrissShowPage: () => import('./pages/acriss/AcrissShowPage'),

        'AssociateFleetClassificationPage': () => import('./pages/fleetClassification/associate/AssociateFleetClassificationPage'),
        'CarGroupPage': () => import('./pages/carGroup/create/CarGroupPage'),
        'CommercialGroupPage': () => import('./pages/commercialGroup/create/CommercialGroupPage'),
        'CommercialGroupListPage': () => import('./pages/commercialGroup/list/CommercialGroupListPage'),
        'CreateEditStopSalePage': () => import('./pages/stopSale/createEditStopSale/CreateEditStopSalePage'),
        'DynamicFooter': () => import('./components/DynamicFooter.vue'),
        'ExcelRoutePage': () => import('./pages/movement/routes/excel/ExcelRoutePage'),
        'EditCarGroupPage': () => import('./pages/carGroup/edit/EditCarGroupPage'),
        'EditCommercialGroupPage': () => import('./pages/commercialGroup/edit/EditCommercialGroupPage'),
        'ListCarGroupPage': () => import('./pages/carGroup/list/ListCarGroupPage'),
        'ListStopSalePage': () => import('./pages/stopSale/listStopSale/ListStopSalePage'),
        'LocationListPage': () => import('./pages/location/LocationListPage'),
        'MovementCreatePage': () => import('./pages/movement/Create/MovementCreatePage'),
        'MovementEditPage': () => import('./pages/movement/Edit/MovementEditPage'),
        'MovementDetailsPage': () => import('./pages/movement/Details/MovementDetailsPage'),
        'MovementListPage': () => import('./pages/movement/List/MovementListPage'),
        'MovementAssignVehicleListPage': () => import('./pages/movement/Management/MovementAssignVehicleListPage'),
        'MovementVehicleManagementPage': () => import('./pages/movement/Management/MovementVehicleManagementPage'),
        'ParameterSettingCreatePage': () => import('./pages/parameterSetting/create/ParameterSettingCreatePage'),
        'ParameterSettingListPage': () => import('./pages/parameterSetting/list/ParameterSettingListPage'),
        'PlanningPage': () => import('./pages/planning/PlanningPage'),
        'RoutesListPage': () => import('./pages/movement/routes/list/RoutesListPage'),
        'SeasonPage': () => import('./pages/season/listSeason/SeasonPage'),
        'ShowCarGroupPage': () => import('./pages/carGroup/show/ShowCarGroupPage'),
        'ShowCommercialGroupPage': () => import('./pages/commercialGroup/show/ShowCommercialGroupPage'),
        'SupplierListPage': () => import('./pages/supplier/SupplierListPage'),
        'UpdateDataPage': () => import('./pages/updateData/UpdateDataPage'),
        'VehicleBooking': () => import('./pages/vehicle/VehicleBooking'),
        'VehicleDetailsPage': () => import('./pages/vehicle/details/VehicleDetailsPage'),
        'VehicleListPage': () => import('./pages/vehicle/List/VehicleListPage'),
        'VehicleSearchPage': () => import('./pages/vehicle/VehicleSearchPage'),
    }
});
