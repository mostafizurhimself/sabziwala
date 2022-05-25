export default function ({ store, redirect }) {
    if (store.$auth.loggedIn === true && store.$auth.user.type === "rider") {
        redirect('/rider/profile');
    }
}