/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

//Inicializo Vuetify
import Vuetify from "vuetify";
Vue.use(Vuetify);

import Vue from "vue";

import excel from "vue-excel-export";
Vue.use(excel);

//Para dividir el flujo de los formularios
import VueFormWizard from "vue-form-wizard";
import "vue-form-wizard/dist/vue-form-wizard.min.css";
Vue.use(VueFormWizard);

//Asesor

Vue.component(
    "asesorindex-component",
    require("./components/asesor/AsesorIndexComponent.vue").default
);
Vue.component(
    "nuevagestion-component",
    require("./components/asesor/NuevaGestionComponent.vue").default
);
Vue.component(
    "gestiones-component",
    require("./components/asesor/GestionesComponent.vue").default
);

//Administrador
Vue.component(
    "reportesgestion-component",
    require("./components/reportes/ReportesGestionComponent.vue").default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",

    //Instancio Vuetify como parametro de Vue
    vuetify: new Vuetify({
        icons: {
            iconfont: "mdi"
        }
    })
});
