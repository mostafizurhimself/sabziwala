<template>
    <div class="flex  py-8 px-8">
        <div class="w-5/12">
            <div class="mb-4">
                <h6 class="font-bold text-lg">How It Works</h6>
                <span class=" text-gray-500 ">Add & change how it works content here</span>
            </div>
            <!-- Admin -->
            <button class="btn btn-primary px-6 py-2" @click.prevent="addHowItWorks">
                <span class="mr-2">+ Add</span>
                <span class="hidden md:inline">How It Works</span>
            </button>

        </div>
        <!--Table Rows -->
        <div class="w-7/12 rounded-lg border overflow-x-auto">
            <table v-if="$page.props.howItWorks.length">
                <thead class="head">
                    <tr>
                        <th>Id</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Action</th>
                    </tr>

                </thead>
                <tbody>
                    <tr v-for="(row, index) in $page.props.howItWorks" :key="index">
                        <td>{{row.id}}</td>
                        <td>
                            <div class="w-10 h-10">
                                <img :src="row.primaryMediaUrl" class="w-100 object-cover">
                            </div>
                        </td>
                        <td>{{row.title}}</td>

                        <td class="flex">
                            <div>
                                <jet-button class="btn btn-success mr-2" title="Edit" @click="editHowItWorks(index)" v-if="$page.props.can.updateAppearances">
                                    <i class="ti-pencil-alt"></i>
                                </jet-button>

                                <jet-danger-button title="Delete" @click="deleteResource(route('how-it-works.delete', row.id))" v-if="$page.props.can.deleteAppearances">
                                    <i class="ti-trash"></i>
                                </jet-danger-button>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>

            <div class="flex justify-center items-center text-gray-800 h-32" v-else>
                <span class="font-semibold">No Data Added</span>
            </div>
        </div>

        <!-- Add Country modal -->
        <jet-dialog-modal :show="showDialog" @close="closeModal">
            <template #title>Add How it works</template>

            <template #content>

                <!-- title -->
                <form-group class="border-b">
                    <jet-label class="md:w-1/4 mt-2" for="title" value="Title" required />
                    <div class="w-full mt-1">
                        <jet-input v-model="form.title" id="title" type="text" class="w-full" autocomplete="title" />
                        <jet-input-error :message="form.errors.title" class="mt-2" />
                    </div>
                </form-group>

                <!-- Image -->
                <form-group class="border-b">
                    <jet-label for="image" class="md:w-1/4 mt-2" value="Image" required />
                    <div class="w-full mt-1">
                        <jet-image-input :url="form.imageUrl" v-model="form.image"></jet-image-input>
                        <jet-input-error :message="form.errors.image" class="mt-2" />
                    </div>
                </form-group>

            </template>

            <template #footer>
                <button class="" @click="closeModal">Cancel</button>

                <button class="ml-2 btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="save">Save</button>
            </template>
        </jet-dialog-modal>

    </div>
</template>

<script>
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetButton from "@/Jetstream/Button.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import FormGroup from "@/Jetstream/FormGroup.vue";
import JetTextInput from "@/Jetstream/TextInput.vue";
import JetImageInput from "@/Jetstream/ImageInput.vue";
export default {
    name: "howItWorks",

    props: {
        query: Object,
    },

    components: {
        Link,
        JetButton,
        JetDangerButton,
        JetDialogModal,
        JetButton,
        JetInput,
        JetInputError,
        JetLabel,
        FormGroup,
        JetTextInput,
        JetImageInput,
    },

    data() {
        return {
            form: this.$inertia.form({
                id: null,
                title: null,
                image: null,
            }),

            showDialog: false,
            edit: false,
        };
    },

    methods: {
        addHowItWorks() {
            this.edit = false;
            this.form.reset();
            this.showDialog = true;
        },
        save() {
            if (this.edit) {
                this.form.post(route("how-it-works.update", this.form.id), {
                    onSuccess: () => {
                        this.edit = false;
                        this.closeModal();
                        this.form.reset();
                    },
                });
            } else {
                this.form.post(route("how-it-works.create"), {
                    onSuccess: () => {
                        this.closeModal();
                        this.form.reset();
                    },
                });
            }
        },

        closeModal() {
            this.showDialog = false;
        },

        editHowItWorks(index) {
            this.showDialog = true;
            this.edit = true;
            this.form.id = this.$page.props.howItWorks[index].id;
            this.form.title = this.$page.props.howItWorks[index].title;
            this.form.imageUrl =
                this.$page.props.howItWorks[index].primaryMediaUrl;
        },
    },
};
</script>

<style lang="scss" scoped>
.head {
    @apply bg-gray-50;
}

tr:nth-child(even) {
    @apply bg-gray-50;
}
</style>
