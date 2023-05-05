@extends('ums::layouts.master')

@section('title') Change Password @endsection

@if(env('UMS_BOOTSTRAP') == 'true')
    @section('content')
        <div class="content-wrapper h-auto">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <h1>Change Password</h1>
                        </div>
                    </div>
                </div>
            </div>
            @livewire('change-password')
        </div>
    @endsection
@else
    @section('content')
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
            @include('ums::include.sidebar')
            @livewire('change-password')
        </div>
    @endsection
@endif
