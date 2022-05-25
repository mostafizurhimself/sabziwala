<template>
    <div class="h-full">
        <form @submit.prevent="save" class="h-full">
            <!-- Purchase Terms-->
            <form-group class="border-b" style="height: 350px">
                <jet-label class="md:w-1/4 mt-2" for="purchase" value="Purchease Terms" required />
                <div class="w-full mt-1" style="height: 250px">
                    <QuillEditor v-model:content="form.purchase" contentType="html" theme="snow" />
                </div>
            </form-group>

            <!-- Refunds-->
            <form-group class="border-b" style="height: 350px">
                <jet-label class="md:w-1/4 mt-2" for="refunds" value="Refunds" required />
                <div class="w-full mt-1" style="height: 250px;">
                    <QuillEditor v-model:content="form.refunds" contentType="html" theme="snow" />
                </div>
            </form-group>

            <div class="footer">
                <Link :href="route('dashboard')" class="xs:mr-4">Cancel</Link>
                <jet-button class="px-6" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" v-if="$page.props.can.updateAppearances">Save</jet-button>
            </div>

        </form>

    </div>
</template>

<script>
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import { Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetTextInput from "@/Jetstream/TextInput.vue";
import JetButton from "@/Jetstream/Button.vue";
import FormGroup from "@/Jetstream/FormGroup.vue";
export default {
    title: "show-paymentRefunds",

    components: {
        Link,
        JetInput,
        JetInputError,
        JetLabel,
        JetTextInput,
        FormGroup,
        JetButton,
        QuillEditor,
    },

    data() {
        return {
            form: this.$inertia.form({
                purchase: this.$page.props.paymentRefunds?.data?.purchase,
                refunds: this.$page.props.paymentRefunds?.data?.refunds,
            }),
        };
    },

    methods: {
        save() {
            this.form.post(route("appearance.payments.paymentRefunds"));
        },
    },
};
</script>

<style lang="scss" scoped>
.footer {
    @apply flex flex-col-reverse xs:flex-row xs:items-center xs:justify-end px-4 py-5 bg-gray-50 text-center sm:px-6 shadow rounded-bl-primary rounded-br-primary w-full overflow-hidden;
}
</style>
