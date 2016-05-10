@extends('layouts.master')

@section('content')

<style type="text/css">
.field{
margin-bottom:20px;
}
.field input, .field select{
margin-bottom:0;
}
.field label{
display:inline-block;
margin-right:20px;
}
.field label.tag{
padding:8px 0;
font-size:100%;
}
div.new-form{
    display:none;
}
</style>

<!-- Subheader -->
<div id="subheader" class="clearfix">
    <h2>Add new theme</h2>
    <a href="{{ url('adm/theme/list') }}"><span>Cancel</span></a>
</div>
<!-- /End Subheader -->

<!-- Main Content Area -->
<div id="content" ng-controller="ThemeAddCtrl" ng-init="$api.vendors = '{{ url('adm/api/vendors') }}';">
    <div id="inner">
        
{{ Form::open(array('url' => 'adm/theme/new')) }}

{{ Form::token() }}

<ul>

<li><label>Add new theme</label>
<input name="theme[title]" type="text" class="large" />
</li>

<li><label>Submission notes (copy from sale page)</label>
<textarea id="" name="theme[notes]" rows="10" class="ckeditor" cols="30"></textarea>
</li>

</ul>

<div class="field" style="margin-top:20px;">
    <div class="grid_3"><label class="tag" for="theme-price">Price</label></div>
    <div class="grid_9">
        <input name="theme[price]" id="theme-price" type="text" class="small" /><br/>
        <label><input name="theme[price_type]" type="radio" value="free" /> Free</label>
        <label><input name="theme[price_type]" type="radio" value="Fixed" /> Fixed</label>
        <label><input name="theme[price_type]" type="radio" value="Membership" /> Membership</label>
    </div>
    <div class="clear"></div>
</div>
<div class="field">
    <div class="grid_3"><label for="theme-link_purchase" class="tag">Link to purchase page</label></div>
    <div class="grid_9"><input id="theme-link_purchase" name="theme[link_purchase]" type="text" class="medium" /> </div>
    <div class="clear"></div>
</div>
<div class="field">
    <div class="grid_3"><label for="theme-link_demo" class="tag">Link to demo page</label></div>
    <div class="grid_9"><input id="theme-link_demo" name="theme[link_demo]" type="text" class="medium" /> </div>
    <div class="clear"></div>
</div>

<div class="field">
    <div class="grid_3"><label for="theme-vendor" class="tag">Vendor</label></div>
    <div class="grid_9">
        <select ng-model="vendor" ng-options="v as v.name for v in vendors"></select>
        <br/>
        <a id="new-vendor" href="#">+ Add new vendor</a>
        <div id="new-vendor-form" class="new-form">
            <input type="text" id="new-vendor-name" class="small" /><br/>
            <a id="do-add-vendor" href="#" class="new-btn button_white">Add Vendor</a>
        </div>
    </div>
    <div class="clear"></div>
</div>
{{ Form::close() }}

    </div>
</div>
<!-- /End Content Area -->

@stop
