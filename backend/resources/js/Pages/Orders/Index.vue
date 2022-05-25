    <template>
    <index-view title="Orders" :breadcrumb="breadcrumb">
        <datatable :data="orders" searchRoute="orders.index" :filters="filters">
            <!-- Left Header -->
            <template #left-header>
                <search-input v-model="filters.search"></search-input>
            </template>

            <template #right-header>
                <!-- Downloads -->
                <download-dropdown class="mr-4">
                    <pdf-download-button :href="route('orders.pdf', searchQuery)"></pdf-download-button>
                    <excel-download-button :href="route('orders.excel', searchQuery)"></excel-download-button>
                </download-dropdown>

                <!-- Actions -->
                <action-dropdown class="mr-4" v-if="selectedIds.length && hasPermissions(['updateOrders'])">
                    <update-order-status :selectedIds="selectedIds" @success="handleSuccess"></update-order-status>
                    <assign-rider v-if="filters.zone" :selectedIds="selectedIds" :zone="this.filters.zone"></assign-rider>
                </action-dropdown>

                <!-- Fiter -->
                <filter-dropdown v-model="filters" @reset="reset">
                    <!-- Filters -->
                    <jet-label class="mb-2 px-2 font-semibold" for="status" value="Status" />
                    <jet-select id="status" track="value" v-model="filters.status" class="w-full" :options="statusOptions"></jet-select>

                    <jet-label class="my-2 px-2 font-semibold" for="zoneId" value="Zone" />
                    <searchable-select :options="zones" v-model="filters.zone" autoFocus></searchable-select>

                    <jet-label class="my-2 px-2 font-semibold" for="customer" value="Customers" />
                    <searchable-select :options="customers" v-model="filters.customer" autoFocus></searchable-select>

                    <jet-label class="my-2 px-2 font-semibold" for="rider" value="Riders" />
                    <searchable-select :options="riders" v-model="filters.rider" autoFocus></searchable-select>
                </filter-dropdown>
            </template>

            <!--Table Rows -->
            <template #default="{ rows }">
                <table v-if="rows.length">
                    <thead>
                        <tr>
                            <th>
                                <input class="checkbox" @input="checkAll" v-model="allChecked" type="checkbox" />
                            </th>
                            <th>Invoice</th>
                            <th>Details</th>
                            <th>Customer</th>
                            <th>Rider</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in rows" :key="index">
                            <td>
                                <input class="checkbox" @change="checkOne" :value="row.id" v-model="selectedIds" type="checkbox" />
                            </td>
                            <td>
                                <Link v-if="hasPermissions(['viewOrders'])" class="text-primary-500 hover:underline" :href="route('orders.show', row.id)">{{ row.invoiceNo }}</Link>
                                <span v-else>{{ row.invoiceNo }}</span>
                            </td>
                            <td>
                                <p class="text-primary-500">
                                    <span v-if="row.zone">Zone: {{ row.zone.name }}</span>
                                    <span v-else>Zone: - </span>
                                </p>

                                <p>
                                    <span>Amount: {{ row.grandTotalFormatted }}, </span>
                                    <span>Method: </span>
                                    <span class="uppercase">{{ row.paymentMethod }}</span>
                                </p>
                                <p class="text-xs">
                                    <span>Ordered At: {{ row.dateFormatted }}</span>
                                </p>
                                <p class="text-sm"></p>
                            </td>
                            <td>{{ row.customer.name }}</td>
                            <td>{{ row.rider ? row.rider.name : "-" }}</td>

                            <td>
                                <jet-badge :value="row.status"></jet-badge>
                            </td>

                            <td>
                                <Link class="btn btn-success mr-2" title="Details" :href="route('orders.show', row.id)" v-if="hasPermissions(['viewOrders'])">
                                <detail-icon></detail-icon>
                                </Link>

                                <Link class="btn btn-danger mr-2" title="Invoice" :href="route('orders.invoice', row.id)" v-if="hasPermissions(['viewOrders'])">
                                <pdf-icon></pdf-icon>
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>
            <template #nodata>No Orders Found</template>
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
import ActionDropdown from "@/Jetstream/ActionDropdown.vue";
import DetailIcon from "@/Icons/DetailIcon.vue";
import PdfIcon from "@/Icons/PdfIcon.vue";
import JetBadge from "@/Jetstream/Badge.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetSelect from "@/Jetstream/Select";
import JetLabel from "@/Jetstream/Label.vue";
import UpdateOrderStatus from "@/Actions/UpdateOrderStatus.vue";
import AssignRider from "@/Actions/AssignRider.vue";
import DownloadDropdown from "@/Jetstream/DownloadDropdown.vue";
import ExcelDownloadButton from "@/Jetstream/ExcelDownloadButton.vue";
import PdfDownloadButton from "@/Jetstream/PdfDownloadButton.vue";
import SearchableSelect from "@/Jetstream/SearchableSelect";
export default {
    name: "orders",

    props: {
        orders: Object,
        query: Object,
        statusOptions: Array,
        zones: Array,
        customers: Array,
        riders: Array,
    },

    components: {
        IndexView,
        Link,
        ButtonLink,
        JetDangerButton,
        Datatable,
        SearchInput,
        FilterDropdown,
        ActionDropdown,
        DetailIcon,
        PdfIcon,
        JetBadge,
        JetCheckbox,
        JetSelect,
        JetLabel,
        UpdateOrderStatus,
        AssignRider,
        DownloadDropdown,
        ExcelDownloadButton,
        PdfDownloadButton,
        SearchableSelect,
    },

    data() {
        return {
            filters: {
                search: this.query.search,
                zone: this.query.zone,
                customer: this.query.customer,
                rider: this.query.rider,
            },
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Orders", route: null },
            ],
            selectedIds: [],
            allChecked: false,
        };
    },
    computed: {
        allIds() {
            return this.orders.data.map((order) => order.id);
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
