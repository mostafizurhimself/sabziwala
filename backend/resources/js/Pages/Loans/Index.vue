<template>

    <index-view title="Loans" :breadcrumb="breadcrumb">
        <datatable :data="loans" searchRoute="loans.index" :filters="filters">
            <!-- Left Header -->
            <template #left-header>
                <search-input v-model="filters.search"></search-input>
            </template>

            <template #right-header>
                <!-- Downloads -->
                <download-dropdown class="mr-4">
                    <pdf-download-button :href="route('loans.pdf', searchQuery)"></pdf-download-button>
                    <excel-download-button :href="route('loans.excel', searchQuery)"></excel-download-button>
                </download-dropdown>

                <!-- Actions -->
                <action-dropdown class="mr-4" v-if="selectedIds.length && hasPermissions(['updateLoans'])">
                    <slot name="Actions">
                        <update-loan-status :selected-ids="selectedIds" @success="handleSuccess"></update-loan-status>
                    </slot>
                </action-dropdown>

                <!-- Fiter -->
                <filter-dropdown v-model="filters" @reset="reset">
                    <slot name="filter">
                        <jet-label class="mb-2 px-2 font-semibold" for="status" value="Status" />
                        <jet-select id="status" track="value" v-model="filters.status" class="w-full" :options="status"></jet-select>
                    </slot>
                </filter-dropdown>

                <!-- Admin -->
                <button-link class="px-6 py-3 ml-4" :href="route('loans.create')" v-if="$page.props.can.createLoans">
                    <span class="mr-2">+ Add</span>
                    <span class="hidden md:inline">Loan</span>
                </button-link>
            </template>

            <!--Table Rows -->
            <template #default="{rows}">
                <table v-if="rows.length">
                    <thead>
                        <tr>
                            <th>
                                <input class="checkbox" @input="checkAll" v-model="allChecked" type="checkbox">
                            </th>
                            <th>Id</th>
                            <th>Employee Name</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>

                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in rows" :key="index">
                            <td>

                                <input class="checkbox" @change="checkOne" :value="row.id" v-model="selectedIds" type="checkbox">
                            </td>
                            <td>{{row.id}}</td>
                            <td>{{row.employee.name}}</td>
                            <td>{{row.loanDate}}</td>
                            <td>{{row.loanAmountFormatted}}</td>
                            <td>{{row.paidAmountFormatted}}</td>
                            <td>{{row.dueAmountFormatted}}</td>
                            <td>
                                <jet-badge :value="row.status"></jet-badge>
                            </td>

                            <td>
                                <div class="flex justify-end">
                                    <Link class="btn btn-success" title="Details" :href="route('loans.show', row.id)" v-if="hasPermissions(['viewLoans'])">
                                    <detail-icon></detail-icon>
                                    </Link>

                                    <Link class="btn btn-purple ml-2" title="Edit" :href="route('loans.edit', row.id)" v-if="hasPermissions(['updateLoans']) && row.status == 'draft'">
                                    <i class="ti-pencil-alt"></i>
                                    </Link>

                                    <jet-danger-button class="ml-2" title="Delete" @click="deleteResource(route('loans.destroy', row.id))" v-if="hasPermissions(['deleteLoans']) && row.status == 'draft'">
                                        <i class="ti-trash"></i>
                                    </jet-danger-button>

                                </div>
                            </td>

                        </tr>

                    </tbody>
                </table>
            </template>
            <template #nodata>No Data Found</template>

        </datatable>
    </index-view>

</template>

<script>
import IndexView from "@/Views/IndexView.vue";
import { Link } from "@inertiajs/inertia-vue3";
import ButtonLink from "@/Jetstream/ButtonLink.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import Datatable from "@/Jetstream/Datatable.vue";
import SearchInput from "@/Jetstream/SearchInput.vue";
import FilterDropdown from "@/Jetstream/FilterDropdown.vue";
import DetailIcon from "@/Icons/DetailIcon.vue";
import JetBadge from "@/Jetstream/Badge.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetSelect from "@/Jetstream/Select";
import UpdateLoanStatus from "@/Actions/UpdateLoanStatus.vue";
import ActionDropdown from "@/Jetstream/ActionDropdown.vue";
import DownloadDropdown from "@/Jetstream/DownloadDropdown.vue";
import ExcelDownloadButton from "@/Jetstream/ExcelDownloadButton.vue";
import PdfDownloadButton from "@/Jetstream/PdfDownloadButton.vue";
export default {
    name: "Loans",

    props: {
        loans: Object,
        query: Object,
        status: Array,
    },

    components: {
        IndexView,
        Link,
        ButtonLink,
        JetDangerButton,
        Datatable,
        SearchInput,
        FilterDropdown,
        DetailIcon,
        JetBadge,
        JetSelect,
        JetLabel,
        UpdateLoanStatus,
        ActionDropdown,
        DownloadDropdown,
        ExcelDownloadButton,
        PdfDownloadButton,
    },

    data() {
        return {
            filters: {
                search: this.query.search,
                status: this.query.status,
            },
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Loans", route: null },
            ],

            selectedIds: [],
            allChecked: false,
        };
    },

    computed: {
        allIds() {
            return this.loans.data.map((loan) => loan.id);
        },
    },
    methods: {
        checkAll(e) {
            this.selectedIds = e.target.checked ? this.allIds : [];
        },
        checkOne() {
            this.allChecked = this.allIds.length == this.selectedIds.length;
        },
        handleSuccess() {
            this.allChecked = false;
            this.selectedIds = [];
        },
    },
};
</script>
