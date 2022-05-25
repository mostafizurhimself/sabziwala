<template>
    <index-view title="Customers" :breadcrumb="breadcrumb">
        <datatable :data="customers" searchRoute="customers.index" :filters="filters">
            <!-- Left Header -->
            <template #left-header>
                <search-input v-model="filters.search"></search-input>
            </template>

            <template #right-header>
                <!-- Downloads -->
                <download-dropdown class="mr-4">
                    <pdf-download-button :href="route('customers.pdf', searchQuery)"></pdf-download-button>
                    <excel-download-button :href="route('customers.excel', searchQuery)"></excel-download-button>
                </download-dropdown>

                <!-- Filters -->
                <filter-dropdown v-model="filters" @reset="reset">
                    <slot name="filter">
                        <jet-label class="mb-2 px-2 font-semibold" for="status" value="Status" />
                        <jet-select id="status" track="value" v-model="filters.status" class="w-full" :options="statusOptions"></jet-select>
                    </slot>
                </filter-dropdown>

                <!-- Create Button -->
                <button-link class="px-6 py-3 ml-4" :href="route('customers.create')" v-if="$page.props.can.createCustomers">
                    <span class="mr-2">+ Add</span>
                    <span class="hidden md:inline">Customer</span>
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

                            <th>Phone</th>
                            <th>Last Login</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>

                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in rows" :key="index">
                            <td>{{ row.id }}</td>
                            <td>
                                <div class="w-10 h-10">
                                    <img :src="row.profilePhotoUrl" class="w-100 object-cover">
                                </div>
                            </td>
                            <td>{{ row.name }}</td>

                            <td>
                                <a class="text-blue-500" :href="`tel:${row.phone}`">{{row.phone}}</a>
                            </td>
                            <td>{{row.lastLoginForHuman ? row.lastLoginForHuman : "-"}}</td>
                            <td>{{row.balanceFormatted}}</td>
                            <td>
                                <!-- <p class="badge" :class="[row.status == 'active'? 'bg-green-500': 'bg-red-500',]">{{ row.status }}</p> -->
                                <jet-badge :value="row.status"></jet-badge>
                            </td>

                            <td class="flex">
                                <div v-if="$page.props.can.updateCustomers">
                                    <button class="btn mr-2" title="Toggle Status" :class="{'btn-danger' : row.status =='active', 'btn-success': row.status == 'inactive'}" @click="toggleStatus(row.id)">
                                        <active-icon v-if="row.status == 'inactive'"></active-icon>
                                        <inactive-icon v-else></inactive-icon>
                                    </button>
                                </div>

                                <div v-if="$page.props.can.viewCustomers">
                                    <Link class="btn btn-success mr-2" title="Details" :href="route('customers.show', row.id)">
                                    <detail-icon></detail-icon>
                                    </Link>
                                </div>

                            </td>

                        </tr>

                    </tbody>
                </table>
            </template>
            <template #nodata>No Customer Found</template>

        </datatable>
    </index-view>
</template>

<script>
import IndexView from "@/Views/IndexView.vue";
import { Link } from "@inertiajs/inertia-vue3";
import ButtonLink from "@/Jetstream/ButtonLink.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import ActiveIcon from "@/Icons/ActiveIcon.vue";
import InactiveIcon from "@/Icons/InactiveIcon.vue";
import Datatable from "@/Jetstream/Datatable.vue";
import SearchInput from "@/Jetstream/SearchInput.vue";
import FilterDropdown from "@/Jetstream/FilterDropdown.vue";
import DetailIcon from "@/Icons/DetailIcon.vue";
import CustomerIcon from "@/Icons/CustomerIcon.vue";
import JetSelect from "@/Jetstream/Select";
import JetLabel from "@/Jetstream/Label.vue";
import JetBadge from "@/Jetstream/Badge.vue";
import DownloadDropdown from "@/Jetstream/DownloadDropdown.vue";
import ExcelDownloadButton from "@/Jetstream/ExcelDownloadButton.vue";
import PdfDownloadButton from "@/Jetstream/PdfDownloadButton.vue";

export default {
    name: "customers",
    // props: ["sessions"],

    props: {
        customers: Object,
        statusOptions: Array,
        query: Object,
    },

    components: {
        IndexView,
        Link,
        ButtonLink,
        JetDangerButton,
        ActiveIcon,
        InactiveIcon,
        Datatable,
        SearchInput,
        FilterDropdown,
        DetailIcon,
        CustomerIcon,
        JetSelect,
        JetLabel,
        JetBadge,
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
                { label: "Customers", route: null },
            ],
        };
    },

    methods: {
        toggleStatus(id) {
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
                        this.$inertia.post(
                            this.route("customers.update-status", id)
                        );
                    }
                });
        },
    },
};
</script>
