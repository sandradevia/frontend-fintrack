@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Saldo Awal Buku" />
        <x-saldo.saldo-awal-buku />
        <x-saldo.tabel-saldo />
@endsection