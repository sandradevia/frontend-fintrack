@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Profil Pengguna" />

    <div class="grid grid-cols-1 gap-6">
        @include('admin.profile.personal-info-card')
    </div>
@endsection