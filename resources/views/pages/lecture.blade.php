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
                                <h4 class="card-title">Lectures List</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li>
                                            <a onclick="refreshTable()" data-action="reload">
                                                <i class="ft-rotate-cw"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table w-100" id="lecture_dataTable">
                                            <thead>
                                                <tr>
                                                    {{-- <th></th> --}}
                                                    <th>Lecture Hall</th>
                                                    <th>Lecture Name</th>
                                                    <th>Type</th>
                                                    <th>Date</th>
                                                    <th>Start Time</th>
                                                    <th>End Time</th>
                                                    <th>Student Capacity</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">

                        <form autocomplete="off" action="{{ route('admin.lecture.ENROLL') }}" method="POST"
                            id="form_records">
                            @csrf
                            <input type="hidden" id="isnew" name="isnew" value="{{ old('isnew') ? old('isnew') : '1' }}">
                            <input type="hidden" id="record" name="record"
                                value="{{ old('record') ? old('record') : '' }}">

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Add/Edit Lecture</h4>

                                    <a class="heading-elements-toggle">
                                        <i class="la la-ellipsis-v font-medium-3"></i>
                                    </a>

                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li>
                                                <label for="resetbtn">
                                                    <a data-action="reload"><i class="ft-rotate-cw"></i></a>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-12">

                                                {{-- NAME --}}
                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="l_name">
                                                            <small class="text-dark">Lecture Name
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>
                                                        <input value="{{ old('l_name') }}" type="text" name="l_name"
                                                            id="l_name" class="form-control"
                                                            placeholder="Enter lecture hall name ..">
                                                        @error('l_name')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- LECTURE HALL --}}
                                                <div class="row mt-1">
                                                    <div class="col-md-12">

                                                        <label for="lh_university">
                                                            <small>Lecture Hall
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>

                                                        <select class="form-control" name="l_hall_id" id="l_hall_id">

                                                            @foreach ($lecture_halls as $lecture_hall)
                                                                <option
                                                                    {{ old('l_hall_id') == $lecture_hall->id ? 'selected' : '' }}
                                                                    value="{{ $lecture_hall->id }}">
                                                                    {{ $lecture_hall->lecture_hall_name }}
                                                                </option>
                                                            @endforeach

                                                        </select>

                                                        @error('l_hall_id')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror

                                                    </div>
                                                </div>

                                                {{-- LECTURE TYPE --}}
                                                <div class="row mt-1">
                                                    <div class="col-md-12">

                                                        <label for="l_type_id">
                                                            <small>Lecture Type
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>

                                                        <select class="form-control" name="l_type_id" id="l_type_id">
                                                            <option {{ old('l_type_id') == 1 ? 'selected' : '' }}
                                                                value="1">
                                                                Theory
                                                            </option>
                                                            <option {{ old('l_type_id') == 2 ? 'selected' : '' }}
                                                                value="2">
                                                                Practicles
                                                            </option>
                                                        </select>

                                                        @error('l_type_id')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror

                                                    </div>
                                                </div>

                                                {{-- DATE --}}
                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="l_date">
                                                            <small class="text-dark">Lecture Date
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>
                                                        <input value="{{ old('l_date') }}" type="date" name="l_date"
                                                            id="l_date" class="form-control">
                                                        @error('l_date')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- TIME --}}
                                                <div class="row">

                                                    <div class="col-md-6 mt-1 p-0">
                                                        <div class="col-md-12">
                                                            <label for="l_start_time">
                                                                <small class="text-dark">Start Time
                                                                    {!! required_mark() !!}
                                                                </small>
                                                            </label>
                                                            <input value="{{ old('l_start_time') }}" type="time"
                                                                name="l_start_time" id="l_start_time"
                                                                class="form-control">
                                                            @error('l_start_time')
                                                                <span class="text-danger">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mt-1 p-0">
                                                        <div class="col-md-12">
                                                            <label for="l_end_time">
                                                                <small class="text-dark">End Time
                                                                    {!! required_mark() !!}
                                                                </small>
                                                            </label>
                                                            <input value="{{ old('l_end_time') }}" type="time"
                                                                name="l_end_time" id="l_end_time" class="form-control">
                                                            @error('l_end_time')
                                                                <span class="text-danger">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>

                                                {{-- CAPACITY --}}
                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="l_student_capacity">
                                                            <small class="text-dark">Lecture student Capacity
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>
                                                        <input value="{{ old('l_student_capacity') }}" type="number"
                                                            name="l_student_capacity" id="l_student_capacity"
                                                            class="form-control"
                                                            placeholder="Enter lecture student capacity ..">
                                                        @error('l_student_capacity')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- STATUS --}}
                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="l_status">
                                                            <small>
                                                                Status
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>
                                                        <select class="form-control" name="l_status" id="l_status">
                                                            <option {{ old('l_status') == 1 ? 'selected' : '' }}
                                                                value="1">
                                                                Active
                                                            </option>
                                                            <option {{ old('l_status') == 2 ? 'selected' : '' }}
                                                                value="2">
                                                                Inactive
                                                            </option>
                                                        </select>
                                                        @error('l_status')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <hr class="my-2">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input id="submitbtn" class="btn btn-success w-100" type="submit"
                                                            value="Submit">
                                                    </div>
                                                    <div class="col-md-6 mt-md-0 mt-1">
                                                        <input class="btn btn-danger w-100" type="button"
                                                            form="form_records" id="resetbtn" value="Reset">
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

    <div id="lecture_enrolled_student_list_modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lecture Enrolled Students</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="table-responsive">
                        <table class="table w-100" id="lecture_enrolled_dataTable">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="lecture_enrolled_dataTable_body">

                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')
    @include('layouts.scripts')

    <script>
        let listTable = $('#lecture_dataTable').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            serverSide: true,
            responsive: true,
            language: {
                searchPlaceholder: "Search By Name"
            },
            ajax: "{{ route('admin.lecture.LIST') }}",
            columns: [
                // {
                //     name: 'viewenrolled',
                //     orderable: false,
                //     searchable: false
                // },
                {
                    name: 'lecture_hall_id'
                },
                {
                    name: 'name'
                },
                {
                    name: 'lecture_type'
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
                    name: 'student_capacity'
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
                    url: "{{ route('admin.lecture.GET') }}",
                    data: {
                        'id': id
                    },
                    success: function(response) {
                        $('#l_hall_id').val(response.lecture_hall_id);
                        $('#l_name').val(response.name);
                        $('#l_type_id').val(response.lecture_type);
                        $('#l_date').val(response.conduct_date);
                        $('#l_start_time').val(response.start_time);
                        $('#l_end_time').val(response.end_time);
                        $('#l_student_capacity').val(response.student_capacity);
                        $('#l_status').val(response.status);
                        $('#record').val(response.id);
                        $('#isnew').val('2').trigger('change');
                    }
                });
            });
        }

        function doDelete(id) {
            showAlert('Are you sure to delete this record ?', function() {
                window.location = "{{ route('admin.lecture_hall.DELETE') }}?id=" + id;
            });
        }

        function doViewEnreolledStudents(lecture_id) {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.lecture.GET_ENROLLED_STUDENTS') }}",
                data: {
                    id: lecture_id
                },

                success: function(response) {

                    let table_data = '';

                    $('#lecture_enrolled_student_list_modal').modal('toggle');
                    $('#lecture_enrolled_dataTable_body').html('');

                    $.each(response, function(key, value) {

                        let status = '';

                        if (value['status'] == 1) {
                            status = 'APPROVED'
                        } else {
                            'APPROVAL PENDING'
                        }

                        $('#lecture_enrolled_dataTable_body').append(
                            '<tr>' +
                            '<td>' + value['get_student']['name'] + '</td>' +
                            '<td>' + status + '</td>' +
                            '</tr>');
                    });
                }
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
