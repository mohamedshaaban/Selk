@if(count($arrayOptions))
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">options</th>
            <th scope="col">quantity</th>
            <th scope="col">price</th>
            <th scope="col">sku</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($arrayOptions as $options )
            @php($optionsArray = explode(' ', $options))
            @php($optionsNameString = '')
            @foreach ($optionsArray as $option )
                @php($optionsNameString  .= isset($optionValues[$option]->value_en) ?$optionValues[$option]->value_en  . '/' : 'Nan' )
            @endforeach
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $optionsNameString }}</td>
                <td><input value="0" type="number" name="options_price_combinations[options][{{str_replace(' ', '_', $options)}}][quantity]" id="quantity_{{str_replace(' ', '_', $options)}}"></td>
                <td><input value="0" class="form-control" type="number" name="options_price_combinations[options][{{str_replace(' ', '_', $options)}}][price]" id="price_{{str_replace(' ', '_', $options)}}"></input></td>
                <td><input class="form-control" type="text" name="options_price_combinations[options][{{str_replace(' ', '_', $options)}}][sku]" id="sku_{{str_replace(' ', '_', $options)}}"></input></td>           
            </tr>
            @endforeach
        
    </tbody>
</table>
@endif