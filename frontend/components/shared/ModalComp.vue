<template>
  <div>
    <div @click="toggleModal">
      <slot name="button">
        Open
      </slot>
    </div>
    <div @click.self="toggleModal" v-if="showModal" class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex" style="background: rgba(0,0,0,0.5)">
      <div class="relative w-full my-6 mx-3" :style="{maxWidth:  maxWidth +'px'}">
        <!--content-->
        <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
          <!--header-->
          <div class="flex items-center justify-between py-3 px-5 border-b border-solid border-blueGray-200 rounded-t">
            <h3 class="text-xl font-semibold">{{headerText}}</h3>
            <div @click="toggleModal()" class="text-gray-400 hover:text-primary-500 cursor-pointer">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
          </div>
          <!--body-->
          <div class="relative p-6 flex-auto overflow-y-auto" style="max-height: 550px">
            <slot name="modal-body" :toggle="toggleModal" :orderId="orderId">
              <p class="text-gray-600 leading-relaxed">Modal body goes here!</p>
            </slot>
          </div>
        </div>
      </div>
    </div>
    <!-- <div @click="toggleModal" v-if="showModal" class="opacity-50 fixed inset-0 z-40 bg-black"></div> -->
  </div>
</template>

<script>
export default {
  name: "ModalComp",
  data() {
    return {
      showModal: false
    };
  },
  props: {
    headerText: {
      type: [String, Number],
      default: "HeaderText"
    },
    maxWidth: {
      type: Number,
      default: 600
    },
    orderId: {
      type: Number
    }
  },
  methods: {
    toggleModal: function() {
      this.showModal = !this.showModal;
      if (this.showModal) {
        document.body.classList.add("overflow-hidden");
      } else {
        document.body.classList.remove("overflow-hidden");
      }
    }
  }
};
</script>