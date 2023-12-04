@extends('admin.layout.app')

@push('before-styles')
@endpush

@section('content')
    @if($position == "Payment History")
        @include('admin.payment.history')
    @elseif($position == "Form Edit Payment")
        @include('admin.payment.form')
    @endif
@stop

@push('after-scripts')
@include('admin.payment.script')

@endpush