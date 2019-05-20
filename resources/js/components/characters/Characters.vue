<template>
  <div class="container">
    <div v-for="character in characters.data" :key="character.id">
      <div class="col-md-4 white-gift">
        <h2 class="gift-head">{{ character.name }}</h2>
        <a :href="`products?characters=` + character.id " class="chars gift-img">
          <img :src="`uploads/` + character.image">
        </a>
        <div class="col-md-10 col-md-offset-1 mt-20"></div>
      </div>
    </div>
    <div class="col-xs-12 text-center" v-if="characters.current_page < characters.last_page">
      <a @click.prevent="loadMore()" href="#" class="view-more-tbl">{{$t('website.view_more_label')}}</a>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      pageNumber: 1,
      characters: Object
    };
  },
  props: {
    characters_list: {
      type: Object,
      required: true
    }
  },
  methods: {
    loadMore() {
      this.pageNumber++;
      axios
        .get("characters/filter", {
          params: {
            page: this.pageNumber
          }
        })
        .then(response => {
          this.characters.data = this.characters.data.concat(
            response.data.data
          );
          this.characters.current_page = response.data.current_page;
          this.characters.last_page = response.data.last_page;
        });
    }
  },
  created() {
    this.characters = this.characters_list;
  }
};
</script>
