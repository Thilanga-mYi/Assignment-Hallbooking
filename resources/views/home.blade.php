@extends('layouts.app')

@section('content')
    @include('layouts.navbar')
    @include('layouts.sidebar')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="row">
                     @if(doPermitted('//tickets/enroll'))
                    <div class="col-xl-3 col-lg-6 col-12">
                        <a href="/invoice">
                            <div class="card pull-up">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="info">Create Ticket</h3>
                                                <h6>Click Here</h6>
                                            </div>
                                            <div>
                                                <i class="mbri-edit info font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                            <div class="progress-bar bg-gradient-x-info" role="progressbar"
                                                style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h3 class="warning">{{ $pendingCount }}</h3>
                                            <h6>Pending Tickets</h6>
                                        </div>
                                        <div>
                                            <i class="la la-ticket warning font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-warning" role="progressbar"
                                            style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h3 class="success">{{ $officersCount }}</h3>
                                            <h6>Total Officers</h6>
                                        </div>
                                        <div>
                                            <i class="la la-user success font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-success" role="progressbar"
                                            style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h3 class="danger">{{ $ticketsCount }}</h3>
                                            <h6>Monthly Tickets</h6>
                                        </div>
                                        <div>
                                            <i class="la la-money danger font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-danger" role="progressbar"
                                            style="width: 100%" aria-valuenow="100100" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Sales Chart</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body pt-0">
                                    <div class="row mb-1">
                                        <div class="col-md-12">
                                            <canvas id="monthlysales" width="400" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    @include('layouts.footer')

    @include('layouts.scripts')

    <script>
        const ctx = document.getElementById('monthlysales').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($dates),
                datasets: [{
                    label: 'Sales of last ten days',
                    data: @json($tickets),
                    backgroundColor: [
                        'rgba(16, 135, 211, 1)',
                        'rgba(255, 115, 24, 1)',
                        'rgba(34, 167, 120, 1)',
                        'rgba(255, 24, 55, 1)',
                        'rgba(16, 135, 211, 1)',
                        'rgba(255, 115, 24, 1)',
                        'rgba(34, 167, 120, 1)',
                        'rgba(255, 24, 55, 1)',
                        'rgba(16, 135, 211, 1)',
                        'rgba(255, 115, 24, 1)'
                    ],
                    borderColor: [
                        'rgba(16, 135, 211, 1)',
                        'rgba(255, 115, 24, 1)',
                        'rgba(34, 167, 120, 1)',
                        'rgba(255, 24, 55, 1)',
                        'rgba(16, 135, 211, 1)',
                        'rgba(255, 115, 24, 1)',
                        'rgba(34, 167, 120, 1)',
                        'rgba(255, 24, 55, 1)',
                        'rgba(16, 135, 211, 1)',
                        'rgba(255, 115, 24, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>



@endsection
