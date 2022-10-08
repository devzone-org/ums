@extends('ums::layouts.master')

@section('title') Users @endsection

@section('content')

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        @include('ums::include.sidebar')
        @livewire('permission-detail',['id'=>$id])
    </div>
@endsection
