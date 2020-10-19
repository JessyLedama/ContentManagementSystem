@extends('main')

@section('title', 'My Account Links')

@section('content')
    <section>
        <ul class="card">
            
            <li>
                <div data-toggle="categories-sub-menu" class="toggle-sub-menu clearfix">
                    <span class="pull-left">
                        Departments
                    </span>
    
                    <span class="pull-right toggle-icon">
                        <i class="lni-chevron-down"></i>
                    </span>
                </div>
    
                <ul id="categories-sub-menu" class="sub-menu">
                    <li>
                        <a href="{{ route('category.index') }}">
                            All Departments
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('category.create') }}">
                            Add Department
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <div data-toggle="subcategories-sub-menu" class="toggle-sub-menu clearfix">
                    <span class="pull-left">
                        Faculties
                    </span>
    
                    <span class="pull-right toggle-icon">
                        <i class="lni-chevron-down"></i>
                    </span>
                </div>
    
                <ul id="subcategories-sub-menu" class="sub-menu">
                    <li>
                        <a href="{{ route('subcategory.index') }}">
                            All Faculties
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('subcategory.create') }}">
                            Add Faculty
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <div data-toggle="products-sub-menu" class="toggle-sub-menu clearfix">
                    <span class="pull-left">
                        Members
                    </span>
    
                    <span class="pull-right toggle-icon">
                        <i class="lni-chevron-down"></i>
                    </span>
                </div>
    
                <ul id="products-sub-menu" class="sub-menu">
                    <li>
                        <a href="{{ route('product.index') }}">
                            All members
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('product.create') }}">
                            Add member
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('account.edit') }}">
                    My Account
                </a>
            </li>
            
            <li id="dashboard-sign-out">
                <a onclick="document.getElementById('customer-logout-form').submit()">
                    Sign out
                </a>
            </li>
        </ul>
    
        <!-- logout form -->
        <form id="customer-logout-form" action="{{ route('logout') }}" method="POST">
    
            @csrf
    
        </form>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard/mobile-menu.css') }}">
@endsection

@push('script')
    <script>
        jQuery(document).ready(function ($) {

            // Toggle drop down sub-menu
            $('.toggle-sub-menu').click(function () {

                $(`*[data-toggle="${$(this).attr('data-toggle')}"] .toggle-icon`).toggleClass('drop');

                $('#' + $(this).attr('data-toggle')).fadeToggle();
            });
        });
    </script>
@endpush