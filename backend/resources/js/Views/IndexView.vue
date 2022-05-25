<template>
	<app-layout :title="title">
		<div class="flex flex-col sm:flex-row justify-between sm:items-center mb-5">
			<h1 class="font-bold text-2xl">{{title}}</h1>
			<!-- Breadcumb -->
			<div>
				<breadcrumb :breadcrumb="breadcrumb"></breadcrumb>
			</div>
		</div>
		<slot></slot>
	</app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "@/Jetstream/Breadcrumb.vue";

export default {
	props: {
		title: {
			type: String,
			default: "",
		},
		breadcrumb: {
			type: Array,
			default: () => [],
		},
	},
	components: {
		AppLayout,
		Breadcrumb,
	},
};
</script>

<style lang="scss" scoped>
</style>
