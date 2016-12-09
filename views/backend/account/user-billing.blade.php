@extends('frontend.layout.account')

@section('content')
<!-- Content
    ============================================= -->
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            <div class="row clearfix">
                <div class="col-sm-9">
                    <img src="$user->userinfo->photo" class="alignleft img-circle img-thumbnail notopmargin nobottommargin" alt="Avatar" style="max-width: 84px;">
                    <div class="heading-block noborder">
                        <h3>{!! $user->first_name !!} {!! $user->last_name !!} <small>$user->username</small></h3>
                        <span>Your Shipping Information Section</span>
                    </div>
                    <div class="clear"></div>
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="tabs tabs-alt clearfix" id="tabs-profile">
                                <ul class="tab-nav clearfix">
                                    <li><a href="#tab-feeds"><i class="icon-rss2"></i> Shipping</a></li>
                                    <li><a href="#tab-posts"><i class="icon-pencil2"></i> New</a></li>
                                    <li><a href="#tab-replies"><i class="icon-reply"></i> Edit</a></li>
                                    {{-- <li><a href="#tab-connections"><i class="icon-users"></i> Connections</a></li> --}}
                                </ul>
                                <div class="tab-container">
                                    <div class="tab-content clearfix" id="tab-shipping">

<table class="table table-responsive" id="locations-table">
    <thead>
        <th>Nickname</th>
        <th>City</th>
        <th>State</th>
        <th>Zipcode</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($locations as $location)
        <tr>
            <td>{!! $location->nickname !!}</td>
            <td>{!! $location->city !!}</td>
            <td>{!! $location->state !!}</td>
            <td>{!! $location->zipcode !!}</td>
            <td>
                {!! Form::open(['route' => ['admin.locations.destroy', $location->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.locations.show', [$location->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.locations.edit', [$location->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

                                    </div>
                                    <div class="tab-content clearfix" id="tab-edit">
<div class="form-group col-sm-6">
    {!! Form::label('nickname', 'Nickname:') !!}
    {!! Form::text('nickname', null, ['class' => 'form-control']) !!}
</div>

<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address', 'Address:') !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>

<!-- Street Field -->
<div class="form-group col-sm-6">
    {!! Form::label('street', 'Street:') !!}
    {!! Form::text('street', null, ['class' => 'form-control']) !!}
</div>

<!-- Street Additional Field -->
<div class="form-group col-sm-6">
    {!! Form::label('street_additional', 'Street Additional:') !!}
    {!! Form::text('street_additional', null, ['class' => 'form-control']) !!}
</div>

<!-- City Field -->
<div class="form-group col-sm-6">
    {!! Form::label('city', 'City:') !!}
    {!! Form::text('city', null, ['class' => 'form-control']) !!}
</div>

<!-- State Field -->
<div class="form-group col-sm-6">
    {!! Form::label('state', 'State:') !!}
    {!! Form::select('state', ['' => '', 'UT' => 'Utah', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas', 'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'CT', 'DE' => 'Deleware', 'FL' => 'Florida', 'GA' => 'GA', 'HI' => 'HI', 'ID' => 'ID', 'IL' => 'IL', 'IN' => 'IN', 'IA' => 'IA', 'KS' => 'Kansas', 'KY' => 'KY', 'LA' => 'LA', 'ME' => 'ME', 'MD' => 'MD', 'MA' => 'MA', 'MI' => 'MI', 'MN' => 'MN', 'MS' => 'MS', 'MO' => 'MO', 'MT' => 'MT', 'NE' => 'NE', 'NV' => 'NV', 'NH' => 'NH', 'NJ' => 'NJ', 'NM' => 'NM', 'NY' => 'NY', 'NC' => 'NC', 'ND' => 'ND', 'OH' => 'OH', 'OK' => 'OK', 'OR' => 'OR', 'PA' => 'PA', 'RI' => 'RI', 'SC' => 'SC', 'SD' => 'SD', 'TN' => 'TN', 'TX' => 'TX', 'UT' => 'UT', 'VT' => 'VT', 'VA' => 'VA', 'WA' => 'WA', 'WV' => 'WV', 'WI' => 'WI', 'WY' => 'WY'], null, ['class' => 'form-control']) !!}
</div>


<!-- Zipcode Field -->
<div class="form-group col-sm-6">
    {!! Form::label('zipcode', 'Zipcode:') !!}
    {!! Form::text('zipcode', null, ['class' => 'form-control']) !!}
</div>

<!-- Country Field -->
<div class="form-group col-sm-6">
    {!! Form::label('country', 'Country:') !!}
    {!! Form::text('country', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.locations.index') !!}" class="btn btn-default">Cancel</a>
</div>
                                    </div>
                                {{--     <div class="tab-content clearfix" id="tab-">

                                      <!-- Nickname Field -->
<!-- Location Type Field -->
<div class="form-group">
    {!! Form::label('location_type', 'Location Type:') !!}
    <p>{!! $location->location_type !!}</p>
</div>

<!-- Nickname Field -->
<div class="form-group">
    {!! Form::label('nickname', 'Nickname:') !!}
    <p>{!! $location->nickname !!}</p>
</div>

<!-- Address Field -->
<div class="form-group">
    {!! Form::label('address', 'Address:') !!}
    <p>{!! $location->address !!}</p>
</div>

<!-- Street Field -->
<div class="form-group">
    {!! Form::label('street', 'Street:') !!}
    <p>{!! $location->street !!}</p>
</div>

<!-- Street Additional Field -->
<div class="form-group">
    {!! Form::label('street_additional', 'Street Additional:') !!}
    <p>{!! $location->street_additional !!}</p>
</div>

<!-- City Field -->
<div class="form-group">
    {!! Form::label('city', 'City:') !!}
    <p>{!! $location->city !!}</p>
</div>

<!-- State Field -->
<div class="form-group">
    {!! Form::label('state', 'State:') !!}
    <p>{!! $location->state !!}</p>
</div>

<!-- Zipcode Field -->
<div class="form-group">
    {!! Form::label('zipcode', 'Zipcode:') !!}
    <p>{!! $location->zipcode !!}</p>
</div>

<!-- Country Field -->
<div class="form-group">
    {!! Form::label('country', 'Country:') !!}
    <p>{!! $location->country !!}</p>
</div>

<!-- Latitude Field -->
<div class="form-group">
    {!! Form::label('latitude', 'Latitude:') !!}
    <p>{!! $location->latitude !!}</p>
</div>

<!-- Longitude Field -->
<div class="form-group">
    {!! Form::label('longitude', 'Longitude:') !!}
    <p>{!! $location->longitude !!}</p>
</div>

                                    </div> --}}
                             {{--        <div class="tab-content clearfix" id="tab-">
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="line visible-xs-block"></div>
				@include('frontend.account.partials.account-sidebar')
            </div>
        </div>
    </div>
</section>
@endsection
