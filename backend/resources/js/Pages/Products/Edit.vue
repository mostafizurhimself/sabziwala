<template>
    <form-view @submitted="update('products.update', product.id)" title="Edit Product" :breadcrumb="breadcrumb">
        <template #form>

            <tabs :options="{ useUrlFragment: false }">
                <tab name="Product Details">

                    <!-- Categories -->
                    <form-group class="border-b">
                        <jet-label class="md:w-1/4 mt-2" for="categories" value="Category" required />
                        <div class="w-full mt-1">
                            <jet-select v-model="form.categoryId" class="w-full" :options="categories"></jet-select>
                            <jet-input-error :message="form.errors.categoryId" class="mt-2" />
                        </div>
                    </form-group>

                      	<!-- Zones -->
					<form-group class="border-b">
						<jet-label class="md:w-1/4 mt-2" for="zones" value="Zones" required />
						<div class="w-full mt-1">
							<jet-select v-model="form.zoneId" class="w-full" :options="zones"></jet-select>
							<jet-input-error :message="form.errors.zoneId" class="mt-2" />
						</div>
					</form-group>

                    <!-- Name -->
                    <form-group class="border-b">
                        <jet-label class="md:w-1/4 mt-2" for="name" value="Name" required />
                        <div class="w-full mt-1">
                            <jet-input v-model="form.name" id="name" type="text" class="w-full" autocomplete="name" />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>
                    </form-group>

                    <!-- Code -->
                    <form-group class="border-b">
                        <jet-label class="md:w-1/4 mt-2" for="code" value="Code" required />
                        <div class="w-full mt-1">
                            <jet-input v-model="form.code" id="code" type="text" class="w-full" autocomplete="code" />
                            <jet-input-error :message="form.errors.code" class="mt-2" />
                        </div>
                    </form-group>

                    <!--  Description -->
                    <form-group class="border-b">
                        <jet-label class="md:w-1/4 mt-2" for="name" value=" Description" />
                        <div class="w-full mt-1">
                            <jet-text-input v-model="form.description" id="name" type="text" class="mt-1 block w-full" autocomplete="name" />
                            <jet-input-error class="mt-2" />
                        </div>
                    </form-group>

                    <!-- Actual Price -->
                    <form-group class="border-b">
                        <jet-label class="md:w-1/4 mt-2" for="actualPrice" value="Actual Price" required />
                        <div class="w-full mt-1">
                            <jet-input v-model="form.actualPrice" id="actualPrice" type="number" class="w-full" autocomplete="actualPrice" />
                            <jet-input-error :message="form.errors.actualPrice" class="mt-2" />
                        </div>
                    </form-group>

                    <!-- Sale Price -->
                    <form-group class="border-b">
                        <jet-label class="md:w-1/4 mt-2" for="sellPrice" value="Sale Price" required />
                        <div class="w-full mt-1">
                            <jet-input v-model="form.salePrice" id="salePrice" type="number" class="w-full" autocomplete="salePrice" />
                            <jet-input-error :message="form.errors.salePrice" class="mt-2" />
                        </div>
                    </form-group>

                    <!-- Units -->
                    <form-group class="border-b">
                        <jet-label class="md:w-1/4 mt-2" for="Units" value="Unit" required />
                        <div class="w-full mt-1">
                            <jet-select v-model="form.unitId" class="w-full" :options="units"></jet-select>
                            <jet-input-error :message="form.errors.unitId" class="mt-2" />
                        </div>
                    </form-group>

                </tab>

                <!-- Others Tab -->
                <tab name="Others">

                    <!--Tags -->
                    <form-group class="border-b">
                        <jet-label class="md:w-1/4 mt-2" for="tags" value="Tags" />
                        <div class="w-full mt-1">
                            <tag-input v-model="form.tags" :suggestions="tags"></tag-input>
                            <jet-input-error :message="form.errors.tags" class="mt-2" />
                        </div>
                    </form-group>

                    <!-- Images -->
                    <form-group>
                        <jet-label for="image" class="md:w-1/4 mt-2" value="Images" />
                        <div class="w-full mt-1">
                            <jet-multiple-image-input :medias="product.mediaCollection" v-model="form.images"></jet-multiple-image-input>
                            <small class="mt-1 font-thin text-gray-400">* Image should be 1:1 acpect ratio. Maximum file size: 10MB/10240KB.</small>
                            <jet-input-error :message="form.errors.images" class="mt-2" />
                            <jet-input-error v-for="(i, index) in form.images" :key="index" :message="form.errors[`images.${index}`]" class="mt-2" />

                        </div>
                    </form-group>

                    <!-- Thumbnail -->
                    <form-group>
                        <jet-label for="image" class="md:w-1/4 mt-2" value="Thumbnail" />
                        <div class="w-full mt-1">
                            <jet-image-input :url="product.thumbnailMediaUrl" v-model="form.thumbnail"></jet-image-input>
                            <small class="mt-1 font-thin text-gray-400">* Image should be 1:1 acpect ratio. Maximum file size: 5MB/5120KB.</small>
                            <jet-input-error :message="form.errors.thumbnail" class="mt-2" />
                        </div>
                    </form-group>

                </tab>
            </tabs>

        </template>

        <template #actions>
            <Link :href="route('products.index')" class="xs:mr-4">Cancel</Link>
            <jet-button @click.prevent="update('products.update', product.id, true)" class="px-6 xs:mr-2 my-2 xs:my-0" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Update & Continue</jet-button>
            <jet-button class="px-6" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Update</jet-button>
        </template>
    </form-view>

</template>

<script>
import TagInput from "@/Jetstream/TagInput";
import FormView from "@/Views/FormView.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetSelect from "@/Jetstream/Select.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetTextInput from "@/Jetstream/TextInput.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetMultipleImageInput from "@/Jetstream/MultipleImageInput.vue";
import FormGroup from "@/Jetstream/FormGroup.vue";
import JetImageInput from "@/Jetstream/ImageInput.vue";
import { Tabs, Tab } from "vue3-tabs-component";

export default {
    name: "edit-product",
    props: {
        product: Object,
        categories: Array,
        tags: Array,
        units: Array,
        zones:Array,
    },

    components: {
        Link,
        FormView,
        JetInput,
        JetSelect,
        JetInputError,
        JetLabel,
        JetTextInput,
        JetMultipleImageInput,
        FormGroup,
        JetButton,
        JetImageInput,
        Tab,
        Tabs,
        TagInput,
    },
    data() {
        return {
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Products", route: this.route("products.index") },
                {
                    label: this.product.name,
                    route: this.route("products.show", this.product.id),
                },
                { label: "Edit", route: null },
            ],

            form: this.$inertia.form({
                categoryId: this.product.categoryId,
                zoneId: this.product.zoneId,
                unitId: this.product.unitId,
                name: this.product.name,
                code: this.product.code,
                tags: [],
                description: this.product.description,
                actualPrice: this.product.actualPrice,
                salePrice: this.product.salePrice,
                images: null,
                thumbnail: null,
            }),
        };
    },

    created() {
        this.form.tags = this.product.tags.map((tag) => tag.name);
    },
};
</script>
