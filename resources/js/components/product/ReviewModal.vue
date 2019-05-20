<template>
  <div class="row">
    <div class="col-sm-6">
      <div class="rate">
        <div class="rating">
          <input
            :checked="rating == 5 ? 'checked' : ''"
            disabled="disabled"
            type="radio"
            id="star1"
            name="rating-main"
            value="10"
          >
          <label for="star1">1 star</label>
          <input
            :checked="rating == 4 ? 'checked' : ''"
            disabled="disabled"
            type="radio"
            id="star2"
            name="rating-main"
            value="9"
          >
          <label for="star2">2 stars</label>
          <input
            :checked="rating == 3 ? 'checked' : ''"
            disabled="disabled"
            type="radio"
            id="star3"
            name="rating-main"
            value="8"
          >
          <label for="star3">3 stars</label>
          <input
            :checked="rating == 2 ? 'checked' : ''"
            disabled="disabled"
            type="radio"
            id="star4"
            name="rating-main"
            value="7"
          >
          <label for="star4">4 stars</label>
          <input
            :checked="rating == 1 ? 'checked' : ''"
            disabled="disabled"
            type="radio"
            id="star5"
            name="rating-main"
            value="6"
          >
          <label for="star5">5 star</label>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <a @click="addReview()" href="javascript:void(0);" style="line-height: 50px;" class="text-right">Add Reviews</a>
      <!-- Modal box for add review-->
      <div
        class="modal fade"
        id="add-review"
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
              >{{ $t('website.add_your_review_label')}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form @submit.prevent="submit">
              <div class="modal-body">
                <div class="d-block">
                  <div class="rate">
                    <div class="rating">
                      <input
                        v-model="fields.rate"
                        type="radio"
                        id="star0005"
                        name="rate2"
                        value="5"
                        checked
                      >
                      <label for="star0005" title="text">5 stars</label>
                      <input
                        v-model="fields.rate"
                        type="radio"
                        id="star0004"
                        name="rate2"
                        value="4"
                      >
                      <label for="star0004" title="text">4 stars</label>
                      <input
                        v-model="fields.rate"
                        type="radio"
                        id="star0003"
                        name="rate2"
                        checked="checked"
                        value="3"
                      >
                      <label for="star0003" title="text">3 stars</label>
                      <input
                        v-model="fields.rate"
                        type="radio"
                        id="star0002"
                        name="rate2"
                        value="2"
                      >
                      <label for="star0002" title="text">2 stars</label>
                      <input
                        v-model="fields.rate"
                        type="radio"
                        id="star0001"
                        name="rate2"
                        value="1"
                      >
                      <label for="star0001" title="text">1 star</label>
                    </div>
                  </div>
                  <span v-if="errors && errors.rate" class="error">{{ errors.rate[0] }}</span>
                </div>
                <br>
                <!-- <div class="form-group">
                  <label for="exampleInputPassword1">Nick Name</label>
                  <input
                    type="Text"
                    class="form-control mt-2 rounded-0"
                    id="exampleInputPassword1"
                    placeholder="Nick Name"
                    v-model="fields.name"
                  >
                  <span v-if="errors && errors.name" class="error">{{ errors.name[0] }}</span>
                </div>-->
                <div class="form-group">
                  <label for="exampleInputPassword1">{{ $t('website.review_details_label')}}</label>
                  <textarea
                    style="height: 120px; resize: none;"
                    class="forms-control rounded-0"
                    placeholder="Comment"
                    v-model="fields.comment"
                  />
                  <span v-if="errors && errors.comment" class="error">{{ errors.comment[0] }}</span>
                </div>
              </div>
              <center
                style="color:green"
                v-if="success"
              >{{ $t('website.success_notify_me_message')}}</center>

              <div class="modal-footer flex-row-reverse">
                <button type="submit" class="btn btn-primary new">{{ $t('website.submit_button')}}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    product: {
      type: Object,
      required: true
    },
    rating: {
      default: 0,
      type: Number,
      required: false
    }
  },
  data() {
    return {
      fields: {},
      errors: {},
      success: false
    };
  },
  methods: {
    addReview() {
      if (this.$store.getters.isLoggedIn) {
        $("#add-review").modal("show");
      } else {
        $("#login-reg").modal("show");
      }
    },
    submit() {
      this.errors = {};
      this.fields["product_id"] = this.product.id;
      axios
        .post("/product/add_review", this.fields)
        .then(response => {
          this.fields = {};
          this.success = true;
        })
        .catch(error => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors || {};
          }
        });
    }
  }
};
</script>
