@extends('ums::layouts.master')

@section('title')
    Activity Details
@endsection

@if(env('UMS_BOOTSTRAP') == 'true')
    @section('content')
        <div class="content-wrapper h-auto">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <h1>Activity Details</h1>
                        </div>
                    </div>
                </div>
            </div>
            @livewire('activity-details',['id'=>$id])
        </div>
    @endsection
@else
    @section('content')
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
            @include('ums::include.sidebar')
            @livewire('activity-details',['id'=>$id])
        </div>
    @endsection
@endif
