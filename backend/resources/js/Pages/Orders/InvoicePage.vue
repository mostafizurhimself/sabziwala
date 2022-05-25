<template>
    <app-layout>
        <!-- Header -->
        <div class=" divide-y divide-gray-200">
            <div class="flex justify-between py-3 rounded-md">
                <div>
                    <h1 class="truncate text-90 font-normal text-xl">
                        <span class="ml-2"> Invoice No: {{order.invoiceNo}}</span>
                    </h1>
                </div>
                <!-- Route Link -->
                <div class="items-center">
                    <button class="btn btn-success mr-2" @click="print('print')">
                        <span class="ti-printer mr-2"></span> <span> Print</span>
                    </button>

                    <Link class="btn btn-primary mr-2" :href="route('orders.index')">
                    <i class="ti-arrow-left"></i>
                    </Link>
                </div>
            </div>
        </div>
        <!-- Invoice Section -->
        <div id="print" class="bg-white rounded-sm flex flex-col py-6 px-8">
            <div class="flex justify-between mt-2">
                <!-- Logo -->
                <div class="">
                    <img :src="website.primaryMediaUrl" alt="logo" style="width:100px">
                </div>
                <!-- Invoice info -->
                <div class="text-right">
                    <h1 class="text-2xl font-bold uppercase mt-2"> Invoice</h1>
                    <span class="text-xs">#{{ order.invoiceNo }} </span>
                    <span class="text-xs block">{{ order.dateFormatted }} </span>
                </div>
            </div>
            <!--  Info Section -->
            <div class="flex justify-between mt-5">
                <!-- Company  info -->
                <div class="">
                    <h5 class="font-bold">Billing From</h5>
                    <div class="text-sm mt-2">
                        <p class="font-bold">{{ website.data.name }}</p>
                        <p>{{website.data.phone}}</p>
                        <p>{{website.data.email}}</p>
                        <p> {{ website.data.street }}</p>
                        <p> {{ website.data.city }}-{{ website.data.zip }} ,
                            {{ website.data.country }}
                        </p>
                    </div>
                </div>
                <!-- Customer info -->
                <div class="text-right">
                    <h5 class="font-bold">Bill To</h5>
                    <div class="text-sm mt-2">
                        <p class="font-bold">{{ order.customer.name }}</p>
                        <p>{{order.customer.phone}}</p>
                        <p>{{order.customer.email}}</p>

                        <p> {{ order.billingAddress.street}}</p>
                        <p> {{ order.billingAddress.city }}-{{ order.billingAddress.zipcode }} , {{ order.billingAddress.country }}</p>
                    </div>
                </div>
            </div>

            <div>

            </div>

            <!-- Items -->
            <h5 class="font-bold mt-4 mb-2">Items:</h5>
            <!-- component -->
            <div class="bg-white rounded-sm shadow overflow-x-auto">
                <table class="w-full divide-y divide-black border-1">
                    <thead class="bg-white ">
                        <tr class="">
                            <th scope="col" class="px-6 py-3 text-left border-2 text-sm text-black uppercase font-bold">#</th>
                            <th scope="col" class="px-6 py-3 text-left border-2 text-sm text-black uppercase font-bold">Item Name</th>
                            <th scope="col" class="px-6 py-3 text-left border-2 text-sm text-black uppercase font-bold">Code</th>
                            <th scope="col" class="px-6 py-3 text-left border-2 text-sm text-black uppercase font-bold">Quantity</th>
                            <th scope="col" class="px-6 py-3 text-left border-2 text-sm text-black uppercase font-bold">Price</th>
                            <th scope="col" class="px-6 py-3 text-left border-2 text-sm text-black uppercase font-bold">Total Price</th>

                        </tr>

                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(orderItem, index) in order.orderItems" :key="index">
                            <td class="px-6 py-3 border-2 whitespace-nowrap">
                                {{ index + 1 }}
                            </td>

                            <td class="px-6 py-3 border-2 whitespace-nowrap">{{orderItem.product.name}}</td>
                            <td class="px-6 py-3 border-2 whitespace-nowrap">{{orderItem.product.code}}</td>
                            <td class="px-6 py-3 border-2 whitespace-nowrap  text-right">{{orderItem.quantity}} {{orderItem.unit.code}}</td>
                            <td class="px-6 py-3 border-2 whitespace-nowrap text-right">{{orderItem.rateFormatted}}</td>
                            <td class="px-6 py-3 border-2 whitespace-nowrap text-right">{{orderItem.amountFormatted}}</td>
                        </tr>

                        <tr>
                            <th scope="col" colspan="5" class="px-6 py-3 text-right text-sm text-black uppercase font-bold">Subtotal</th>
                            <td class="px-6 py-3 border-2 text-right whitespace-nowrap">{{order.subTotalFormatted}} </td>
                        </tr>
                        <tr>
                            <th scope="col" colspan="5" class="px-6 py-3 text-right text-sm text-black uppercase font-bold">Discount</th>
                            <td class="px-6 py-3 border-2 text-right whitespace-nowrap">{{order.totalDiscountFormatted}} </td>
                        </tr>

                        <tr>
                            <th scope="col" colspan="5" class="px-6 py-3 text-right text-sm text-black uppercase font-bold">TOTAL</th>
                            <td class="px-6 py-3 border-2 text-right whitespace-nowrap">{{order.grandTotalFormatted}}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </app-layout>

</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import ImagePreview from "@/Partials/ImagePreview.vue";
import { Link } from "@inertiajs/inertia-vue3";
export default {
    name: "order-invoice",
    props: {
        order: Object,
        website: Object,
    },

    components: {
        AppLayout,
        ImagePreview,
        Link,
    },

    methods: {
        print(id) {
            let contents = document.getElementById(id).innerHTML;
            let frame1 = document.createElement("iframe");
            frame1.name = "frame1";
            frame1.style.position = "absolute";
            frame1.style.top = "-1000000px";
            document.body.appendChild(frame1);
            let frameDoc = frame1.contentWindow
                ? frame1.contentWindow
                : frame1.contentDocument.document
                ? frame1.contentDocument.document
                : frame1.contentDocument;
            frameDoc.document.open();
            frameDoc.document.write(
                '<html lang="en"><head><title>Invoice</title>'
            );
            frameDoc.document.write(
                '<link rel="stylesheet" type="text/css" href="/css/app.css" />'
            );
            frameDoc.document.write("</head><body>");
            frameDoc.document.write(contents);
            frameDoc.document.write("</body></html>");
            frameDoc.document.close();
            setTimeout(function () {
                window.frames["frame1"].focus();
                window.frames["frame1"].print();
                document.body.removeChild(frame1);
            }, 500);
            return false;
        },
    },
};
</script>


<style lang="scss" scoped>
#print {
    min-height: 11.5in;
}
</style>
