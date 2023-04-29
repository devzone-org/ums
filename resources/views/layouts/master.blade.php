@if(env('UMS_BOOTSTRAP') == 'true')
    @include('layouts.master')
@else
    @include('ums::include.master-layout')
@endif