<template>
	<jet-dropdown width="64" :align="align">
		<template #trigger>
			<button class="inline-flex bg-white text-black items-center px-6 py-3 shadow-md border border-transparent rounded-full font-bold text-xs uppercase tracking-widest disabled:opacity-25 transition">
				<span class="mr-4 ti-calendar"></span>
				<span class="">Filter</span>
				<span class="ml-4 ti-angle-down text-primary-500 "></span>
			</button>
		</template>

		<template #content>
			<div class="p-2">
				<slot>
					<div>No Filter Added.</div>
				</slot>
               <div class="flex justify-center items-center">
                    <button class=" text-sm my-1 text-primary-500 hover:underline" type="button" @click="$emit('reset')">Reset</button>
               </div>
			</div>
		</template>
	</jet-dropdown>
</template>

<script>
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";
export default {
	components: {
		JetDropdown,
		JetDropdownLink,
	},
	props: {
		align: {
			type: String,
			default: "right",
		},

	},
};
</script>
