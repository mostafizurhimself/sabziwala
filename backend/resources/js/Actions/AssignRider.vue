<template>
    <div>
        <button @click.prevent="showDialog = true" class="w-full hover:bg-gray-100  py-1">
            <span class="flex items-center ml-3 text-sm">
                <i class="ti-truck mr-2"></i>
                <span>Assign Rider</span>
            </span>
        </button>

        <!-- Assign Rider modal -->
        <jet-dialog-modal :show="showDialog" @close="closeModal">
            <template #title>Assign Rider</template>

            <template #content>
                <!-- Rider -->
            <form-group class="border-b">
                    <jet-label class="md:w-1/4 mb-2" for="riderId" value="Riders" required />
                    <div class="w-full">
                        <jet-select class="w-full" placeholder="Select Rider" v-model="form.riderId" :options="riders"></jet-select>
                        <jet-input-error :message="form.errors.riderId" class="mt-2" />
                    </div>
                </form-group>
            </template>

            <template #footer>
                <button class="px-4" @click="closeModal">Cancel</button>
                <button class="ml-2 btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="update">Assign</button>
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
        zone: {
            type: [Number, String],
            required: true
        }
    },

    data() {
        return {
            showDialog: false,
            form: this.$inertia.form({
				riderId: null,
			}),
            riders: [],
        };
    },
    components: {
        JetDialogModal,
        JetLabel,
        JetSelect,
        JetInputError,
        FormGroup,
    },
    mounted() {
        // this.getRiders();
        // console.log('mounted', this.riders);
    },
    methods: {
        closeModal() {
            this.showDialog = false;
        },
        update() {
            this.form.transform((data) => ({
                        ...data,
                        ids: this.selectedIds,
                    })).post(this.route("orders.assign-rider"),
                {
                    onSuccess: () => {
                        this.showDialog = false
                        this.$emit('success');
                    },
                }
            );
        },
        async getRiders() {
            const response = await axios.get(`/api/riders?zone=${this.zone}`)
            this.riders = response.data.data;
            console.log(response.data);
        },

    },

    created () {
        this.getRiders();
    },
};
</script>

<style lang="scss" scoped>
</style>
