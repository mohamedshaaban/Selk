<template>
  <div class="panel panel-default">
    <ul class="nav nav-pills nav-stacked" id="stacked-menu">
      <!-- Category collapsed menu -->
      <li>
        <a
          class="nav-container"
          data-toggle="collapse"
          data-parent="#stacked-menu"
          href="#categories"
        >{{ $t('website.categories_label')}}</a>
        <ul
          class="nav nav-pills nav-stacked collapse in"
          id="categories"
          v-for="category in categories"
          :key="category.id"
        >
          <template v-if="category.parent_id == 0">
            <li
              v-bind:class="{ 'nav-sub-container' : category.sub_categories.length != 0 }"
              data-toggle="collapse"
              data-parent="#p1"
              :href="`#`+category.id"
            >
              <a
                @click.prevent="setFilterQuery('categories',category)"
                class="single-category"
              >{{ category.name }}</a>
            </li>
            <ul class="nav nav-pills nav-stacked collapse in" :id="category.id">
              <li v-for="subCategory in category.sub_categories" :key="subCategory.id">
                <a
                  @click.prevent="setFilterQuery('categories',subCategory)"
                  v-if="subCategory.parent_id == category.id"
                  href="#"
                >{{ subCategory.name}}</a>
              </li>
            </ul>
          </template>
        </ul>
      </li>

      <!-- Brand collapsed menu -->
      <li>
        <a
          class="nav-container"
          data-toggle="collapse"
          data-parent="#stacked-menu"
          href="#brand"
        >{{ $t('website.brands_label')}}</a>
        <ul class="nav nav-pills nav-stacked collapse in" id="brand">
          <li
            v-for="brand in brands"
            :key="brand.id"
            @click.prevent="setFilterQuery('brands',brand)"
          >
            <a class="single-category">{{ brand.name }}</a>
          </li>
        </ul>
      </li>

      <!-- Price collapsed menu -->
      <li>
        <a
          class="nav-container"
          data-toggle="collapse"
          data-parent="#stacked-menu"
          href="#price"
        >{{ $t('website.price_label')}}</a>
        <ul class="nav nav-pills nav-stacked collapse in" id="price">
          <li class="pad-15">
            <div id="slider-range" @click="getPriceRange()"></div>

            <input
              class="rangedprice pull-left"
              type="text"
              id="amountfrm"
              readonly
              style="text-align:left;"
            >
            <input class="rangedprice pull-right" type="text" id="amountto">
          </li>
        </ul>
      </li>

      <!-- Size collapsed menu -->
      <li v-for="option in options" :key="option.id">
        <a
          class="nav-container"
          data-toggle="collapse"
          data-parent="#stacked-menu"
          :href="`#`+option.name"
        >{{ option.name }}</a>
        <ul class="nav nav-pills nav-stacked collapse in" :id="option.name">
          <li
            class="check_box_here product-size-checkbox-container"
            v-for="option_value in option.option_value"
            :key="option_value.id"
          >
            <span class="check product-size-checkbox">
              <input
                @click.prevent="setFilterQuery('options_value',option_value)"
                class="filter_checkbox"
                :id="`pro-size-chk` + option_value.id"
                :value="option_value.id"
                :name="`option`[option.id][option_value.id]"
                type="checkbox"
              >
              <label :for="`pro-size-chk` + option_value.id"></label>
            </span>
            <label class="siz-box-label">{{option_value.value }}</label>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</template>
<script>
export default {
  props: {
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
    min_price: {
      type: Number,
      required: false,
      default: 1
    },
    max_price: {
      type: Number,
      required: false,
      default: 1000
    }
  },
  data() {
    return {
      filterQuery: []
    };
  },
  created() {
    this.getUrlParameters();
    this.setPriceRange();
  },

  methods: {
    setFilterQuery: function(name, element) {
      if (this.filterQuery[name]) {
        if (this.filterQuery[name].indexOf(element.id) > -1) {
          this.filterQuery[name].pop(element.id);
        } else {
          this.filterQuery[name].push(element.id);
        }
      } else {
        if (this.filterQuery.indexOf(name) == -1) {
          this.filterQuery[name] = [];
        }
        this.filterQuery[name].push(element.id);
      }
      this.getFilterData();
    },

    getFilterData() {
      this.$emit("fetchProducts", this.filterQuery);
    },
    getUrlParameters() {
      let uri = window.location.href.split("?");
      let getVars = [];

      if (uri.length == 2) {
        let vars = uri[1].split("&");
        let tmp = "";
        vars.forEach(function(v) {
          tmp = v.split("=");
          if (tmp.length == 2) {
            getVars[tmp[0]] = [];
            getVars[tmp[0]].push(tmp[1]);
          }
        });
        this.filterQuery = getVars;
        this.getFilterData();
      }
    },
    setPriceRange() {
      setTimeout(() => {
        $("#amountfrm").val(Math.floor(this.min_price));
        $("#slider-range").slider("option", "min", Math.floor(this.min_price));
        $("#amountto").val(Math.floor(this.max_price));
        $("#slider-range").slider("option", "max", Math.floor(this.max_price));
      }, 1000);
    },
    getPriceRange() {
      this.filterQuery["price_from"] = $("#amountfrm").val();
      this.filterQuery["price_to"] = $("#amountto").val();
      this.getFilterData();
    }
  }
};
</script>
