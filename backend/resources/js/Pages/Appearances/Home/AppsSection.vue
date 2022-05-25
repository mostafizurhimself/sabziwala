<template>
    <div class="">
        <form @submit.prevent="save">
            <!-- Title-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="name" value="Title" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.title" id="title" type="text" class="w-full" autocomplete="title" />
                    <jet-input-error :message="form.errors.title" class="mt-2" />
                </div>
            </form-group>

            <!-- Subtitle-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="subtitle" value="Subtitle" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.subtitle" id="subtitle" type="text" class="w-full" autocomplete="subtitle" />
                    <jet-input-error :message="form.errors.subtitle" class="mt-2" />
                </div>
            </form-group>

            <!-- Playstore-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="playStore" value="PlayStore" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.playStore" id="playStore" type="url" class="w-full" autocomplete="playStore" />
                    <jet-input-error :message="form.errors.playStore" class="mt-2" />
                </div>
            </form-group>

            <!-- AppStore-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="appStore" value="AppStore" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.appStore" id="appStore" type="url" class="w-full" autocomplete="appStore" />
                    <jet-input-error :message="form.errors.appStore" class="mt-2" />
                </div>
            </form-group>

            <!-- Image -->
            <form-group class="border-b">
                <jet-label for="image" class="md:w-1/4 mt-2" value="Image" />
                <div class="w-full mt-1">
                    <jet-image-input :url="$page.props.apps?.primaryMediaUrl" v-model="form.image"></jet-image-input>
                    <jet-input-error :message="form.errors.image" class="mt-2" />
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
import { Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetTextInput from "@/Jetstream/TextInput.vue";
import JetButton from "@/Jetstream/Button.vue";
import FormGroup from "@/Jetstream/FormGroup.vue";
import JetImageInput from "@/Jetstream/ImageInput.vue";
export default {
    title: "Apps-section",

    components: {
        Link,
        JetInput,
        JetInputError,
        JetLabel,
        JetTextInput,
        FormGroup,
        JetButton,
        JetImageInput,
    },

    data() {
        return {
            form: this.$inertia.form({
                title: this.$page.props.apps?.data?.title,
                subtitle: this.$page.props.apps?.data?.subtitle,
                playStore: this.$page.props.apps?.data?.playStore,
                appStore: this.$page.props.apps?.data?.appStore,
                image: null,
            }),
        };
    },

    methods: {
        save() {
            this.form.post(route("appearance.home.apps"));
        },
    },
};
</script>

<style lang="scss" scoped>
.footer {
    @apply flex flex-col-reverse xs:flex-row xs:items-center xs:justify-end px-4 py-5 bg-gray-50 text-center sm:px-6 shadow rounded-bl-primary rounded-br-primary w-full overflow-hidden;
}
</style>
