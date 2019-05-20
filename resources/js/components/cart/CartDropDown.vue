<template>
  <div class="cart_contents full-width">
    <h2>{{ $t('website.recently_Added_label')}}</h2>
    <h1 class="ttl-crt">{{ cart.cartCount }} {{ $t('website.items_label')}}</h1>

    <!-- /.border_dashed -->
    <div class="border_dashed full-width" v-for="cart_product in cart.cart" :key="cart_product.key">
      <img :src="cart_product.image" alt="cart" class="mCS_img_loaded">
      <h1>{{cart_product.product.name}}</h1>

      <h3>{{currency.code}} {{ (cart_product.total * currency.value).toFixed(3)}}</h3>
      <h1 class="crt-price">{{ $t('website.quantity_label')}} : {{ cart_product.quantity}}</h1>
      <h3 class="cart-btnx crt-mt-10">
        <a href="/checkout/my_cart">
          <img src="/img/edit.png" alt>
        </a>
        <a class="delete-4-cart" @click.prevent="removeFromCart(cart_product)">
          <img src="/img/dlt.png" alt>
        </a>
      </h3>
      <p
        class="cart-see-more"
        data-toggle="collapse"
        :data-target="`#crtinx1_`+ cart_product.product_id"
        v-if="cart_product.product.options.length"
      >{{ $t('website.View_details')}}</p>
      <div :id="`crtinx1_`+ cart_product.product_id" class="collapse cart-see-more cbz">
        <div v-for="option_values  in cart_product.options_value" :key="option_values.key">
          <p>
            <span>{{option_values.option_name}}</span>
          </p>
          <p>{{option_values.option_value_name}}</p>
        </div>
      </div>
    </div>

    <div
      class="border_dashed full-width"
      :v-if="cartCard"
      v-for="cart_product in cartCard.cartCard"
      :key="cart_product.key"
    >
      <img :src="'/uploads/'+cart_product.image" alt="cart" class="mCS_img_loaded">
      <h1>{{cart_product.product.name}}</h1>

      <h3>{{currency.code}} {{ (cart_product.total * currency.value).toFixed(3) }}</h3>
      <h1 class="crt-price">{{ $t('website.quantity_label')}} : {{ cart_product.quantity}}</h1>
      <h3 class="cart-btnx crt-mt-10">

        <a class="delete-4-cart" @click.prevent="removeCardFromCart(cart_product)">
          <img src="/img/dlt.png" alt>
        </a>
      </h3>
      <div :id="`crtinx1_`+ cart_product.product_id" class="collapse cart-see-more cbz"></div>
    </div>

    <!-- /.border_dashed -->
    <h1 class="crt-total">{{ $t('website.total_label')}} </h1>
    <h1 class="crt-price-ttl">{{ currency.code }} {{ (cart.cartTotal * currency.value).toFixed(3) }}</h1>
  </div>
</template>

<script>
export default {
  props: {
    currency: null
  },
  data() {
    return {
      cart: Object,
      cartCard: Object,
      currency_name: null,
      currency_exchange_rate: null
    };
  },
  created() {
    // this.$store.commit('getServerData');
    this.cart = this.$store.state;
    this.cartCard = this.$store.state;
  },
  beforeCreate() {
    this.$store.dispatch("getServerData");
  },
  methods: {
    removeFromCart(product) {
      this.$store.commit("removeFromCart", product);
    },
    removeCardFromCart(product) {
      this.$store.commit("removeCardFromCart", product);
    }
  }
};
</script>
