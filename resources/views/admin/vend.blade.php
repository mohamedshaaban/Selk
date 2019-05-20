<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-body" style="padding: 31px 6px;">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-2">Suppliers</div>
            <div class="col-md-2">
              <button type="button" class="btn btn-primary btn-xs update" data-action="suppliers" >Update</button>
            </div>
            <div class="col-md-8">
              <div class="message text-success"></div>
            </div>
          </div>
          <div class="row"><div class="col-md-12"><hr></div></div>
        </div>

        <div class="col-md-12">
          <div class="row">
            <div class="col-md-2">Brands</div>
            <div class="col-md-2">
              <button type="button" class="btn btn-primary btn-xs update" data-action="brands">Update</button>
            </div>
            <div class="col-md-8">
              <div class="message text-success"></div>
            </div>
          </div>
          <div class="row"><div class="col-md-12"><hr></div></div>
        </div>

        <div class="col-md-12">
          <div class="row">
            <div class="col-md-2">Products</div>
            <div class="col-md-2">
              <button type="button" class="btn btn-primary btn-xs update" data-action="products">Update</button>
            </div>
            <div class="col-md-8">
              <div class="message text-success"></div>
            </div>
          </div>
          <div class="row"><div class="col-md-12"><hr></div></div>
        </div>

        <div class="col-md-12">
          <div class="row">
            <div class="col-md-2">Inventory</div>
            <div class="col-md-2">
              <button type="button" class="btn btn-primary btn-xs update" data-action="inventory">Update</button>
            </div>
            <div class="col-md-8">
              <div class="message text-success"></div>
            </div>
          </div>
          <div class="row"><div class="col-md-12"><hr></div></div>
        </div>

        {{--<div class="col-md-12">--}}
          {{--<div class="row">--}}
            {{--<div class="col-md-2">Payment Types</div>--}}
            {{--<div class="col-md-2">--}}
              {{--<button type="button" class="btn btn-primary btn-xs update" data-action="payment_types">Update</button>--}}
            {{--</div>--}}
            {{--<div class="col-md-8">--}}
              {{--<div class="message text-success"></div>--}}
            {{--</div>--}}
          {{--</div>--}}
        {{--</div>--}}



      </div>
    </div>
  </div>
</div>

<script>

  var urlUpdatingFn = {
    "suppliers": "{{ route('vend.ajax.suppliers') }}",
    "brands": "{{ route('vend.ajax.brands') }}",
    "products": "{{ route('vend.ajax.products') }}",
    "inventory": "{{ route('vend.ajax.inventory') }}",
    "payment_types": "{{ route('vend.ajax.payment_types') }}"
  }
  
  $('button.update').click(function(){
    var $this = $(this);

    if(urlUpdatingFn[$this.data('action')]){
      $this.closest('.row').find('.message').text('Loading ...');
      $.get(urlUpdatingFn[$this.data('action')])
        .success(function (d){
          var msg = $this.closest('.row').find('.message');
          if(d.status){
            msg.attr('class', 'message text-success');
            $this.closest('.row').find('.message').text(d.msg);
          }
          else {
            msg.attr('class', 'message text-danger');
            $this.closest('.row').find('.message').text('Error: '.d.msg);
          }



        });
    }
    
    
  });
  
  
  
</script>