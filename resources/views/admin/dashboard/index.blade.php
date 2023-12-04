@extends('admin.layout.app')

@push('before-styles')
@endpush

@section('content')
    @if($position == "Home")
        @include('admin.dashboard.home')
    @endif
@stop

@push('after-scripts')

@endpush