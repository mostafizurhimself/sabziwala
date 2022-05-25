import Welcome from "@/Jetstream/Welcome.vue";

// Icons
import CustomerIcon from "@/Icons/CustomerIcon.vue";
import TagIcon from "@/Icons/TagIcon.vue";

export default function (app) {
    app.component('welcome', Welcome)
    app.component('customer-icon', CustomerIcon)
    app.component('tag-icon', TagIcon)
}
