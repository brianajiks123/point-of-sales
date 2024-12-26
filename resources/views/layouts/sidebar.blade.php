<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('dashboard') }}" class="brand-link">
        <img src="{{ asset('admin/img/AdminLTELogo.png') }}" alt="Point Of Sale v1 Logo" class="brand-image img-circle elevation-3"
            style="opacity: 0.8" />
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('admin/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image" />
            </div>
            <div class="info">
                <a href="{{ url('profile') }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ url('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">MASTER</li>
                <li class="nav-item">
                    <a href="{{ url('category') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Category</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('product') }}" class="nav-link">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>Product</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('member') }}" class="nav-link">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>Member</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('supplier') }}" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Supplier</p>
                    </a>
                </li>

                <li class="nav-header">TRANSACTION</li>
                <li class="nav-item">
                    <a href="{{ url('expense') }}" class="nav-link">
                        <i class="nav-icon fas fa-money-bill-alt"></i>
                        <p>Expense</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('purchase') }}" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Purchase</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('sale') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Sale</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('old-transaction') }}" class="nav-link">
                        <i class="nav-icon fas fa-cart-arrow-down"></i>
                        <p>Old Transaction</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('new-transaction') }}" class="nav-link">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p>New Transaction</p>
                    </a>
                </li>

                <li class="nav-header">REPORT</li>
                <li class="nav-item">
                    <a href="{{ url('report') }}" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Report</p>
                    </a>
                </li>

                <li class="nav-header">REPORT</li>
                <li class="nav-item">
                    <a href="{{ url('user') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>User</p>
                    </a>
                </li>

                <li class="nav-header">SYSTEM</li>
                <li class="nav-item">
                    <a href="{{ url('settings') }}" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Settings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" onclick="document.getElementById('logout-form').submit()">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
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
