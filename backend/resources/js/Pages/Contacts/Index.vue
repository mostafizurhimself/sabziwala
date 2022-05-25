<template>

    <index-view title="Messages" :breadcrumb="breadcrumb">
        <datatable :data="contacts" searchRoute="contacts.index" :filters="filters">
            <!-- Left Header -->
            <template #left-header>
                <search-input v-model="filters.search"></search-input>
            </template>

            <template #right-header>
                <!-- Fiter -->
                <filter-dropdown>
                    <slot name="filter"></slot>
                </filter-dropdown>
            </template>

            <!--Table Rows -->
            <template #default="{rows}">
                <table v-if="rows.length">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Massage</th>
                            <th>Reply</th>
                            <th>Answered</th>
                            <th>Action</th>
                        </tr>

                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in rows" :key="index">
                            <td>{{row.id}}</td>
                            <td>{{row.name}}</td>
                            <td>{{row.email}}</td>
                            <td class="truncate" style="max-width:200px">{{row.subject}}</td>
                            <td class="truncate" style="max-width:200px">{{row.message}}</td>
                            <td class="truncate" style="max-width:200px">{{row.reply ? row.reply : "-"}}</td>
                            <td>
                                <p :class="[row.answered == true ? 'text-green-500': 'text-red-500',]">
                                    <span v-if="row.answered">Yes</span>
                                    <span v-else>No</span>
                                </p>
                            </td>

                            <td class="flex">
                                <div>
                                    <Link class="btn btn-purple mr-2" :href="route('contacts.show', row.id)" v-if="$page.props.can.viewContacts">
                                    <detail-icon></detail-icon>
                                    </Link>

                                    <jet-danger-button title="Delete" @click="deleteResource(route('contacts.destroy', row.id))" v-if="$page.props.can.deleteContacts">
                                        <i class="ti-trash"></i>
                                    </jet-danger-button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </template>
            <template #nodata>No Contacts Found</template>

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
export default {
    name: "contacts",

    props: {
        contacts: Object,
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
    },

    data() {
        return {
            filters: {
                search: this.query.search,
            },
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Messages", route: null },
            ],
        };
    },
};
</script>
