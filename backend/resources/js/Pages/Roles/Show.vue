<template>
    <detail-view title="Customer Details" :breadcrumb="breadcrumb">

        <!-- ID -->
        <detail-section class="border-b" label="ID" :value="role.id"></detail-section>

        <!-- Name -->
        <detail-section class="border-b" label="Name" :value="role.name"></detail-section>

        <!-- Roles -->
        <detail-section class="border-b" label="Roles">

            <div class="grid grid-cols-3 gap-4 w-full">
                <div v-for="row in permissions" :key="row.id">
                    <label class="flex items-center font-bold cursor-pointer text-sm">
                        <span>{{ row.label }}</span>
                    </label>

                    <div v-for="col in row.permissions" :key="col.id" class="mt-1">
                        <label class="flex items-center cursor-pointer text-sm">
                            <ul class='list-outside list-disc ml-6'>
                                <li :class="[hasPermission(col.id) ? 'text-green-500': 'text-red-500']">
                                    <span class="text-black">{{col.label}}</span>
                                </li>
                            </ul>
                        </label>
                    </div>
                </div>
            </div>

        </detail-section>

    </detail-view>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import DetailView from "@/Views/DetailView.vue";
import DetailSection from "@/Jetstream/DetailSection.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Tabs, Tab } from "vue3-tabs-component";

export default {
    name: "role-details",
    // props: ["sessions"],
    props: {
        role: Object,
        permissions: Object,
    },

    components: {
        AppLayout,
        DetailView,
        DetailSection,
        Link,
        Tabs,
        Tab,
    },

    data() {
        return {
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Roles", route: this.route("roles.index") },
                { label: this.role.name, route: null },
            ],


        };
    },
    methods: {
        hasPermission(id) {
            return this.role.permissions.find((permission)=>  permission.id == id)
        },
    },
};
</script>

<style  lang="scss" scoped>

</style>
