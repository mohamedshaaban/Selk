<template>
  <!-- Start Notify Me Modal -->
  <div id="notify-me" class="modal-notify-me modal fade">
    <div class="modal-dialog">
      <div class="modal-content text-center">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h2>{{ $t('website.notify_me_label')}}</h2>
          <form @submit.prevent="submit">
            <div class="col-xs-12">
              <hr>
              <p>{{$t('website.dear_customer_label')}}&comma;</p>
              <p>{{$t('website.notify_me_desc')}}&period;</p>
            </div>
            <div class="col-xs-6">
              <input
                required
                type="text"
                class="form-control"
                :placeholder="this.$t('website.name_label')"
                v-model="fields.name"
              >
              <span v-if="errors && errors.name" class="error">{{ errors.name[0] }}</span>
            </div>
            <div class="col-xs-6">
              <input
                type="tel"
                class="form-control"
                :placeholder="this.$t('website.phone_number_label')"
                v-model="fields.phone"
                required
              >
              <span v-if="errors && errors.phone" class="error">{{ errors.phone[0] }}</span>
            </div>
            <div class="col-xs-6">
              <input
                type="email"
                class="form-control"
                :placeholder="this.$t('website.email_label')"
                v-model="fields.email"
              >
              <span v-if="errors && errors.email" class="error">{{ errors.email[0] }}</span>
            </div>
            <div class="col-xs-6">
              <button type="submit" class="btn text-uppercase form-control">{{ $t('website.submit_button')}}</button>
            </div>
          </form>
          <b style="color:green" v-if="success">{{ $t('website.success_notify_me_message')}}</b>
        </div>
      </div>
    </div>
  </div>
  <!-- End Notify Me Modal -->
</template>

<script>
export default {
  props: {
    product: {
      type: Object,
      required: true
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
    submit() {
      this.errors = {};
      this.fields["product_id"] = this.product.id;

      axios
        .post("/product/notify_customer_once_ava", this.fields)
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
