@extends('layouts.three-col')

@section('content')

<h1 class="page_title_primary">Account - <span class="h_alt">{{ $me->nicename }}</span></h1>

<div id="col_1">
	<div class="js_accordion" data-multiple="true">
        @include('account.sidebar', ['page' => 'profile'])
	</div>
</div>
<div id="col_3" role="aside">
    @include('account.activity-widget', [])
</div>

<div id="col_2" role="main">
    <div class="h1 page_title page_title_duplicate">Account - <span class="h_alt">{{ $me->nicename }}</span></div>
    
    <div><h2 class="page_sub_title">Profile Settings</h2></div>
    
    <form action="{{ url('/account/profile') }}" method="post">
        <fieldset>
            <legend>Profile Settings</legend>
            
@if( Session::get('error') )
            <p class="required"><em>&raquo;</em> {{ Session::get('error') }}</p>
@endif
            
            <div class="f_row">
                <label for="username">Username: <em>*</em></label>
                <input type="text" class="text w_bp_large" name="username" id="username" value="{{ e($me->username) }}" required aria-required />
            </div>
            
            <div class="f_row">
                <label for="firstName">First Name:</label>
                <input type="text" class="text w_bp_large" name="first_name" id="firstName" value="{{ e($me->first_name) }}"  />
            </div>
            
            <div class="f_row">
                <label for="lastName">Last Name:</label>
                <input type="text" class="text w_bp_large" name="last_name" id="lastName" value="{{ e($me->last_name) }}"  />
            </div>
            
            <div class="f_row">
                <label for="location">Location:</label>
                <input type="text" class="text w_bp_large" name="location" id="location" value="{{ e($me->location) }}"  />
            </div>
            
            <div class="f_row">
                <label for="website">Website:</label>
                <input type="url" class="text w_bp_large" name="website" id="website" value="{{ e($me->website) }}"  />
            </div>
            
            <div class="f_row">
                <label for="email">Email: <em>*</em></label>
                <input type="email" class="text w_bp_large" name="email" id="email" required aria-required  value="{{ e($me->email) }}" />
            </div>
            
            <div class="f_row">
                <label for="bio">Bio: <span class="description">Max of 300 chars</span></label>
                <textarea class="text" name="bio" id="bio">{{ e($me->bio) }}</textarea>
            </div>
            
            <p class="required"><em>*</em> Denotes a required field</p>
            <div class="btns dbl_mt">
                <button type="submit">Change Settings</button>
            </div>
        </fieldset>
    </form>
    
</div>

@stop
