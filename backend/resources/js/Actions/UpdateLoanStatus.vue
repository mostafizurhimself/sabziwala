<template>
    <div>
        <button @click.prevent="update" class="w-full hover:bg-gray-100  py-1">
            <span class="flex items-center ml-3 text-sm">
                <i class="ti-check-box mr-2"></i>
                <span>Confirm Status</span>
            </span>
        </button>
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
    },
    data() {
        return {
            showDialog: false,
            form: this.$inertia.form({}),
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
            this.$swal
                .fire({
                    title: "Are you Sure ?",
                    text: "You will not be able to recover this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#10B981",
                    confirmButtonText: "Yes, confirm",
                    cancelButtonText: "Cancel",
                })
                .then((result) => {
                    console.log(result);
                    if (result.isConfirmed) {
                        this.form
                            .transform((data) => ({
                                ids: this.selectedIds,
                            }))
                            .post(this.route("loans.confirmMultiple"), {
                                onSuccess: () => {
                                    this.showDialog = false;
                                    this.$emit("success");
                                },
                            });
                    }
                });
        },
    },
};
</script>

<style lang="scss" scoped>
</style>
