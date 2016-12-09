                <div class="tabbable panel-tabs">
                    <ul class="nav nav-tabs">
                        <li class="active"> <a data-toggle="tab" href="#panel_tab_article_content"> Article Content </a> </li>
                        <li> <a data-toggle="tab" href="#panel_tab_header_image">Header Image </a> </li>
                        <li> <a data-toggle="tab" href="#panel_tab_seo"> SEO </a> </li>
                        <li> <a data-toggle="tab" href="#panel_tab_social"> SOCIAL </a> </li>

                        <li>&nbsp;</li>
                        <li>{!! Form::submit('Update', ['class' => 'btn btn-primary btn-squared']) !!}</li>
                        <li> <a href="{!! url('admin.pages.index') !!}" class="btn btn-default btn-squared">Cancel</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="panel_tab_article_content" class="tab-pane active">
                            <div class="container-fluid">
                                <div class="row-fluid">
                                    <div class="col-md-6">


                            {{--             <!-- Image -->
                                        <div class="fileinput fileinput-new control-group ">

                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-width: 500px; max-height: 400px;width: 100%;">
                                            </div>

                                        </div>
                                        <hr /> --}}

 {{--  <!-- Tag -->
    <div class="col-md-4 control-group {!! $errors->has('tag') ? 'has-error' : '' !!}">
        <label class="control-label" for="title">Tag</label>

        <div class="controls">
            {!! Form::text('tag', null, array('class'=>'form-control', 'id' => 'tag', 'placeholder'=>'Tag', 'value'=>Input::old('tag'))) !!}
            @if ($errors->first('tag'))
            <span class="help-block">{!! $errors->first('tag') !!}</span>
            @endif
        </div>
    </div>
 --}}




	<div id="out_searchresults" style="display: block;">
	        <!-- SEARCH RESULTS -->
	        <div id="res" class="med">
	            <h3 class="hd">Example Search Result</h3>
	            <div id="ires">
	                <ol>

	                    <li class="g">
	                        <div class="vsc">
	                            <h4 class="r">
	                                <a href="#" onclick="return false;" class="l">
	                                    {{-- <span id="out_title">Domain Name Registration and Web Hosting | Domain.com</span> --}}
	                                </a>
	                            </h4>
	                            <div class="s">
	                                <div class="f kv">
	                                    <cite><span id="out_url"></span><span id="out_dash1" style="display: inline;"></span></cite>
	                                </div>
	                                <div class="f kv">
	                                    <div class="f" id="out_richsnippet" style="display: none;">
	                                        <div id="out_stars" style="display: none;">
	                                            {{--<table border="0" cellpadding="0" cellspacing="0" class="ti" style="height:px;width:px">--}}
	                                                {{--<tbody>--}}
	                                                    {{--<tr>--}}
	                                                        {{--<td>--}}
	                                                            {{--<p style="height:9px;width:10px;margin:0;padding:0;position:relative;overflow:hidden"> <img alt="Rated 4.5 out of 5.0" src="images/srpr/nav_logo13.png" style="left:0px;position:absolute;top:-110px"> </p>--}}
	                                                        {{--</td>--}}
	                                                        {{--<td>--}}
	                                                            {{--<p style="height:9px;width:10px;margin:0;padding:0;position:relative;overflow:hidden"> <img alt="" src="images/srpr/nav_logo13.png" style="left:0px;position:absolute;top:-110px"> </p>--}}
	                                                        {{--</td>--}}
	                                                        {{--<td>--}}
	                                                            {{--<p style="height:9px;width:10px;margin:0;padding:0;position:relative;overflow:hidden"> <img alt="" src="images/srpr/nav_logo13.png" style="left:0px;position:absolute;top:-110px"> </p>--}}
	                                                        {{--</td>--}}
	                                                        {{--<td>--}}
	                                                            {{--<p style="height:9px;width:10px;margin:0;padding:0;position:relative;overflow:hidden"> <img alt="" src="images/srpr/nav_logo13.png" style="left:0px;position:absolute;top:-110px"> </p>--}}
	                                                        {{--</td>--}}
	                                                        {{--<td>--}}
	                                                            {{--<p style="height:9px;width:10px;margin:0;padding:0;position:relative;overflow:hidden"> <img alt="" src="images/srpr/nav_logo13.png" style="left:-117px;position:absolute;top:-107px"> </p>--}}
	                                                        {{--</td>--}}
	                                                    {{--</tr>--}}
	                                                {{--</tbody>--}}
	                                            {{--</table>--}}
	                                        </div>
	                                        <span id="out_richtext">Review by Darren Slatten - Jan 1, 2010 - Price range: $999.99</span><br>
	                                    </div>
	                                    <span id="out_datesnip"><span class="mofo_date"><span id="out_date" style="display: none;"></span><span id="out_datedots" style="display: none; color: rgb(102, 102, 102);">&nbsp;-&nbsp;</span></span><span class="mofo_snippet">
	                              {{--       <span id="out_snippet">Register a domain name and transfer domains. Reliable web hosting and VPS. Powerful website, blog, and ecommerce tools. 12 years, millions of customers.</span> --}}
	                                    </span></span>
	                                    <span class="gl"><span id="out_cached" style="display: inline;"></span><span id="out_dash2" style="display: inline;"></span><span id="out_similar" style="display: inline;"></span></span>
	                                </div>
	                            </div>
	                        </div>
	                    </li>

	                </ol>

	            </div>

	        </div>
	    </div>

























                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">


                                            <!-- Category -->
                                    <div class="col-md-3 control-group {!! $errors->has('category') ? 'error' : '' !!}">
                                                <label class="control-label" for="title">Category</label>
                                                <div class="controls">
                                                    {!! Form::select('category', $categories, null, array('class' => 'form-control', 'value'=>Input::old('category'))) !!}
                                                    @if ($errors->first('category'))
                                                    <span class="help-block">{!! $errors->first('category') !!}</span>
                                                    @endif
                                                </div>
                                            </div>
	                                        <!-- Author Id Field -->
	                                         <div class="form-group col-sm-3">
		                                        {!! Form::label('author_id', 'Author:') !!}
		                                        {!! Form::select('user', $users, null, array('class' => 'form-control', 'value'=>Input::old('user'))) !!}
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
                        <script type="text/javascript">
                            function titleFunction(){
                                theTitle = val('input[name="title"]').replace(/^\s+|\s+$/g,"");
                                get('titlechar').innerHTML = theTitle.length;
                                get('out_title').innerHTML = theTitle;
                                if(get('check_bold').checked == true){
                                    highlightTerms('out_title');
                                }
                            }
                        </script>

                                        <div class="row">


                                          <!-- Title -->
                                            <div class="form-group col-md-8 {!! $errors->has('title') ? 'has-error' : '' !!}">
                                                <label class="control-label" for="title">Title</label>
                                                <span id="titlechar">53</span>
                                                <div class="controls">
                                                        {!! Form::text('title', null, array('class'=>'form-control', 'id' => 'title',
                                                        'onkeyup' => 'titleFunction()',
                                                        'onfocus' => '

                                                        this.style.color="#00C";
                                                        this.style.border="1px solid #00C";
                                                        css("subtext_title").color="#000";
                                                        css("tip_title").color="#000";
                                                        if(this.value== "This is an Example of a Title Tag that is Seventy Characters in Length")
                                                        this.value="";',

                                                       'onblur'=> 'if(this.value=='')
                                                       this.value="This is an Example of a Title Tag that is Seventy Characters in Length";
    this.style.color="#CCCCF5"; this.style.border="1px solid #8080E6"; css("subtext_title").color="#CCC";
    css("tip_title").color="#CCC";
    titleFunction();

                                                        ',
                                                        'value'=>Input::old('title')
                                                        )
                                                    ) !!}
                                                    @if ($errors->first('title'))
                                                    <span class="help-block">{!! $errors->first('title') !!}</span>
                                                    @endif
                                                </div>
                                            </div>




                                            <!-- Subtitle Field -->
                                            <div class="form-group col-md-8">
                                                {!! Form::label('subtitle', 'Subtitle:') !!}
                                                {!! Form::text('subtitle', null, ['class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                        <hr />
                                        <script type="text/javascript">
                                            function makeExcerpt(){
                                                var lol = document.getElementById('content').value;
                                                   $('#excerpt').val(lol);

                                            }
                                        </script>

                                        <div class="row">
                                            <!-- Excerpt Field -->
                                            <div class="form-group ">
                                                {!! Form::label('excerpt', 'Excerpt:') !!}
                                                {!! Form::textarea('excerpt', null, ['class' => 'form-control', 'rows' => '5']) !!}
                                                {{-- <small>create from content <input type="button" value="click" onclick="makeExcerpt();"/></small> --}}
                                            </div>

                                        </div>
                                    </div>

                                            <!-- Content Field -->
                                            <div class="form-group col-sm-12 col-lg-12 {!! $errors->has('content') ? 'has-error' : '' !!}" style="    visibility: visible;">
                                                {!! Form::label('content', 'Content:') !!}
                                                {!! Form::textarea('content', null, ['onkeyup' => ' ','id'=>'content', 'class' => 'form-control summernote', 'value'=>Input::old('content'), 'rows' => '30']) !!}
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


<div class="col-md-6">
                <table border="0" cellpadding="0" cellspacing="0" id="inputtable">
                    <tbody><tr>
                        <td>

                            <textarea id="in_title" name="in_title" rows="2" cols="70" onkeyup="titleFunction();" onfocus="this.style.color='#00C'; this.style.border='1px solid #00C'; css('subtext_title').color='#000'; css('tip_title').color='#000'; if(this.value=='This is an Example of a Title Tag that is Seventy Characters in Length')this.value='';" onblur="if(this.value=='')this.value='This is an Example of a Title Tag that is Seventy Characters in Length'; this.style.color='#CCCCF5'; this.style.border='1px solid #8080E6'; css('subtext_title').color='#CCC'; css('tip_title').color='#CCC'; titleFunction();" tabindex="1" style="color: rgb(204, 204, 245); border: 1px solid rgb(128, 128, 230);"> </textarea>

               {{--              <div class="input_subtext" id="subtext_title" style="color: rgb(204, 204, 204);"><span class="tip_subtext" id="tip_title" style="color: rgb(204, 204, 204);">Tip:&nbsp;&nbsp;</span><a href="experiments/serp/google-snippet-07.html">Google limits SERP titles by pixel width, not by character count</a></div> --}}
                        </td>
                    </tr>
                    <tr id="box_rich_date" style="display: none;">
                        <td style="width:554.5px;">
                            <div id="box_richtext" style="display: none;">
                                <label for="in_richtext">Rich Snippet Text</label><br>
                                <textarea id="in_richtext" name="in_richtext" rows="1" cols="54" onkeyup="richTextFunction();" onfocus="this.style.color='#676767'; this.style.border='1px solid #676767'; css('subtext_richtext').color='#676767'; css('tip_richtext').color='#000';" onblur="this.style.color='#E1E1E1'; this.style.border='1px solid #B3B3B3'; css('subtext_richtext').color='#CCC'; css('tip_richtext').color='#CCC';" tabindex="2">Review by Darren Slatten - Jan 1, 2010 - Price range: $999.99</textarea>
                                <div class="input_subtext" id="subtext_richtext"><span class="tip_subtext" id="tip_richtext">Example:&nbsp;&nbsp;</span>Review by Darren Slatten - Jan 1, 2010 - Price range: $999.99</div>
                            </div>
                            <div id="box_date" style="display: none;">
                                <label for="in_datevalue"><span id="enteradate" style="color: rgb(51, 51, 51);">Enter a date:</span></label><br>
                                <textarea id="in_datevalue" name="in_datevalue" rows="1" cols="11" onkeyup="dateFunction();" onfocus="this.style.color='#000'; this.style.border='1px solid #000'; css('subtext_datevalue').color='#000'; css('tip_datevalue').color='#000';" onblur="this.style.color='#CCC'; this.style.border='1px solid #808080'; css('subtext_datevalue').color='#CCC'; css('tip_datevalue').color='#CCC';" tabindex="3"></textarea>
                                <div class="input_subtext" id="subtext_datevalue"><span class="tip_subtext" id="tip_datevalue">Example:&nbsp;&nbsp;</span>Jan 1, 2011</div>
                            </div>
                            <div style="clear:both;"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="in_snippet" style="display:block; margin:0; padding:0; width:276px; float:left; text-align:left; line-height:20px;">Description</label><span id="snippetchar" style="display:block; margin:0; padding:0; width:276px; float:right; text-align:right; line-height:20px;">152</span><span style="display:block; margin:0; padding:0; clear:both;"></span>
                            <textarea id="in_snippet" name="in_snippet" rows="3" cols="70" onkeyup="snippetFunction();" onfocus="this.style.color='#000'; this.style.border='1px solid #000'; css('subtext_snippet').color='#000'; css('subtext_snippet_char').color='#06C'; css('tip_snippet').color='#000'; if(this.value=='Here is an example of what a snippet looks like in Google\'s SERPs. The content that appears here is usually taken from the Meta Description tag if relevant.')this.value='';" onblur="if(this.value=='')this.value='Here is an example of what a snippet looks like in Google\'s SERPs. The content that appears here is usually taken from the Meta Description tag if relevant.'; this.style.color='#CCC'; this.style.border='1px solid #808080'; css('subtext_snippet').color='#CCC'; css('subtext_snippet_char').color='#CCC'; css('tip_snippet').color='#CCC'; snippetFunction();" tabindex="4" style="color: rgb(204, 204, 204); border: 1px solid rgb(128, 128, 128);">Here is an example of what a snippet looks like in Google's SERPs. The content that appears here is usually taken from the Meta Description tag if relevant.</textarea>
                            <div style="display: none; color: rgb(204, 204, 204);" class="input_subtext" id="subtext_snippet"><span class="tip_subtext" id="tip_snippet" style="color: rgb(204, 204, 204);">Tip:&nbsp;&nbsp;</span>the maximum number of characters in a Google SERP snippet is <span class="char_subtext" id="subtext_snippet_char" style="color: rgb(204, 204, 204);">156</span></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="in_url">URL</label><br>
                            <textarea id="in_url" name="in_url" rows="1" cols="70" onkeyup="urlFunction();" onfocus="this.style.color='#008000'; this.style.border='1px solid #008000'; css('subtext_url').color='#40a040'; css('tip_url').color='#000'; if(this.value=='www.seomofo.com/snippet-optimizer.html')this.value='';" onblur="if(this.value=='')this.value='www.seomofo.com/snippet-optimizer.html'; this.style.color='#CCE6CC'; this.style.border='1px solid #80C080'; css('subtext_url').color='#CCC'; css('tip_url').color='#CCC'; urlFunction();" tabindex="5" style="color: rgb(204, 230, 204); border: 1px solid rgb(128, 192, 128);">www.seomofo.com/snippet-optimizer.html</textarea>
                            <div class="input_subtext" id="subtext_url" style="color: rgb(204, 204, 204);"><span class="tip_subtext" id="tip_url" style="color: rgb(204, 204, 204);">Example:&nbsp;&nbsp;</span>www.seomofo.com/snippet-optimizer.html</div>
                        </td>
                    </tr>
                    <tr id="box_bold" style="display: none;">
                        <td style="width:554.5px;">
                            <div style="float:left; width:402px; height:104px;">
                                <label for="in_bold">Bold Words</label><br>
                                <textarea id="in_bold" name="in_bold" rows="4" cols="70" onchange="makeBoldWords(); titleFunction(); snippetFunction(); urlFunction();" onfocus="this.style.color='#000'; this.style.border='1px solid #000'; css('subtext_bold').color='#000'; css('tip_bold').color='#000';" onblur="this.style.color='#CCC'; this.style.border='1px solid #808080'; css('subtext_bold').color='#CCC'; css('tip_bold').color='#CCC';" tabindex="6">Paste keywords here. snippet tag google title</textarea><br>
                                <div class="input_subtext" id="subtext_bold"><span class="tip_subtext" id="tip_bold">Tip:&nbsp;&nbsp;</span>paste words here to simulate bolded query terms.</div>
                            </div>
                            <div style="float:right; width:127px; height:104px; line-height:20px;">
                                <br>
                                <button onclick="makeBoldWords(); titleFunction(); snippetFunction(); urlFunction();" type="button" tabindex="7">Refresh</button>
                            </div>
                            <div style="clear:both;"></div>
                        </td>
                    </tr>
                </tbody></table>
            </div>
<div class="col-md-6">











</div>

        <div class="form-group">
            <div class="col-sm-12 ">
                <label>
                    Image Upload
                </label>
                <div class="fileupload fileupload-new  control-group {!! $errors->has('image') ? 'has-error' : '' !!}" data-provides="fileupload">
                    <div class="fileupload-new thumbnail" style="width: 1140px; height: 600px;">

           {{--          <img data-src="" {!! (($article->path) ? "src='".url($article->path)."'" : '<img src="http://www.placehold.it/1140x600/EFEFEF/AAAAAA?text=no+image" alt=""/>') !!} alt="..."> --}}
                    </div>
                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 1140px; max-height: 600px; line-height: 20px;"></div>
                    <div>
                        <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
                            {!! Form::file('image', null, ['class'=>'form-control', 'id' => 'image', 'placeholder'=>'Image', 'files'=>true, 'value'=>Input::old('image')]) !!}
                        </span>
                        <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                            <i class="fa fa-times"></i> Remove
                        </a>
                    </div>
                </div>

            </div>
        </div>



<!-- Path Field -->
<div class="form-group col-sm-6 hidden">
    {!! Form::label('path', 'Path:') !!}
    {!! Form::text('path', null, ['class' => 'form-control']) !!}
</div>

<div class="clearfix"></div>

<!-- File Size Field -->
<div class="form-group col-sm-6 hidden">
    {!! Form::label('file_size', 'File Size:') !!}
    {!! Form::number('file_size', null, ['class' => 'form-control']) !!}
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


                         <!-- Link To Product Title Field -->
                                    <div class="form-group col-sm-6">
                                        {!! Form::label('link_to_product_title', 'Link To Product Title:') !!}
                                        {!! Form::text('link_to_product_title', null, ['class' => 'form-control']) !!}
                                    </div>

                                    <!-- Link To Product Field -->
                                    <div class="form-group col-sm-6">
                                        {!! Form::label('link_to_product', 'Link To Product:') !!}
                                        {!! Form::text('link_to_product', null, ['class' => 'form-control']) !!}
                                    </div>


                                               </div>
                        </div>
                        </div>
                    </div>
                </div>