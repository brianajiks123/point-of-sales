<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard.index') }}" class="brand-link">
        <img src="{{ $setting->path_logo ? url($setting->path_logo) : asset('admin/img/AdminLTELogo.png') }}"
            alt="Point Of Sale v1 Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8" />
        <span class="brand-text font-weight-light">{{ $setting->company_name ?? config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ Auth::user()->profile_photo_path ? url(Auth::user()->profile_photo_path) : asset('admin/img/user2-160x160.jpg') }}"
                    class="img-circle elevation-2 img_profile" alt="User Image" />
            </div>
            <div class="info">
                <a href="{{ route('user.profile') }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if (Auth::user()->current_team_id == 1)
                    <li class="nav-header">MASTER</li>
                    <li class="nav-item">
                        <a href="{{ route('category.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>Category</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('product.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-cubes"></i>
                            <p>Product</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('member.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-id-card"></i>
                            <p>Member</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('supplier.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Supplier</p>
                        </a>
                    </li>

                    <li class="nav-header">TRANSACTION</li>
                    <li class="nav-item">
                        <a href="{{ route('expense.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-money-bill-alt"></i>
                            <p>Expense</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('purchase.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Purchase</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sale.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>Sale</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('transaction.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-cart-arrow-down"></i>
                            <p>Active Transaction</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('transaction.new') }}" class="nav-link">
                            <i class="nav-icon fas fa-cart-plus"></i>
                            <p>New Transaction</p>
                        </a>
                    </li>

                    <li class="nav-header">REPORT</li>
                    <li class="nav-item">
                        <a href="{{ route('report.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Report</p>
                        </a>
                    </li>

                    <li class="nav-header">USER MANAGEMENT</li>
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>User</p>
                        </a>
                    </li>

                    <li class="nav-header">SYSTEM</li>
                    <li class="nav-item">
                        <a href="{{ route('setting.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>Settings</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link"
                            onclick="document.getElementById('logout-form').submit()">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                @else
                    <li class="nav-header">TRANSACTION</li>
                    <li class="nav-item">
                        <a href="{{ route('transaction.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-cart-arrow-down"></i>
                            <p>Active Transaction</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('transaction.new') }}" class="nav-link">
                            <i class="nav-icon fas fa-cart-plus"></i>
                            <p>New Transaction</p>
                        </a>
                    </li>
                    <li class="nav-header">SYSTEM</li>
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link"
                            onclick="document.getElementById('logout-form').submit()">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

{{-- Form Logout --}}
<form action="{{ route('logout') }}" method="post" class="d-none" id="logout-form">
    @csrf
</form>
