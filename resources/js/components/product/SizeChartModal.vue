<template>
  <div
    class="modal fade"
    id="size-chart2"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header text-center">
          <h4
            class="modal-title text-drkgreen"
            id="exampleModalLabel"
          >{{ $t('website.size_chart_label')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th width="33%">{{ $t('website.size_label')}}</th>
                <th width="33%">{{ $t('website.quantity_label')}}</th>
                <th width="33%">{{ $t('website.price_label')}}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="size_chart in size_charts" :key="size_chart.key">
                <td>{{ size_chart.name}}</td>
                <td>{{ size_chart.quantity > 0 ? size_chart.quantity : $t('website.out_of_stock_label') }}</td>
                <td>{{ size_chart.price}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    size_charts: {
      type: Array,
      required: false
    }
  }
};
</script>
