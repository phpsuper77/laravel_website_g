@if(Session::has('flash_message'))
    <div class="alert-wrapper">
        <div class="alert alert-info">
            <p>{{ Session::get('flash_message') }}</p>
        </div>
    </div>
@endif