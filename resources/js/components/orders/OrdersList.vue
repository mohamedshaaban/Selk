<template>
  <div ref="container">

  <div class="full-width x_scroll">
    <table class="my_account">
      <tbody>
        <tr class="headk">
          <td>{{ $t('website.date_label') }}</td>
          <td>{{ $t('website.order') }} #</td>
          <td>{{$t('website.status')}}</td>
          <td>{{$t('website.amount')}}</td>
          <td>&nbsp;</td>
        </tr>
      </tbody>
        <tr v-for="order in orders.data" :key="order.key">
            <td><span>{{ order.order_date }}</span></td>
            <td><span>{{ order.unique_id }}</span></td>
            <td><span>{{ order.status.title_en }}</span></td>
            <td><span>KD {{ order.total }}</span></td>
            <td>
            <a :href="`order-detatils/`+ order.unique_id  "><img src="/images/icons/view-icon.png" alt="dhl" class="mCS_img_loaded"></a>  &nbsp;&nbsp;&nbsp;&nbsp;
            <a v-if="order.dhl_shipping_info_id" :href="`order_track?tracking_number=`+ order.dhlshippinginfo.tracking_number  "><img src="/images/icons/tracking.png" alt="dhl" class="mCS_img_loaded"></a>
            </td>
        </tr>
    </table>
  </div>
    <div class="col-xs-12 text-center" v-if="orders.current_page < orders.last_page">
      <a @click.prevent="loadMoreOrders()" href="#" class="view-more-tbl">{{ $t('website.load_more')}}</a>
    </div>
  </div>
</template>
<script>

export default {

  props: {
    orders: {
      type: Object,
      required: true
    }
  },
  methods: {
    loadMoreOrders: function() {
      this.$emit("loadMoreOrders");
    },
  }
};
</script>
