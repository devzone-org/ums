@extends('ums::layouts.master')

@section('title')
    Manage Roles
@endsection

@section('content')
    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        @include('ums::include.sidebar')
        <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
        @livewire('manage-roles')
        @livewire('activity-details',['id'=>null ,'log_name'=>'ManageRole'])
        </div>
    </div>
@endsection
