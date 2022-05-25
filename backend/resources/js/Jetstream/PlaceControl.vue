<template>
	<div class="map-control">
		<!-- Autocomplete -->
		<GMapAutocomplete placeholder="Search Place Here" @place_changed="fillPlace($event)" :options="options">
		</GMapAutocomplete>
	</div>
</template>

<script>
export default {
	name: "place-control",
	props: {
		/**
		 * Restrict the country search
		 */
		countries: {
			type: Array,
			default: () => [],
		},
	},
	data() {
		return {
			place: {
				name: "",
				city: "",
				zipcode: "",
				state: "",
				country: "",
			},
		};
	},
	computed: {
		options() {
			return {
				componentRestrictions: { country: this.countries },
				fields: [
					"address_components",
					"geometry",
					"name",
					"formatted_address",
				],
			};
		},
	},
	methods: {
		fillPlace(event) {
			this.place.name = event.name;
			for (const component of event.address_components) {
				const componentType = component.types[0];

				switch (componentType) {
					case "postal_code": {
						this.place.zipcode = component.long_name;
						break;
					}
					case "locality": {
						this.place.city = component.long_name;
						break;
					}
					case "administrative_area_level_1": {
						this.place.state = component.short_name;
						break;
					}

					case "country": {
						this.place.country = component.long_name;
						break;
					}
				}
			}
			this.$emit("setPlace", this.place);
		},
	},
};
</script>

<style lang="scss">
.map-control .pac-target-input {
	padding: 10px 15px;
	border: 1px solid rgba(209, 213, 219);
	width: 100%;
	border-radius: 9999px;
	margin-bottom: 15px;

	&:focus {
		outline: none;
		border-color: rgba(241, 74, 79);
		box-shadow: 0px 0px 2px 1px #f14a4f;
	}
}
</style>


