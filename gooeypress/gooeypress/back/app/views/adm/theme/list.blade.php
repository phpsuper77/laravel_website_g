@extends('layouts.admin')

@section('content')

<style type="text/css">
.meta{
    display:none;
}
</style>


<!-- Main Content Area -->
<div class="row">
    <div class="col-md-12">
        <div class="grid simple">
            <div class="grid-title no-border" style="position:relative">
                <h4>Themes</h4>
                <form class="form-inline" action="{{ url('adm/theme/list') }}" method="GET" style="right:26px;top:10px;position:absolute;">
                    <input class="form-control" type="text" name="q" value="{{{ Input::get('q') }}}" />
                    <input class="btn btn-primary" type="submit" value="Search" />
                </form>
            </div>
            <div class="grid-body no-border">

<table width="100%" class="table table-striped">
<thead>
    <tr>
        <th>#</th>
        <th width="30%">Theme Name</th>
        <th>Vendor</th>
        <th>Author</th>
        <th>Grade</th>
        <th>n Complete</th>
        <th>Updated</th>
    </tr>
</thead>
<tbody>
@foreach($themes as $theme)
    <tr>
        <td>{{ $theme->id }}</td>
        <td>{{ $theme->title }}
            <div class="meta">
<a href="{{ url('adm/theme/'. $theme->id) }}">Edit</a> |
<a onclick="return confirm('Are you sure?');" href="{{ url('adm/theme/'. $theme->id . '/delete') }}">Delete</a> |
<a href="{{{ $theme->link_purchase }}}">View Theme</a> |
<a href="{{{ $theme->link_demo }}}">View Demo</a>
            </div>
        </td>
        @if($theme->vendor_id)
            <td><a href="{{ url('adm/theme/list') }}?vendor={{$theme->vendor_id}}">{{ $theme->vendor->name }}</a></td>
        @else
            <td><a href="{{ url('adm/theme/list') }}?vendor=0">- None -</a></td>
        @endif
        @if($theme->author_id)
            <td><a href="{{ url('adm/theme/list') }}?author={{$theme->author_id}}">{{ $theme->author->name }}</a></td>
        @else
            <td><a href="{{ url('adm/theme/list') }}?vendor={{$theme->vendor_id}}">- Same as vendor -</a></td>
        @endif
        <td><a href="{{ url('adm/theme/list') }}?grade={{$theme->level}}">{{ $theme->level }}</a></td>
        <td>{{ $theme->n_complete }}</td>
        <td>{{ $theme->updated_at }}</td>
    </tr>
@endforeach
</tbody>
</table>

{{ $themes->appends($filters)->links(); }}
                    </div>
                </div>
            </div>
        </div><!-- .row -->
    
<!-- /End Content Area -->

<script type="text/javascript">
$('tr').hover(function(){
    $(this).find('div.meta').show();
}, function(){
    $(this).find('div.meta').hide();
});
</script>

@stop
