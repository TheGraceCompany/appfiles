@extends('backend/layout/create')

@section('pagetitle')
<div class="row">
    <div class="col-sm-12">
        <!-- start: PAGE TITLE & BREADCRUMB -->
        <ol class="breadcrumb">
            <li><a href="{!! url(getLang() . '/admin/article') !!}"><i class="fa fa-book"></i> Article</a></li>
            <li class="active">Update Article</li>
        </ol>
        <div class="page-header">
            <h1> Article <small> | Update Article</small> </h1>
        </div>
        <!-- end: PAGE TITLE & BREADCRUMB -->
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="clip-stats"></i> Article Data
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a>
                    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="fa fa-wrench"></i> </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="fa fa-refresh"></i> </a>
                    <a class="btn btn-xs btn-link panel-close" href="#"> <i class="fa fa-times"></i> </a>
                </div>
            </div>
            {!! Form::model($article, ['route' => [getLang(). '.admin.article.update', $article->id], 'method' => 'PATCH', 'files'=>true]) !!}
            <div class="panel-body">
                @include('flash::message')
                <div class="space12">
                    <div class="btn-group btn-group-lg">
                        <a class="btn btn-default active" href="javascript:;"> Articles </a>
                        <a class="btn btn-default hidden-xs" href="{!! langRoute('admin.article.create') !!}"> <i class="fa fa-plus"></i> Add Article  </a>
                    </div>
                </div>
                @include('backend.article.fields')
                {{-- <div class="pull-right"> --}}
                    {!! Form::submit('UPDATE', ['class'=>'btn btn-primary btn-squared']) !!}
                    <a href="{!! url(getLang(). '/admin/article') !!}" class="cancel btn btn-dark-grey btn-squared">Cancel</a>
                {{-- </div> --}}
            </div>
            {!! Form::close() !!}
            <div style="clear:both"></div>
        </div>
    </div>
</div>
</div>
@endsection

@section('topscripts')

@endsection

@section('bottomscripts')
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<script src="{!! asset('/clip/assets/js/article-elements.js') !!}"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
@endsection

@section('clipinline')
CreateArticle.init();
@endsection
