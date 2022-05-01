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
                    @if (doPermitted('//tickets/enroll'))
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
                                            <h3 class="warning">{{ $total_transports }}</h3>
                                            <h6>Total Transports</h6>
                                        </div>
                                        <div>
                                            <i class="la la-subway warning font-large-2 float-right"></i>
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
                                            <h3 class="success">{{ $total_events }}</h3>
                                            <h6>Total Events</h6>
                                        </div>
                                        <div>
                                            <i class="la la-birthday-cake success font-large-2 float-right"></i>
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
                                            <h3 class="danger">{{$total_lectures}}</h3>
                                            <h6>Total Lectures</h6>
                                        </div>
                                        <div>
                                            <i class="la la-graduation-cap danger font-large-2 float-right"></i>
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

                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h3 class="danger">{{$total_payment_requests}}</h3>
                                            <h6>Total Payment Requests</h6>
                                        </div>
                                        <div>
                                            <i class="la la-money primary font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-primary" role="progressbar"
                                            style="width: 100%" aria-valuenow="100100" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Timetable</h4>
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

                                            <div id='calendar'></div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Registered Events</h4>
                                <a class="heading-elements-toggle">
                                    <i class="la la-ellipsis-v font-medium-3"></i>
                                </a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                    </ul>
                                </div>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body pt-0">
                                    <div class="row mb-1">
                                        <div class="col-md-12">

                                            <div class="card-content collapse show">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table w-100" id="event_dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Title</th>
                                                                    <th>Time Schedule</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Registered Lectures</h4>
                                <a class="heading-elements-toggle">
                                    <i class="la la-ellipsis-v font-medium-3"></i>
                                </a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                    </ul>
                                </div>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body pt-0">
                                    <div class="row mb-1">
                                        <div class="col-md-12">

                                            <div class="card-content collapse show">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table w-100" id="lecture_dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Lecture Name</th>
                                                                    <th>Date</th>
                                                                    <th>Start Time</th>
                                                                    <th>End Time</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
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

            </div>
        </div>
    </div>

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    @include('layouts.footer')

    @include('layouts.scripts')

    <script>
        console.log(@json($calenderData));

        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            navLinks: true,
            businessHours: true,
            editable: true,
            selectable: true,
            events: @json($calenderData)
        });

        calendar.render();

        let event_listTable = $('#event_dataTable').DataTable({
            lengthMenu: [
                [5, 10, 25, -1],
                [5, 10, 25, "All"]
            ],
            serverSide: true,
            responsive: true,
            language: {
                searchPlaceholder: "Search By Name"
            },
            ajax: "{{ route('admin.dashboard.events.list') }}",
            columns: [{
                    name: 'title'
                },
                {
                    name: 'start'
                },
                {
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
            ],
            createdRow: function(row, data, dataIndex, cells) {
                $(cells).addClass(' align-middle datatables-sm');
            }
        });

        let lecture_listTable = $('#lecture_dataTable').DataTable({
            lengthMenu: [
                [5, 10, 25, -1],
                [5, 10, 25, "All"]
            ],
            serverSide: true,
            responsive: true,
            language: {
                searchPlaceholder: "Search By Name"
            },
            ajax: "{{ route('admin.dashboard.lecture.list') }}",
            columns: [{
                    name: 'name'
                },
                {
                    name: 'conduct_date'
                },
                {
                    name: 'start_time'
                },
                {
                    name: 'end_time'
                },
                {
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
            ],
            createdRow: function(row, data, dataIndex, cells) {
                $(cells).addClass(' align-middle datatables-sm');
            }
        });
    </script>
@endsection
