<div class="tabbable ">
    <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue">
        <li class="active"> <a data-toggle="tab" href="#panel_tab_article_content"> Article Content </a> </li>
        <li> <a data-toggle="tab" href="#panel_tab_header_image">Header Image </a> </li>
        <li> <a data-toggle="tab" href="#panel_tab_seo"> SEO </a> </li>
        <li> <a data-toggle="tab" href="#panel_tab_social"> SOCIAL </a> </li>
        <li>&nbsp;</li>

    </ul>
    <div class="tab-content">
        <div id="panel_tab_article_content" class="tab-pane active">
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="col-md-12">
                        <div class="row">
                            <!-- Author Id Field -->
                            <div class="form-group col-md-3">
                                    {!! Form::label('author_id', 'Author:') !!}
                                    {!! Form::select('user', $users, null, array('class' => 'form-control', 'value'=>Input::old('user'))) !!}
                            </div>
                            <!-- Category -->
                            <div class="col-md-3 control-group {!! $errors->has('category') ? 'error' : '' !!}">
                                <label class="control-label" for="title">Category</label>
                                <div class="controls">
                                    {!! Form::select('category', $categories, null, ['class' => 'form-control', 'value'=> Input::old('category')] ) !!}
                                    @if ($errors->first('category'))
                                    <span class="help-block">{!! $errors->first('category') !!}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-sm-3 {{ $errors->has('is_published')? 'has-error' : '' }}">
                                {!! Form::label('is_published', 'Is Published:') !!}
                                <label class="checkbox-inline">
                                {!! Form::checkbox('is_published', 1, true,  ['data-toggle' => 'toggle']) !!}
                                </label>
                                {!! $errors->has('is_published')? '<p class="help-block"> '.$errors->first('is_published').' </p>':'' !!}
                            </div>
                        </div>
                        <div class="row">
                            <!-- Title Field -->
                            <div class="form-group col-sm-8 {{ $errors->has('title')? 'has-error' : '' }}">
                                {!! Form::label('title', 'Title:') !!}
                                {!! Form::text('title', null, ['class' => 'form-control', 'value' => old('title')]) !!}
                                {!! $errors->has('title')? '<p class="help-block"> '.$errors->first('title').' </p>':'' !!}
                            </div>
                            <!-- Subtitle Field -->
                            <div class="form-group col-sm-8 {{ $errors->has('subtitle')? 'has-error' : '' }}">
                                {!! Form::label('subtitle', 'Subtitle:') !!}
                                {!! Form::text('subtitle', null, ['class' => 'form-control', 'value' => old('subtitle')]) !!}
                                {!! $errors->has('subtitle')? '<p class="help-block"> '.$errors->first('subtitle').' </p>':'' !!}
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <!-- Excerpt Field -->
                            <div class="form-group col-sm-12 col-lg-12">
                                {!! Form::label('excerpt', 'Excerpt:') !!}
                                {!! Form::textarea('excerpt', null, ['class' => 'form-control', 'value' => old('excerpt')]) !!}
                                {!! $errors->has('excerpt')? '<p class="help-block"> '.$errors->first('excerpt').' </p>':'' !!}
                            </div>
                        </div>
                    </div>
                    <!-- Content Field -->
                    <div class="form-group col-sm-12 col-lg-12">
                        {!! Form::label('content', 'Content:') !!}
                        {!! Form::textarea('content', null, ['class' => 'form-control', 'value' => old('content')]) !!}
                        {!! $errors->has('content')? '<p class="help-block"> '.$errors->first('content').' </p>':'' !!}
                    </div>
                </div>
            </div>
        </div>
        <div id="panel_tab_header_image" class="tab-pane">
            <div class="container-fluid">
                <div class="row-fluid">


        <div class="form-group">
            <div class="col-sm-8 ">
                <label>
                    Image Upload
                </label>
                <div class="fileupload fileupload-new  control-group {!! $errors->has('image') ? 'has-error' : '' !!}" data-provides="fileupload">
                    <div class="fileupload-new thumbnail" >


                        <img data-src="{{ isset($article->file_name) ? url($article->path.$article->file_name) : 'http://www.placehold.it/1140x600/EFEFEF/AAAAAA?text=no+image' }}" src="{{ isset($article->path) ? url($article->path.$article->file_name) : 'http://www.placehold.it/1140x600/EFEFEF/AAAAAA?text=no+image' }}" alt="">
                    </div>
                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 1140px; max-height: 600px; line-height: 20px;"></div>
                    <div>
                        <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select image</span>
                            <span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
                            {!! Form::file('image', null, ['class'=>'form-control', 'id' => 'image', 'files'=>true, 'value'=> Input::old('image')]) !!}
                        </span>
                        <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                            <i class="fa fa-times"></i> Remove
                        </a>
                    </div>
                </div>

            </div>
        </div>





                </div>
            </div>
        </div>
        <div id="panel_tab_seo" class="tab-pane">
            <div class="container-fluid">
                <div class="row-fluid">
                    <!-- Meta Title Field -->
                    <div class="form-group col-sm-6 {{ $errors->has('meta_title')? 'has-error' : '' }}">
                        {!! Form::label('meta_title', 'Meta Title:') !!}
                        {!! Form::text('meta_title', null, ['class' => 'form-control', 'value' => old('meta_title')]) !!}
                        {!! $errors->has('meta_title')? '<p class="help-block"> '.$errors->first('meta_title').' </p>':'' !!}
                    </div>

        {{--             <!-- Meta Keywords Field -->
                    <div class="form-group col-sm-8 {{ $errors->has('meta_keywords')? 'has-error' : '' }}">
                        {!! Form::label('meta_keywords', 'Meta Keywords:') !!}
                        {!! Form::text('meta_keywords', null, ['class' => 'tags form-control', 'id' => 'meta_keywords', 'value' => old('meta_keywords')] ) !!}
                        {!! $errors->has('meta_keywords')? '<p class="help-block"> '.$errors->first('meta_keywords').' </p>':'' !!}
                    </div> --}}

                                                  <!-- Tag -->
                  <div class="form-group col-sm-8 {!! $errors->has('tag') ? 'has-error' : '' !!}">
                        <label class="control-label" for="title">Meta Keywords</label>

                        <div class="controls">
                            {!! Form::text('tag', $tags , array('class'=>'form-control tags', 'id' => 'tag', 'value'=>Input::old('tag'))) !!}
                            @if ($errors->first('tag'))
                            <span class="help-block">{!! $errors->first('tag') !!}</span>
                            @endif
                        </div>
                    </div>


                    <!-- Meta Description Field -->
                    <div class="form-group col-sm-12 col-lg-12">
                        {!! Form::label('meta_description', 'Meta Description:') !!}
                        {!! Form::textarea('meta_description', null, ['class' => 'form-control', 'value' => old('meta_description')]) !!}
                        {!! $errors->has('meta_description')? '<p class="help-block"> '.$errors->first('meta_description').' </p>':'' !!}
                    </div>
                </div>
            </div>
        </div>
        <div id="panel_tab_social" class="tab-pane">
            <div class="container-fluid">
                <div class="row-fluid">
                    <!-- Fb Title Field -->
                    <div class="form-group col-sm-6 col-md-8 {{ $errors->has('fb_title')? 'has-error' : '' }}">
                        {!! Form::label('fb_title', 'Facebook Title:') !!}
                        {!! Form::text('fb_title', null, ['class' => 'form-control', 'value' => old('fb_title')]) !!}
                        {!! $errors->has('fb_title')? '<p class="help-block"> '.$errors->first('fb_title').' </p>':'' !!}
                    </div>
                    <!-- Gp Title Field -->
                    <div class="form-group col-sm-6 col-md-8 {{ $errors->has('gp_title')? 'has-error' : '' }}">
                        {!! Form::label('gp_title', 'Google Plus Title:') !!}
                        {!! Form::text('gp_title', null, ['class' => 'form-control', 'value' => old('gp_title')]) !!}
                        {!! $errors->has('gp_title')? '<p class="help-block"> '.$errors->first('gp_title').'</p>':'' !!}
                    </div>
                    <!-- tw Title Field -->
                    <div class="form-group col-sm-6 col-md-8 {{ $errors->has('tw_title')? 'has-error' : '' }}">
                        {!! Form::label('tw_title', 'Twitter Title:') !!}
                        {!! Form::text('tw_title', null, ['class' => 'form-control', 'value' => old('tw_title')]) !!}
                        {!! $errors->has('tw_title')? '<p class="help-block"> '.$errors->first('tw_title').'</p>':'' !!}
                    </div>
                    <!-- Link To Product Title Field -->
                    <div class="form-group col-sm-6 col-md-8">
                        {!! Form::label('link_to_product_title', 'Link To Product Title:') !!}
                        {!! Form::text('link_to_product_title', null, ['class' => 'form-control']) !!}
                    </div>
                    <!-- Link To Product Field -->
                    <div class="form-group col-sm-6 col-md-8">
                        {!! Form::label('link_to_product', 'Link To Product:') !!}
                        {!! Form::text('link_to_product', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
