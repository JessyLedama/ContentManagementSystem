@extends('main')

@section('title', 'Dashboard | ' . config('app.name'))

@section('content')

    <section class="clearfix">
        @include('dashboard.menu')

        <article class="card pull-right">
            <div id="category-list">
                <h4 class="clearfix desktop">
                    <span class="pull-left">
                        Dashboard
                    </span>
                </h4>

                <div class="clearfix mobile">
                    <h4>
                        <a href="{{ route('dashboard.menu') }}" id="back-to-menu">
                            <i class="lnr lnr-arrow-left"></i>
                        </a>
                        
                        Department
                    </h4>

                    <a href="{{ route('category.create') }}">
                        <i class="lnr lnr-file-add"></i>
                        Add department
                    </a>
                </div>

                @if (session()->has('success'))
                    <span class="alert alert-success">
                        {{ session('success') }}
                    </span>
                @endif

                <div class="row">
                    <div class="dasboard-card col-md-4">
                        <span class="dashboard-card">
                            <span> Categories </span>
                            {{ $categoriesCount }}
                        </span>

                        <span class="dashboard-card">
                            <span> Sub Categories </span>
                            {{ $subCategoriesCount }}
                        </span>

                        <span class="dashboard-card">
                            <span> Members </span>
                            {{ $usersCount }}
                        </span>
                    </div>

                    
                </div>

            </div>
        </article>
    </section>

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
@endsection