<template>

    <index-view title="Salaries" :breadcrumb="breadcrumb">
        <datatable :data="salaries" searchRoute="salaries.index" :filters="filters">
            <!-- Left Header -->
            <template #left-header>
                <search-input v-model="filters.search"></search-input>
            </template>

            <template #right-header>

                <!-- Downloads -->
                <download-dropdown class="mr-4">
                    <pdf-download-button :href="route('salaries.pdf', searchQuery)"></pdf-download-button>
                    <excel-download-button :href="route('salaries.excel', searchQuery)"></excel-download-button>
                </download-dropdown>
                <!-- Actions -->
                <action-dropdown class="mr-4" v-if="selectedIds.length && hasPermissions(['updateSalaries'])">
                    <slot name="Actions">
                        <confirm-salary :selected-ids="selectedIds" @success="handleSuccess"></confirm-salary>
                    </slot>
                </action-dropdown>

                <!-- Fiter -->
                <filter-dropdown v-model="filters" @reset="reset">
                    <slot name="filter">
                        <jet-label class="mb-2 px-2 font-semibold" for="month" value="Month" />
                        <jet-input v-model="filters.month" id="month" type="month" class="w-full" autocomplete="month" />

                        <jet-label class="my-2 px-2 font-semibold" for="status" value="Status" />
                        <jet-select id="status" track="value" v-model="filters.status" class="w-full" :options="status"></jet-select>
                        <jet-label class="my-2 px-2 font-semibold" for="zoneId" value="Zone" />
                        <searchable-select :options="zones" v-model="filters.zone" autoFocus></searchable-select>
                    </slot>
                </filter-dropdown>

                <!-- Admin -->
                <generate-salary></generate-salary>

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
                            <th>Name</th>
                            <th>Zone</th>
                            <th>Month</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Deducted</th>
                            <th>Due</th>
                            <th>Status</th>
                            <th cl>Action</th>
                        </tr>

                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in rows" :key="index">
                            <td>
                                <input class="checkbox" @change="checkOne" :value="row.id" v-model="selectedIds" type="checkbox">
                            </td>
                            <td>{{row.id}}</td>
                            <td>{{row.employee.name}}</td>
                            <td>{{row.zone.name}}</td>
                            <td>{{row.monthFormatted}}</td>
                            <td>{{row.totalAmountFormatted}}</td>
                            <td>{{row.paidAmountFormatted}}</td>
                            <td>{{row.totalDeductedFormatted}}</td>
                            <td>{{row.totalDueFormatted}}</td>
                            <td>
                                <jet-badge :value="row.status"></jet-badge>
                            </td>

                            <td class="flex justify-end">
                                <div>

                                    <Link class="btn btn-success" title="Details" :href="route('salaries.show', row.id)" v-if="hasPermissions(['viewSalaries'])">
                                    <detail-icon></detail-icon>
                                    </Link>

                                    <a class="btn btn-info ml-2" title="Payslip" :href="route('payslips.create', row.id)" target="_blank" v-if="hasPermissions(['updateSalaries']) && row.status != 'draft'">
                                        <i class="ti-receipt"></i>
                                    </a>

                                    <Link class="btn btn-purple ml-2" title="Edit" :href="route('salaries.edit', row.id)" v-if="hasPermissions(['updateSalaries']) && row.status == 'draft'">
                                    <i class="ti-pencil-alt"></i>
                                    </Link>

                                    <jet-danger-button class="ml-2" title="Delete" @click="deleteResource(route('salaries.destroy', row.id))" v-if="hasPermissions(['deleteSalaries']) && row.status == 'draft'">
                                        <i class="ti-trash"></i>
                                    </jet-danger-button>

                                </div>
                            </td>

                        </tr>

                    </tbody>
                </table>
            </template>
            <template #nodata>No salaries Found</template>

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
import ActionDropdown from "@/Jetstream/ActionDropdown.vue";
import JetSelect from "@/Jetstream/Select";
import JetLabel from "@/Jetstream/Label.vue";
import JetInput from "@/Jetstream/Input.vue";
import GenerateSalary from "@/Actions/GenerateSalary.vue";
import ConfirmSalary from "@/Actions/ConfirmSalary.vue";
import SearchableSelect from "@/Jetstream/SearchableSelect";
import DownloadDropdown from "@/Jetstream/DownloadDropdown.vue";
import ExcelDownloadButton from "@/Jetstream/ExcelDownloadButton.vue";
import PdfDownloadButton from "@/Jetstream/PdfDownloadButton.vue";
export default {
    name: "salaries",

    props: {
        salaries: Object,
        query: Object,
        status: Object,
        zones: Array,
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
        ActionDropdown,
        JetSelect,
        JetLabel,
        JetInput,
        ConfirmSalary,
        GenerateSalary,
        SearchableSelect,
        DownloadDropdown,
        ExcelDownloadButton,
        PdfDownloadButton,
    },

    data() {
        return {
            filters: {
                search: this.query.search,
                status: this.query.status,
                zone: this.query.zone,
            },
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Salaries", route: null },
            ],
            selectedIds: [],
            allChecked: false,
        };
    },

    computed: {
        allIds() {
            return this.salaries.data.map((order) => order.id);
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
