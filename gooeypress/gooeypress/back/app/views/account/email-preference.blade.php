@extends('layouts.three-col')

@section('content')

<h1 class="page_title_primary">Account - <span class="h_alt">{{ $me->nicename }}</span></h1>

<div id="col_1">
	<div class="js_accordion" data-multiple="true">
        @include('account.sidebar', ['page' => 'email'])
	</div>
</div>
<div id="col_3" role="aside">
    @include('account.activity-widget', [])
</div>

<div id="col_2" role="main">
    <div class="h1 page_title page_title_duplicate">Account - <span class="h_alt">{{ $me->nicename }}</span></div>
    
    <div><h2 class="page_sub_title">Email Notification Preferences</h2></div>
    
    <form action="{{ url('/account/email-preference') }}" method="post">
        <fieldset class="rc rc_no_ml">
            <legend>Email Notification Preferences</legend>

            <ul class="dbl_mb">
                <li>
                    {{ Form::checkbox('updates', 'true', $pref->updates, ['id' => 'pref1']) }}
                    <label for="pref1">Recieve infrequent Gooeypress notifications, updates and announcements.</label>
                </li>
                <li>
                    {{ Form::checkbox('products', 'true', $pref->products, ['id' => 'pref2']) }}
                    <label for="pref2">Get notifications on top new products</label>
                </li>
                <li>
                    {{ Form::checkbox('free_themes', 'true', $pref->free_themes, ['id' => 'pref3']) }}
                    <label for="pref3">Get notifications when new free themes come online. </label>
                </li>
                <li>
                    {{ Form::checkbox('recommendations', 'true', $pref->recommendations, ['id' => 'pref4']) }}
                    <label for="pref4">Get new recommendations each week</label>
                </li>
                <li>
                    {{ Form::checkbox('blog', 'true', $pref->blog, ['id' => 'pref5']) }}
                    <label for="pref5">Get notifications of blog posts</label>
                </li>
                <li>
                    {{ Form::checkbox('give_aways', 'true', $pref->give_aways, ['id' => 'pref6']) }}
                    <label for="pref6">Get notification on competions and free give aways</label>
                </li>
            </ul>
            
            <div class="btns dbl_mt btns_no_ml">
                <button type="submit">Change Preferences</button>
            </div>
        </fieldset>
    </form>
    
</div>

@stop
