@if( session()->has('flash_message'))
    <div class="alert alert-info alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </button>
        {{ session()->get('flash_message') }}
    </div>
@endif