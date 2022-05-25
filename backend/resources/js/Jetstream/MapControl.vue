<template>
	<div class="map-control">
		<!-- Autocomplete -->
		<GMapAutocomplete placeholder="Search Place" @place_changed="handleSearch($event)" :options="options">
		</GMapAutocomplete>

		<!-- Map -->
		<!-- <GMapMap ref="mapInstance" :center="center" :zoom="zoom" map-type-id="terrain" :style="{width, height}">
			<GMapPolygon ref="mapPoly" :options="options" :editable="false" :paths="paths" />
		</GMapMap> -->

		<!-- Polygon -->
	</div>
</template>

<script>
export default {
	name: "map-control",
	props: {
		center: {
			type: Object,
			default: { lat: 23.759606, lng: 90.420256 },
		},
		zoom: {
			type: Number,
			default: 14,
		},
		width: {
			type: String,
			default: "100%",
		},
		height: {
			type: String,
			default: "400px",
		},
		country: {
			type: String,
			default: "PK",
		},
	},
	data() {
		return {
			// paths: [
			// 	{ lat: 23.767209, lng: 90.414417 },
			// 	{ lat: 23.767739, lng: 90.416155 },
			// 	{ lat: 23.76713, lng: 90.41903 },
			// 	{ lat: 23.763033, lng: 90.421652 },
			// 	{ lat: 23.758398, lng: 90.419742 },
			// 	{ lat: 23.75774, lng: 90.40853 },
			// ],
			// options: {
			// 	strokeColor: "rgba(241, 74, 79)",
			// },
		};
	},
	computed: {
		options() {
			return {
				componentRestrictions: { country: [this.country] },
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
		handleSearch(e) {
			this.$emit("setPlace", e);
		},
	},
	async mounted() {
		// const map = await this.$refs.mapInstance;
		// console.log(map);
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


