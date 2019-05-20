import { isNull } from "util";


let cart =[];
let cartCard = [];
let cartCount = 0;
let cartTotal = 0;
let cartId    ='';
let cartCardId    = '';

export const strict = false;

const store = {

    state: {
        cart:  [],
        cartCard:  [],
        cartCount:  0,
        cartTotal :  0,
        cartId : '',
        cartCardId : '',
    },
actions:{
    getServerData(state, response) {
        axios
        .get("/cart/get", {
          params: {
            cartId : window.localStorage.getItem('cartId'),
          }
        })
        .then(response => {
          if(response.data){
            this.state.cart =JSON.parse(response.data.cart);
              this.state.cartCard =JSON.parse(response.data.cartCard);
            this.state.cartCount= response.data.cartCount;

              this.state.cartTotal = response.data.totalCart;
          }

        });

        // axios
        // .get("/giftcart/get", {
        //   params: {
        //     cartId : window.localStorage.getItem('cartCardId'),
        //   }
        // })
        // .then(response => {
        //   if(response.data){
        //     this.state.cartCard =JSON.parse(response.data.cartCard);
        //       this.state.cartTotal = this.state.cartTotal+response.data.totalCart;
        //   }
        // });
    },
},
    mutations: {

        quantityInc(state , payload)
        {
            let item = payload.product;
            let options = payload.options;
            let price = payload.price;
            let quantity =payload.quantity;
            let found = state.cart.find(product => product.product_id == item.id);


                found.quantity = quantity;
                found.total += quantity * price;
                state.cartTotal +=   quantity * price;
                axios
                .post("/cart/update", {
                  params: {
                    cartId : state.cartId,
                    product:item,
                    quantity:1,
                    increment:'true'
                  }
                })
                .then(response => {

                    state.cart = JSON.parse(response.data.cart);
                    state.cartCount = response.data.cartCount;
                    state.cartTotal = response.data.totalCart;

                });

                // this.commit("saveCart");

        },
        quantityDec(state , payload)
        {
            let item = payload.product;
            let quantity = 1;
            let price = payload.price;
            let found = state.cart.find(product => product.product_id == item.id);


            found.quantity = quantity;
            found.total += quantity * price;
            state.cartTotal +=   quantity * price;
            axios
            .post("/cart/update", {
              params: {
                cartId : state.cartId,
                product:item,
                quantity:quantity,
                increment:'false'
              }
            })
            .then(response => {
                window.localStorage.setItem('cartId', response.data.cartId);
                state.cart = JSON.parse(response.data.cart);
                state.cartCount = response.data.cartCount;
                state.cartTotal = response.data.totalCart;

            });

            this.commit("saveCart");
        },
       addToCart(state, payload) {

           let item = payload.product;
           let options = payload.options;
           let price = payload.price;
           let quantity = payload.quantity;



           let found = state.cart.find(product => product.product_id == item.id);

            if (found) {
                found.quantity += quantity;
                found.total += quantity * price;
                // state.cartTotal +=   quantity * price;
                axios
                .post("/cart/add", {
                  params: {
                    cartId : state.cartId,
                    product:item,
                    quantity:quantity,
                    options:options
                  }
                })
                .then(response => {
                    window.localStorage.setItem('cartId', response.data.cartId);
                    // window.localStorage.setItem('cart', JSON.parse(response.data.cart));
                    // window.localStorage.setItem('cartCount', response.data.cartCount);
                    // window.localStorage.setItem('cartTotal', response.data.totalCart);
                    this.state.cart =JSON.parse(response.data.cart);
                    this.state.cartCount= response.data.cartCount
                    this.state.cartTotal =response.data.totalCart;
                });
            } else {

            axios
                .post("/cart/add", {
                  params: {
                    cartId : state.cartId,
                    product:item,
                    quantity:quantity,
                    options:options
                  }
                })
                .then(response => {

                    // window.localStorage.setItem('cartId', response.data.cartId);
                    // window.localStorage.setItem('cart', JSON.parse(response.data.cart));
                    // window.localStorage.setItem('cartCount', response.data.cartCount);
                    // window.localStorage.setItem('cartTotal', response.data.totalCart);
                    this.state.cart =JSON.parse(response.data.cart);
                    this.state.cartCount= response.data.cartCount
                    this.state.cartTotal =response.data.totalCart;


                });

            }

            // this.commit("saveCart");
        },
        removeFromCart(state, item) {

             axios
                .get("/cart/remove", {
                  params: {
                    product_id: item.product_id
                  }
                })
                .then(response => {

                    this.state.cart =JSON.parse(response.data.cart);
                    this.state.cartCount=response.data.cartCount>= 0 ? response.data.cartCount : 0;
                    this.state.cartTotal =response.data.totalCart;




                });
            // this.commit("saveCart");
        },
        removeCardFromCart(state, item) {

            axios
               .get("/giftcart/remove", {
                 params: {
                   product_id: item.product_id
                 }
               })
               .then(response => {

                   this.state.cartCard =JSON.parse(response.data.cart);
                   this.state.cartCount= response.data.cartCount
                   this.state.cartTotal =response.data.totalCart;




               });
            this.commit("getServerData");

       },
        saveCart(state) {

            window.localStorage.setItem('cart', JSON.stringify(state.cart));
            window.localStorage.setItem('cartCount', state.cartCount);
            window.localStorage.setItem('cartTotal', state.cartTotal);

        },
        saveCartCard(state) {

            window.localStorage.setItem('cartCardId', JSON.stringify(state.cartCardId));
            window.localStorage.setItem('cartCount', state.cartCount);
            window.localStorage.setItem('cartTotal', state.cartTotal);

        },
        addGroupProducts(state, payload){
            // console.log(payload.groupProducts);
            let product=payload.groupProducts;
            let item = payload.product;
            let options = payload.options;
            let price = payload.price;
            let quantity = payload.quantity;

            axios
                .post("/cart/add", {
                  params: {
                    cartId : state.cartId,
                    product:item,
                    quantity:quantity,
                    options:options
                  }
                })
                .then(response => {


                    this.state.cart =JSON.parse(response.data.cart);
                    this.state.cartCount= response.data.cartCount
                    state.cartTotal =response.data.totalCart;


                });

        },
        addToWishlist(state,product_id){
            axios
            .post("/customer/add_to_wishlist",{'product_id': product_id})
            .catch(error => {
              if (error.response.status === 401) {
                $('#login-reg').modal('show');
              }
            });
        },
        removeFromWishList(state,product_id){
            axios
            .post("/customer/removeFromWishList",{'product_id': product_id})
            .catch(error => {
              if (error.response.status === 401) {
                $('#login-reg').modal('show');
              }
            });
        },
        addCardToCart(state, payload)
        {

            let item = payload.product;
            let price=payload.amount;

            state.cartCard.push({
                'product_id' : item.id,
                'image' :  item.image,
                'product' : item,
                'quantity' :1,
                'price' : price,
                'total' : 1 * price,
                'name':payload.name,
                'email':payload.email
            });
            axios
            .post("/giftcart/add", {
              params: {
                cartCardId : state.cartCardId,
                product:item,
                quantity:1,
                name:payload.name,
                email:payload.email,
                phone:payload.phone,
                amount:payload.amount
              }
            })
            .then(response => {
                this.state.cartCard =JSON.parse(response.data.cart);
                this.state.cartCount= this.state.cartCount+ response.data.cartCount;
                this.state.cartTotal = response.data.totalCart;


            });

            this.commit("getServerData");
            // this.commit("saveCartCard");
        }

    },
    getters :{
        isLoggedIn(state) {
            return window.auth_user;
        }

    },

    strict: false
};

export default store;
