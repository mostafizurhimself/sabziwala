<template>
    <index-view title="Riders" :breadcrumb="breadcrumb">
        <datatable :data="riders" searchRoute="riders.index" :filters="filters">
            <!-- Left Header -->
            <template #left-header>
                <search-input v-model="filters.search"></search-input>
            </template>

            <template #right-header>

                <!-- Downloads -->
                <download-dropdown class="mr-4">
                    <pdf-download-button :href="route('riders.pdf', searchQuery)"></pdf-download-button>
                    <excel-download-button :href="route('riders.excel', searchQuery)"></excel-download-button>
                </download-dropdown>

                <!-- Filters -->
                <filter-dropdown v-model="filters" @reset="reset">
                    <slot name="filter">
                        <jet-label class="mb-2 px-2 font-semibold" for="status" value="Status" />
                        <jet-select id="status" track="value" v-model="filters.status" class="w-full" :options="statusOptions"></jet-select>

                        <jet-label class="my-2 px-2 font-semibold" for="zoneId" value="Zone" />
                        <searchable-select :options="zones" v-model="filters.zone" autoFocus></searchable-select>
                    </slot>
                </filter-dropdown>

                <!-- Create Button -->
                <button-link class="px-6 py-3 ml-4" :href="route('riders.create')" v-if="$page.props.can.createRiders">
                    <span class="mr-2">+ Add</span>
                    <span class="hidden md:inline">Riders</span>
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
                            <th>Phone</th>
                            <th>Verified</th>
                            <th>Last Login</th>
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
                            <td>{{ row.zone.name}}</td>

                            <td>
                                <a class="text-blue-500" :href="`tel:${row.phone}`">{{row.phone}}</a>
                            </td>

                            <td>
                                <unverified-icon class="text-primary-500" v-if="row.verified == '0'"></unverified-icon>
                                <verified-icon class="text-green-500" v-else></verified-icon>
                            </td>

                            <td>{{row.lastLoginForHuman ? row.lastLoginForHuman : "-"}}</td>
                            <td>
                                <jet-badge :value="row.status"></jet-badge>
                            </td>

                            <td class="flex">
                                <div v-if="$page.props.can.updateRiders">
                                    <button class="btn mr-2" title="Toggle Status" :class="{'btn-danger' : row.status =='active', 'btn-success': row.status == 'inactive'}" @click="toggleStatus(row.id)">
                                        <active-icon v-if="row.status == 'inactive'"></active-icon>
                                        <inactive-icon v-else></inactive-icon>
                                    </button>
                                </div>

                                <div v-if="$page.props.can.viewRiders">
                                    <Link class="btn btn-success mr-2" title="Details" :href="route('riders.show', row.id)">
                                    <detail-icon></detail-icon>
                                    </Link>
                                </div>

                            </td>

                        </tr>

                    </tbody>
                </table>
            </template>
            <template #nodata>No Riders Found</template>

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
import VerifiedIcon from "@/Icons/VerifiedIcon.vue";
import UnverifiedIcon from "@/Icons/UnverifiedIcon.vue";
import JetBadge from "@/Jetstream/Badge.vue";
import SearchableSelect from "@/Jetstream/SearchableSelect";
import DownloadDropdown from "@/Jetstream/DownloadDropdown.vue";
import ExcelDownloadButton from "@/Jetstream/ExcelDownloadButton.vue";
import PdfDownloadButton from "@/Jetstream/PdfDownloadButton.vue";

export default {
    name: "riders",
    // props: ["sessions"],

    props: {
        riders: Object,
        statusOptions: Array,
        query: Object,
        zones: Array,
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
        VerifiedIcon,
        UnverifiedIcon,
        JetBadge,
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
                { label: "Riders", route: null },
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
                            this.route("riders.update-status", id)
                        );
                    }
                });
        },
    },
};
</script>
