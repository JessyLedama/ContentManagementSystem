<aside class="card pull-left">
    <ul>
        <li>
            <a href="{{ route('dashboard') }}" > 
                DASHBOARD 

                <span class="pull-right toggle-icon">
                    <i class="lni-chevron-right"></i>
                </span>
            </a>

        </li>
        
        <li>
            <div data-toggle="categories-sub-menu" class="toggle-sub-menu clearfix">
                <span class="pull-left">
                    CATEGORIES
                </span>

                <span class="pull-right toggle-icon">
                    <i class="lni-chevron-down"></i>
                </span>
            </div>

            <ul id="categories-sub-menu" class="sub-menu">
                <li>
                    <a href="{{ route('category.index') }}">
                        ALL CATEGORIES
                    </a>
                </li>
                <li>
                    <a href="{{ route('category.create') }}">
                        ADD CATEGORIES
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <div data-toggle="subcategories-sub-menu" class="toggle-sub-menu clearfix">
                <span class="pull-left">
                    SUB-CATEGORIES
                </span>

                <span class="pull-right toggle-icon">
                    <i class="lni-chevron-down"></i>
                </span>
            </div>

            <ul id="subcategories-sub-menu" class="sub-menu">
                <li>
                    <a href="{{ route('subcategory.index') }}">
                        ALL SUB-CATEGORIES
                    </a>
                </li>
                <li>
                    <a href="{{ route('subcategory.create') }}">
                        ADD SUB-CATEGORY
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <div data-toggle="products-sub-menu" class="toggle-sub-menu clearfix">
                <span class="pull-left">
                    MEMBERS
                </span>

                <span class="pull-right toggle-icon">
                    <i class="lni-chevron-down"></i>
                </span>
            </div>

            <ul id="products-sub-menu" class="sub-menu">
                <li>
                    <a href="{{ route('product.index') }}">
                        ALL MEMBERS
                    </a>
                </li>
                <li>
                    <a href="{{ route('product.create') }}">
                        ADD MEMBER
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
</aside>

@push('script')
    <script>
        jQuery(document).ready(function ($) {

            // Toggle drop down sub-menu
            $('.toggle-sub-menu').click(function () {

                $(`*[data-toggle="${$(this).attr('data-toggle')}"] .toggle-icon`).toggleClass('drop');

                $('#' + $(this).attr('data-toggle')).fadeToggle();
            });

            // Show dropdown with current page link
            switch ('{{ url()->current() }}') {

                case "{{ route('category.index') }}":
                case "{{ route('category.create') }}":

                    $('#categories-sub-menu').css('display', 'block');
                    $('*[data-toggle="categories-sub-menu"], #categories-sub-menu').addClass('link-active');
                    break;

                case "{{ route('subcategory.index') }}":
                case "{{ route('subcategory.create') }}":

                    $('#subcategories-sub-menu').css('display', 'block');
                    $('*[data-toggle="subcategories-sub-menu"], #subcategories-sub-menu').addClass('link-active');
                    break;

                case "{{ route('product.index') }}":
                case "{{ route('product.create') }}":

                    $('#products-sub-menu').css('display', 'block');
                    $('*[data-toggle="products-sub-menu"], #products-sub-menu').addClass('link-active');
                    break;
            }

            // Highlight cuurent page link
            $(`a[href="{{ url()->current() }}"]`).addClass('link-active');

            // Invert drop-down icon for active link
            $('.toggle-sub-menu.link-active .toggle-icon').toggleClass('drop')
        });
    </script>
@endpush