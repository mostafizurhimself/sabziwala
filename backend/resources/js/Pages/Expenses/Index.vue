<template>

    <index-view title="Expenses" :breadcrumb="breadcrumb">
        <datatable :data="expenses" searchRoute="expenses.index" :filters="filters">
            <!-- Left Header -->
            <template #left-header>
                <search-input v-model="filters.search"></search-input>
            </template>

            <template #right-header>

                <!-- Downloads -->
                <download-dropdown class="mr-4">
                    <pdf-download-button :href="route('expenses.pdf', searchQuery)"></pdf-download-button>
                    <excel-download-button :href="route('expenses.excel', searchQuery)"></excel-download-button>
                </download-dropdown>

                <!-- Admin -->
                <button-link class="px-6 py-3 ml-4" :href="route('expenses.create')" v-if="$page.props.can.createExpenses">
                    <span class="mr-2">+ Add</span>
                    <span class="hidden md:inline">Expense</span>
                </button-link>
            </template>

            <!--Table Rows -->
            <template #default="{rows}">
                <table v-if="rows.length">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Expense Type</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>

                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in rows" :key="index">
                            <td>{{row.id}}</td>
                            <td>{{row.expenseType.name}}</td>
                            <td class="turncate" style="max-width:250px">{{row.description}}</td>
                            <td>{{row.amountFormatted}}</td>
                            <td class="flex">
                                <div>
                                    <Link class="btn btn-purple mr-2" title="Edit" :href="route('expenses.edit', row.id)" v-if="$page.props.can.updateExpenses">
                                    <i class="ti-pencil-alt"></i>
                                    </Link>

                                    <jet-danger-button title="Delete" @click="deleteResource(route('expenses.destroy', row.id))" v-if="$page.props.can.deleteExpenses">
                                        <i class="ti-trash"></i>
                                    </jet-danger-button>

                                </div>
                            </td>

                        </tr>

                    </tbody>
                </table>
            </template>
            <template #nodata>No Expenses Found</template>

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
import DownloadDropdown from "@/Jetstream/DownloadDropdown.vue";
import ExcelDownloadButton from "@/Jetstream/ExcelDownloadButton.vue";
import PdfDownloadButton from "@/Jetstream/PdfDownloadButton.vue";
export default {
    name: "Expense Types",

    props: {
        expenses: Object,
        query: Object,
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
        DownloadDropdown,
        ExcelDownloadButton,
        PdfDownloadButton,
    },

    data() {
        return {
            filters: {
                search: this.query.search,
            },
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Expenses", route: null },
            ],
        };
    },
};
</script>
