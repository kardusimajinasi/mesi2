@extends('layouts/app')
@endsection
@push('styles')
<style>

</style>
@endpush
@section('content')
<p>Selamat datang, {{ Auth::user()->username }}</p>
GONE administrator
@endsection
@push('scripts')
<script>

</script>
@endpush
