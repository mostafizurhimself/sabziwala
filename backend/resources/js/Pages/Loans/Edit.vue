<template>
    <form-view @submitted="update('loans.update', loan.id)" title="Edit loan" :breadcrumb="breadcrumb">
        <template #form>

            <!-- Employees -->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="employees" value="Employees" required />
                <div class="w-full mt-1">
                    <jet-select v-model="form.employeeId" class="w-full" :options="employees"></jet-select>
                    <jet-input-error :message="form.errors.employeeId" class="mt-2" />
                </div>
            </form-group>

            <!-- Loan Date -->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="loanDate" value="Loan Date" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.loanDate" id="loanDate" type="date" class="w-full" autocomplete="loanDate" />
                    <jet-input-error :message="form.errors.loanDate" class="mt-2" />
                </div>
            </form-group>

            <!-- Loan Amount -->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="loanAmount" value="Loan Amount" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.loanAmount" id="loanAmount" type="number" class="w-full" autocomplete="loanAmount" />
                    <jet-input-error :message="form.errors.loanAmount" class="mt-2" />
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

            <!-- Status -->
            <!-- <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="status" value="Status" required />
                <div class="w-full mt-1">
                    <jet-select v-model="form.status" track="value" class="w-full" :options="status"></jet-select>
                    <jet-input-error :message="form.errors.status" class="mt-2" />
                </div>
            </form-group> -->

        </template>

        <template #actions>
            <Link :href="route('loans.index')" class="xs:mr-4">Cancel</Link>
            <jet-button @click.prevent="update('loans.update', loan.id, true)" class="px-6 xs:mr-2 my-2 xs:my-0" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Update & Continue</jet-button>
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
    name: "edit-loan",
    props: {
        loan: Object,
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
                { label: "Loans", route: this.route("loans.index") },
                {
                    label: this.loan.employee.name,
                    route: this.route("loans.show", this.loan.id),
                },
                { label: "Edit", route: null },
            ],

            form: this.$inertia.form({
                employeeId: this.loan.employeeId,
                loanDate: this.loan.loanDate,
                loanAmount: this.loan.loanAmount,
                // paidAmount: this.loan.paidAmount,
                // status: this.loan.status,
            }),
        };
    },
};
</script>
