@extends('layouts.admin')

@section('content')

<style type="text/css">
.new-form{
    display:none;
}
.layout-url{
    display:none;
}
.controls label{
    display:inline-block;
    margin:10px 0 15px 0;
}
</style>

<!-- Main Content Area -->

<div class="row">
    <div class="col-md-12">
        <div class="grid simple">
            <div class="grid-title no-border">
                <h4>Add new theme</h4>
            </div>
            <div class="grid-body no-border">


        
{{ Form::open(array('url' => 'adm/theme/new')) }}

{{ Form::token() }}


<div class="form-group">
    <input name="theme[title]" type="text" class="form-control input-lg" placeholder="Theme title" />
</div>

<div class="form-group">
<label>Submission notes (copy from sale page)</label>
<textarea id="" name="theme[notes]" rows="10" class="ckeditor" cols="30"></textarea>
</div>


<div class="form-group">
    <div class="controls">
        <input name="theme[price]" id="theme-price" type="text" class="small" placeholder="Price" /><br/>
        <label><input name="theme[price_type]" type="radio" value="free" /> Free</label>
        <label><input name="theme[price_type]" type="radio" value="Fixed" /> Fixed</label>
        <label><input name="theme[price_type]" type="radio" value="Membership" /> Membership</label>
    </div>
</div>

<div class="form-group">
    <input id="theme-link_purchase" name="theme[link_purchase]" type="text" class="form-control" placeholder="Link to purchase page" />
</div>
<div class="form-group">
    <input id="theme-link_demo" name="theme[link_demo]" type="text" class="form-control" placeholder="Link to demo page" />
</div>

<div class="form-group">
    <div class="controls">
        {{ Form::select('theme[vendor_id]', array_pluck($vendors, 'name', 'id'), null,
        ['class="form-control']) }}
        <br/>
        <a id="new-vendor" href="#">+ Add new vendor</a>
        <div id="new-vendor-form" class="new-form">
            <input type="text" id="new-vendor-name" class="small" /><br/>
            <a id="do-add-vendor" href="#" class="btn btn-small">Add Vendor</a>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="controls">
        {{ Form::select('theme[author_id]', array_pluck($authors, 'name', 'id'), null,
        ['class="form-control']) }}
        <br/>
        <a id="new-author" href="#">+ Add new author</a>
        <div id="new-author-form" class="new-form">
            <input type="text" id="new-author-name" class="small" /><br/>
            <a id="do-add-author" href="#" class="btn btn-small">Add Author</a>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="controls">
        {{ Form::select('theme[requirement_id]', array_pluck($requirements, 'name', 'id'), null,
        ['class="form-control']) }}
        <br/>
        <a id="new-requirement" href="#">+ Add new requirement</a>
        <div id="new-requirement-form" class="new-form">
            <input type="text" id="new-requirement-name" class="small" /><br/>
            <a id="do-add-requirement" href="#" class="btn btn-small">Add Requirement</a>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="controls">
        {{ Form::select('theme[platform_id]', array_pluck($platforms, 'name', 'id'), null,
        ['class="form-control']) }}
        <br/>
        <a id="new-platform" href="#">+ Add new platform</a>
        <div id="new-platform-form" class="new-form">
            <input type="text" id="new-platform-name" class="small" /><br/>
            <a id="do-add-platform" href="#" class="btn btn-small">Add platform</a>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="controls">
        {{ Form::select('theme[licence_id]', array_pluck($licences, 'name', 'id'), null,
        ['class="form-control']) }}
        <br/>
        <a id="new-licence" href="#">+ Add new licence</a>
        <div id="new-licence-form" class="new-form">
            <input type="text" id="new-licence-name" class="small" /><br/>
            <a id="do-add-licence" href="#" class="btn btn-small">Add licence</a>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="controls"><div id="theme-layout">
        @foreach($layouts as $layout)
        <label><input type="checkbox" name="layouts[]" value="{{$layout['id']}}">{{$layout['name']}}</label>
        @endforeach
        </div>
        <a id="new-layout" href="#">+ Add new layout</a>
        <div id="new-layout-form" class="new-form">
            <input type="text" id="new-layout-name" class="small" /><br/>
            <a id="do-add-layout" href="#" class="btn btn-small">Add Layout</a>
        </div>
        <div id="theme-layout-urls-div">
<table width="100%">
    <thead>
        <tr><td>Default</td><td></td></tr>
    </thead>
    <tbody id="theme-layout-urls">
        @foreach($layouts as $layout)
        <tr id="layout-{{$layout['id']}}-url" class="layout-url"><td><input type="radio" name="default_layout_id" value="{{$layout['id']}}" /></td>
            <td>{{$layout['name']}}<br/>
<input type="text" name="layout_url[{{$layout['id']}}]" value="" class="large" />
</td></tr>
        @endforeach
    </tbody>
</table>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="controls">
        {{ Form::select('theme[style_id]', array_pluck($styles, 'name', 'id'), null,
        ['class="form-control']) }}
        <br/>
        <a id="new-style" href="#">+ Add new style</a>
        <div id="new-style-form" class="new-form">
            <input type="text" id="new-style-name" class="small" /><br/>
            <a id="do-add-style" href="#" class="btn btn-small">Add Style</a>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="controls">
        {{ Form::select('theme[genre_id]', array_pluck($genres, 'name', 'id'), null,
        ['class="form-control']) }}
        <br/>
        <a id="new-genre" href="#">+ Add new genre</a>
        <div id="new-genre-form" class="new-form">
            <input type="text" id="new-genre-name" class="small" /><br/>
            <a id="do-add-genre" href="#" class="btn btn-small">Add Genre</a>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="controls">
        <label><input type="radio" name="theme[responsive]" value="yes" /> Responsive</label>
        <label><input type="radio" name="theme[responsive]" value="no" /> Non-Responsive</label>
    </div>
</div>

<div class="form-group">
    <div class="controls">
        <label><input type="radio" name="theme[level]" value="A" /> Grade A</label>
        <label><input type="radio" name="theme[level]" value="B" /> Grade B</label>
        <label><input type="radio" name="theme[level]" value="C" /> Grade C</label>
        <label><input type="radio" name="theme[level]" value="D" /> Grade D</label>
    </div>
</div>

<input class="btn btn-primary" type="submit" value="Add Theme" /> <a href="{{ url('adm/theme/list') }}">Cancel</a>

{{ Form::close() }}

            </div>
        </div>
    </div>
</div>

<!-- /End Content Area -->

<script type="text/javascript" src="{{ asset('static/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">

$('#theme-layout').on('click', 'input:checkbox', function(){
    var layoutIDs = $("#theme-layout input:checkbox:checked")
        .map(function(){ return $(this).val(); }).get();

    var i = 0;
    $('tr.layout-url').hide();
    for(i = 0; i < layoutIDs.length; i++){
        $('#layout-'+layoutIDs[i]+'-url').show();
    }
});

function objectNewUI(cfg){
    cfg = $.extend({
        'input' : '#new-vendor-name',
        'form' : '#new-vendor-form',
        'select' : '#theme-vendor',
        'showBtn' : '#new-vendor',
        'doBtn' : '#do-add-vendor',
        'collectionKey' : 'vendors',
        'itemKey' : 'vendor',
        'inputName' : '',
        'api' : "{{ url('adm/api/vendors') }}"
    }, cfg);

    $(cfg.showBtn).click(function(){
        $(cfg.form).toggle();
        return false;
    });
    $(cfg.doBtn).click(function(){
        var name = $(cfg.input).val();
        var i = 0;
        if(name){
            $(cfg.select).empty();

            $.post(cfg.api, {'name' : name}, function(data){
                for(i = 0; i < data[cfg.collectionKey].length; i++){
                    var item = data[cfg.collectionKey][i];
                    var selected = item.id == data[cfg.itemKey].id ? ' selected ' : '';
                    $(cfg.select).append('<option '+selected+' value="'
                        +item.id+'">'+item.name+'</option>');
                }
                $(cfg.form).hide();
            }, 'json');
        }
        return false;
    });
}
function objectNewLayoutUI(cfg){
    cfg = $.extend({
        'input' : '#new-vendor-name',
        'form' : '#new-vendor-form',
        'select' : '#theme-vendor',
        'showBtn' : '#new-vendor',
        'doBtn' : '#do-add-vendor',
        'collectionKey' : 'vendors',
        'itemKey' : 'vendor',
        'inputName' : '',
        'api' : "{{ url('adm/api/vendors') }}"
    }, cfg);

    $(cfg.showBtn).click(function(){
        $(cfg.form).toggle();
        return false;
    });
    $(cfg.doBtn).click(function(){
        var name = $(cfg.input).val();
        var i = 0;
        if(name){
            $.post(cfg.api, { name: name }, function(data){
                var item = data[cfg.itemKey];
                $(cfg.select).append('<label><input id="layout-'
                    + item.id +'" type="checkbox" checked name="'+cfg.inputName+'" value="'
                    + item.id +'" /> '+ item.name +'</label>');

                $('#theme-layout-urls').append('<tr style="display:table-row;" id="layout-'+item.id+'-url" class="layout-url"><td><input type="radio" name="default_layout_id" value="'
                    +item.id+'" /></td><td>'+item.name+'<br/><input name="layout_url['+item.id+']" value="" class="large" type="text" /></td>');
                $(cfg.form).hide();
            }, 'json');
        }
        return false;
    });
}

objectNewUI({
    'input' : '#new-vendor-name',
    'form' : '#new-vendor-form',
    'select' : '#theme-vendor',
    'showBtn' : '#new-vendor',
    'doBtn' : '#do-add-vendor',
    'collectionKey' : 'vendors',
    'itemKey' : 'vendor',
    'api' : "{{ url('adm/api/vendors') }}"
});
objectNewUI({
    'input' : '#new-author-name',
    'form' : '#new-author-form',
    'select' : '#theme-author',
    'showBtn' : '#new-author',
    'doBtn' : '#do-add-author',
    'collectionKey' : 'authors',
    'itemKey' : 'author',
    'api' : "{{ url('adm/api/authors') }}"
});
objectNewUI({
    'input' : '#new-requirement-name',
    'form' : '#new-requirement-form',
    'select' : '#theme-requirement',
    'showBtn' : '#new-requirement',
    'doBtn' : '#do-add-requirement',
    'collectionKey' : 'requirements',
    'itemKey' : 'requirement',
    'api' : "{{ url('adm/api/requirements') }}"
});

objectNewLayoutUI({
    'input' : '#new-layout-name',
    'form' : '#new-layout-form',
    'select' : '#theme-layout',
    'showBtn' : '#new-layout',
    'doBtn' : '#do-add-layout',
    'collectionKey' : 'layouts',
    'itemKey' : 'layout',
    'inputName' : 'layouts[]',
    'api' : "{{ url('adm/api/layouts') }}"
});

objectNewUI({
    'input' : '#new-style-name',
    'form' : '#new-style-form',
    'select' : '#theme-style',
    'showBtn' : '#new-style',
    'doBtn' : '#do-add-style',
    'collectionKey' : 'styles',
    'itemKey' : 'style',
    'api' : "{{ url('adm/api/styles') }}"
});

objectNewUI({
    'input' : '#new-genre-name',
    'form' : '#new-genre-form',
    'select' : '#theme-genre',
    'showBtn' : '#new-genre',
    'doBtn' : '#do-add-genre',
    'collectionKey' : 'genres',
    'itemKey' : 'genre',
    'api' : "{{ url('adm/api/genres') }}"
});

objectNewUI({
    'input' : '#new-platform-name',
    'form' : '#new-platform-form',
    'select' : '#theme-platform',
    'showBtn' : '#new-platform',
    'doBtn' : '#do-add-platform',
    'collectionKey' : 'platforms',
    'itemKey' : 'platform',
    'api' : "{{ url('adm/api/platforms') }}"
});
objectNewUI({
    'input' : '#new-licence-name',
    'form' : '#new-licence-form',
    'select' : '#theme-licence',
    'showBtn' : '#new-licence',
    'doBtn' : '#do-add-licence',
    'collectionKey' : 'licences',
    'itemKey' : 'licence',
    'api' : "{{ url('adm/api/licences') }}"
});
</script>

@stop
