<template>
    <div class="" >
        <form @submit.prevent="save">
            <!-- Country Name-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="name" value="Country Name" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.name" id="name" type="text" class="w-full" autocomplete="name" />
                    <jet-input-error :message="form.errors.name" class="mt-2" />
                </div>
            </form-group>

             <!--Code-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="code" value="Currency Code" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.code" id="code" type="text" class="w-full" autocomplete="code" />
                    <jet-input-error :message="form.errors.code" class="mt-2" />
                </div>
            </form-group>

                <!--Symbol-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="symbol" value="Currency Symbol" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.symbol" id="symbol" type="text" class="w-full" autocomplete="symbol" />
                    <jet-input-error :message="form.errors.symbol" class="mt-2" />
                </div>
            </form-group>

            <div class="footer">
                <Link :href="route('dashboard')" class="xs:mr-4">Cancel</Link>
                <jet-button class="px-6" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" v-if="$page.props.can.updateSettings">Save</jet-button>
            </div>

        </form>

    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetTextInput from "@/Jetstream/TextInput.vue";
import JetButton from "@/Jetstream/Button.vue";
import FormGroup from "@/Jetstream/FormGroup.vue";
export default {
    name: "currency-settings",

    components: {
        Link,
        JetInput,
        JetInputError,
        JetLabel,
        JetTextInput,
        FormGroup,
        JetButton,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: this.$page.props.currency?.data?.name,
                code: this.$page.props.currency?.data?.code,
                symbol: this.$page.props.currency?.data?.symbol,
            }),

        };
    },

    methods: {
        save() {
            this.form.post(route("settings.currency"));
        },
    },
};
</script>

<style lang="scss" scoped>
.footer {
    @apply flex flex-col-reverse xs:flex-row xs:items-center xs:justify-end px-4 py-5 bg-gray-50 text-center sm:px-6 shadow rounded-bl-primary rounded-br-primary w-full overflow-hidden;
}
</style>
