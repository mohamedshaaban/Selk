<template class="options-tpl">
    <div class="has-many-option-form fields-group" id="__LA_KEY__">
        <div class="form-group col-md-12 ">
            <div class="col-sm-2">
                <select
                    class="form-control select2 options_select"
                    style="width: 100%;"
                    name="options[__LA_KEY__][option_id]"
                    data-placeholder="Input options"
                    data-value=""
                >
                </select>
            </div>
            <div class="col-sm-8">
                <select
                    class="form-control select2 option_values_select"
                    style="width: 100%;"
                    name="options[__LA_KEY__][option_values_ids][]"
                    multiple="multiple"
                    data-placeholder="Input option values"
                    data-value=""
                >
                </select>
            </div>
        </div>
        <div class="form-group ">
            <label class="col-sm-2  control-label"></label>
            <div class="col-sm-8">
                <div class="remove btn btn-warning btn-sm pull-right">
                    <i class="fa fa-trash"></i>&nbsp;Remove
                </div>
            </div>
        </div>
        <hr />
    </div>
</template>
<script>
    $(document).ready(function() {
        var action = "{{$action}}";
        var index = 0;
    
        $(".empty_options_div")
            .parent()
            .attr("class", "col-mod-12");
       
        $(".options_json").attr("name", "");
        $(".selected_options_json").attr("name", "");
    
        if(action == 'edit'){
           selected_options = JSON.parse($(".selected_options_json").val());
            
            $.each(selected_options,function(option_id,selected_option_values){
                price_combination = selected_option_values[0].price_combination;
                if(price_combination != '' || price_combination == null){
                    price_combination = JSON.parse(price_combination);
                }
                
                cloneOptionsSelect(index);
                setSelectedOption(index , option_id);
                options = JSON.parse($(".options_json").val());
                option_values = options[option_id].option_value;
                appendOptionValuesToSelect(index ,option_values );
                setSelectedOptionValues(index , selected_option_values);
                index++;
            });
            generateOptionsTableMatrix();
            
            setTimeout(function(){
                fillOptionsTableMatrix(price_combination['options']);
            },3000);
        }
        $(".add_new_option").click(function() {
            cloneOptionsSelect(index);
            index++;
        });

        $('.generate_option_btn').click(function(){
            generateOptionsTableMatrix();
        });
      
        // remove option div
        $(".empty_options_div").on("click", ".remove", function() {
            $(this)
                .closest(".has-many-option-form")
                .remove();
            
        });

        // option select on select and unselect
        $(".empty_options_div").on(
            "select2:select select2:unselect",
            ".options_select",
            function(e) {
                options = JSON.parse($(".options_json").val());
                option_values = options[e.params.data.id].option_value;
                option_div_id = $(this)
                    .closest(".has-many-option-form")
                    .attr("id");
                appendOptionValuesToSelect(option_div_id, option_values);
            }
        );
        // option values select on select and unselect
        $(".empty_options_div").on(
            "select2:select select2:unselect",
            ".option_values_select",
            function(e) {
                
            }
        );
    });

    function cloneOptionsSelect(index){
            options_count = Object.keys(JSON.parse($(".options_json").val()))
            .length;
            
            append_options_count = $(".has-many-option-form").length;
            if (append_options_count == options_count) {
                return;
            }
            var tpl = $("template.options-tpl");
            
            var template = tpl.html().replace(/__LA_KEY__/g, index);

            $(".empty_options_div").append(template);
            $(".select2").select2({ allowClear: true });
            appendOptionsToSelect(index);
    }

    function appendOptionsToSelect(option_div_id) {
        options = JSON.parse($(".options_json").val());

        newOption = new Option("", "");
        $("#" + option_div_id)
            .find(".options_select")
            .append(newOption);

        $.each(options, function(index, value) {
            newOption = new Option(value.name_en, value.id, false, false);
            $("#" + option_div_id)
                .find(".options_select")
                .append(newOption);
        });
    }

    function appendOptionValuesToSelect(option_div_id, option_values) {
        $("#" + option_div_id)
            .find(".option_values_select")
            .empty();

        $.each(option_values, function(index, value) {
            newOption = new Option(value.value_en, value.id);
            $("#" + option_div_id)
                .find(".option_values_select")
                .append(newOption);
        });
    }

    function generateOptionsTableMatrix() {
        selected_options = [];
        $.each($(".option_values_select").prop("selected", true), function() {
            selected_options.push($(this).val());
        });

        $.ajax({
            url: "/admin/product/generate_options_table",
            type: "POST",
            data: {
                _token: LA.token,
                options: selected_options
            },
            success: function(response) {
                $(".generate_options_table").html("");
                $(".generate_options_table").append(response);
            },
            error: function() {}
        }); //end of ajax
    }
    function setSelectedOption(index , option_id){
        $("#" + index)
            .find(".options_select").val(option_id).trigger('change')
    }

    function setSelectedOptionValues(index,  option_values){
        selectedOptionValues = [];
        $.each(option_values, function (index, value) {
            selectedOptionValues.push(value.option_value_id);
        });
        $("#" + index)
            .find(".option_values_select").val(selectedOptionValues).trigger('change');
    }

    function fillOptionsTableMatrix(price_combination){
        $.each(price_combination,function(index,value){
           $('#quantity_' + index).val(value.quantity);
           $('#price_' + index).val(value.price);
           $('#sku_' + index).val(value.sku);
        });
    }

</script>