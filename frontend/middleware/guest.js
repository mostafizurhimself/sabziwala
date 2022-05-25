export default function ({ store, redirect }) {
    if (store.$auth.loggedIn === true) {
        if (store.$auth.user.type == "rider") {
            redirect("/rider/profile");
        }

        if (store.$auth.user.type == "customer") {
            redirect("/customer/profile");
        }
    }
}