<template>
  <div class="upcoming-slider">
    <div class="slide">
      <a
        v-for="category in categories.data"
        :key="category.id"
        :href="`products?categories=` + category.id "
        class="item"
      >
        <img :src="`uploads/` + category.image" alt="img">
        <div class="cat-name">
          <p>{{ category.name }}</p>
        </div>
      </a>
    </div>
    <div class="col-xs-12 text-center" v-if="categories.current_page < categories.last_page">
      <a @click.prevent="loadMore()" href="#" class="view-more-tbl">{{$t('website.view_more_label')}}</a>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      pageNumber: 1,
      categories: Object
    };
  },
  props: {
    categories_list: {
      type: Object,
      required: true
    }
  },
  methods: {
    loadMore() {
      this.pageNumber++;
      axios
        .get("categories/filter", {
          params: {
            page: this.pageNumber
          }
        })
        .then(response => {
          this.categories.data = this.categories.data.concat(
            response.data.data
          );
          this.categories.current_page = response.data.current_page;
          this.categories.last_page = response.data.last_page;
        });
    }
  },
  created() {
    this.categories = this.categories_list;
  }
};
</script>
