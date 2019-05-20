<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">&nbsp;</h3>
              <div class="box-tools">
                <div class="btn-group pull-right" style="margin-right: 5px">
                  <a href="{{ route('admin_order.index') }}" class="btn btn-sm btn-default" title="List"><i
                        class="fa fa-list"></i><span class="hidden-xs">&nbsp;List</span></a>
                </div>
                <div class="btn-group pull-right" style="margin-right: 5px">
                  <button type="button" class="btn btn-sm btn-primary add-btn" title="List"><i
                        class="fa fa-save"></i><span class="hidden-xs">&nbsp;save</span></button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <form action="{{ $order->id? route('admin_order.update', [$order->id]): route('admin_order.store') }}"
            id="form-order" class="form-horizontal" method="post">
        @if($order->id)
          <input type="hidden" name="_method" value="put">
        @endif
        @csrf
        <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Customer Details</h3>
              </div>

              <div class="box-body">
                <div class="fields-group">
                  <div class="form-group">
                    <label for="customer-add-type" class="col-sm-2 control-label">Add Customer</label>
                    <div class="col-sm-10">
                      <input type="checkbox"
                             class="customer-add-type la_checkbox" data-on-label="Add New Customer"
                             data-off-label="Select Exist Customer" {{ old('customer-add-type', 'off') == 'on' ? 'checked' : '' }} />
                      <input type="hidden" class="customer-add-type" name="customer-add-type"
                             value="{{ old('customer-add-type', 'off') }}"/>
                    </div>
                  </div>

                  <div id="select_customer">
                    <div class="form-group ">
                      <label for="customer_id" class="col-sm-2 control-label">Customer</label>
                      <div class="col-sm-10">
                        <label class="control-label error" style="display: none;" for="inputError"><i
                              class="fa fa-times-circle-o"></i> This Field is Required</label>
                        <select class="form-control customer_id" style="width: 100%;" name="customer_id"
                                id="customer_id">
                          @if($order->user_id)
                            <option value="{{ $order->user_id }}" selected="">{{ $order->user->name }}</option>
                          @endif
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Address</label>
                      <div class="col-sm-10">
                        <input type="checkbox" data-off-label="Add new address" data-on-label="Select exist address"
                               class="add-address-type la_checkbox"{{ old('add-address-type', ($order->address_id? 'on': 'off')) == 'on' ? 'checked' : '' }} />
                        <input type="hidden" class="add-address-type" name="add-address-type"
                               value="{{ old('add-address-type', 'on') }}"/>
                      </div>
                    </div>
                  </div>

                  <div id="add_customer" style="display: none;">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Name</label>
                      <div class="col-sm-10">
                        <label class="control-label error" style="display: none;" for="inputError"><i
                              class="fa fa-times-circle-o"></i> This Field is Required</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                          <input type="text" id="user-name" name="user-name" value="" class="form-control"
                                 placeholder="Input User Name">
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Email</label>
                      <div class="col-sm-10">
                        <label class="control-label error" style="display: none;" for="inputError"><i
                              class="fa fa-times-circle-o"></i> This Field is Required</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                          <input type="text" id="user-email" name="user-email" value="" class="form-control"
                                 placeholder="Input User email">
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Phone</label>
                      <div class="col-sm-10">
                        <label class="control-label error" style="display: none;" for="inputError"><i
                              class="fa fa-times-circle-o"></i> This Field is Required</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                          <input type="text" id="user-phone" name="user-phone" value="" class="form-control"
                                 placeholder="Input User Phone">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div id="select_address" style="{{ $order->address_id? '': 'display: none;' }}">
                    <div class="form-group">
                      <label for="address_id" class="col-sm-2 control-label">Select Address</label>
                      <div class="col-sm-10">
                        <label class="control-label error" style="display: none;" for="inputError"><i
                              class="fa fa-times-circle-o"></i> This Field is Required</label>
                        <input type="hidden" name="address_id"/>
                        <select class="form-control address_id" style="width: 100%;" name="address_id"
                                id="address_id">
                          @if($order->user_id)
                            <option value="{{ $order->address_id }}"
                                    selected="">{{ optional($order->userAddress)->first_address }}</option>
                          @endif
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div id="add_address" style="{{ $order->address_id? 'display: none;': '' }}">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Add Address</h3>
                </div>
                <div class="box-body">
                  <div class="fields-group">
                    <div class="col-sm-6">
                      <div class="form-group ">
                        <label for="address_type" class="col-sm-3 control-label">Address Type</label>
                        <div class="col-sm-9">
                          <label class="control-label error" style="display: none;" for="inputError"><i
                                class="fa fa-times-circle-o"></i> This Field is Required</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                            <input type="text" id="address_type" name="address_type" value="" class="form-control"
                                   placeholder="Input Address Type">
                          </div>
                        </div>
                      </div>

                      <div class="form-group ">
                        <label for="user_label" class="col-sm-3 control-label">User Label</label>
                        <div class="col-sm-9">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                            <input type="text" id="user_label" name="user_label" value="" class="form-control"
                                   placeholder="Input User Label">
                          </div>
                        </div>
                      </div>

                      <div class="form-group ">
                        <label for="first_address" class="col-sm-3 control-label">First Address</label>
                        <div class="col-sm-9">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                            <input type="text" id="first_address" name="first_address" value="" class="form-control"
                                   placeholder="Input First Address">
                          </div>
                        </div>
                      </div>

                      <div class="form-group ">
                        <label for="second_address" class="col-sm-3 control-label">Second Address</label>
                        <div class="col-sm-9">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                            <input type="text" id="second_address" name="second_address" value="" class="form-control"
                                   placeholder="Input Second Address">
                          </div>
                        </div>
                      </div>

                      <div class="form-group ">
                        <label for="mobile_no" class="col-sm-3 control-label">Mobile Number</label>
                        <div class="col-sm-9">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                            <input type="text" id="mobile_no" name="mobile_no" value="" class="form-control"
                                   placeholder="Input Mobile Number">
                          </div>
                        </div>
                      </div>

                      <div class="form-group ">
                        <label for="phone_no" class="col-sm-3 control-label">Phone Number</label>
                        <div class="col-sm-9">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                            <input type="text" id="phone_no" name="phone_no" value="" class="form-control"
                                   placeholder="Input Phone Number">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group ">
                        <label for="first_name" class="col-sm-3 control-label">First Name</label>
                        <div class="col-sm-9">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                            <input type="text" id="first_name" name="first_name" value="" class="form-control"
                                   placeholder="Input First Name">
                          </div>
                        </div>
                      </div>

                      <div class="form-group ">
                        <label for="last_name" class="col-sm-3 control-label">Last Name</label>
                        <div class="col-sm-9">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                            <input type="text" id="last_name" name="last_name" value="" class="form-control"
                                   placeholder="Input Last Name">
                          </div>
                        </div>
                      </div>

                      <div class="form-group ">
                        <label for="post_code" class="col-sm-3 control-label">Post Code</label>
                        <div class="col-sm-9">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                            <input type="text" id="post_code" name="post_code" value="" class="form-control"
                                   placeholder="Input Post Code">
                          </div>
                        </div>
                      </div>

                      <div class="form-group ">
                        <label for="governorate_id" class="col-sm-3 control-label">Governorate</label>
                        <div class="col-sm-9">
                          <label class="control-label error" style="display: none;" for="inputError"><i
                                class="fa fa-times-circle-o"></i> This Field is Required</label>
                          <select class="form-control governorate_id" style="width: 100%;" name="governorate_id"
                                  id="governorate_id">
                            @foreach($governorates as $governorate)
                              <option value="{{ $governorate->id }}">{{ $governorate->name_en }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="city" class="col-sm-3 control-label">City</label>
                        <div class="col-sm-9">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                            <input type="text" id="city" name="city" value="" class="form-control"
                                   placeholder="Input City">
                          </div>
                        </div>
                      </div>

                      <div class="form-group ">
                        <label for="province" class="col-sm-3 control-label">Province</label>
                        <div class="col-sm-9">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                            <input type="text" id="province" name="province" value="" class="form-control"
                                   placeholder="Input Province">
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div>
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Order Status</h3>
                </div>
                <div class="box-body">
                  <div class="fields-group">
                    <div class="form-group">
                      <label for="order_status" class="col-sm-3 control-label">Order Status</label>
                      <div class="col-sm-6">
                        <label class="control-label error" style="display: none;" for="inputError"><i
                              class="fa fa-times-circle-o"></i> This Field is Required</label>
                        <select name="order_status" id="order_status" class="form-control">
                          @foreach($order_status as $status)
                            <option
                                value="{{ $status->id }}" {!! $status->id==old('order_status', $order->status_id)? 'selected=""': '' !!}>{{ $status->title_en }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="status_comment" class="col-sm-3 control-label">Comment</label>
                      <div class="col-sm-6">
                        <label class="control-label error" style="display: none;" for="inputError"><i
                              class="fa fa-times-circle-o"></i> This Field is Required</label>
                        <textarea class="form-control" id="status_comment" name="status_comment"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <hr>
                    </div>
                  </div>
                  @foreach($statusHis as $statusRow)
                    <div class="row">
                      <div class="col-md-6 col-md-offset-3"><label>{{ optional($statusRow->status_history)->title_en }}</label> <span class="pull-right">{{ $statusRow->created_at->diffForHumans() }}</span></div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-md-offset-3"><pre style="min-height: 39px">{{ $statusRow->comment }}</pre></div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Delivery details</h3>
                </div>
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="fields-group">
                        <div class="form-group">
                          <label for="delivery_method" class="col-sm-4 control-label">Delivery Method</label>
                          <div class="col-sm-8">
                            <label class="control-label error" style="display: none;" for="inputError"><i
                                  class="fa fa-times-circle-o"></i> This Field is Required</label>
                            <select name="delivery_method" id="delivery_method" class="form-control">
                              @foreach($shipping_methods as $method)
                                <option value="{{ $method->id }}" data-free="{{ $method->is_free }}"
                                        data-price="{{ $method->price }}" {{ ($order->shipping_method and $order->shipping_method==$method->id)? 'selected=""': '' }}>{{ $method->title_en }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-sm-8 col-md-offset-4 pt-3">
                            Charge: <span id="delivery_charge">{{ $order->delivery_charges }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="fields-group">
                        <div class="form-group">
                          <label for="payment_method" class="col-sm-4 control-label">Payment Method</label>
                          <div class="col-sm-8">
                            <label class="control-label error" style="display: none;" for="inputError"><i
                                  class="fa fa-times-circle-o"></i> This Field is Required</label>
                            <select name="payment_method" id="payment_method" class="form-control">
                              @foreach($payment_methods as $method)
                                <option value="{{ $method->id }}"
                                    {{ ($order->payment_method == $method->id)? 'selected=""': '' }}>{{ $method->name_en }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-sm-8 col-md-offset-4">
                            <label><input type="checkbox" value="1"
                                          name="is_paid" {{$order->is_paied? 'checked=""': '' }}> Is Paid</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Products</h3>
                  <div class="box-tools">
                    <div class="btn-group pull-right" style="margin-right: 5px">
                      <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal"
                              title="Add Product" type="button">
                        <i class="fa fa-plus"></i><span class="hidden-xs">&nbsp;Add Product</span>
                      </button>
                    </div>
                  </div>
                </div>

                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover" id="product_tab">
                    <thead>
                    <tr>
                      <th class="text-center" style="width: 100px">Product ID</th>
                      <th class="text-center" style="width: 200px">Image</th>
                      <th style="width: 200px">Product Name</th>
                      <th>Product Option</th>
                      <th class="text-center" style="width: 50px">Quantity</th>
                      <th class="text-center" style="width: 100px">Sub Total</th>
                      <th class="text-center" style="width: 100px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                      $subTotal = 0;
                    @endphp
                    @foreach($order->orderProducts as $orderProduct)
                      <tr>
                        <td class="text-center data-input" data-name="product_id"
                            data-value="{{ $orderProduct->product_id }}">{{ $orderProduct->product_id }}</td>
                        <td class="text-center">
                          <img src="{!! asset($orderProduct->product->main_image_path) !!}"
                               style="max-height: 150px;"/>
                        </td>
                        <td>{{ $orderProduct->product->name_en }}</td>
                        @php
                          $optionsArr=[];
                        @endphp
                        @foreach($orderProduct->orderProductOption as $productOption)
                          @php
                            $optionsArr[]=[
                              'option' => $productOption->option->id,
                              "value"  => $productOption->optionValue->id
                            ];
                          @endphp
                        @endforeach
                        <td class="data-input" data-name="option_id" data-value="{{ json_encode($optionsArr) }}">
                          @foreach($orderProduct->orderProductOption as $productOption)
                            {{ $productOption->option->name_en }}: {{ $productOption->optionValue->value_en }}<br>
                          @endforeach
                        </td>

                        <td class="text-center data-input" data-name="quantity"
                            data-value="{{ $orderProduct->quantity }}">{{ $orderProduct->quantity }}</td>
                        <td class="text-center data-input" data-name="price"
                            data-value="{{ $orderProduct->sub_total }}">{{ $orderProduct->sub_total }}</td>
                        <td class="text-center totals">{{ $orderProduct->total }}</td>
                        <td class="text-center">
                          <button type="button" class="delete-product btn-link"><span
                                aria-hidden="true">&times;</span></button>
                        </td>
                      </tr>
                      @php
                        $subTotal += $orderProduct->sub_total;
                      @endphp
                    @endforeach

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      </form>

      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">&nbsp;</h3>
              <div class="box-tools">
                <div class="btn-group pull-right" style="margin-right: 5px">
                  <button type="button" class="btn btn-sm btn-primary add-btn" title="List"><i
                        class="fa fa-save"></i><span class="hidden-xs">&nbsp;save</span></button>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>

<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="fields-group">

            <div class="form-group ">

              <label for="product_id" class="col-sm-2 control-label">Product</label>
              <div class="col-sm-10">
                <label class="control-label error" style="display: none;" for="inputError"><i
                      class="fa fa-times-circle-o"></i> Select Product</label>
                <input type="hidden" name="product_id"/>
                <select class="form-control product_id" style="width: 100%;" name="product_id"
                        id="product_id"></select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">Price</label>
              <div class="col-sm-10">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                  <input type="text" id="price_input" value="" readonly="" class="form-control">
                </div>
              </div>
            </div>

            <div class="form-group ">
              <label for="option_id" class="col-sm-2 control-label">Options</label>
              <div class="col-sm-10">
                <div class="table-responsive no-padding">
                  <table class="table table-hover" id="option_id_tab">
                  </table>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">Quantity</label>
              <div class="col-sm-10">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                  <input type="text" id="quantity_input" value="1" class="form-control number">
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addProduct">Add Product</button>
      </div>
    </div>
  </div>
</div>

<script>

  function load() {
    $('.la_checkbox')
      .not('.initialize')
      .addClass('initialize')
      .each(function () {
        $(this).bootstrapSwitch({
          size: 'small',
          onText: $(this).data('on-label'),
          offText: $(this).data('off-label'),
          onColor: 'primary',
          offColor: 'default',
          onSwitchChange: function (event, state) {
            $(event.target).closest('.bootstrap-switch').next().val(state ? 'on' : 'off').change();
          }
        });
      });

    $('.customer-add-type').change(function () {
      var val = $(this).val() == 'on';
      $('#select_customer').toggle(!val);
      $('#add_customer').toggle(val);
      $('#select_address').toggle(!val);
      $('#add_address').toggle(val);
      $('.add-address-type.la_checkbox').bootstrapSwitch('state', false);

    });

    $('.add-address-type').change(function () {
      var val = $(this).val() == 'on';
      $('#select_address').toggle(val);
      $('#add_address').toggle(!val);
    });

    $(".customer_id").select2({
      ajax: {
        url: "{!! route('ajax.customer') !!}",
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            q: params.term,
            page: params.page
          };
        },
        processResults: function (data, params) {
          params.page = params.page || 1;

          return {
            results: $.map(data.data, function (d) {
              d.id = d.id;
              d.text = d.name;
              return d;
            }),
            pagination: {
              more: data.next_page_url
            }
          };
        },
        cache: true
      },
      'allowClear': true,
      'placeholder': 'Select Customer',
      'minimumInputLength': 1,
      escapeMarkup: function (markup) {
        return markup;
      }
    })
      .on('select2:select', function (e) {
        $('#address_id').empty().append(function () {
          var $row, result = [];

          if (e.params.data.user_address) {
            for (var i = 0; $row = e.params.data.user_address[i]; i++) {
              result.push($('<option>').val($row.id).text($row.first_address));
            }
          }

          return result;
        })
      })
      .on('change', function () {
        if ($(this).val() == null) {
          $('#address_id').empty();
        }
      });

    $('#address_id').select2({
      'placeholder': 'Select address',
    });

    $(".product_id").select2({
      ajax: {
        url: "{!! route('ajax.product') !!}",
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            q: params.term,
            page: params.page
          };
        },
        processResults: function (data, params) {
          params.page = params.page || 1;

          return {
            results: $.map(data.data, function (d) {
              d.id = d.id;
              d.text = d.name_en;
              return d;
            }),
            pagination: {
              more: data.next_page_url
            }
          };
        },
        cache: true
      },
      'allowClear': true,
      'placeholder': 'Select Product',
      'minimumInputLength': 1,
      escapeMarkup: function (markup) {
        return markup;
      }
    })
      .on('select2:select', function (e) {
        var $tab = $('#option_id_tab');
        $tab.empty().append(function () {
          var $row, $rowOption, result = [];

          if (e.params.data.options) {
            for (var i = 0; $row = e.params.data.options[i]; i++) {
              result.push(
                $('<tr>')
                  .append($('<td colspan="2">').text($row.name_en))
              );
              for (var j = 0; $rowOption = e.params.data.option_values[j]; j++) {
                if ($rowOption.option_id != $row.id) {
                  continue;
                }

                result.push(
                  $('<tr>')
                    .append($('<td>').css('width', '50').append(
                      $('<input type="radio" class="option_id_input" name="' + $row.name_en + '">')
                        .prop('checked', j == 0)
                        .data('name', $row.name_en)
                        .data('value', $rowOption.value_en)
                        .data('option_id', $row.id)
                        .val($rowOption.id)
                    ))
                    .append($('<td colspan="2">').text($rowOption.value_en))
                );
              }
            }
          }

          return result;
        });

        $tab.find('.option_id_input').first().prop('checked', true);
        $('#price_input').val(e.params.data.price);
        $('#addProduct').data('product', e.params.data);

      })
      .on('change', function () {
        if ($(this).val() == null) {
          $('#option_id_tab').empty();
        }
      });

    $('.number').keypress(function (e) {
      var key = e.which || e.keyCode;
      var char = String.fromCharCode(key);
      var allowChar = '0123456789';
      if ($(this).is('.decimal')) {
        allowChar += '.';
      }

      if (allowChar.indexOf(char) == -1) {
        return false;
      }

      if (String($(this).val()).indexOf('.') > -1 && char == '.') {
        return false;
      }
    });

    deliveryMethod = function () {
      var $option = $(this).find('option:selected');
      var $total = $option.data('price');

      if ($option.data('free') == 1) {
        $total = 0;
        $('#product_tab').find('tbody td.totals').each(function () {
          $total += parseFloat($(this).text());
        });

        if ({{ App\Models\Settings::getSetting('free_delivery_amount', 0) }}) {
          if ($total >= {{ App\Models\Settings::getSetting('free_delivery_amount') }}) {
            $('#delivery_charge').text(0);
            return;
          }
        }
      }

      $('#delivery_charge').text($option.data('price'));
    };

    $('#delivery_method')
      .change(deliveryMethod)
      .change()
      .select2();

    $('#myModal').on('show.bs.modal', function () {
      $('#product_id').val(null).change();
      $('#price_input').val(0);
      $('#quantity_input').val(1);

    });

    $('#addProduct').click(function () {

      $('#myModal').find('.has-error').removeClass('has-error').find('.error').hide();

      if ($('#product_id').val() == null) {
        $('#product_id').closest('.form-group').addClass('has-error').find('.error').show();
      }

      $('#product_tab').find('tbody').append($('<tr>').append(function () {
        var result = [];
        var $product = $('#addProduct').data('product');
        var option = $('.option_id_input:checked');
        var quantity = ($('#quantity_input').val()) || 1;

        result.push($('<td class="text-center data-input">').data('name', 'product_id').data('value', $product.id).text($product.id));
        result.push($('<td class="text-center">').append($('<img style="max-height: 150px;">').attr('src', $product.main_image_path)));
        result.push($('<td>').text($product.name_en));


        if (option.length > 0) {

          var $opValues = [];
          var $opName = [];
          option.each(function () {
            $opValues.push({'option': $(this).data('option_id'), 'value': $(this).val()});
            $opName.push($(this).data('name') + ": " + $(this).data('value'));
          });


          result.push(
            $('<td class="text-center data-input">')
              .data('name', 'option_id')
              .data('value', $opValues)
              .html($opName.join('<br />'))
          );
        }
        else {
          result.push($('<td>'));
        }

        result.push(
          $('<td class="text-center data-input">')
            .data('name', 'quantity')
            .data('value', quantity)
            .text(quantity)
        );
        result.push(
          $('<td class="text-center data-input">')
            .data('name', 'price')
            .data('value', $product.price)
            .text($product.price));
        result.push($('<td class="text-center totals">').text($product.price * quantity));
        result.push($('<td class="text-center">')
          .append('<button type="button" class="delete-product btn-link"><span aria-hidden="true">&times;</span></button>'));

        return result;

      }));

      $('#delivery_method').change();

      $('#myModal').modal('hide');
    });

    $('#form-order').on('click', '.delete-product', function () {
      $(this).closest('tr').remove();
    });

    $('.add-btn').click(function () {
      var formAction = $('#form-order').attr('action');
      var formArr = $('#form-order').serializeArray();
      var $error = false;

      $('#form-order').find('.has-error').removeClass('has-error').find('.error').hide();

      if ($('[name="customer-add-type"]').val() == 'off') {
        if ($('#customer_id').val() == null) {
          $error = true;
          $('#customer_id').closest('.form-group').addClass('has-error').find('.error').show();
        }

        if ($('[name="add-address-type"]').val() == 'on') {
          if ($('#address_id').val() == null) {
            $error = true;
            $('#address_id').closest('.form-group').addClass('has-error').find('.error').show();
          }
        }
        else {
          // if ($('#address_id').val() == null) {
          //   $error=true;
          //   $('#address_id').closest('.form-group').addClass('has-error').find('.error').show();
          // }

          if (String($('#address_type').val()).trim() == '') {
            $error = true;
            $('#address_type').closest('.form-group').addClass('has-error').find('.error').show();
          }

          if ($('#governorate_id').val() == null) {
            $error = true;
            $('#governorate_id').closest('.form-group').addClass('has-error').find('.error').show();
          }
        }
      }
      else {
        if (String($('#user-name').val()).trim() == '') {
          $error = true;
          $('#user-name').closest('.form-group').addClass('has-error').find('.error').show();
        }
        if (String($('#user-email').val()).trim() == '') {
          $error = true;
          $('#user-email').closest('.form-group').addClass('has-error').find('.error').show();
        }
        if (String($('#user-phone').val()).trim() == '') {
          $error = true;
          $('#user-phone').closest('.form-group').addClass('has-error').find('.error').show();
        }

        if (String($('#address_type').val()).trim() == '') {
          $error = true;
          $('#address_type').closest('.form-group').addClass('has-error').find('.error').show();
        }
        if ($('#governorate_id').val() == null) {
          $error = true;
          $('#governorate_id').closest('.form-group').addClass('has-error').find('.error').show();
        }
      }

      if ($('#delivery_method').val() == null) {
        $error = true;
        $('#delivery_method').closest('.form-group').addClass('has-error').find('.error').show();
      }

      if ($('#product_tab').find('td.data-input').length == 0) {
        alert('you have to add products');
        $error = true;
      }

      if ($error) {
        return;
      }

      $('#product_tab').find('tbody tr').each(function (index) {

        $(this).find('.data-input').each(function () {
          if ($(this).data('name') == 'option_id') {
            var row;
            var $arrOptions = $(this).data('value');

            for (i = 0; $row = $arrOptions[i]; i++) {
              formArr.push({
                name: 'product[' + index + '][option_id][' + $row['option'] + ']',
                value: $row['value']
              });
            }
          }
          else {
            formArr.push({
              name: 'product[' + index + '][' + $(this).data('name') + ']',
              value: $(this).data('value')
            });
          }
        });
      });

      $.post(formAction, formArr)
        .success(function (d) {
          if (d.status) {
            location.href = '{{ route('admin_order.index') }}';
            return;
          }

          alert(d.msg);
        });

    });

  }


  if (document.readyState === 'complete') {
    load();
  }
  else {
    $(document).ready(load);
  }
  function printDiv()
  {

      var divToPrint=document.getElementById('DivIdToPrint');

      var newWin=window.open('','Print-Window');

      newWin.document.open();

      newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

      newWin.document.close();

      setTimeout(function(){newWin.close();},10);

  }
</script>
