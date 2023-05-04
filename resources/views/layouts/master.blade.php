@if(env('UMS_BOOTSTRAP') == 'true')
    <style>
        /* define the background colors for the striped effect */
        select.stripe option:nth-child(odd) {
            background-color: #f2f2f2;
        }
        select.stripe option:nth-child(even) {
            background-color: #fff;
        }
    </style>
    @include('layouts.master')
@else
    @include('ums::include.master-layout')
@endif