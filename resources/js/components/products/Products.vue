<template>
  <div class="container">
    <div class="row">
      <div class="col-sm-3">
        <ProductsFilter
          :options="options"
          :categories="categories"
          :brands="brands"
          :min_price="min_price"
          :max_price="max_price"
          @fetchProducts="fetchFilterData"
        />
      </div>
      <div class="col-sm-9">
        <ProductsList
          :products="products"
          :google_ads="google_ads"
          @loadMoreProducts="loadMoreProducts"
          @fetchProducts="fetchFilterData"
          @sortProducts="sortProducts"
        />
      </div>
    </div>
  </div>
</template>
<script>
import ProductsFilter from "./ProductsFilter";
import ProductsList from "./ProductsList";

export default {
  components: {
    ProductsFilter,
    ProductsList
  },
  props: {
    products_list: {
      required: true
    },
    google_ads: {
      required: false
    },
    options: {
      type: Array,
      required: true
    },
    categories: {
      type: Array,
      required: true
    },
    brands: {
      type: Array,
      required: true
    },
    max_price: {
      type: Number,
      required: false,
      default: 1000
    },
    min_price: {
      type: Number,
      required: false,
      default: 1
    }
  },
  data() {
    return {
      products: Object,
      filterQuery: {},
      pageNumber: 1
    };
  },
  methods: {
    fetchFilterData(filterQuery) {
      this.filterQuery = filterQuery;
      this.pageNumber = 1;

      let queryObj = {};
      for (var property in this.filterQuery) {
        if (this.filterQuery.hasOwnProperty(property)) {
          queryObj[property] = this.filterQuery[property];
        }
      }

      axios
        .get("/products/filter", {
          params: queryObj
        })
        .then(response => {
          this.products = response.data;
        });
    },
    sortProducts(filterQuery) {
      console.log(filterQuery);
      //this.filterQuery = filterQuery;
      this.pageNumber = 1;

      let queryObj = {};
      for (var property in this.filterQuery) {
        if (this.filterQuery.hasOwnProperty(property)) {
          queryObj[property] = this.filterQuery[property];
        }
      }

      if(filterQuery.hasOwnProperty('sorting')){
        queryObj['sorting'] = filterQuery['sorting'];
      }

      axios
        .get("/products/filter", {
          params: queryObj
        })
        .then(response => {
          this.products = response.data;
        });
    },
    loadMoreProducts() {
      this.pageNumber++;
      let queryObj = {};
      queryObj["page"] = this.pageNumber;

      for (var property in this.filterQuery) {
        if (this.filterQuery.hasOwnProperty(property)) {
          queryObj[property] = this.filterQuery[property];
        }
      }

      axios
        .get("/products/filter", {
          params: queryObj
        })
        .then(response => {
          this.products.data = this.products.data.concat(response.data.data);
          this.products.current_page = response.data.current_page;
          this.products.last_page = response.data.last_page;
        });
    }
  },
  created() {
    this.products = this.products_list;
  }
};
</script>
