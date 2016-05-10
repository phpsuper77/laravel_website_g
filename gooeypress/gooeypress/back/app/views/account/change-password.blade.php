@extends('layouts.three-col')

@section('content')

<h1 class="page_title_primary">Account - <span class="h_alt">{{ $me->nicename }}</span></h1>

<div id="col_1">
	<div class="js_accordion" data-multiple="true">
        @include('account.sidebar', ['page' => 'password'])
	</div>
</div>
<div id="col_3" role="aside">
    @include('account.activity-widget', [])
</div>

<div id="col_2" role="main">
    <div class="h1 page_title page_title_duplicate">Account - <span class="h_alt">{{ $me->nicename }}</span></div>
    
    <div><h2 class="page_sub_title">Change Account Password</h2></div>
    
    <form action="{{ url('/account/change-password') }}" method="post">
        <fieldset>
            <legend>Change Account Password</legend>
            
            <div class="f_row">
                <label for="passwordOld">Old password:</label>
                <input type="password" class="text w_bp_large" name="password" id="passwordOld" required aria-required />
            </div>
            
            <div class="f_row">
                <label for="passwordNew">New password:</label>
                <input type="password" class="text w_bp_large" name="new_pass" id="passwordNew" required aria-required />
            </div>
            
            <div class="f_row">
                <label for="passwordVerify">Verify password:</label>
                <input type="password" class="text w_bp_large" name="pass_confirm" id="passwordVerify" required aria-required />
            </div>
            
            <div class="btns dbl_mt">
                <button type="submit">Change Password</button>
            </div>
            
            <div class="f_comment dbl_m">
                Please note, a confirmation email will be sent to the email address associated to this account. 
            </div>
        </fieldset>
    </form>
    
</div>

@stop
