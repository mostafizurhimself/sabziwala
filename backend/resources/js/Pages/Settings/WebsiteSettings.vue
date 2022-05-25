<template>
    <div class="">
        <form @submit.prevent="save">
            <!-- Website Name-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="name" value="Website Name" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.name" id="name" type="text" class="w-full" autocomplete="name" />
                    <jet-input-error :message="form.errors.name" class="mt-2" />
                </div>
            </form-group>

            <!--  Description -->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="description" value=" Description" />
                <div  class="w-full mt-1">
                    <jet-text-input v-model="form.description" id="name" type="text" class="mt-1 block w-full" autocomplete="name" />
                    <jet-input-error class="mt-2" />
                </div>
            </form-group>

            <!-- Logo -->
            <form-group class="border-b">
                <jet-label for="logo" class="md:w-1/4 mt-2" value="Logo"/>
                <div class="w-full mt-1">
                    <jet-image-input :url="$page.props.website?.primaryMediaUrl" v-model="form.logo"></jet-image-input>
                    <jet-input-error :message="form.errors.logo" class="mt-2" />
                </div>
            </form-group>

            <!-- Phone-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="phone" value="Phone" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.phone" id="phone" type="tel" class="w-full" autocomplete="phone" />
                    <jet-input-error :message="form.errors.phone" class="mt-2" />
                </div>
            </form-group>

            <!-- Email-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="email" value="Email" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.email" id="email" type="email" class="w-full" autocomplete="email" />
                    <jet-input-error :message="form.errors.email" class="mt-2" />
                </div>
            </form-group>

            <!-- Street Address-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="street" value="Street Address" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.street" id="street" type="text" class="w-full" autocomplete="street" />
                    <jet-input-error :message="form.errors.street" class="mt-2" />
                </div>
            </form-group>

            <!-- City-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="city" value="City" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.city" id="city" type="text" class="w-full" autocomplete="city" />
                    <jet-input-error :message="form.errors.city" class="mt-2" />
                </div>
            </form-group>

            <!-- Zip Code-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="zip" value="Zip Code" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.zip" id="zip" type="text" class="w-full" autocomplete="zip" />
                    <jet-input-error :message="form.errors.zip" class="mt-2" />
                </div>
            </form-group>

            <!-- Country-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="country" value="Country" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.country" id="country" type="text" class="w-full" autocomplete="country" />
                    <jet-input-error :message="form.errors.country" class="mt-2" />
                </div>
            </form-group>

            <!-- Facebook-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="facebook" value="Facebook"/>
                <div class="w-full mt-1">
                    <jet-input v-model="form.facebook" id="facebook" type="url" class="w-full" autocomplete="facebook" />
                    <jet-input-error :message="form.errors.facebook" class="mt-2" />
                </div>
            </form-group>

             <!-- Twitter-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="twitter" value="Twitter"/>
                <div class="w-full mt-1">
                    <jet-input v-model="form.twitter" id="twitter" type="url" class="w-full" autocomplete="twitter" />
                    <jet-input-error :message="form.errors.twitter" class="mt-2" />
                </div>
            </form-group>

              <!-- Instagram-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="instagram" value="Instagram"/>
                <div class="w-full mt-1">
                    <jet-input v-model="form.instagram" id="instagram" type="url" class="w-full" autocomplete="instagram" />
                    <jet-input-error :message="form.errors.instagram" class="mt-2" />
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
import JetImageInput from "@/Jetstream/ImageInput.vue";
export default {
    name: "website-settings",

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
                name: this.$page.props.website?.data?.name,
                description: this.$page.props.website?.data?.description,
                logo: null,
                phone: this.$page.props.website?.data?.phone,
                email: this.$page.props.website?.data?.email,
                street: this.$page.props.website?.data?.street,
                city: this.$page.props.website?.data?.city,
                zip: this.$page.props.website?.data?.zip,
                country: this.$page.props.website?.data?.country,
                facebook: this.$page.props.website?.data?.facebook,
                twitter: this.$page.props.website?.data?.twitter,
                instagram: this.$page.props.website?.data?.instagram,
            }),
        };
    },

    methods: {
        save() {
            this.form.post(route("settings.website"));
        },
    },
};
</script>

<style lang="scss" scoped>
.footer {
    @apply flex flex-col-reverse xs:flex-row xs:items-center xs:justify-end px-4 py-5 bg-gray-50 text-center sm:px-6 shadow rounded-bl-primary rounded-br-primary w-full overflow-hidden;
}
</style>
