<template>
    <detail-view title="Employee Details" :breadcrumb="breadcrumb">

        <tabs :options="{ useUrlFragment: false }">
            <tab name="Employee Details">
                <!-- ID -->
                <detail-section class="border-b" label="ID" :value="employee.id"></detail-section>
                <!-- Name -->
                <detail-section class="border-b" label="Name" :value="employee.name"></detail-section>

                <!-- Email -->
                <detail-section class="border-b" label="Email" :value="employee.email"></detail-section>

                <!-- Phone -->
                <detail-section class="border-b" label="Phone" :value="employee.phone"></detail-section>

                <!-- Photo -->
                <detail-section class="border-b" label="Photo">
                    <image-preview :url="employee.profilePhotoUrl"></image-preview>
                </detail-section>

                <!-- Status-->
                <detail-section label="Status">
                    <jet-badge :value="employee.status"></jet-badge>
                </detail-section>
            </tab>

            <!-- Personal Information Tab -->
            <tab name="Personal Information">

                <!-- Father Name -->
                <detail-section class="border-b" label="Father Name" :value="employee.fatherName"></detail-section>

                <!-- Mother Name -->
                <detail-section class="border-b" label="Mother Name" :value="employee.motherName"></detail-section>

                <!-- Gender -->
                <detail-section class="border-b" label="Gender" :value="employee.gender"></detail-section>

                <!-- Maritial Status -->
                <detail-section class="border-b" label="Maritial Status" :value="employee.maritalStatus"></detail-section>
            </tab>

            <!-- Official Information Tab -->
            <tab name="Official Information">
                 <!-- Zone -->
                <detail-section class="border-b" label="Zone" :value="employee.zone.name"></detail-section>

                <!-- Designation -->
                <detail-section class="border-b" label="Designation" :value="employee.designation"></detail-section>

                <!-- Joining Date -->
                <detail-section class="border-b" label="Joining Date" :value="employee.joiningDate"></detail-section>

                <!-- Resign Date -->
                <detail-section class="border-b" label="Resign Date">
                    <span v-if="employee.resignDate">
                        {{employee.resignDate}}
                    </span>
                    <span v-else>
                        Continuing
                    </span>
                </detail-section>

                <!-- Salary -->
                <detail-section class="border-b" label="Salary" :value="employee.salaryFormatted"></detail-section>

            </tab>
        </tabs>

    </detail-view>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import DetailView from "@/Views/DetailView.vue";
import DetailSection from "@/Jetstream/DetailSection.vue";
import MultipleImagePreview from "@/Partials/MultipleImagePreview.vue";
import ImagePreview from "@/Partials/ImagePreview.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Tabs, Tab } from "vue3-tabs-component";
import JetBadge from "@/Jetstream/Badge.vue";

export default {
    name: "employee-details",
    props: {
        employee: Object,
    },

    components: {
        AppLayout,
        DetailView,
        DetailSection,
        MultipleImagePreview,
        ImagePreview,
        Link,
        Tabs,
        Tab,
        JetBadge,
    },

    data() {
        return {
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Employees", route: this.route("employees.index") },
                { label: this.employee.name, route: null },
            ],
        };
    },
};
</script>
