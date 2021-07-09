@extends('ums::layouts.master')

@section('title') Change Password @endsection

@section('content')

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        @include('ums::include.sidebar')
        @livewire('change-password')
    </div>
@endsection
