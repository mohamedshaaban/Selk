<template>
  <div id="product-detail" class="modal-add-cart modal fade">
    <div class="modal-dialog">
      <div class="modal-content text-center">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <div class="row item-row">
            <div class="col-sm-4">
              <div class="item-img">
                <img :src="product.product.main_image_path">
              </div>
            </div>
            <div class="col-sm-8">
              <p class="item-na[me">{{product.product.name}}</p>
              <p
                class="price"
              >{{product.product.currency_name}} {{ ((product.price * product.product.currency_exchange_rate) * product.quantity).toFixed(3) }}</p>
              <div
                class="row size-qty"
                v-for="option_value in product.product.options"
                :key="option_value.key"
              >
                <div class="col-xs-6 col-md-5">
                  <span class="size-text">{{ option_value.name}}</span>
                </div>
                <div class="col-xs-6 col-md-2">
                  <span class="size-value">{{ option_value.id | optionValueName(product)}}</span>
                </div>
              </div>
              <div class="row size-qty">
                <div class="col-xs-6 col-md-5">
                  <p class="quantity text-left">
                      {{ $t('website.qty_label')}}
                    <span v-if="product.product.maxima_order>0">&lpar;Limit {{product.product.maxima_order ?product.product.maxima_order:product.product.quantity}}&rpar;</span>
                  </p>
                </div>
                <div class="col-xs-6 col-md-2">
                  <div class="input-group counter pull-right">
                    <!-- <span class="input-group-btn">
                      <button type="button" class="btn btn-number" data-type="minus" data-field>
                        <span class="glyphicon glyphicon-minus"></span>
                      </button>
                    </span>-->
                    <input
                      type="text"
                      id="quantity"
                      name="quantity"
                      class="form-control input-number"
                      :value="product.quantity"
                      readonly
                    >
                    <!-- <span class="input-group-btn">
                      <button type="button" class="btn btn-number" data-type="plus" data-field>
                        <span class="glyphicon glyphicon-plus"></span>
                      </button>
                    </span>-->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <button
                data-dismiss="modal"
                class="btn text-uppercase form-control"
              >{{ $t('website.continue_shopping_label')}}</button>
            </div>
            <div class="col-sm-6">
              <a
                href="/checkout "
                type="button"
                class="check-out btn text-uppercase form-control"
              >{{ $t('website.checkout_label')}}</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
Vue.filter("optionValueName", function(option_value_id, product) {
  let value = "";
  value = product.product.option_values.find(function(option_value) {
    if (option_value.option_id == option_value_id) {
      if (product.options.indexOf(option_value.id) != -1) {
        return option_value;
      }
    }
  });
  return value.value;
});
export default {
  props: {
    product: {
      type: Object,
      required: true
    }
  },

  created() {}
};
</script>
