require("./bootstrap");

window.Vue = require("vue");

import BlogPosts from "./components/BlogPosts.vue";

const app = new Vue({
    el: "#app",
    components: {
        BlogPosts
    }
});