<!-- Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    {!! Form::text('id', null, ['class' => 'form-control']) !!}
</div>

<!-- Alert Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('alert_title', 'Alert Title:') !!}
    {!! Form::text('alert_title', null, ['class' => 'form-control']) !!}
</div>

<!-- Alert Message Field -->
<div class="form-group col-sm-6">
    {!! Form::label('alert_message', 'Alert Message:') !!}
    {!! Form::text('alert_message', null, ['class' => 'form-control']) !!}
</div>

<!-- Alerticon Field -->
<div class="form-group col-sm-6">
    {!! Form::label('alerticon', 'Alerticon:') !!}
    {!! Form::select('alerticon', ['' => '', 'fa-exclamation' => 'fa-exclamation', 'fa-thumbs-up' => 'fa-thumbs-up', 'fa-exclamation-triangle' => 'fa-exclamation-triangle', 'fa-info-circle' => 'fa-info-circle', 'fa-bell-o' => 'fa-bell-o', 'fa-exclamation-circle' => 'fa-exclamation-circle', 'fa-sticky-note' => 'fa-sticky-note', 'fa-comment' => 'fa-comment', 'fa-commenting' => 'fa-commenting', 'fa-comments' => 'fa-comments', 'fa-th-list' => 'fa-th-list', 'fa-history' => 'fa-history', 'fa-list-alt' => 'fa-list-alt'], null, ['class' => 'form-control']) !!}
</div>

<!-- Alertstyle Field -->
<div class="form-group col-sm-6">
    {!! Form::label('alertstyle', 'Alertstyle:') !!}
    {!! Form::select('alertstyle', ['' => '', 'MessageBox' => 'MessageBox', 'MessagePanel' => 'MessagePanel', 'AlertBox' => 'AlertBox', 'AlertBoxClosable' => 'AlertBoxClosable'], null, ['class' => 'form-control']) !!}
</div>

<!-- Alerttype Field -->
<div class="form-group col-sm-6">
    {!! Form::label('alerttype', 'Alerttype:') !!}
    {!! Form::select('alerttype', ['' => '', 'Success' => 'Success', 'Error' => 'Error', 'Info' => 'Info', 'Warning' => 'Warning', 'Light' => 'Light', 'Dark' => 'Dark'], null, ['class' => 'form-control']) !!}
</div>

<!-- Order Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_id', 'Order Id:') !!}
    {!! Form::text('order_id', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Product Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('product_id', 'Product Id:') !!}
    {!! Form::text('product_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.alerts.index') !!}" class="btn btn-default">Cancel</a>
</div>
