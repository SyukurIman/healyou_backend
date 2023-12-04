@extends('admin.layout.app')

@push('before-styles')
@endpush

@section('content')
    @if($type == "index")
        @include('admin.data_donasi.table')
    @else
        @include('admin.data_donasi.form')
    @endif
@stop

@push('after-scripts')

@include('admin.data_donasi.script')

@endpush