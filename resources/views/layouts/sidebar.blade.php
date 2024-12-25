<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img src="{{ asset('admin/assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow" />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">{{ config('app.name') }}</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Master Data --}}
                <li class="nav-header">MASTER</li>
                <li class="nav-item">
                    <a href="{{ url('/category') }}" class="nav-link">
                        <i class="nav-icon bi bi-ui-checks-grid"></i>
                        <p>Category</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/product') }}" class="nav-link">
                        <i class="nav-icon bi bi-boxes"></i>
                        <p>Product</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/member') }}" class="nav-link">
                        <i class="nav-icon bi bi-person-vcard"></i>
                        <p>Member</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/supplier') }}" class="nav-link">
                        <i class="nav-icon bi bi-box-seam"></i>
                        <p>Supplier</p>
                    </a>
                </li>

                {{-- Transaction --}}
                <li class="nav-header">TRANSACTION</li>
                <li class="nav-item">
                    <a href="{{ url('/expense') }}" class="nav-link">
                        <i class="nav-icon bi bi-journal-arrow-down"></i>
                        <p>Expense</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/purchase') }}" class="nav-link">
                        <i class="nav-icon bi bi-cash-coin"></i>
                        <p>Purchase</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/sale') }}" class="nav-link">
                        <i class="nav-icon bi bi-bag"></i>
                        <p>Sale</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/old-transaction') }}" class="nav-link">
                        <i class="nav-icon bi bi-journal-bookmark"></i>
                        <p>Old Transaction</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/new-transaction') }}" class="nav-link">
                        <i class="nav-icon bi bi-cart"></i>
                        <p>New Transaction</p>
                    </a>
                </li>

                {{-- Report --}}
                <li class="nav-header">REPORT</li>
                <li class="nav-item">
                    <a href="{{ url('/report') }}" class="nav-link">
                        <i class="nav-icon bi bi-journal"></i>
                        <p>Report</p>
                    </a>
                </li>

                {{-- System --}}
                <li class="nav-header">SYSTEM</li>
                <li class="nav-item">
                    <a href="{{ url('/user') }}" class="nav-link">
                        <i class="nav-icon bi bi-people"></i>
                        <p>User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/settings') }}" class="nav-link">
                        <i class="nav-icon bi bi-gear"></i>
                        <p>Settings</p>
                    </a>
                </li>
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->
