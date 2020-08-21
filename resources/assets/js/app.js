require("./bootstrap");
require("babel-regenerator-runtime");
window.Vue = require("vue");

Vue.component("list-data", require("./components/ListData/List.vue"));
Vue.component("history-data", require("./views/History/list-history.vue"));

const app = new Vue({
  el: "#app",
});
