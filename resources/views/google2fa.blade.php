@extends('ums::layouts.master')

@section('title') Google 2fa @endsection


    @section('content')
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
            @include('ums::include.sidebar')
            @livewire('google2fa')
        </div>
    @endsection
