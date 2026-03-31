@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Saldo Awal Buku" />
        <div class="grid grid-cols-1 gap-6">
        @include('admin.awal-buku.saldo-awal-buku')
        @include('admin.awal-buku.tabel-saldo')
    </div>
@endsection