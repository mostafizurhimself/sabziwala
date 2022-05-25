<template>
    <form-view @submitted="update('expenses.update', expense.id)" title="Edit Expense" :breadcrumb="breadcrumb">
        <template #form>
            <!-- Expense Type -->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="Expense Type" value="Expense Types" required />
                <div class="w-full mt-1">
                    <jet-select v-model="form.expenseTypeId" class="w-full" :options="expenseTypes"></jet-select>
                    <jet-input-error :message="form.errors.expenseTypeId" class="mt-2" />
                </div>
            </form-group>

            <!--  Description -->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="description" value=" Description" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.description" id="description" type="text" class="w-full" autocomplete="description" />
                    <jet-input-error :message="form.errors.description" class="mt-2" />
                </div>

            </form-group>

            <!-- Amount -->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="amount" value="Amount" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.amount" id="amount" type="number" class="w-full" autocomplete="amount" />
                    <jet-input-error :message="form.errors.amount" class="mt-2" />
                </div>
            </form-group>

        </template>

        <template #actions>
            <Link :href="route('expenses.index')" class="xs:mr-4">Cancel</Link>
            <jet-button @click.prevent="update('expenses.update', expense.id, true)" class="px-6 xs:mr-2 my-2 xs:my-0" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Update & Continue</jet-button>
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

export default {
    name: "edit-expense",
    props: {
        expense: Object,
        expenseTypes: Array,
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
    },
    data() {
        return {
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Expenses", route: this.route("expenses.index") },
                {
                    label: this.expense.name,
                    route: this.route("expenses.show", this.expense.id),
                },
                { label: "Edit", route: null },
            ],

            form: this.$inertia.form({
                expenseTypeId: this.expense.expenseTypeId,
                description: this.expense.description,
                amount: this.expense.amount,
            }),
        };
    },
};
</script>
