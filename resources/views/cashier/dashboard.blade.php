@extends('layouts.master')

@section('title')
    <h1 class="m-0">{{ $menu }}</h1>
@endsection

@section('breadcumb')
    @parent
    <li class="breadcrumb-item active">{{ $menu }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body text-center">
                        <h1>Welcome, {{ Auth::user()->name }}</h1><br>
                        <h2>You're logged in Cashier</h2><br><br>
                        <a href="{{ route('transaction.new') }}" class="btn btn-success">
                            <i class="icon fas fa-plus"></i> New Transaction
                        </a><br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $("body").addClass("sidebar-collapse");
        });
    </script>
@endpush
