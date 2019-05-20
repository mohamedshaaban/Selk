<template>
  <div ref="container">
    <p class="product-count text-uppercase">
      {{$t('website.products_label')}}
      <span>&lpar;{{products.total}}&ThickSpace;{{$t('website.products_label')}}&rpar;</span>
    </p>
    <select class="col-md-2 col-sm-2 col-xs-2 rit" @change="sorting($event)">
      <option value disabled selected hidden>{{$t('website.sort_by_label')}}</option>
      <option value="newest">{{$t('website.newest_label')}}</option>
      <option value="asc">{{$t('website.sorting_price_asc_label')}}</option>
      <option value="desc">{{$t('website.sorting_price_desc_label')}}</option>
    </select>

    <div class="row">
      <div v-for="(product,index) in products.data" :key="product.key">
        <div class="col-md-4">
          <a :href="`/product/`+ product.slug_name" class="col-md-12 prodct-list-item">
            <div class="item-img">
              <img :src="product.main_image_path" class="img-responsive" :alt="product.name">
            </div>
            <p
              class="new-labl off"
              v-if="product.offer"
            >{{product.offer.percentage}}{{$t('website.off_percent_label')}}</p>
            <p
              class="new-labl out"
              v-if="!product.in_stock && !product.pre_order"
            >{{ $t('website.out_of_stock_label')}}</p>
            <p
              class="new-labl pre"
              v-if="!product.in_stock && product.pre_order"
            >{{ $t('website.pre_order_label')}}</p>
            <p class="new-labl" v-if="product.is_new">{{$t('website.new_label')}}</p>
            <div class="btn-fav-cart">
              <button @click.prevent="addToWishlist(product)" class="fav-crt">
                <img src="/img/wish.png" alt>
              </button>
              <button @click.prevent="addToCart(product)" class="fav-crt">
                <img src="/img/crt.png" alt>
              </button>
            </div>
            <p class="item-desc">{{product.name }}</p>
            <div v-if="product.offer">
              <p
                class="old-item-price"
              >{{ product.currency_name}} {{ (product.price * product.currency_exchange_rate).toFixed(3) }}</p>
              <p
                class="item-price"
              >{{ product.currency_name}} {{ ((product.price - product.offer.fixed) * product.currency_exchange_rate).toFixed(3)}}</p>
            </div>
            <div v-else>
              <p
                class="item-price"
              >{{ product.currency_name}} {{ (product.price * product.currency_exchange_rate).toFixed(3)}}</p>
            </div>
          </a>
        </div>
        <div class="row" v-if="(index + 1) % 9 === 0 && index < 30">
          <div class="col-xs-12">
            <div class="ads" v-html="getAdImage()">
              <!-- <img src="img/ads-banner.png" alt> -->
            </div>
          </div>
        </div>
      </div>

      <!--product item-->
    </div>

    <!--row-->
    <div class="col-xs-12 text-center" v-if="products.current_page < products.last_page">
      <a
        @click.prevent="loadMoreProducts()"
        href="#"
        class="view-more-tbl"
      >{{$t('website.view_more_label')}}</a>
    </div>
    <div v-if="appendProductModal">
      <ProductModal
        @closeProductModal="closeProductModal"
        :key="ProductModaltKey"
        :product="selectedProduct"
      ></ProductModal>
    </div>
  </div>
</template>

<script>
import ProductModal from "./ProductModal";

export default {
  components: {
    ProductModal
  },
  data() {
    return {
      selectedProduct: {},
      appendProductModal: false,
      ProductModaltKey: 0,
      adNumber: 1,
      adMaxNumber: 3
    };
  },
  props: {
    products: {
      type: Object,
      required: true
    },
    google_ads: {
      required: false
    }
  },
  methods: {
    getAdImage() {
      return this.google_ads.google_ads_1;
    },
    sorting(event) {
      this.$emit("sortProducts", { sorting: event.target.value });
    },
    loadMoreProducts: function() {
      this.$emit("loadMoreProducts");
    },
    addToCart(product) {
      this.ProductModaltKey += 1;
      this.selectedProduct = product;
      this.appendProductModal = true;
      this.openProductModal();
    },
    addToWishlist(product) {
      if (this.$store.getters.isLoggedIn) {
        this.$store.commit("addToWishlist", product.id);
        this.showAlert(this.$t("website.added_to_wishlist_message"));
      } else {
        $("#login-reg").modal("show");
      }
    },
    openProductModal() {
      setTimeout(() => {
        $("#add-cart").modal("show");
      }, 50);
    },
    closeProductModal() {
      setTimeout(() => {
        $("#add-cart").modal("hide");
      }, 500);
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
    }
  }
};
</script>
