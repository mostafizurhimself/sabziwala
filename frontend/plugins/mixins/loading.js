import Vue from "vue";

Vue.mixin({
    data() {
        return {
            isLoading: true
        };
    },

    methods: {
        startLoading() {
            this.isLoading = true
        },
        stopLoading() {
            this.isLoading = false
        }
    },
});