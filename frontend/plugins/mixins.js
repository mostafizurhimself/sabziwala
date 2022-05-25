import Vue from "vue";
import { mapGetters } from 'vuex';

// Vue.filter("currencySymbol", function (value) {
//     return "Rs. " + Math.ceil(value);
// });

// Vue.filter("truncate", function (value, size = 150) {
//     if (!value) return "";
//     value = value.toString();

//     if (value.length <= size) {
//         return value;
//     }
//     return value.substr(0, size) + "...";
// });

Vue.mixin({
    computed: {
        ...mapGetters({
            getCurrency: 'config/getCurrency',
        }),
    },
    methods: {
        currencyFormat(value) {
            if (this.getCurrency && this.getCurrency.data) {
                return this.getCurrency.data.symbol + " " + new Intl.NumberFormat('en-IN').format(Math.round(value, 2));
            }
            return "Rs. " + new Intl.NumberFormat('en-IN').format(Math.round(value, 2));
        }
    },
})
