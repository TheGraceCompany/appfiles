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
                        <span>Your Profile & Account Section</span>
                    </div>
                    <div class="clear"></div>
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="tabs tabs-alt clearfix" id="tabs-profile">
                                <ul class="tab-nav clearfix">
                                    <li><a href="#tab-feeds"><i class="icon-rss2"></i> Feeds</a></li>
                                    <li><a href="#tab-posts"><i class="icon-pencil2"></i> Posts</a></li>
                                    <li><a href="#tab-replies"><i class="icon-reply"></i> Replies</a></li>
                                    <li><a href="#tab-connections"><i class="icon-users"></i> Connections</a></li>
                                </ul>
                                <div class="tab-container">
                                    <div class="tab-content clearfix" id="tab-feeds">
                                        <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium harum ea quo! Nulla fugiat earum, sed corporis amet iste non, id facilis dolorum, suscipit, deleniti ea. Nobis, temporibus magnam doloribus. Reprehenderit necessitatibus esse dolor tempora ea unde, itaque odit. Quos.</p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <colgroup>
                                                    <col class="col-xs-1">
                                                    <col class="col-xs-7">
                                                </colgroup>
                                                <thead>
                                                    <tr>
                                                        <th>Time</th>
                                                        <th>Activity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <code>5/23/2016</code>
                                                        </td>
                                                        <td>Payment for VPS2 completed</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <code>5/23/2016</code>
                                                        </td>
                                                        <td>Logged in to the Account at 16:33:01</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <code>5/22/2016</code>
                                                        </td>
                                                        <td>Logged in to the Account at 09:41:58</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <code>5/21/2016</code>
                                                        </td>
                                                        <td>Logged in to the Account at 17:16:32</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <code>5/18/2016</code>
                                                        </td>
                                                        <td>Logged in to the Account at 22:53:41</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-content clearfix" id="tab-posts">
                                    </div>
                                    <div class="tab-content clearfix" id="tab-replies">
                                    </div>
                                    <div class="tab-content clearfix" id="tab-connections">
                                    </div>
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
