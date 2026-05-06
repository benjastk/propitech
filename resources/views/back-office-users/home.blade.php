@extends('back-office-users.layouts.app')
@section('content')
<main id="content" class="bg-gray-01">
    <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
        <div class="d-flex flex-wrap flex-md-nowrap mb-6">
        <div class="mr-0 mr-md-auto">
            <h2 class="mb-0 text-heading fs-22 lh-15">Welcome back, {{ $user->name }} {{ $user->apellido }}!</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. At iusto, laboriosam. Atque</p>
        </div>
        <div>
            <a href="dashboard-add-new-property.html" class="btn btn-primary btn-lg">
            <span>Add New Property</span>
            <span class="d-inline-block ml-1 fs-20 lh-1"><svg class="icon icon-add-new"><use
                xlink:href="#icon-add-new"></use></svg></span>
            </a>
        </div>
        </div>
    </div>
</main>
@endsection