<template>
  <div>
    <section class="pb-45">
      <div class="container">
        <div class>
          <div class="col-md-6 white-gift">
            <h2 class="gift-head" :style="'color:'+ card.color">{{ $t('website.thank_you_card')}}</h2>
            <div class="gift-img">
              <img :src="'/uploads/'+card.image" alt>
              <h1 class="gift-price" :style="'color:'+ card.color">
                KD
                <span id="priceID" :style="'color:'+ card.color">{{ selectedValue }}</span>
              </h1>
              <p class="gift-code">
                {{ $t('website.your_gift_code')}}
                <br>
                <span :style="'color:'+ card.color">**** **** **** ****</span>
              </p>
            </div>
          </div>
          <div class="col-md-6">
            <form id="app" @submit="addCardToCart" method="post">
              <div class="register_box full-width">
                <h2 class="gift-head">{{ $t('website.recipient_information')}}</h2>
                <div class="row">
                  <div class="col-lg-6 col-md-6">
                    <input
                      class="inpt"
                      type="text"
                      v-model="name"
                      required
                      :placeholder="$t('website.Name_label')"
                    >
                    <span v-if="errors && errors.name" class="error">{{ errors.name[0] }}</span>
                  </div>
                  <!-- /.col-lg-6 -->
                  <div class="col-lg-6 col-md-6">
                    <input
                      class="inpt"
                      type="text"
                      v-model="email"
                      required
                      :placeholder="$t('website.Email_label')"
                    >
                    <span v-if="errors && errors.email" class="error">{{ errors.email[0] }}</span>
                  </div>
                  <!-- /.col-lg-6 -->
                  <div class="col-lg-6 col-md-6">
                    <input
                      class="inpt"
                      type="text"
                      v-model="phone"
                      required
                      :placeholder="$t('website.PhoneNumber_label_label')"
                    >
                    <span v-if="errors && errors.phone" class="error">{{ errors.phone[0] }}</span>
                  </div>
                  <!-- /.col-lg-6 -->
                  <div class="col-lg-6 col-md-6">
                      <input type="hidden" id="amt" name="amt">
                    <select
                      class="inpt"
                      @change="onChange($event)"



                    >
                      <option value="0" :selected="amount == 0" >{{ $t('website.please_select_label')}}</option>
                      <option
                        v-for="cardprice in card.cardprices"
                        :key="cardprice.key"
                        v-bind:value="cardprice.amount"
                      >{{ cardprice.amount }}</option>
                    </select>
                    <span v-if="errors && errors.amount" class="error">{{ errors.amount[0] }}</span>
                  </div>
                  <!-- /.col-lg-6 -->
                  <div class="list-inline mp-0 m-13-0">
                    <label class="radio-container">{{ $t('website.Send_by')}}</label>
                    <label class="radio-container">
                      {{ $t('website.By_Email')}}
                      <input
                        type="radio"
                        checked="checked"
                        name="radio5"
                      >
                      <span class="checkmark"></span>
                    </label>
                    <label class="radio-container">
                      {{ $t('website.by_mobile')}}
                      <input type="radio" name="radio5">
                      <span class="checkmark"></span>
                    </label>
                  </div>
                </div>
                <!-- /.row -->

                <!--
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-25 clear col-md-offset-3">
                    <button class="button-main" type="button" data-toggle="modal" data-target="#confirmation" data-dismiss="modal">submit</button>
                </div>
                -->
              </div>

              <div class="register_box full-width">
                <h2 class="gift-head">{{ $t('website.sender_information')}}</h2>
                <div class="row">
                  <div class="col-lg-6 col-md-6">
                    <input
                      class="inpt"
                      type="text"
                      v-model="user.name"
                      :placeholder="$t('website.Name_label')"
                    >
                    <span v-if="errors && errors.user_name" class="error">{{ errors.user_name[0] }}</span>
                  </div>
                  <!-- /.col-lg-6 -->
                  <div class="col-lg-6 col-md-6">
                    <input
                      class="inpt"
                      type="text"
                      v-model="user.email"
                      :placeholder="$t('website.Email_label')"
                    >
                    <span
                      v-if="errors && errors.user_email"
                      class="error"
                    >{{ errors.user_email[0] }}</span>
                  </div>
                  <!-- /.col-lg-6 -->
                  <div class="col-lg-6 col-md-6">
                    <input
                      class="inpt"
                      type="text"
                      v-model="user.phone"
                      :placeholder="$t('website.PhoneNumber_label_label')"
                    >
                    <span
                      v-if="errors && errors.user_phone"
                      class="error"
                    >{{ errors.user_phone[0] }}</span>
                  </div>
                </div>
                <!-- /.row -->

                <!-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-25 clear col-md-offset-3"> -->
                <button
                  class="button-main"
                  type="button"
                  @click="addCardToCart"
                >{{ $t('website.add_to_bag_label_label')}}</button>
                <!-- </div> -->
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
export default {
  data() {
    return {
      selectedValue: 0,
      name: null,
      email: null,
      phone: null,
      amount: null,
      errors: {},
      success: false
    };
  },
  props: {
    card: {
      type: Object,
      required: true
    },
    user: {
      type: Object,
      required: true
    }
  },

  methods: {
    onChange(event) {
      this.card.price = event.target.value;
      $('#amt').val(event.target.value);

      this.selectedValue = event.target.value;
    },
    addCardToCart: function(e) {
      let data = {
        product: this.card,
        amount: $('#amt').val()!=0 ? $('#amt').val() : null,
        name: this.name,
        email: this.email,
        phone: this.phone
      };

      this.validation(data);
    },
    validation(data) {

      this.errors = {};

      axios
        .post("/giftcart/validation", data)
        .then(response => {

            if(response.data==true) {

            this.$store.commit("addCardToCart", data);
            this.showAlert();
        }
        })
        .catch(error => {

          if (error.response.status === 422) {
            this.errors = error.response.data.errors || {};
          }
        });
    },
    showAlert() {
      this.$swal({
        type: "success",
        title: "Card successfully added to your cart",
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 5000
      });
    }
  }
};
</script>
