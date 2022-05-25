<template>
    <form-view @submitted="update('salaries.update', salary.id)" title="Edit Salary" :breadcrumb="breadcrumb">
        <template #form>

                        <!--Employee Name -->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="employees" value=" Employee Name" required />
                <div class="w-full mt-1">
                    <jet-select v-model="form.employeeId" class="w-full" :options="employees" @update:modelValue="setSalary"></jet-select>
                    <jet-input-error :message="form.errors.employeeId" class="mt-2" />
                </div>
            </form-group>

            <!-- Salary Month -->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="month" value="Salary Month" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.month" id="month" type="month" class="w-full" autocomplete="month" />
                    <jet-input-error :message="form.errors.month" class="mt-2" />
                </div>
            </form-group>

            <!-- Salary Amount -->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="totalAmount" value="Salary Amount" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.totalAmount" id="totalAmount" type="number" class="w-full" autocomplete="totalAmount" />
                    <jet-input-error :message="form.errors.totalAmount" class="mt-2" />
                </div>
            </form-group>

            <!-- Paid Amount -->
            <!-- <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="paidAmount" value="Paid Amount" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.paidAmount" id="paidAmount" type="number" class="w-full" autocomplete="paidAmount" />
                    <jet-input-error :message="form.errors.paidAmount" class="mt-2" />
                </div>
            </form-group> -->


        </template>

        <template #actions>
            <Link :href="route('salaries.index')" class="xs:mr-4">Cancel</Link>
            <jet-button @click.prevent="update('salaries.update', salary.id, true)" class="px-6 xs:mr-2 my-2 xs:my-0" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Update & Continue</jet-button>
            <jet-button class="px-6" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Update</jet-button>
        </template>
    </form-view>

</template>

<script>
import FormView from "@/Views/FormView.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetSelect from "@/Jetstream/Select.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetTextInput from "@/Jetstream/TextInput.vue";
import JetButton from "@/Jetstream/Button.vue";
import FormGroup from "@/Jetstream/FormGroup.vue";
import { Tabs, Tab } from "vue3-tabs-component";

export default {
    name: "edit-salary",
    props: {
        salary: Object,
        employees: Array,
        status: Array,
    },

    components: {
        Link,
        FormView,
        JetInput,
        JetSelect,
        JetInputError,
        JetLabel,
        JetTextInput,
        FormGroup,
        JetButton,
        Tab,
        Tabs,
    },
    data() {
        return {
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Salaries", route: this.route("salaries.index") },
                {
                    label: this.salary.employee.name,
                    route: this.route("salaries.show", this.salary.id),
                },
                { label: "Edit", route: null },
            ],

            form: this.$inertia.form({
                employeeId: this.salary.employeeId,
                month: this.salary.month,
                totalAmount: this.salary.totalAmount,
            }),
        };
    },
};
</script>
