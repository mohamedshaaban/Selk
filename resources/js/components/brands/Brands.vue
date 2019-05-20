<template>
  <div class="container">
    <div class="row brands">
      <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6" v-for="brand in brands.data" :key="brand.id">
        <a :href="`products?brands=` + brand.id">
          <img :src="`uploads/` + brand.image" alt="brand" class="brand-loaded">
        </a>
      </div>
    </div>
    <div class="col-xs-12 text-center" v-if="brands.current_page < brands.last_page">
      <a  @click.prevent="loadMore()" href="#" class="view-more-tbl">{{$t('website.view_more_label')}}</a>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      pageNumber: 1,
      brands: Object
    };
  },
  props: {
    brands_list: {
      type: Object,
      required: true
    }
  },
  methods: {
    loadMore() {
      this.pageNumber++;
      axios
        .get("brands/filter", {
          params: {
            page: this.pageNumber
          }
        })
        .then(response => {
          this.brands.data = this.brands.data.concat(response.data.data);
          this.brands.current_page = response.data.current_page;
          this.brands.last_page = response.data.last_page;
        });
    }
  },
  created() {
    this.brands = this.brands_list;
  }
};
</script>
