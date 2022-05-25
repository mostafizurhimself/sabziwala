<template>
    <detail-view title="Message Details" :breadcrumb="breadcrumb">

        <!-- ID -->
        <detail-section class="border-b" label="ID" :value="contact.id"></detail-section>

        <!-- Name -->
        <detail-section class="border-b" label="Name" :value="contact.name"></detail-section>

        <!-- Email  -->
        <detail-section class="border-b" label="Email " :value="contact.email "></detail-section>

        <!-- Subject -->
        <detail-section class="border-b" label="Subject" :value="contact.subject"></detail-section>

        <!-- Message -->
        <detail-section class="border-b" label="Message" :value="contact.message"></detail-section>

        <!-- Reply -->
        <detail-section class="border-b" label="Reply" :value="contact.reply" v-if="contact.reply"></detail-section>

        <!-- Answered -->
        <detail-section class="border-b" label="Answered">
            <div class="w-3/4  break-words">
                <p :class="[contact.answered == true ? 'text-green-500': 'text-red-500',]">
                    <span v-if="contact.answered">Yes</span>
                    <span v-else>No</span>
                </p>
            </div>
        </detail-section>

        <!-- Reply -->
        <detail-section class="border-b" label="Reply" v-if="!contact.answered">
            <form @submit.prevent="reply" >
                <!-- Reply -->
                <div class="flex -mx-6 px-6">
                    <div class="w-3/4 py-4 break-words">
                        <jet-text-input v-model="form.reply" class="w-full"></jet-text-input>
                        <jet-input-error :message="form.errors.reply" class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center justify-end">
                    <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save</jet-button>
                </div>
            </form>

        </detail-section>

    </detail-view>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import DetailView from "@/Views/DetailView.vue";
import DetailSection from "@/Jetstream/DetailSection.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Tabs, Tab } from "vue3-tabs-component";
import JetBadge from "@/Jetstream/Badge.vue";
import JetTextInput from "@/Jetstream/TextInput.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInputError from "@/Jetstream/InputError.vue";
export default {
    name: "contact-details",
    props: {
        contact: Object,
    },

    components: {
        AppLayout,
        DetailView,
        DetailSection,
        Link,
        Tabs,
        Tab,
        JetBadge,
        JetTextInput,
        JetLabel,
        JetButton,
        JetInputError,
    },

    data() {
        return {
            form: this.$inertia.form({
                reply: null,
            }),

            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Messages", route: this.route("contacts.index") },
                { label: this.contact.name, route: null },
            ],
        };
    },


        methods: {
            reply() {
                this.form.post(this.route("contacts.reply", this.contact.id));
            },
        },

};
</script>
