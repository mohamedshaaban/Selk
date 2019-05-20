<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $form->title() }}</h3>

        <div class="box-tools">
            {!! $form->renderTools() !!}
        </div>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    {!! $form->open(['class' => "form-horizontal" ,'id' => "giftform"]) !!}

        <div class="box-body">

            @if(!$tabObj->isEmpty())
                @include('admin::form.tab', compact('tabObj'))
            @else
                <div class="fields-group">

                    @if($form->hasRows())
                        @foreach($form->getRows() as $row)
                            {!! $row->render() !!}
                        @endforeach
                    @else
                        @foreach($form->fields() as $field)
                            {!! $field->render() !!}
                        @endforeach
                    @endif


                </div>
            @endif
            <input type="hidden" id="is_preview" name="is_preview" value="0"/>
            <input type="button" class="btn btn-primary" style="float: right;margin-right: 18%;"onclick="previewCard()" value="Preview" />
        </div>
        <!-- /.box-body -->

        {!! $form->renderFooter() !!}
        
        @foreach($form->getHiddenFields() as $field)
            {!! $field->render() !!}
 
            @endforeach
 
        <!-- /.box-footer -->
    {!! $form->close() !!}
    <script>
    function previewCard()
    {
        $('#is_preview').val(1);
        $('.form-horizontal').submit();
    }
    </script>
</div>


