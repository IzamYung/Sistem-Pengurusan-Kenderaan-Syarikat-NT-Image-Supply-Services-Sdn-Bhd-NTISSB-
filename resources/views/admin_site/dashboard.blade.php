@extends('admin_site.layout.layout')

@section('title', 'Halaman Utama')

@section('content')
    <h1 class="text-3xl font-bold text-center mt-20">Welcome Admin 👑</h1>
    <pre>{{ print_r(Auth::user(), true) }}</pre>
@endsection