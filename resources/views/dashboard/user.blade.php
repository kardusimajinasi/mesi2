@extends('layouts.app')
@endsection
@push('styles')
<style>

</style>
@endpush
@section('content')
@php
    dd(Auth::user(), Auth::user()->level, Auth::user()->instansi);
@endphp
<p>Selamat datang, {{ Auth::user()->username }}</p>
GONE user

@endsection
@push('scripts')
<script>

</script>
@endpush
