@extends('ums::layouts.master')

@section('title') Edit User @endsection

@section('content')

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        @include('ums::include.sidebar')
        <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
            @livewire('edit-user',['id' => $id])
            @livewire('ip-restriction',['id'=>$id])
            @livewire('schedule',['id'=>$id])
            @livewire('permission',['id'=>$id])
        </div>
    </div>
@endsection
