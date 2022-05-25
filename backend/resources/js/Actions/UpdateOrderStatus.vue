<template>
    <div>
        <button @click.prevent="showDialog = true" class="w-full hover:bg-gray-100  py-1" v-if="type == 'multiple'">
            <span class="flex items-center ml-3 text-sm">
                <i class="ti-pencil-alt mr-2"></i>
                <span>Update Status</span>
            </span>
        </button>

        <button @click.prevent="showDialog = true" class="btn btn-success" v-else>
            Update Status
        </button>


        <!-- Update status modal -->
        <jet-dialog-modal :show="showDialog" @close="closeModal">
            <template #title>Update Status</template>

            <template #content>
                <!-- Status -->
                <div class="flex flex-col md:flex-row px-6 pb-4">
                    <jet-label class="md:w-1/4" for="status" value="Status" required />
                    <div class="w-full">
                        <jet-select class="w-full" placeholder="Select Status" track="value" v-model="form.status" :options="$page.props.statusOptions"></jet-select>
                        <jet-input-error :message="form.errors.status" class="mt-2" />
                    </div>
                </div>
            </template>

            <template #footer>
                <button class="px-4" @click="closeModal">Cancel</button>
                <button class="ml-2 btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="update">Update</button>
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
export default {
    props: {
        selectedIds: {
            type: Array,
            required: true,
        },

        type: {
            type: String,
            default: "multiple",
            validator: (value) => {
                return ['multiple', 'single'].includes(value)
            }
        }
    },
    data() {
        return {
            showDialog: false,
            form: this.$inertia.form({
				status: null,
			}),
        };
    },
    components: {
        JetDialogModal,
        JetLabel,
        JetSelect,
        JetInputError,
        FormGroup,
    },
    methods: {
        closeModal() {
            this.showDialog = false;
        },
        update() {
            this.form.transform((data) => ({
                        ...data,
                        ids: this.selectedIds,
                    })).post(this.route("orders.update-status"),
                {
                    onSuccess: () => {
                        this.showDialog = false
                        this.$emit('success');
                    },
                }
            );
        },
    },
};
</script>

<style lang="scss" scoped>
</style>
