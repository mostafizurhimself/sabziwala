<template>
    <form-view @submitted="save('customers.store')" title="Create Customer" :breadcrumb="breadcrumb">
        <template #form>

            <!-- Profile Photo -->
            <form-group class="border-b">
                <jet-label for="photo" class="md:w-1/4 mt-2" value="Profile Photo" required />
                <div class="w-full">
                    <jet-image-input v-model="form.photo"></jet-image-input>
                    <small class="mt-1 font-thin text-gray-400">* Image should be 1:1 acpect ratio. Maximum file size: 2MB(2048KB).</small>
                    <jet-input-error :message="form.errors.photo" class="mt-2" />
                </div>
            </form-group>

            <!-- First Name -->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="firstName" value="First Name" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.firstName" id="firstName" type="text" class="w-full" autocomplete="firstName" />
                    <jet-input-error :message="form.errors.firstName" class="mt-2" />
                </div>
            </form-group>

            <!-- Last Name -->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="lastName" value="Last Name" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.lastName" id="lastName" type="text" class="w-full" autocomplete="lastName" />
                    <jet-input-error :message="form.errors.lastName" class="mt-2" />
                </div>
            </form-group>

            <!-- Email -->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="email" value="Email" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.email" id="email" type="email" class="w-full" autocomplete="email" />
                    <jet-input-error :message="form.errors.email" class="mt-2" />
                </div>
            </form-group>

            <!-- Phone -->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="phone" value="Phone" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.phone" id="phone" type="tel" class="w-full" autocomplete="phone" />
                    <jet-input-error :message="form.errors.phone" class="mt-2" />
                </div>
            </form-group>

            <!-- Password -->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="password" value="Password" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.password" id="password" type="password" class="w-full" autocomplete="password" />
                    <jet-input-error :message="form.errors.password" class="mt-2" />
                </div>
            </form-group>

            <!-- Confirm Password -->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="password_confirmation" value="Confirm Password" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.password_confirmation" id="password_confirmation" type="password" class="w-full" autocomplete="password_confirmation" />
                    <jet-input-error :message="form.errors.password_confirmation" class="mt-2" />
                </div>
            </form-group>
        </template>

        <template #actions>
            <Link :href="route('customers.index')" class="xs:mr-4">Cancel</Link>
            <jet-button @click.prevent="save('customers.store', true)" class="px-6 xs:mr-2 my-2 xs:my-0" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save & Continue</jet-button>
            <jet-button class="px-6" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save</jet-button>
        </template>
    </form-view>

</template>

<script>
import JetImageInput from "@/Jetstream/ImageInput.vue";
import FormView from "@/Views/FormView.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetTextInput from "@/Jetstream/TextInput.vue";
import JetButton from "@/Jetstream/Button.vue";
import FormGroup from "@/Jetstream/FormGroup.vue";

export default {
    name: "create-customer",

    components: {
        Link,
        FormView,
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
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Customers", route: this.route("users.index") },
                { label: "Create", route: null },
            ],

            form: this.$inertia.form({
                photo: null,
                firstName: null,
                lastName: null,
                email: null,
                phone: null,
                password: null,
                password_confirmation: null,
            }),
        };
    },
};
</script>
