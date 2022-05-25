<template>
    <form-view @submitted="save('employees.store')" title="Create Employees" :breadcrumb="breadcrumb">
        <template #form>

            <tabs :options="{ useUrlFragment: false }">
                <tab name="Profile">
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
                        <jet-label class="md:w-1/4 mt-2" for="email" value="Email" />
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

                    <!--Photo -->
                    <form-group class="border-b">
                        <jet-label for="photo" class="md:w-1/4 mt-2" value="Photo" />
                        <div class="w-full">
                            <jet-image-input v-model="form.photo"></jet-image-input>
                            <jet-input-error :message="form.errors.photo" class="mt-2" />
                        </div>
                    </form-group>

                    <!-- Status -->
                    <form-group class="border-b">
                        <jet-label class="md:w-1/4 mt-2" for="status" value="Status" required />
                        <div class="w-full mt-1">
                            <jet-select v-model="form.status" track="value" class="w-full" :options="status"></jet-select>
                            <jet-input-error :message="form.errors.status" class="mt-2" />
                        </div>
                    </form-group>

                </tab>

                <tab name="Personal Information">
                    <!-- Father Name -->
                    <form-group class="border-b">
                        <jet-label class="md:w-1/4 mt-2" for="fatherName" value="Father Name" />
                        <div class="w-full mt-1">
                            <jet-input v-model="form.fatherName" id="fatherName" type="text" class="w-full" autocomplete="fatherName" />
                            <jet-input-error :message="form.errors.fatherName" class="mt-2" />
                        </div>
                    </form-group>

                    <!-- Mother Name -->
                    <form-group class="border-b">
                        <jet-label class="md:w-1/4 mt-2" for="motherName" value="Mother Name" />
                        <div class="w-full mt-1">
                            <jet-input v-model="form.motherName" id="motherName" type="text" class="w-full" autocomplete="motherName" />
                            <jet-input-error :message="form.errors.motherName" class="mt-2" />
                        </div>
                    </form-group>

                    <!-- Gender -->
                    <form-group class="border-b">
                        <jet-label class="md:w-1/4 mt-2" for="gender" value="Gender" required />
                        <div class="w-full mt-1">
                            <jet-select v-model="form.gender" class="w-full" :options="gender"></jet-select>
                            <jet-input-error :message="form.errors.gender" class="mt-2" />
                        </div>
                    </form-group>

                    <!-- Marital Status  -->
                    <form-group class="border-b">
                        <jet-label class="md:w-1/4 mt-2" for="maritalStatus" value="Marital Status " />
                        <div class="w-full mt-1">
                            <jet-select v-model="form.maritalStatus " class="w-full" :options="maritalStatus"></jet-select>
                            <jet-input-error :message="form.errors.maritalStatus" class="mt-2" />
                        </div>
                    </form-group>

                    <!-- Blood Group  -->
                    <form-group class="border-b">
                        <jet-label class="md:w-1/4 mt-2" for="bloodGroup" value="Blood Group " />
                        <div class="w-full mt-1">
                            <jet-select v-model="form.bloodGroup " class="w-full" :options="bloodGroup"></jet-select>
                            <jet-input-error :message="form.errors.bloodGroup" class="mt-2" />
                        </div>
                    </form-group>

                </tab>

                <tab name="Official Information">
                    <!-- Zones -->
                    <form-group class="border-b">
                        <jet-label class="md:w-1/4 mt-2" for="zones" value="Zones" required />
                        <div class="w-full mt-1">
                            <searchable-select :options="zones" v-model="form.zoneId" autoFocus></searchable-select>
                            <jet-input-error :message="form.errors.zoneId" class="mt-2" />
                        </div>
                    </form-group>
                    <!-- Designation -->
                    <form-group class="border-b">
                        <jet-label class="md:w-1/4 mt-2" for="designation" value="Designation" required />
                        <div class="w-full mt-1">
                            <jet-input v-model="form.designation" id="designation" type="text" class="w-full" autocomplete="designation" />
                            <jet-input-error :message="form.errors.designation" class="mt-2" />
                        </div>
                    </form-group>

                    <!-- Joining Date -->
                    <form-group class="border-b">
                        <jet-label class="md:w-1/4 mt-2" for="joiningDate" value="Joining Date" required />
                        <div class="w-full mt-1">
                            <jet-input v-model="form.joiningDate" id="joiningDate" type="date" class="w-full" autocomplete="joiningDate" />
                            <jet-input-error :message="form.errors.joiningDate" class="mt-2" />
                        </div>
                    </form-group>

                    <!-- Resign Date -->
                    <form-group class="border-b">
                        <jet-label class="md:w-1/4 mt-2" for="resignDate" value="Resign Date" />
                        <div class="w-full mt-1">
                            <jet-input v-model="form.resignDate" id="resignDate" type="date" class="w-full" autocomplete="resignDate" />
                            <jet-input-error :message="form.errors.resignDate" class="mt-2" />
                        </div>
                    </form-group>

                    <!-- Salary -->
                    <form-group class="border-b">
                        <jet-label class="md:w-1/4 mt-2" for="salary" value="Salary" required />
                        <div class="w-full mt-1">
                            <jet-input v-model="form.salary" id="salary" type="number" class="w-full" autocomplete="salary" />
                            <jet-input-error :message="form.errors.salary" class="mt-2" />
                        </div>
                    </form-group>

                </tab>

            </tabs>

        </template>

        <template #actions>
            <Link :href="route('employees.index')" class="xs:mr-4">Cancel</Link>
            <jet-button @click.prevent="save('employees.store', true)" class="px-6 xs:mr-2 my-2 xs:my-0" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save & Continue</jet-button>
            <jet-button class="px-6" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save</jet-button>
        </template>
    </form-view>

</template>

<script>
import JetMultipleImageInput from "@/Jetstream/MultipleImageInput.vue";
import JetImageInput from "@/Jetstream/ImageInput.vue";
import FormView from "@/Views/FormView.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetTextInput from "@/Jetstream/TextInput.vue";
import JetButton from "@/Jetstream/Button.vue";
import FormGroup from "@/Jetstream/FormGroup.vue";
import { Tabs, Tab } from "vue3-tabs-component";
import JetSelect from "@/Jetstream/Select";
import SearchableSelect from "@/Jetstream/SearchableSelect";

export default {
    name: "Create-Employees",

    props: {
        gender: Array,
        maritalStatus: Array,
        bloodGroup: Array,
        status: Array,
        zones: Array,
    },

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
        JetMultipleImageInput,
        Tab,
        Tabs,
        JetSelect,
        SearchableSelect,
    },
    data() {
        return {
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Employees", route: this.route("employees.index") },
                { label: "Create", route: null },
            ],

            form: this.$inertia.form({
                firstName: null,
                lastName: null,
                email: null,
                phone: null,
                photo: null,
                status: null,
                fatherName: null,
                motherName: null,
                gender: null,
                maritalStatus: null,
                bloodGroup: null,
                designation: null,
                joiningDate: null,
                resignDate: null,
                salary: null,
                zoneId: null,
            }),
        };
    },
};
</script>
