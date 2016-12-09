@extends('backend/layout/create')

@section('topcss')@endsection

@section('topscripts')
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
{!! Form::open(['action' => '\App\Http\Controllers\Admin\ArticleController@store', 'files' => true]) !!}
    <div class="col-sm-12">
        <!-- start: PANLEL TABS -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-reorder"></i>
                Panel Tabs
            </div>
            <div class="panel-body">


                @include('/backend/article/fields')

                <!-- end: PANLEL TABS -->
            </div>
        </div>
        <div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary btn-squared']) !!}
    <a href="{!! url(getLang().'/admin/article') !!}" class="btn btn-default btn-squared">Cancel</a>
</div>

    </div>
    <!-- Submit Field -->

{!! Form::close() !!}
</div>

@endsection

@section('bottomscripts')
        <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
        <script src="{!! asset('/clip/assets/js/article-elements.js') !!}"></script>
        <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

@endsection

@section('js_init')
CreateArticle.init();
 $('.fileinput').fileinput()
@endsection
