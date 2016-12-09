<!-- Id Field -->
<div class="form-group col-sm-6 {{ $errors->has('id')? 'has-error' : '' }}">
    {!! Form::label('id', 'Id:', ['class' => 'control-label']) !!}
    {!! Form::text('id', null, ['class' => 'form-control', 'value' => old('id')]) !!}
    {!! $errors->has('id')? '<p class="help-block"> '.$errors->first('id').' </p>':'' !!}
    <small></small>
</div>

<!-- Id Field -->
<div class="form-group {{ $errors->has('id')? 'has-error' : '' }}">
    {!! Form::label('id', 'Id:', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
    {!! Form::text('id', null, ['class' => 'form-control', 'value' => old('id')]) !!}
    <small></small>
    </div>
    {!! $errors->has('id')? '<p class="help-block"> '.$errors->first('id').' </p>':'' !!}
</div>

<!-- Nickname Field -->
<div class="form-group col-sm-6 {{ $errors->has('nickname')? 'has-error' : '' }}">
    {!! Form::label('nickname', 'Nickname:', ['class' => 'control-label']) !!}
    {!! Form::text('nickname', null, ['class' => 'form-control', 'value' => old('nickname')]) !!}
    {!! $errors->has('nickname')? '<p class="help-block"> '.$errors->first('nickname').' </p>':'' !!}
    <small></small>
</div>

<!-- Nickname Field -->
<div class="form-group {{ $errors->has('nickname')? 'has-error' : '' }}">
    {!! Form::label('nickname', 'Nickname:', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
    {!! Form::text('nickname', null, ['class' => 'form-control', 'value' => old('nickname')]) !!}
    <small></small>
    </div>
    {!! $errors->has('nickname')? '<p class="help-block"> '.$errors->first('nickname').' </p>':'' !!}
</div>

<!-- Outer Length Field -->
<div class="form-group col-sm-6 {{ $errors->has('outer_length')? 'has-error' : '' }}">
    {!! Form::label('outer_length', 'Outer Length:', ['class' => 'control-label']) !!}
    {!! Form::text('outer_length', null, ['class' => 'form-control', 'value' => old('outer_length')]) !!}
    {!! $errors->has('outer_length')? '<p class="help-block"> '.$errors->first('outer_length').' </p>':'' !!}
    <small></small>
</div>

<!-- Outer Length Field -->
<div class="form-group {{ $errors->has('outer_length')? 'has-error' : '' }}">
    {!! Form::label('outer_length', 'Outer Length:', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
    {!! Form::text('outer_length', null, ['class' => 'form-control', 'value' => old('outer_length')]) !!}
    <small></small>
    </div>
    {!! $errors->has('outer_length')? '<p class="help-block"> '.$errors->first('outer_length').' </p>':'' !!}
</div>

<!-- Outer Width Field -->
<div class="form-group col-sm-6 {{ $errors->has('outer_width')? 'has-error' : '' }}">
    {!! Form::label('outer_width', 'Outer Width:', ['class' => 'control-label']) !!}
    {!! Form::text('outer_width', null, ['class' => 'form-control', 'value' => old('outer_width')]) !!}
    {!! $errors->has('outer_width')? '<p class="help-block"> '.$errors->first('outer_width').' </p>':'' !!}
    <small></small>
</div>

<!-- Outer Width Field -->
<div class="form-group {{ $errors->has('outer_width')? 'has-error' : '' }}">
    {!! Form::label('outer_width', 'Outer Width:', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
    {!! Form::text('outer_width', null, ['class' => 'form-control', 'value' => old('outer_width')]) !!}
    <small></small>
    </div>
    {!! $errors->has('outer_width')? '<p class="help-block"> '.$errors->first('outer_width').' </p>':'' !!}
</div>

<!-- Inner Height Field -->
<div class="form-group col-sm-6 {{ $errors->has('inner_height')? 'has-error' : '' }}">
    {!! Form::label('inner_height', 'Inner Height:', ['class' => 'control-label']) !!}
    {!! Form::text('inner_height', null, ['class' => 'form-control', 'value' => old('inner_height')]) !!}
    {!! $errors->has('inner_height')? '<p class="help-block"> '.$errors->first('inner_height').' </p>':'' !!}
    <small></small>
</div>

<!-- Inner Height Field -->
<div class="form-group {{ $errors->has('inner_height')? 'has-error' : '' }}">
    {!! Form::label('inner_height', 'Inner Height:', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
    {!! Form::text('inner_height', null, ['class' => 'form-control', 'value' => old('inner_height')]) !!}
    <small></small>
    </div>
    {!! $errors->has('inner_height')? '<p class="help-block"> '.$errors->first('inner_height').' </p>':'' !!}
</div>

<!-- Inner Length Field -->
<div class="form-group col-sm-6 {{ $errors->has('inner_length')? 'has-error' : '' }}">
    {!! Form::label('inner_length', 'Inner Length:', ['class' => 'control-label']) !!}
    {!! Form::text('inner_length', null, ['class' => 'form-control', 'value' => old('inner_length')]) !!}
    {!! $errors->has('inner_length')? '<p class="help-block"> '.$errors->first('inner_length').' </p>':'' !!}
    <small></small>
</div>

<!-- Inner Length Field -->
<div class="form-group {{ $errors->has('inner_length')? 'has-error' : '' }}">
    {!! Form::label('inner_length', 'Inner Length:', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
    {!! Form::text('inner_length', null, ['class' => 'form-control', 'value' => old('inner_length')]) !!}
    <small></small>
    </div>
    {!! $errors->has('inner_length')? '<p class="help-block"> '.$errors->first('inner_length').' </p>':'' !!}
</div>

<!-- Inner Width Field -->
<div class="form-group col-sm-6 {{ $errors->has('inner_width')? 'has-error' : '' }}">
    {!! Form::label('inner_width', 'Inner Width:', ['class' => 'control-label']) !!}
    {!! Form::text('inner_width', null, ['class' => 'form-control', 'value' => old('inner_width')]) !!}
    {!! $errors->has('inner_width')? '<p class="help-block"> '.$errors->first('inner_width').' </p>':'' !!}
    <small></small>
</div>

<!-- Inner Width Field -->
<div class="form-group {{ $errors->has('inner_width')? 'has-error' : '' }}">
    {!! Form::label('inner_width', 'Inner Width:', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
    {!! Form::text('inner_width', null, ['class' => 'form-control', 'value' => old('inner_width')]) !!}
    <small></small>
    </div>
    {!! $errors->has('inner_width')? '<p class="help-block"> '.$errors->first('inner_width').' </p>':'' !!}
</div>

<!-- Outer Height Field -->
<div class="form-group col-sm-6 {{ $errors->has('outer_height')? 'has-error' : '' }}">
    {!! Form::label('outer_height', 'Outer Height:', ['class' => 'control-label']) !!}
    {!! Form::text('outer_height', null, ['class' => 'form-control', 'value' => old('outer_height')]) !!}
    {!! $errors->has('outer_height')? '<p class="help-block"> '.$errors->first('outer_height').' </p>':'' !!}
    <small></small>
</div>

<!-- Outer Height Field -->
<div class="form-group {{ $errors->has('outer_height')? 'has-error' : '' }}">
    {!! Form::label('outer_height', 'Outer Height:', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
    {!! Form::text('outer_height', null, ['class' => 'form-control', 'value' => old('outer_height')]) !!}
    <small></small>
    </div>
    {!! $errors->has('outer_height')? '<p class="help-block"> '.$errors->first('outer_height').' </p>':'' !!}
</div>

<!-- Box Weight Field -->
<div class="form-group col-sm-6 {{ $errors->has('box_weight')? 'has-error' : '' }}">
    {!! Form::label('box_weight', 'Box Weight:', ['class' => 'control-label']) !!}
    {!! Form::text('box_weight', null, ['class' => 'form-control', 'value' => old('box_weight')]) !!}
    {!! $errors->has('box_weight')? '<p class="help-block"> '.$errors->first('box_weight').' </p>':'' !!}
    <small></small>
</div>

<!-- Box Weight Field -->
<div class="form-group {{ $errors->has('box_weight')? 'has-error' : '' }}">
    {!! Form::label('box_weight', 'Box Weight:', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
    {!! Form::text('box_weight', null, ['class' => 'form-control', 'value' => old('box_weight')]) !!}
    <small></small>
    </div>
    {!! $errors->has('box_weight')? '<p class="help-block"> '.$errors->first('box_weight').' </p>':'' !!}
</div>

<!-- Max Weight Field -->
<div class="form-group col-sm-6 {{ $errors->has('max_weight')? 'has-error' : '' }}">
    {!! Form::label('max_weight', 'Max Weight:', ['class' => 'control-label']) !!}
    {!! Form::text('max_weight', null, ['class' => 'form-control', 'value' => old('max_weight')]) !!}
    {!! $errors->has('max_weight')? '<p class="help-block"> '.$errors->first('max_weight').' </p>':'' !!}
    <small></small>
</div>

<!-- Max Weight Field -->
<div class="form-group {{ $errors->has('max_weight')? 'has-error' : '' }}">
    {!! Form::label('max_weight', 'Max Weight:', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
    {!! Form::text('max_weight', null, ['class' => 'form-control', 'value' => old('max_weight')]) !!}
    <small></small>
    </div>
    {!! $errors->has('max_weight')? '<p class="help-block"> '.$errors->first('max_weight').' </p>':'' !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.boxes.index') !!}" class="btn btn-default">Cancel</a>
</div>
