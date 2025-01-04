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
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $total_category }}</h3>

                        <p>Total Category</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-th"></i>
                    </div>
                    <a href="{{ route('category.index') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $total_product }}</h3>

                        <p>Total Product</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cubes"></i>
                    </div>
                    <a href="{{ route('product.index') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $total_member }}</h3>

                        <p>Total Member</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <a href="{{ route('member.index') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $total_supplier }}</h3>

                        <p>Total Supplier</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <a href="{{ route('supplier.index') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Income Recap Report ( {{ indonesia_date(date("Y-m-01"), false) }} -
                            {{ indonesia_date(date("Y-m-d"), false) }} )</h5>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="chart">
                                    <!-- Income Recap Chart Canvas -->
                                    <canvas id="incomeRecapChart" height="180" style="height: 180px"></canvas>
                                </div>
                                <!-- /.chart-responsive -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- ./card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            'use strict'

            $("body").addClass("sidebar-collapse");

            //-----------------------
            // - INCOME RECAP CHART -
            //-----------------------

            var incomeRecapChartCanvas = $('#incomeRecapChart').get(0).getContext('2d');

            var incomeRecapChartData = {
                labels: {{ json_encode($data_date) }},
                datasets: [{
                    label: 'Income',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: {{ json_encode($data_income) }}
                }]
            };

            var incomeRecapChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: true
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: true
                        }
                    }]
                }
            };

            var incomeRecapChart = new Chart(incomeRecapChartCanvas, {
                type: 'line',
                data: incomeRecapChartData,
                options: incomeRecapChartOptions
            });

            //---------------------------
            // - END INCOME RECAP CHART -
            //---------------------------
        });
    </script>
@endpush
