<template>
    <detail-view title="Salary Details" :breadcrumb="breadcrumb">

        <!-- ID -->
        <detail-section class="border-b" label="ID" :value="salary.id"></detail-section>

        <!-- Employee Name -->
        <detail-section class="border-b" label="Employee Name" :value="salary.employee.name"></detail-section>

        <!-- Month -->
        <detail-section class="border-b" label="Month" :value="salary.monthFormatted"></detail-section>

        <!-- Total Amount -->
        <detail-section class="border-b" label="Total Amount" :value="salary.totalAmountFormatted"></detail-section>

        <!-- Deduct Amount -->
        <detail-section class="border-b" label="Deduct Amount" :value="salary.totalDeductedFormatted"></detail-section>

        <!-- Paid Amount -->
        <detail-section class="border-b" label="Paid Amount" :value="salary.paidAmountFormatted"></detail-section>

        <!-- Due Amount -->
        <detail-section class="border-b" label="Due Amount" :value="salary.totalDueFormatted"></detail-section>

        <!-- Status-->
        <detail-section label="Status" class="border-b">
            <jet-badge :value="salary.status"></jet-badge>
        </detail-section>

        <template #secondary-view>
            <div class="mt-8">

                <h1 class="font-bold text-xl">Payslips</h1>
                <datatable :data="payslips">
                    <!--Table Rows -->
                    <template #default="{rows}">
                        <table v-if="rows.length">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>Paid Amount</th>
                                    <th>Deduct Amount</th>
                                    <th>Action</th>
                                </tr>

                            </thead>
                            <tbody>
                                <tr v-for="(row, index) in rows" :key="index">
                                    <td>{{row.id}}</td>
                                    <td>{{row.dateFormatted}}</td>
                                    <td>{{row.paidAmountFormatted}}</td>
                                    <td>{{row.deductedFormatted}}</td>
                                    <td>
                                        <a target="_blank" class="btn btn-success" :href="route('payslips.invoice', row.id)">
                                            <pdf-icon></pdf-icon>
                                        </a>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </template>
                    <template #nodata>No Payslips Found</template>

                </datatable>
            </div>
        </template>
    </detail-view>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import DetailView from "@/Views/DetailView.vue";
import DetailSection from "@/Jetstream/DetailSection.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Tabs, Tab } from "vue3-tabs-component";
import JetBadge from "@/Jetstream/Badge.vue";
import Datatable from "@/Jetstream/Datatable.vue";
import PdfIcon from "@/Icons/PdfIcon.vue";

export default {
    name: "salary-payslips",
    props: {
        salary: Object,
        payslips: Object,
    },

    components: {
        AppLayout,
        DetailView,
        DetailSection,
        Link,
        Tabs,
        Tab,
        JetBadge,
        Datatable,
        PdfIcon,
    },

    data() {
        return {
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Salaries", route: this.route("salaries.index") },
                { label: this.salary.employee.name, route: null },
            ],
        };
    },
};
</script>
