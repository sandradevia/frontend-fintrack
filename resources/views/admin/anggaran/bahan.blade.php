@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Setup Anggaran" />
    @livewire('admin.anggaran-table')
@endsection