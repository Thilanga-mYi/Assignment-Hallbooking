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
                    @include('layouts.flash')
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Timetable Slot List</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a onclick="refreshTable()" data-action="reload"><i
                                                    class="ft-rotate-cw"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table w-100" id="dataTable">
                                            <thead>
                                                <tr>
                                                    <th>Reason</th>
                                                    <th>Student</th>
                                                    <th>Lecture Hall</th>
                                                    <th>Date</th>
                                                    <th>Start Time</th>
                                                    <th>End Time</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>


                                    {{-- <div id='calendar'></div> --}}


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


    @include('layouts.footer')
    @include('layouts.scripts')
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     var calendarEl = document.getElementById('calendar');
        //     var calendar = new FullCalendar.Calendar(calendarEl, {
        //         initialView: 'dayGridMonth'
        //     });
        //     calendar.render();
        // });

        let listTable = $('#dataTable').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            serverSide: true,
            responsive: true,
            language: {
                searchPlaceholder: "Search By Name"
            },
            ajax: "{{ route('admin.studentBookedLectureHall.LIST') }}",
            columns: [{
                    name: 'reason'
                },
                {
                    name: 'student_id'
                },
                {
                    name: 'lecture_hall_id'
                },
                {
                    name: 'date'
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
                {
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            createdRow: function(row, data, dataIndex, cells) {
                $(cells).addClass(' align-middle datatables-sm');
            }
        });

        function doConfirm(id) {
            showAlert('Are you sure to confirm this slot ?', function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.studentBookedLectureHall.ChangeStatus') }}",
                    data: {
                        'id': id,
                        'status': 1
                    },
                    success: function(response) {
                        listTable.ajax.reload(null, false);
                    }
                });
            });
        }

        function doCancel(id) {
            showAlert('Are you sure to cancel this slot ?', function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.studentBookedLectureHall.ChangeStatus') }}",
                    data: {
                        'id': id,
                        'status': 3
                    },
                    success: function(response) {
                        listTable.ajax.reload(null, false);
                    }
                });
            });
        }
    </script>
@endsection
