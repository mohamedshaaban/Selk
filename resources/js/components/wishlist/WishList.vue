<template>
  <div ref="container">
    <div class="col-md-9 wish-list">
      <p class="item-counter-veiwer">
        {{$t('website.Wishlist_label')}}&ThickSpace;
        <span>&lpar;{{$t('website.items_label')}} {{ products.to }} {{ $t('website.of_label')}} {{ products.total }} {{ $t('website.total')}}&rpar;</span>
      </p>
      <div v-for="(product,index) in products.data" :key="product.key">
        <a :href="`/product/`+ product.slug_name" class="col-md-12 prodct-list-item">
          <div class="row item-row">
            <div class="col-md-5 col-md-4">
              <img :src="product.main_image_path" class="img-responsive" :alt="product.name_en">
            </div>
            <div class="col-md-5 col-md-4">
              <img src="img/disney-logo.png" alt="disney">
              <p class="item-name">
                {{product.name_en }}
                <br>
                {{product.name_en + index}}
              </p>
              <div v-if="product.offer">
                <p class="old-item-price">KD {{ product.price.toFixed(3) }}</p>
                <p class="price">KD {{ (product.price - product.offer.fixed).toFixed(3) }}</p>
              </div>
              <div v-else>
                <p class="price">KD {{product.price.toFixed(3) }}</p>
              </div>
            </div>
            <div class="col-md-3">
              <button
                @click.prevent="addToCart(product)"
                class="btn text-uppercase add-to-bag"
              >{{ $t('website.add_to_bag_label_label')}}</button>
              <button
                @click.prevent="removeFromWishList(product , index)"
                class="btn text-uppercase remove-item"
              >{{ $t('website.remove_item')}}</button>
            </div>
          </div>
          <hr>
        </a>
      </div>
      <div v-if="appendProductModal">
        <ProductModal
          @closeProductModal="closeProductModal"
          :key="ProductModaltKey"
          :product="selectedProduct"
        ></ProductModal>
      </div>
      <!--product item-->
    </div>

    <div class="col-xs-12 text-center" v-if="products.current_page < products.last_page">
      <a @click.prevent="loadMoreProducts()" href="#" class="view-more-tbl">View More</a>
    </div>
  </div>
</template>
<script>
import ProductModal from "../products/ProductModal";
export default {
  components: {
    ProductModal
  },
  data() {
    return {
      selectedProduct: {},
      appendProductModal: false,
      ProductModaltKey: 0
    };
  },
  props: {
    products: {
      type: Object,
      required: true
    }
  },
  methods: {
    loadMoreProducts: function() {
      this.$emit("loadMoreProducts");
    },
    addToCart(product) {
      this.ProductModaltKey += 1;
      this.selectedProduct = product;
      this.appendProductModal = true;
      this.openProductModal();
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
    removeFromWishList(product, index) {
      this.products.data.splice(index, 1);
      this.$store.commit("removeFromWishList", product.id);
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
