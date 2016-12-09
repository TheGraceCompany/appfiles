@extends('backend/layout/forms')

@section('topscripts')
<link rel="stylesheet" href="{!! asset('assets/bootstrap/css/bootstrap-tagsinput.css') !!}" type="text/css" />
<link rel="stylesheet" href="{!! asset('jasny-bootstrap/css/jasny-bootstrap.min.css') !!}" type="text/css" />
<script type="text/javascript">
     $(document).ready(function () {
        $("#title").slug();

    });
</script>
@endsection

@section('pagetitle')
    <div class="row">
        <div class="col-sm-12">
            <!-- start: PAGE TITLE & BREADCRUMB -->
            <ol class="breadcrumb">
                <li><a href="{!! url(getLang() . '/admin/article') !!}"><i class="fa fa-book"></i> Article</a></li>
                <li class="active">Add Article</li>
            </ol>
            <div class="page-header">
            <h1> Article <small> | Add Article</small> </h1>
            </div>
            <!-- end: PAGE TITLE & BREADCRUMB -->
        </div>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <!-- start: PANLEL TABS -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-reorder"></i>
                Panel Tabs
            </div>
            <div class="panel-body" onload="onload();">


                {!! Form::open(['action' => '\App\Http\Controllers\Admin\ArticleController@store', 'files'=>true]) !!}



				@include('backend.article.fields')

                {!! Form::close() !!}
                <!-- end: PANLEL TABS -->
            </div>
        </div>
    </div>
    <!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! url('admin.pages.index') !!}" class="btn btn-default">Cancel</a>
</div>
</div>

@endsection

@section('bottomscripts')
        <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
        <script type="text/javascript" src="{!! asset('/backend/assets/plugins/bootbox/bootbox.min.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('/backend/assets/plugins/jquery-mockjax/jquery.mockjax.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('/backend/assets/plugins/select2/select2.min.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('/backend/assets/plugins/DataTables/media/js/jquery.dataTables.min.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('/backend/assets/plugins/DataTables/media/js/DT_bootstrap.js') !!}"></script>
        <script src="{!! asset('/backend/assets/js/table-data.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('jasny-bootstrap/js/jasny-bootstrap.min.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('ckeditor/ckeditor.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('assets/bootstrap/js/bootstrap-tagsinput.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('assets/js/jquery.slug.js') !!}"></script>
        <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
       <script type="text/javascript">
        window.onload = function () {
            CKEDITOR.replace('content', {
                "filebrowserBrowseUrl": "{!! url('filemanager/show') !!}"
            });
        };

        $(document).ready(function () {

            if ($('#tag').length != 0) {
                var elt = $('#tag');
                elt.tagsinput();
            }
        });




        (function($) {
            // window.onkeyup = keyup;
            // var inputTextAreaValue;

            // function keyup(e) {
            //   //setting your input text to the global Javascript Variable for every key press
            //   inputTextValue = e.target.value;

            //   //listens for you to press the ENTER key, at which point your web address will change to the one you have input in the search box
            //   if (e.keyCode == 13) {
            //     window.location = "http://www.myurl.com/search/" + inputTextValue;
            //   }
            // }


        // $.fn.createExcerpts = function(elems,length,more_txt) {
        // $.each($(elems), function() {
        //     var item_html = $(this).html(); //
        //     item_html = item_html.replace(/< /?[^>]+>/gi, '');
        //             item_html = jQuery.trim(item_html);
        //             $(this).html(item_html.substring(0,length)+more_txt);
        //         });
        //         return this; //allow jQuery chaining
        //     }
        // })(jQuery);

        // $().createExcerpts('#content',280,'...');


        $("h1").click(function(){
            $(this).addClass("blue");
        });












//var $ = window.$.noConflict(true); // Required for IE













         });


    </script>



<script type="text/javascript">
    //<![CDATA[
    var boldWords;
    var boldList = "";
    var ellipsis = " ...";
    var dateEllipsis = " <b>...</b> ";

    var d = new Date();
    var month = new Array(12);
                    month[0] = "Jan";
                    month[1] = "Feb";
                    month[2] = "Mar";
                    month[3] = "Apr";
                    month[4] = "May";
                    month[5] = "Jun";
                    month[6] = "Jul";
                    month[7] = "Aug";
                    month[8] = "Sep";
                    month[9] = "Oct";
                    month[10] = "Nov";
                    month[11] = "Dec";

    var todaysDate = month[d.getMonth()] + ' '  + d.getDate() + ', ' + d.getFullYear();

    function get(e){return document.getElementById(e);}
    function val(e){return document.getElementById(e).value;}
    function html(e){return document.getElementById(e).innerHTML;}
    function css(e){return document.getElementById(e).style;}

    function titleFunction(){
        theTitle = val('in_title').replace(/^\s+|\s+$/g,"");
        get('titlechar').innerHTML = theTitle.length;
        get('out_title').innerHTML = theTitle;
        if(get('check_bold').checked == true){
            highlightTerms('out_title');
        }
    }
    function snippetFunction(){
        theSnippet = val('in_snippet').replace(/^\s+|\s+$/g,"");
        if(get('check_date').checked == true){
            var dateLength = html('out_date').length + 5;
            css('out_datedots').display = "inline";}
        else{
            var dateLength = 0;
            css('out_datedots').display = "none";}
        var snippetLength = theSnippet.length + dateLength;
        get('snippetchar').innerHTML = snippetLength;
        if(theSnippet.length + dateLength <= 156){
            get('out_snippet').innerHTML = theSnippet;}
        else{
            var snipLimit = 153 - dateLength;
            snippetSpace = theSnippet.lastIndexOf(" ",snipLimit);
            get('out_snippet').innerHTML = theSnippet.substring(0,snippetSpace).concat(ellipsis.bold());}
        if(get('check_bold').checked == true){
            highlightTerms('out_snippet');
        }
    }
    function urlFunction(){
        var theURL = val('in_url');
        theURL = theURL.replace('http://','');
        theURL = theURL.replace(/^\s+|\s+$/g,"");
        get('out_url').innerHTML = theURL;
        if(get('check_bold').checked == true){
            highlightURL();}}
    function richTextFunction(){
        if(val('in_richtext') != ''){
            get('out_richtext').innerHTML = val('in_richtext').replace(/^\s+|\s+$/g,"");}}
    function showTopads(){
        if(get('check_topads').checked == true){
            css('out_topads').display = "block";
            css('notes_default').display = "none";
            css('notes_sponsored').display = "block";}
        else{
            css('out_topads').display = "none";
            if(get('check_rightads').checked == false){
                css('notes_default').display = "block";
                css('notes_sponsored').display = "none";}}}
    function showRightads(){
        if(get('check_rightads').checked == true){
            css('out_rightads').display = "block";
            css('notes_default').display = "none";
            css('notes_sponsored').display = "block";}
        else{
            css('out_rightads').display = "none";
            css('topspons').float = "right";
            if(get('check_topads').checked == false){
                css('notes_default').display = "block";
                css('notes_sponsored').display = "none";}}}
    function showOrganics(){
        if(get('check_organics').checked == true){
            css('toporganic').display = "block";
            css('bottomorganic').display = "block";}
        else{
            css('toporganic').display = "none";
            css('bottomorganic').display = "none";}}
    function showSerpElements(){
        if(get('check_serpelements').checked == true){
            css('box_topads').display = "inline";
            css('box_rightads').display = "inline";
            css('box_organics').display = "inline";}
        else{
            css('box_topads').display = "none";
            css('box_rightads').display = "none";
            css('box_organics').display = "none";}
        if(get('check_serpelements').checked == true){
            css('out_topsearch').display = "block";
            css('out_toplinks').display = "block";
            css('out_bottomsearch').display = "block";
            css('out_leftside').display = "block";
            showTopads();
            showRightads();
            showOrganics();}
        else{
            css('out_topsearch').display = "none";
            css('out_toplinks').display = "none";
            css('out_bottomsearch').display = "none";
            css('out_leftside').display = "none";
            css('out_topads').display = "none";
            css('out_rightads').display = "none";
            css('topspons').float = "right";
            css('toporganic').display = "none";
            css('bottomorganic').display = "none";
            css('notes_default').display = "block";
            css('notes_sponsored').display = "none";}}
    function dateFunction(){
            get('out_date').innerHTML = val('in_datevalue').replace(/^\s+|\s+$/g,"");
            snippetFunction();
            dateError();}
    function showDate(){
        if(get('check_date').checked == true){
            css('out_date').display = "inline";
            css('box_date').display = "block";
            css('out_datedots').display = "inline";}
        else{
            css('out_date').display = "none";
            css('box_date').display = "none";
            css('out_datedots').display = "none";}
        showTR();
        dateFunction();
        dateError();}
    function useTodaysDate(){
        if(val('in_datevalue') == '' && get('check_date').checked == true){
            get('in_datevalue').innerHTML = todaysDate;}}
    function focusDateValue(){
        get('in_datevalue').focus();}
    function dateError(){
        if(val('in_datevalue') == '' && get('check_date').checked == true){
                css('addadate').color = "#F00";
                css('enteradate').color = "#F00";
                css('out_datedots').color = "#F00";
                focusDateValue();}
            else{
                css('addadate').color = "#000";
                css('enteradate').color = "#333";
                css('out_datedots').color = "#666";}}
    function showTR(){
        if(get('check_date').checked == false && get('check_richsnippet').checked == false){
                css('box_rich_date').display = "none";}
        else{
                css('box_rich_date').display = "block";}}
    function showRichSnippet(){
        if(get('check_richsnippet').checked == true){
            css('out_richsnippet').display = "inline";
            css('box_richtext').display = "block";
            css('box_stars').display = "block";}
        else{
            css('out_richsnippet').display = "none";
            css('box_richtext').display = "none";
            css('box_stars').display = "none";}
        if(get('check_stars').checked == true){
            css('out_stars').display = "inline";}
        else{
            css('out_stars').display = "none";}
        showTR();}
    function showCached(){
        if(get('check_cached').checked == true && get('check_similar').checked == true){
            css('out_dash1').display = "inline";
            css('out_dash2').display = "inline";}
        if(get('check_cached').checked == false && get('check_similar').checked == false){
            css('out_dash1').display = "none";
            css('out_dash2').display = "none";}
        if(get('check_cached').checked == true && get('check_similar').checked == false){
            css('out_dash1').display = "inline";
            css('out_dash2').display = "none";}
        if(get('check_cached').checked == false && get('check_similar').checked == true){
            css('out_dash1').display = "inline";
            css('out_dash2').display = "none";}
        if(get('check_cached').checked == true){
            css('out_cached').display = "inline";}
        else{
            css('out_cached').display = "none";}
        if(get('check_similar').checked == true){
            css('out_similar').display = "inline";}
        else{
            css('out_similar').display = "none";}}

    function showBold(){
        if(get('check_bold').checked == false){
                css('box_bold').display = "none";}
        else{
                css('box_bold').display = "block";}
    // The next 2 lines are there to force IE to reflow the page layout.
        css('out_searchresults').display = "none";
        css('out_searchresults').display = "block";
    }

    function focusBold(){
        titleFunction();
        snippetFunction();
        urlFunction();
        get('in_bold').focus();
        get('in_bold').select();}


    // This function takes the value of in_bold
    // and outputs an array of words to make bold
    function makeBoldWords(){
        var splitChars = /\s+/g;
        var trashChars = /\s+|\W+|^.{1,2}$/g;
        boldWords = "";
        boldWords = val('in_bold').replace(trashChars," ").toLowerCase();
        boldWords = boldWords.split(splitChars);
        for(i=0; i<boldWords.length; i++){
            boldWords[i] = boldWords[i].replace(trashChars,"");
            if(boldWords[i] == ""){
                boldWords.splice(i,1);
                i--;
            }
        }
        boldList = "";
        for(i=0; i<boldWords.length; i++){
            boldList += boldWords[i] + "\n";
        }
        get('in_bold').value = boldList;
        return boldWords;
    }


    function highlightTerms(content){
        makeBoldWords();
        var outNode = get(content);
        for(i=0; i<boldWords.length; i++){
            var boldRegExp = new RegExp('\\b('+boldWords[i]+'(\'\\S*)?)\\b','ig');
            var tempText = outNode.innerHTML;
            outNode.innerHTML = tempText.replace(boldRegExp,'<em>$1</em>');
        }
    }

    function highlightURL(){
        makeBoldWords();
        var outNode = get('out_url');
        for(i=0; i<boldWords.length; i++){
            var boldRegExp = new RegExp('('+boldWords[i]+')','ig');
            var tempText = outNode.innerHTML;
            outNode.innerHTML = tempText.replace(boldRegExp,'<em>$1</em>');
        }
    }



    function focusRichText(){ get('in_richtext').focus();}

    function pageRefresh(){
        showTopads();
        showRightads();
        showOrganics();
        showSerpElements();
        showRichSnippet();
        useTodaysDate();
        showDate();
        showCached();
        showBold();
        titleFunction();
        snippetFunction();
        urlFunction();
        richTextFunction();
        dateFunction();}

    window.onload = function(){
        pageRefresh();
     //   loadSidebars();
     //   mofoCopyright();
      //  newTwitterButtonWidget();
       }

    function loadSidebars(){
        if(document.getElementById('sidebars_iframeXXXXX')){
            var sidebarArray = new Array();
            sidebarArray.push("<iframe scrolling=\"no\" height=\"939\" frameborder=\"0\" width=\"382\" src=\"http:\/\/www.seomofo.com\/sidebars.html\"><\/iframe>");
            var sidebarCode = sidebarArray.join('');
            document.getElementById('sidebars_iframe').innerHTML = sidebarCode;}
        }

    function newTwitterButtonWidget(){
        if(document.getElementById('tw_box')){
            var twArray = new Array();
            twArray.push("<iframe scrolling=\"no\" height=\"62\" frameborder=\"0\" width=\"58\" src=\"http:\/\/platform.twitter.com\/widgets\/tweet_button.html?count=vertical&amp;related=seomofo%3AWorld%27s%20Greatest%20SEO%20(verified)&amp;url=" + escape(document.URL) + "&amp;lang=en&amp;text=Useful%20tool%20from%20@SEOmofo%20%C2%BB%20" + encodeURIComponent(document.title) + "%20%C2%BB\"" + "onload=\"document.getElementById('tw_loading').style.display='none';\"><\/iframe>");
            var twCode = twArray.join('');
            document.getElementById('tw_box').innerHTML = twCode;
        }
    }

    function mofoCopyright(){
    if(document.getElementById('footer')){
        var myCopy = "";
        var d = new Date();
        var mofoYear = d.getFullYear();
        myCopy += "&copy;&nbsp;Copyright&nbsp;&nbsp;2007-" + mofoYear + "&nbsp;&nbsp;Darren Slatten";
        document.getElementById('footer').innerHTML = myCopy;}}

    function doneLoading(){
        document.getElementById('tm_loading').style.display='none';
        var doneLoadNode = document.createElement('span');
        document.getElementById('append_load_node').appendChild(doneLoadNode);
        doneLoadNode.setAttribute('id', 'done_loading');
    }


    //]]>
</script>



@endsection

@section('clipinline')
TableData.init();
@endsection
