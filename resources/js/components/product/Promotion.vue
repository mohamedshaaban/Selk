<template>
  <div class="container" v-if="products_group">
    <div class="mainhead text-center m-30">
      <h2>{{ $t('website.promotion_label')}}</h2>
    </div>
    <div class="row">
      <a
        :href="`/product/` + products_group.product_with.slug_name"
        class="col-xs-3 prodct-new-arr prom-item"
      >
        <div class="pic">
          <img :src="products_group.product_with.main_image_path" alt>
        </div>
        <div class="btnx-func">
          <button class="crt">
            <img src="img/wish.png" alt>
          </button>
          <button class="crt">
            <img src="img/crt.png" alt>
          </button>
        </div>
        <p class="small-des">{{products_group.product_with.name}}</p>
        <p
          class="price"
        >{{ products_group.product_with.currency_name}} {{ (products_group.product_with.price * products_group.product_with.currency_exchange_rate).toFixed(3) }}</p>
      </a>

      <div class="col-xs-1 plus-symbol text-center">&plus;</div>

      <a
        :href="`/product/` + products_group.product_belong.slug_name"
        class="col-xs-3 prodct-new-arr prom-item"
      >
        <div class="pic">
          <img :src="products_group.product_belong.main_image_path" alt>
        </div>
        <div class="btnx-func">
          <button class="crt">
            <img src="img/wish.png" alt>
          </button>
          <button class="crt">
            <img src="img/crt.png" alt>
          </button>
        </div>
        <p class="small-des">{{ products_group.product_belong.name }}</p>
        <p
          class="price"
        >{{products_group.product_belong.currency_name}} {{ (products_group.product_belong.price * products_group.product_belong.currency_exchange_rate).toFixed(3) }}</p>
      </a>
      <!-- <div class="col-xs-5 "> -->
      <div class="col-xs-1 equals-symbol text-center">&equals;</div>
      <div class="col-xs-4 mt-12-per">
        <div
          class="col-xs-6 old-price text-center"
        >{{products_group.product_belong.currency_name}} {{ ((products_group.product_with.price + products_group.product_belong.price) * products_group.product_belong.currency_exchange_rate).toFixed(3)}}</div>
        <div
          class="col-xs-6 new-price text-center"
        >{{products_group.product_belong.currency_name}} {{ (products_group.price * products_group.product_belong.currency_exchange_rate).toFixed(3) }}</div>

        <div class="col-md-12 text-center">
          <button
            class="button-main clear mt-15"
            type="btn bg-light text-uppercase"
            @click="addGroupToCart(products_group.product_with)"
          >{{ $t('website.add_to_shopping_bag_label')}}</button>
        </div>
      </div>
      <div v-if="appendProductModal">
        <ProductModal
          @closeProductModal="closeProductModal"
          :key="ProductModaltKey"
          :buttonName="this.$t(buttonName)"
          :product="selectedProduct"
          :disabledQuantity="true"
          :isGroupProducts="true"
          :groupProducts="products_group"
        ></ProductModal>
      </div>
    </div>
  </div>
</template>

<script >
import ProductModal from "../products/ProductModal";

export default {
  data() {
    return {
      appendProductModal: false,
      ProductModaltKey: 0,
      selectedProduct: {},
      buttonName: "website.next_product_label"
    };
  },
  props: {
    products_group: {
      type: Object,
      required: true
    }
  },
  components: {
    ProductModal
  },
  methods: {
    addGroupToCart(product) {
      this.ProductModaltKey += 1;
      this.selectedProduct = product;
      this.appendProductModal = true;
      this.openProductModal();
    },
    openProductModal() {
      setTimeout(() => {
        $("#add-cart").modal("show");
      }, 500);
    },
    closeProductModal() {
      if (this.ProductModaltKey % 2 == 0) {
        setTimeout(() => {
          $("#add-cart").modal("hide");
          this.appendProductModal = false;
          this.buttonName = this.$t("website.next_product_label");
        }, 500);
      } else {
        this.buttonName = this.$t("website.add_to_shopping_bag_label");
        $("#add-cart").modal("hide");
        this.addGroupToCart(this.products_group.product_belong);
      }
    }
  }
};
</script>
