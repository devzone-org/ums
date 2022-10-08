@extends('ums::layouts.master')

@section('title') Permissions @endsection

@section('content')

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        @include('ums::include.sidebar')
        @livewire('permissions-list')
    </div>
@endsection
