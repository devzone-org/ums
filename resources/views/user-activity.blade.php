@extends('ums::layouts.master')

@section('title')
    User Activity
@endsection

@if(env('UMS_BOOTSTRAP') == 'true')
    @section('content')
        <div class="content-wrapper h-auto">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <h1>User Activity</h1>
                        </div>
                    </div>
                </div>
            </div>
            @livewire('user-activity')
        </div>
    @endsection
@else
    @section('content')
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
            @include('ums::include.sidebar')
            @livewire('user-activity')
        </div>
    @endsection
@endif
