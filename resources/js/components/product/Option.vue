<template>
  <div>
    <div v-if="product.offer">
      <p class="old-price">
        {{ product.currency_name}}
        <span
          id="product_old_price_with_offer"
        >{{ (product.price * product.currency_exchange_rate).toFixed(3) }}</span>
      </p>
      <p class="price">
        {{ product.currency_name}}
        <span
          id="product_price"
        >{{ (productPrice * this.product.currency_exchange_rate).toFixed(3) }}</span>
      </p>
    </div>
    <div v-else>
      <p class="price">
        {{ product.currency_name}}
        <span
          id="product_price"
        >{{ (productPrice * this.product.currency_exchange_rate).toFixed(3) }}</span>
      </p>
    </div>
    <p class="return" v-if="product.free_return">{{$t('website.free_return_label')}}</p>
    <p class="delivery">
      {{ $t('website.free_delivery_label', {
      'amount': (free_delivery_amount * this.product.currency_exchange_rate).toFixed(3),
      'currency': this.product.currency_name
      })}}
    </p>
    <p class="pre-order text-uppercase" v-if="product.pre_order && product.in_stock == 0">
      {{ $t('website.pre_order_label')}}
      <br>
      <span>
        {{ $t('website.pre_order_item_ava_text', {
        'days': product.pre_order_days
        })}}
      </span>
    </p>

    <a
      href="javascript:void(0);"
      v-if="size_charts.length > 0"
      @click="showSizeChartModal"
      class="text-uppercase"
    >{{$t('website.size_chart_label')}}</a>
    <div class="options">
      <div class="row size-chart" v-for="option in product.options" :key="option.key">
        <div class="col-xs-1 col-sm-2 col-md-1">
          <p class="size-txt">{{ option.name }}</p>
        </div>
        <div class="col-xs-7 col-sm-7">
          <div class="btn-group" data-toggle="buttons" v-if="option_values[option.id]">
            <label
              class="btn size"
              v-for="option_value in option_values[option.id]"
              :key="option_value.id"
              @click="calcPrice()"
            >
              <input
                class="input_option_price"
                :type="option.type"
                :value="option_value.id"
                :name="option.id"
                :data-option-value-id="option_value.id"
                :data-option-id="option.id"
              >
              {{ option_value.value }}
            </label>
          </div>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-4 share-col">
          <span class="share-txt pull-right">
            <div class="sharethis-inline-share-buttons share-img"></div>
          </span>
        </div>
      </div>
      <div v-if="error">
        <span class="error" v-for="errorMessage in errorsMessages" :key="errorMessage.key">
          * {{errorMessage}}
          <br>
        </span>
      </div>
    </div>

    <div class="row quantity-limit">
      <div class="col-xs-12">
        <hr>
      </div>
      <div class="col-xs-5 col-sm-5" v-if="product.maxima_order>0">
        <p class="quantity">
          {{ $t('website.qty_label')}}
          <span>
            &lpar;{{ $t('website.limit_label')}}
            <span
              id="limit_quantity"
            >{{product.maxima_order ?product.maxima_order:product.quantity}}</span>&rpar;
          </span>
        </p>
      </div>
      <div class="col-xs-7 col-sm-7">
        <div class="input-group counter pull-right">
          <span class="input-group-btn">
            <button
              type="button"
              class="btn btn-number"
              data-type="minus"
              data-field
              @click="quantityDec()"
            >
              <span class="glyphicon glyphicon-minus"></span>
            </button>
          </span>
          <input
            type="text"
            id="quantity"
            name="quantity"
            class="form-control input-number"
            readonly
            v-model="productQuantity"
          >
          <span class="input-group-btn">
            <button
              type="button"
              class="btn btn-number"
              data-type="plus"
              data-field
              @click="quantityInc()"
            >
              <span class="glyphicon glyphicon-plus"></span>
            </button>
          </span>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-sm-12">
        <hr>
      </div>
    </div>

    <div class="row adding-to">
      <div class="col-xs-12 col-sm-6 add-to-wish">
        <button
          @click="addToWishList(product)"
          type="btn bg-light text-uppercase"
        >{{ $t('website.add_to_wishlist_label')}}</button>
      </div>
      <div class="col-xs-12 col-sm-6">
        <button
          class="add-to-shopping"
          type="btn bg-light text-uppercase"
          @click.prevent="addProductToCart(product)"
        >{{ $t('website.add_to_shopping_bag_label')}}</button>
      </div>
      <div class="col-xs-12 col-sm-6 notify-once" v-if="product.in_stock == 0">
        <button
          type="btn bg-light text-uppercase"
          data-toggle="modal"
          data-target="#notify-me"
        >{{$t('website.notify_me_button')}}</button>
      </div>
    </div>
    <NotifyMeModal @click="showNotiyMeModal" :product="product"></NotifyMeModal>
    <SizeChartModal :size_charts="size_charts"></SizeChartModal>
    <div v-if="appendProductDetailModal">
      <ProductDetailModal :product="productAdded"></ProductDetailModal>
    </div>
  </div>
</template>


<script>
import NotifyMeModal from "./NotifyMeModal";
import SizeChartModal from "./SizeChartModal";
import ProductDetailModal from "../products/ProductDetailModal";

export default {
  data() {
    return {
      checkedOptions: [],
      productPrice: 0,
      productQuantity: 1,
      errorCount: 0,
      error: false,
      errorsMessages: [],
      lang: this.$store.getters.lang,
      appendProductDetailModal: false,
      productAdded: Object
    };
  },
  components: {
    NotifyMeModal,
    SizeChartModal,
    ProductDetailModal
  },
  props: {
    product: {
      type: Object,
      required: true
    },
    option_values: {
      required: true
    },
    free_delivery_amount: {
      required: true
    },
    size_charts: {
      required: false,
      type: Array
    }
  },
  created() {
    this.productQuantity = this.product.minimum_order
      ? this.product.minimum_order
      : 1;
    this.setProductPrice(this.product.price);
  },
  methods: {
    addProductToCart(product) {
      this.calcPrice();

      // handel errors

      this.handleErrors();
      if (this.errorCount > 0) {
        return;
      }

      let data = {
        product: product,
        options: this.checkedOptions,
        price: this.productPrice,
        quantity: this.productQuantity
      };

      this.$store.commit("addToCart", data);
      this.showProductDetailModal(data);
      this.showAlert(this.$t("website.added_to_cart_message"));
    },
    addToWishList(product) {
      if (this.$store.getters.isLoggedIn) {
        this.$store.commit("addToWishlist", product.id);
        this.showAlert(this.$t("website.added_to_wishlist_message"));
      } else {
        $("#login-reg").modal("show");
      }
    },
    quantityDec() {
      let minimum_order = this.product.minimum_order
        ? this.product.minimum_order
        : 1;

      if (this.productQuantity > minimum_order) {
        this.productQuantity--;
      }
    },
    quantityInc() {
      let maxima_order = this.product.maxima_order
        ? this.product.maxima_order
        : this.product.quantity;

      if (this.productQuantity < maxima_order) {
        this.productQuantity++;
      } else {
        return;
      }
    },
    setProductPrice(price) {
      this.productPrice = this.product.offer
        ? price - this.product.offer.fixed
        : price;
    },
    showAlert(message) {
      this.$swal({
        type: "success",
        title: message,
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 10000
      });
    },
    showNotiyMeModal() {
      $("#notify-me").modal("show");
    },
    showSizeChartModal() {
      $("#size-chart2").modal("show");
    },

    showProductDetailModal(productAdded) {
      this.productAdded = productAdded;
      this.appendProductDetailModal = true;
      setTimeout(() => {
        $("#product-detail").modal("show");
      }, 500);
    },
    calcPrice() {
      // defined local checkedOption to save checked optoins inside jQuery each
      let checkedOptions = [];
      // normal jQuery each we are useing jQuery each becuse we need the option sorted asc
      $(".input_option_price").each(function() {
        if ($(this).is(":checked")) {
          checkedOptions.push($(this).data("option-value-id"));
        }
      });
      // delete all data from global checkedOptions
      this.checkedOptions = [];
      // global checkedOptions = local checkedOptions
      this.checkedOptions = checkedOptions;

      // check if product option equal checked options
      let price = 0;
      if (
        this.product.options.length > 0 &&
        this.checkedOptions.length == this.product.options.length
      ) {
        let priceCombination = this.product.option_values[0].pivot
          .price_combination;

        if (priceCombination != "" && priceCombination != null) {
          priceCombination = JSON.parse(priceCombination)["options"];
          priceCombination =
            priceCombination[this.checkedOptions.join("_")]["price"];
        } else {
          priceCombination = 0;
        }
        price = priceCombination == 0 ? this.product.price : priceCombination;
      } else {
        price = this.product.price;
      }
      this.setProductPrice(price);
    },
    handleErrors() {
      this.errorCount = 0;
      this.error = false;
      this.errorsMessages = [];
      if (this.checkedOptions.length != this.product.options.length) {
        this.error = true;
        this.errorsMessages.push(this.$t("website.option_error_message"));
        this.errorCount += 1;
      }
      if (!this.product.in_stock && !this.product.pre_order) {
        this.error = true;
        this.errorsMessages.push(this.$t("website.no_quantity_error"));
        this.errorCount += 1;
      }
    }
  }
};
</script>
