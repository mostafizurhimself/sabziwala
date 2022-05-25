<template>
    <div>
        <button class="px-6 py-4 ml-4 btn btn-success" @click.prevent="showDialog = true">
            <p class="py-1"> <i class="ti-stats-up mr-2"></i><span >Generate Salary</span></p>
        </button>

        <!-- Generate Salary modal -->
        <jet-dialog-modal :show="showDialog" @close="closeModal">
            <template #title>Generate Salary</template>

            <template #content>
                <!-- Month -->
                <div class="flex flex-col md:flex-row px-6 pb-4">
                    <jet-label class="md:w-1/4" for="month" value="Month" required />
                    <div class="w-full">
                        <jet-input v-model="form.month" id="month" type="month" class="w-full" autocomplete="month" />
                        <jet-input-error :message="form.errors.month" class="mt-2" />
                    </div>
                </div>
            </template>

            <template #footer>
                <button class="px-4" @click="closeModal">Cancel</button>
                <button class="ml-2 btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="update">Generate</button>
            </template>
        </jet-dialog-modal>
    </div>

</template>

<script>
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetSelect from "@/Jetstream/Select.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import FormGroup from "@/Jetstream/FormGroup.vue";
import JetInput from "@/Jetstream/Input.vue";
export default {
    name: "Generate-Salary",
    props: {
        employees: Object,
    },

    data() {
        return {
            showDialog: false,
            form: this.$inertia.form({
                month: null,
            }),
        };
    },
    components: {
        JetDialogModal,
        JetLabel,
        JetSelect,
        JetInputError,
        FormGroup,
        JetInput,
    },
    methods: {
        closeModal() {
            this.showDialog = false;
        },
        update() {
            this.form
                .transform((data) => ({
                    ...data,
                    ids: this.employees,
                }))
                .post(this.route("salaries.generate-salaries"), {
                    onSuccess: () => (this.showDialog = false),
                });
        },
    },
};
</script>

<style lang="scss" scoped>
</style>
