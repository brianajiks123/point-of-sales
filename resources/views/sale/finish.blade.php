@extends('layouts.master')

@section('title')
    <h3 class="mb-0">{{ $menu }}</h3>
@endsection

@section('breadcumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">{{ $menu }}</li>
@endsection

@section('content')
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="alert alert-success alert-dismissible">
                                <i class="fas fa-check icon"></i>
                                Transaction has finished.
                            </div>

                            <div class="mt-3">
                                @if ($setting->note_type == 1)
                                    <button class="btn btn-warning"
                                        onclick="printSmallNote('{{ route('transaction.small_note') }}', 'Small Note')">Print
                                        Note</button>
                                @else
                                    <button class="btn btn-warning"
                                        onclick="printBigNote('{{ route('transaction.big_note') }}', 'Big Note')">Print
                                        Note</button>
                                @endif
                                <a href="{{ route('transaction.new') }}" class="btn btn-primary">New Transaction</a>
                            </div>
                        </div>
                        <!-- ./card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
    </div>
@endsection

@push('scripts')
    <script>
        $("body").addClass("sidebar-collapse");

        function printSmallNote(url, title) {
            // Open Pop-up Window
            centerPopup(url, title, 625, 500);
        }

        function printBigNote(url, title) {
            // Open Pop-up Window
            centerPopup(url, title, 900, 675);
        }

        // Centered Pop-up Window
        function centerPopup(url, title, w, h) {
            const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screenX;
            const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screenY;

            const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document
                .documentElement.clientWidth : screen.width;
            const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document
                .documentElement.clientHeight : screen.height;

            const systemZoom = width / window.screen.availWidth;
            const left = (width - w) / 2 / systemZoom + dualScreenLeft;
            const top = (height - h) / 2 / systemZoom + dualScreenTop;
            const newWindow = window.open(url, title,
                `scrollbars=yes, width=${w / systemZoom}, height=${h / systemZoom}, top=${top}, left=${left}`);

            if (window.focus) newWindow.focus();
        }
    </script>
@endpush
