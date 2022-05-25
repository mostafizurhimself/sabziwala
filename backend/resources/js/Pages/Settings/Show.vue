<template>

	<detail-view title="Settings" :breadcrumb="breadcrumb">

		<tabs :options="{ useUrlFragment: false }">
			<tab name="Website Settings">

				<website-settings></website-settings>
			</tab>

            	<tab name="Currency Settings">
				<currency-settings></currency-settings>
			</tab>

			<tab name="Country Settings">
				<country-settings></country-settings>
			</tab>

            <tab name="Unit Settings">
               <unit-settings></unit-settings>
			</tab>
		</tabs>
	</detail-view>
</template>

<script>
import CurrencySettings from "./CurrencySettings.vue";
import UnitSettings from "./UnitSettings.vue";
import CountrySettings from "./CountrySettings.vue";
import WebsiteSettings from "./WebsiteSettings.vue";
import DetailView from "@/Views/DetailView.vue";
import { Tabs, Tab } from "vue3-tabs-component";
import { Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import FormGroup from "@/Jetstream/FormGroup.vue";
import JetTextInput from "@/Jetstream/TextInput.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetMultipleImageInput from "@/Jetstream/MultipleImageInput.vue";

export default {
	name: "show-settings",

	components: {
		Link,
		JetInput,
		JetInputError,
		JetLabel,
		JetTextInput,
		JetMultipleImageInput,
		FormGroup,
		JetButton,
		DetailView,
		Tabs,
		Tab,
        WebsiteSettings,
        CountrySettings,
        UnitSettings,
        CurrencySettings,
	},
	data() {
		return {
			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{ label: "Settings", route: null },
			],

			form: this.$inertia.form({
				firstName: null,
				lastName: null,
				email: null,
				phone: null,
				password: null,
				password_confirmation: null,
			}),
		};
	},

};
</script>
