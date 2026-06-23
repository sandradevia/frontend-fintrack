@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Setup Anggaran" />
    @livewire('super.anggaran-table')
@endsection