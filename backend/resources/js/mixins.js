import pickBy from "lodash/pickBy";
import mapValues from "lodash/mapValues";

export default {
    computed: {
        searchQuery() {
            return pickBy(this.filters);
        },
    },

    methods: {
        // Zigggy route method
        route,

        // Delete resource from storage
        deleteResource(route) {
            this.$swal
                .fire({
                    title: "Are you sure?",
                    text: "You will not be able to recover this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#EF4444",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        this.$inertia.delete(route);
                    }
                });
        },

        //Reset Search filter
        reset() {
            this.filters = mapValues(this.filters, () => null);
        },

        //Resource save method
        save(route, saveAndContinue = false) {
            if (saveAndContinue) {
                this.form
                    .transform((data) => ({
                        ...data,
                        saveAndContinue: true,
                    }))
                    .post(this.route(route), {
                        onSuccess: () => this.form.reset(),
                    });
                return;
            }
            this.form.post(this.route(route));
        },

        //Resource update method
        update(route, id, updateAndContinue = false) {
            if (updateAndContinue) {
                this.form
                    .transform((data) => ({
                        ...data,
                        updateAndContinue: true,
                        _method: "put"
                    }))
                    .post(this.route(route, id));
                return;
            }
            this.form
                .transform((data) => ({
                    ...data,
                    _method: "put"
                }))
                .post(this.route(route, id));
            return;
        },

        // Check permissions
        hasPermissions(permissions) {
            return permissions.some(
                (permission) => this.$page.props.can[permission]
            );
        },
    }
}
