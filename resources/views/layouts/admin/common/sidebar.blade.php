<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light ml-3">{{ config('app.name', 'Tube Well Scheme') }}</span>
    </a>

    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/admin/images/user_default_logo.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('admin.profile') }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('work-orders.index') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-house"></i>
                        <p>
                            Work Order
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ra.index') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-file-invoice"></i>
                        <p>
                            RA
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('report.index') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-file-excel"></i>
                        <p>
                            Report
                        </p>
                    </a>
                </li>
				@foreach(get_master_phase() as $master_phase)
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
							{{ $master_phase->name }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('gram-panchayats.index', $master_phase->slug) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>GramPanchayats</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('items.index', $master_phase->slug) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Items</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('units.index', $master_phase->slug) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Units
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('legend.index', $master_phase->slug) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Legend</p>
                            </a>
                        </li>
                    </ul>
                </li>
				@endforeach
            </ul>
        </nav>
    </div>
</aside>
