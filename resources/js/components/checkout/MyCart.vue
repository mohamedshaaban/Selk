    <template>
  <section class="sec-cart">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-8">
          <div class="row item-row" v-for="product_cart in cart.cart" :key="product_cart.key">
            <div class="col-xs-4">
              <div class="item-img">
                <p
                  class="new-labl off"
                  v-if="product_cart.product.offer"
                >{{product_cart.product.offer.percentage}}{{$t('website.off_percent_label')}}</p>
                <p
                  class="new-labl out"
                  v-if="!product_cart.product.in_stock && !product_cart.product.pre_order"
                >{{ $t('website.out_of_stock_label')}}</p>
                <p
                  class="new-labl pre"
                  v-if="!product_cart.product.in_stock && product_cart.product.pre_order"
                >{{ $t('website.pre_order_label')}}</p>
                <p class="new-labl" v-if="product_cart.product.is_new">{{$t('website.new_label')}}</p>

                <img :src="product_cart.image" alt>
              </div>
            </div>
            <div class="col-xs-5 col-sm-4 col-md-5">
              <img :src="`/uploads/`+product_cart.product.brand.image" alt="disney">
              <p class="item-name">{{ product_cart.name_en}}</p>
              <div v-if="product_cart.offer">
                <p class="old-price">{{ currency.code }}</p>
                <p
                  class="new-price"
                >{{ currency.code }} {{ parseFloat((product_cart.price - product_cart.offer.fixed) * currency.value).toFixed(3)}}</p>
              </div>
              <div v-else>
                <p class="new-price">{{ currency.code }} {{ parseFloat(product_cart.price * currency.value).toFixed(3)}}</p>
              </div>

              <div
                class="row size-qty"
                v-for="option_values  in product_cart.options_value"
                :key="option_values.key"
              >
                <div class="col-xs-3 col-sm-5 col-md-5">
                  <span class="size-text">{{option_values.option_name}}</span>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-2">
                  <span class="size-value">{{option_values.option_value_name}}</span>
                </div>
              </div>
              <div class="row size-qty">
                <div class="col-xs-12 col-lg-5">
                  <p class="quantity text-left">
                    {{ $t('website.qty')}}
                    <span  v-if="product_cart.product.maxima_order>0">&lpar;Limit {{ product_cart.product.maxima_order ? product_cart.product.maxima_order : product_cart.product.quantity }}&rpar;</span>
                  </p>
                </div>
                <div class="col-xs-12 col-lg-2">
                  <div class="input-group counter">
                    <span class="input-group-btn">
                      <button
                        @click="quantityDec(product_cart)"
                        type="button"
                        class="btn btn-number"
                        data-type="minus"
                        data-field
                      >
                        <span class="glyphicon glyphicon-minus"></span>
                      </button>
                    </span>
                    <input
                      type="text"
                      readonly
                      id="quantity"
                      name="quantity"
                      v-model="product_cart.quantity"
                      class="form-control input-number"
                    >
                    
                    <span class="input-group-btn">
                      <button
                        @click.prevent="quantityInc(product_cart)"
                        type="button"
                        class="btn btn-number"
                        data-type="plus"
                        data-field
                      >
                        <span class="glyphicon glyphicon-plus"></span>
                      </button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xs-3 col-sm-4 col-md-3">
              <p class="total-text text-right">{{ $t('website.total')}}</p>

              <p
                class="total-price text-right"
              >{{ currency.code }} {{ parseFloat((product_cart.quantity * product_cart.price) * currency.value).toFixed(3) }}</p>
              <button
                @click="editItemCart(product_cart)"
                class="btn text-uppercase edit"
              >{{ $t('website.edit')}}</button>
              <button
                class="btn text-uppercase remove-item"
                @click.prevent="removeFromCart(product_cart)"
              >{{ $t('website.remove_item')}}</button>
              <button
                class="btn text-uppercase mv-to-wsh-lst"
                @click.prevent="addToWishList(product_cart)"
              >{{ $t('website.move_wish_list')}}</button>
            </div>
          </div>

          <div class="row item-row" v-for="product_card in cart.cartCard" :key="product_card.key">
            <div class="col-xs-4">
              <div class="item-img">
                <img :src="'/uploads/'+product_card.image" alt>
              </div>
            </div>
            <div class="col-xs-5 col-sm-4 col-md-5">
              <p class="item-name">{{ product_card.name_en}}</p>

              <p class="new-price">{{ currency.code }} {{ parseFloat(product_card.price* currency.value).toFixed(3) }}</p>
            </div>
            <div class="col-xs-3 col-sm-4 col-md-3">
              <p class="total-text text-right">Total</p>
              <p
                class="total-price text-right"
              >{{ currency.code }} {{ parseFloat(product_card.price* currency.value).toFixed(3) }}</p>
              <button
                class="btn text-uppercase remove-item"
                @click.prevent="removeCardFromCart(product_card)"
              >Remove Item</button>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title text-uppercase text-center">{{ $t('website.my_account_label')}}</h3>
            </div>
            <div class="panel-body">
              <div class="row summary-row">
                <div class="col-sm-8 col-md-6">
                  <p class="text-uppercase">{{ $t('website.sub_total')}}</p>
                </div>
                <div class="col-sm-4 col-md-6">
                  <p class="value pull-right">{{ currency.code }} {{ parseFloat(cart.cartTotal* currency.value).toFixed(3) }}</p>
                </div>
              </div>
              <hr>

              <div class="row summary-row">
                <div class="col-sm-8 col-md-6">
                  <p class="text-uppercase">{{ $t('website.grand_total')}}</p>
                </div>
                <div class="col-sm-4 col-md-6">
                  <p class="value pull-right">
                    <b>{{ currency.code }} {{ parseFloat(cart.cartTotal* currency.value).toFixed(3) }}</b>
                  </p>
                </div>
              </div>
              <hr>
              <div class="row summary-row">
                <a href="/checkout">
                  <button class="btn proceed">{{ $t('website.Proceed_To_Checkout')}}</button>
                </a>
              </div>
              <div class="row summary-row">
                <a href="/">
                  <button class="btn continue">{{ $t('website.continue_shopping_label')}}</button>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="appendProductModal">
      <ProductModal
        @closeProductModal="closeProductModal"
        :key="ProductModaltKey"
        :product="selectedProduct"
      ></ProductModal>
    </div>
  </section>
</template>

<script>
import ProductModal from "../products/ProductModalCart";

export default {
  components: {
    ProductModal
  },
  props: {
    currency: null
  },
  data() {
    return {
      productsQuantity: [],
      cart: Object,
      cartCard: Object,
      errorCount: 0,
      optionError: false,
      optionErrorMessage: null,
      currency_name: null,
      currency_exchange_rate: null,
      selectedProduct: {},
      appendProductModal: false,
      ProductModaltKey: 0
    };
  },

  methods: {
    addToWishList(product) {
      if (this.$store.getters.isLoggedIn) {
        this.$store.commit("addToWishlist", product.product.id);
        this.showAlert(this.$t("website.added_to_wishlist_message"));
        this.removeFromCart(product);
      } else {
        $("#login-reg").modal("show");
      }
    },
    quantityInc(product) {
      let maxima_order = product.product.maxima_order
        ? product.product.maxima_order
        : product.product.quantity;
      if (product.quantity >= maxima_order) {
        // this.productsQuantity[product.product_id]=this.productsQuantity[product.product_id];
        return;
      }
      //   this.productsQuantity[product.product_id] += 1;

      //   console.log(this.productsQuantity[product.product_id]);
      let data = {
        product: product.product,
        options: this.checkedOptions,
        price: this.productPrice,
        quantity: product.quantity + 1
      };
      this.$store.commit("quantityInc", data);

      this.showAlert();
    },
    quantityDec(product) {
        if((product.quantity - 1) <= 0 )
        {
            this.showFailureAlert(this.$t("Invalid quantity"));
            return ;
        }
      let data = {
        product: product.product,
        options: this.checkedOptions,
        price: this.productPrice,
        quantity: product.quantity - 1
      };
      this.$store.commit("quantityDec", data);

      this.showAlert();
    },
      showFailureAlert(message) {
          this.$swal({
              type: "warning",
              title: message,
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 10000
          });
      },
    showAlert() {
      this.$swal({
        type: "success",
        title: "Product successfully updated to your cart",
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 10000
      });
    },
    removeCardFromCart(product) {
      this.$store.commit("removeCardFromCart", product);
      if (this.cart.cartCount == 0) {
        window.location = "/products";
      }
    },
    removeFromCart(product) {
      this.$store.commit("removeFromCart", product);
      if (this.cart.cartCount == 0) {
        window.location = "/products";
      }
    },
    editItemCart(product) {
      this.ProductModaltKey += 1;
      this.selectedProduct = product.product;

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
    }
  },

  created() {
    this.cart = this.$store.state;

    let localquantity = [];
    // // this.cart.cart.forEach(element => {
    // // console.log(element);
    // // });
    // //    this.$store.state.cart.each(function(product) {
    // // console.log(product);
    //     //   localquantity[product.product_id] = [];
    //     //   localquantity[product.product_id] = product.quantity;

    //     });

    this.productsQuantity = [];
  }
};
</script>
