require("./bootstrap");
require("babel-regenerator-runtime");
window.Vue = require("vue");

//date picker
import Datepicker from "vuejs-datepicker";
Vue.component("Datepicker", Datepicker);

//select box
import vSelect from "vue-select";
Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";

Vue.component("history-data", require("./views/History/list-history.vue"));

const app = new Vue({
  el: "#app",
});
