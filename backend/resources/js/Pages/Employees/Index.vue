<template>

    <index-view title="Employees" :breadcrumb="breadcrumb">
        <datatable :data="employees" searchRoute="employees.index" :filters="filters">
            <!-- Left Header -->
            <template #left-header>
                <search-input v-model="filters.search"></search-input>
            </template>

            <template #right-header>
                <!-- Downloads -->
                <download-dropdown class="mr-4">
                    <pdf-download-button :href="route('employees.pdf', searchQuery)"></pdf-download-button>
                    <excel-download-button :href="route('employees.excel', searchQuery)"></excel-download-button>
                </download-dropdown>

                <!-- Fiters -->
                <filter-dropdown v-model="filters" @reset="reset">
                    <slot name="filter">
                        <jet-label class="mb-2 px-2 font-semibold" for="status" value="Status" />
                        <jet-select id="status" track="value" v-model="filters.status" class="w-full" :options="status"></jet-select>

                        <jet-label class="my-2 px-2 font-semibold" for="zoneId" value="Zone" />
                        <searchable-select :options="zones" v-model="filters.zone" autoFocus></searchable-select>
                    </slot>
                </filter-dropdown>

                <!-- Admin -->
                <button-link class="px-6 py-3 ml-4" :href="route('employees.create')" v-if="$page.props.can.createEmployees">
                    <span class="mr-2">+ Add</span>
                    <span class="hidden md:inline">Employees</span>
                </button-link>
            </template>

            <!--Table Rows -->
            <template #default="{rows}">
                <table v-if="rows.length">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Zone</th>
                            <th>Designation</th>
                            <th>Phone</th>
                            <th>Salary</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>

                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in rows" :key="index">
                            <td>{{row.id}}</td>
                            <td>
                                <div class="w-10 h-10">
                                    <img :src="row.profilePhotoUrl" class="w-100 object-cover">
                                </div>
                            </td>
                            <td>{{row.name}}</td>
                            <td>{{row.zone.name}}</td>
                            <td>{{row.designation}}</td>
                            <td>{{row.phone}}</td>
                            <td>{{row.salaryFormatted}}</td>
                            <td>
                                <jet-badge :value="row.status"></jet-badge>
                            </td>
                            <td class="flex">
                                <div>
                                    <Link class="btn btn-success mr-2" title="Details" :href="route('employees.show', row.id)" v-if="$page.props.can.viewProducts">
                                    <detail-icon></detail-icon>
                                    </Link>

                                    <Link class="btn btn-purple mr-2" title="Edit" :href="route('employees.edit', row.id)" v-if="$page.props.can.updateEmployees">
                                    <i class="ti-pencil-alt"></i>
                                    </Link>

                                    <jet-danger-button title="Delete" @click="deleteResource(route('employees.destroy', row.id))" v-if="$page.props.can.deleteEmployees">
                                        <i class="ti-trash"></i>
                                    </jet-danger-button>

                                </div>
                            </td>

                        </tr>

                    </tbody>
                </table>
            </template>
            <template #nodata>No Employees Found</template>

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
import SearchableSelect from "@/Jetstream/SearchableSelect";
import DownloadDropdown from "@/Jetstream/DownloadDropdown.vue";
import ExcelDownloadButton from "@/Jetstream/ExcelDownloadButton.vue";
import PdfDownloadButton from "@/Jetstream/PdfDownloadButton.vue";
export default {
    name: "Employees",

    props: {
        employees: Object,
        query: Object,
        status: Array,
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
        JetLabel,
        JetSelect,
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
                { label: "Employees", route: null },
            ],
        };
    },
};
</script>
