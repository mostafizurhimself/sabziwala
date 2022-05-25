<template>
    <detail-view title="Loan Details" :breadcrumb="breadcrumb">

        <!-- ID -->
        <detail-section class="border-b" label="ID" :value="loan.id"></detail-section>

        <!-- Employee Name -->
        <detail-section class="border-b" label="Employee Name" :value="loan.employee.name"></detail-section>

        <!-- Loan Date -->
        <detail-section class="border-b" label="Loan Date" :value="loan.loanDate"></detail-section>

        <!-- Loan Amount -->
        <detail-section class="border-b" label="Loan Amount" :value="loan.loanAmountFormatted"></detail-section>

        <!-- Paid Amount -->
        <detail-section class="border-b" label="Paid Amount" :value="loan.paidAmountFormatted"></detail-section>

        <!-- Due Amount -->
        <detail-section class="border-b" label="Due Amount" :value="loan.dueAmountFormatted"></detail-section>

        <!-- Status-->
        <detail-section label="Status" class="border-b">
            <jet-badge :value="loan.status"></jet-badge>
        </detail-section>

        <!-- Verification -->
        <detail-section label="Confirmation" v-if="(loan.status == 'draft' && $page.props.can.canConfirmLoans )">
            <button class="btn mr-2" :class="{'btn-danger' : loan.status == 'confirmed', 'btn-success': loan.status == 'draft'}" @click="confirmed(loan.id)">

                <div class="flex items-center" v-if="loan.status == 'draft'">
                    <span class="ml-2">Confirm</span>
                </div>

                <div class="flex items-center" v-else>
                    <span class="ml-2">Draft</span>
                </div>
            </button>
        </detail-section>

    </detail-view>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import DetailView from "@/Views/DetailView.vue";
import DetailSection from "@/Jetstream/DetailSection.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Tabs, Tab } from "vue3-tabs-component";
import JetBadge from "@/Jetstream/Badge.vue";

export default {
    name: "loan-details",
    props: {
        loan: Object,
    },

    components: {
        AppLayout,
        DetailView,
        DetailSection,
        Link,
        Tabs,
        Tab,
        JetBadge,
    },

    data() {
        return {
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Loans", route: this.route("loans.index") },
                { label: this.loan.employee.name, route: null },
            ],
        };
    },

    methods: {
        confirmed(id) {
            this.$swal
                .fire({
                    title: "Are you sure?",
                    text: "",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#EF4444",
                    confirmButtonText: "Yes, do it!",
                    cancelButtonText: "Cancel",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        this.$inertia.post(this.route("loans.confirmed", id));
                    }
                });
        },
    },
};
</script>
