                <div class="tabbable panel-tabs">
                    <ul class="nav nav-tabs">
                        <li class="active"> <a data-toggle="tab" href="#panel_tab_article_content"> Article Content </a> </li>
                        <li> <a data-toggle="tab" href="#panel_tab_header_image">Header Image </a> </li>
                        <li> <a data-toggle="tab" href="#panel_tab_seo"> SEO </a> </li>
                        <li> <a data-toggle="tab" href="#panel_tab_social"> SOCIAL </a> </li>

                        <li>&nbsp;</li>
                        <li>{!! Form::submit('Save', ['class' => 'btn btn-primary btn-squared']) !!}</li>
                        <li> <a href="{!! url('admin.pages.index') !!}" class="btn btn-default btn-squared">Cancel</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="panel_tab_article_content" class="tab-pane active">
                            <div class="container-fluid">
                                <div class="row-fluid">
                                    <div class="col-md-4">
                                        <!-- Image -->
                                        <div class="fileinput fileinput-new control-group {!! $errors->has('image') ? 'has-error' : '' !!}" data-provides="fileinput">
                                            <label>In Article Image</label>
                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 500px; height: 400px;">
                                            </div>
                                            <div>
                                                <span class="btn btn-default btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                {!! Form::file('image', null, array('class'=>'form-control', 'id' => 'image', 'placeholder'=>'Image', 'value'=>Input::old('image'))) !!}
                                                @if ($errors->first('image'))
                                                <span class="help-block">{!! $errors->first('image') !!}</span>
                                                @endif
                                                </span>
                                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                            </div>
                                        </div>
                                        <hr />
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <!-- Title -->
                                            <div class="col-md-6 control-group {!! $errors->has('title') ? 'has-error' : '' !!}">
                                                <label class="control-label" for="title">Title</label>
                                                <div class="controls">
                                                    {!! Form::text('title', null, array('class'=>'form-control', 'id' => 'title', 'placeholder'=>'Title', 'value'=>Input::old('title'))) !!}
                                                    @if ($errors->first('title'))
                                                    <span class="help-block">{!! $errors->first('title') !!}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Category -->
                                            <div class="col-md-4 control-group {!! $errors->has('category') ? 'error' : '' !!}">
                                                <label class="control-label" for="title">Category</label>
                                                <div class="controls">
                                                    {!! Form::select('category', $categories, null, array('class' => 'form-control', 'value'=>Input::old('category'))) !!}
                                                    @if ($errors->first('category'))
                                                    <span class="help-block">{!! $errors->first('category') !!}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Published -->
                                            <!-- 'bootstrap / Toggle Switch is_published Field' -->
                                            <div class="form-group col-sm-2 {!! $errors->has('is_published') ? 'has-error' : '' !!}">
                                                {!! Form::label('is_published', 'PUBLISHED:') !!}
                                                <label class="checkbox-inline">
                                                {!! Form::checkbox('is_published', 1, true,  ['data-toggle' => 'toggle']) !!}
                                                </label>
                                                @if ($errors->first('is_published'))
                                                <span class="help-block">{!! $errors->first('is_published') !!}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- Subtitle Field -->
                                            <div class="form-group col-sm-6">
                                                {!! Form::label('subtitle', 'Subtitle:') !!}
                                                {!! Form::text('subtitle', null, ['class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <!-- Excerpt Field -->
                                            <div class="form-group ">
                                                {!! Form::label('excerpt', 'Excerpt:') !!}
                                                {!! Form::textarea('excerpt', null, ['class' => 'form-control']) !!}
                                            </div>

                                        </div>
                                    </div>

                                            <!-- Content Field -->
                                            <div class="form-group col-md-12 {!! $errors->has('content') ? 'has-error' : '' !!}">
                                                {!! Form::label('content', 'Content:') !!}
                                                {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder'=>'Main Content Goes Here...', 'value'=>Input::old('content')]) !!}
                                                @if ($errors->first('content'))
                                                <span class="help-block">{!! $errors->first('content') !!}</span>
                                                @endif
                                            </div>

                                </div>
                            </div>
                        </div>
                        <div id="panel_tab_header_image" class="tab-pane">
                        <div class="container-fluid">
                                <div class="row-fluid">
                            <!-- Image -->
                            <div class="fileinput fileinput-new control-group {!! $errors->has('image') ? 'has-error' : '' !!}" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 1140px; height: 600px;">
                                </div>
                                <div>
                                    <span class="btn btn-default btn-file">
                                    <span class="fileinput-new">Select image</span>
                                    <span class="fileinput-exists">Change</span>
                                    {!! Form::file('image', null, array('class'=>'form-control', 'id' => 'image', 'placeholder'=>'Image', 'value'=>Input::old('image'))) !!}
                                    @if ($errors->first('image'))
                                    <span class="help-block">{!! $errors->first('image') !!}</span>
                                    @endif
                                    </span>
                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                        <div id="panel_tab_seo" class="tab-pane">

                        <div class="container-fluid">
                                <div class="row-fluid">
                            <!-- Meta Title Field -->
                            <div class="form-group col-sm-6">
                                {!! Form::label('meta_title', 'Meta Title:') !!}
                                {!! Form::text('meta_title', null, ['class' => 'form-control']) !!}
                            </div>
                            <!-- Meta Keywords Field -->
                            <div class="form-group col-sm-12 col-lg-12 {!! $errors->has('meta_keywords') ? 'has-error' : '' !!}">
                                {!! Form::label('meta_keywords', 'Meta Keywords:') !!}
                                {!! Form::text('meta_keywords', null, ['class' => 'form-control']) !!}
                                @if ($errors->first('meta_keywords'))
                                <span class="help-block">{!! $errors->first('meta_keywords') !!}</span>
                                @endif
                            </div>
                            <!-- Meta Description Field -->
                            <div class="form-group col-sm-12 col-lg-12 {!! $errors->has('meta_description') ? 'has-error' : '' !!}">
                                {!! Form::label('meta_description', 'Meta Description:') !!}
                                {!! Form::textarea('meta_description', null, ['class' => 'form-control']) !!}
                                @if ($errors->first('meta_description'))
                                <span class="help-block">{!! $errors->first('meta_description') !!}</span>
                                @endif
                            </div>
                        </div>

                                           </div>
                        </div>
                        <div id="panel_tab_social" class="tab-pane">
                                                <div class="container-fluid">
                                <div class="row-fluid">
                            <!-- Fb Title Field -->
                            <div class="form-group col-sm-6">
                                {!! Form::label('fb_title', 'Facebook Title:') !!}
                                {!! Form::text('fb_title', null, ['class' => 'form-control']) !!}
                            </div>
                            <!-- Gp Title Field -->
                            <div class="form-group col-sm-6">
                                {!! Form::label('gp_title', 'Google Plus Title:') !!}
                                {!! Form::text('gp_title', null, ['class' => 'form-control']) !!}
                            </div>

                                               </div>
                        </div>
                        </div>
                    </div>
                </div>
