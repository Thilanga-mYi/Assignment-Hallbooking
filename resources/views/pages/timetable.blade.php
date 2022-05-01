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
                                                    <th>Slot Name</th>
                                                    <th>Subject</th>
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
                    <div class="col-md-4">
                        <form autocomplete="off" action="{{ route('admin.timetable.ENROLL') }}" method="POST"
                            id="form_records">
                            @csrf
                            <input type="hidden" id="isnew" name="isnew" value="{{ old('isnew') ? old('isnew') : '1' }}">
                            <input type="hidden" id="record" name="record"
                                value="{{ old('record') ? old('record') : '' }}">
                            <div class="card">

                                <div class="card-header">
                                    <h4 class="card-title">Add/Edit Timetable Slots</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li>
                                                <label for="resetbtn">
                                                    <a data-action="reload">
                                                        <i class="ft-rotate-cw"></i>
                                                    </a>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="card-content collapse show">
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-12">

                                                {{-- SLOT NAME --}}
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="t_slot_name">
                                                            <small class="text-dark">
                                                                Slot Name
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>

                                                        <input value="{{ old('t_slot_name') }}" type="text"
                                                            name="t_slot_name" id="t_slot_name" class="form-control"
                                                            placeholder="Enter slot name ..">
                                                        @error('t_slot_name')
                                                            <span
                                                                class="text-danger"><small>{{ $message }}</small></span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- LECTURE HALL --}}
                                                <div class="row mt-1">
                                                    <div class="col-md-12">

                                                        <label for="t_lecture_hall_id">
                                                            <small class="text-dark">
                                                                Lecture Hall
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>

                                                        <select class="form-control" name="t_lecture_hall_id"
                                                            id="t_lecture_hall_id">
                                                            <option selected disabled value="none">- Select -</option>
                                                            @foreach ($lecture_halls as $lecture_hall)
                                                                <option value="{{ $lecture_hall->id }}">
                                                                    {{ $lecture_hall->lecture_hall_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('t_lecture_hall_id')
                                                            <span
                                                                class="text-danger"><small>{{ $message }}</small></span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- SUBJECTS --}}
                                                <div class="row mt-1">
                                                    <div class="col-md-12">

                                                        <label for="t_subject_id">
                                                            <small class="text-dark">
                                                                Slot Subject
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>

                                                        <select class="form-control" name="t_subject_id"
                                                            id="t_subject_id">
                                                            <option selected disabled value="none">- Select -</option>
                                                            @foreach ($subjects as $subject)
                                                                <option value="{{ $subject->id }}">{{ $subject->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('t_subject_id')
                                                            <span
                                                                class="text-danger"><small>{{ $message }}</small></span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- DATE --}}
                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="end">
                                                            <small class="text-dark">Date
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>
                                                        <input value="{{ old('t_date') }}" type="date" name="t_date"
                                                            id="t_date" class="form-control">
                                                        @error('t_date')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    {{-- START TIME --}}
                                                    <div class="col-md-6 mt-1 p-0">
                                                        <div class="col-md-12">
                                                            <label for="end">
                                                                <small class="text-dark">Start Time
                                                                    {!! required_mark() !!}
                                                                </small>
                                                            </label>
                                                            <input value="{{ old('t_start_time') }}" type="time"
                                                                name="t_start_time" id="t_start_time"
                                                                class="form-control">
                                                            @error('t_start_time')
                                                                <span class="text-danger">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    {{-- END TIME --}}
                                                    <div class="col-md-6 mt-1 p-0">
                                                        <div class="col-md-12">
                                                            <label for="end">
                                                                <small class="text-dark">End Time
                                                                    {!! required_mark() !!}
                                                                </small>
                                                            </label>
                                                            <input value="{{ old('t_end_time') }}" type="time"
                                                                name="t_end_time" id="t_end_time" class="form-control">
                                                            @error('t_end_time')
                                                                <span class="text-danger">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- STATUS --}}
                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="t_status">
                                                            <small>
                                                                Status
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>

                                                        <select class="form-control" name="t_status" id="t_status">
                                                            <option {{ old('t_status') == 1 ? 'selected' : '' }}
                                                                value="1">
                                                                Active
                                                            </option>
                                                            <option {{ old('t_status') == 2 ? 'selected' : '' }}
                                                                value="2">
                                                                Inactive
                                                            </option>
                                                        </select>
                                                        @error('t_status')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <hr class="my-2">
                                                <div class="row">
                                                    <div class="col-md-6"> <input id="submitbtn"
                                                            class="btn btn-success w-100" type="submit" value="Submit">
                                                    </div>
                                                    <div class="col-md-6 mt-md-0 mt-1"><input class="btn btn-danger w-100"
                                                            type="button" form="form_records" id="resetbtn" value="Reset">
                                                    </div>
                                                </div>

                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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
            ajax: "{{ route('admin.timetable.LIST') }}",
            columns: [{
                    name: 'slot_name'
                },
                {
                    name: 'subject_id'
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

        function doEdit(id) {
            showAlert('Are you sure to edit this record ?', function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.timetable.GET') }}",
                    data: {
                        'id': id
                    },
                    success: function(response) {
                        $('#t_slot_name').val(response.slot_name);
                        $('#t_subject_id').val(response.subject_id);
                        $('#t_lecture_hall_id').val(response.lecture_hall_id);
                        $('#t_date').val(response.date);
                        $('#t_start_time').val(response.start_time);
                        $('#t_end_time').val(response.end_time);
                        $('#status').val(response.status);
                        $('#record').val(response.id);
                        $('#isnew').val('2').trigger('change');
                    }
                });
            });
        }

        function doDelete(id) {
            showAlert('Are you sure to delete this record ?', function() {
                window.location = "{{ route('admin.events.delete.one') }}?id=" + id;
            });
        }

        @if (old('record'))
            $('#record').val({{ old('record') }});
        @endif

        @if (old('isnew'))
            $('#isnew').val({{ old('isnew') }}).trigger('change');
        @endif
    </script>
@endsection
