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
                                <h4 class="card-title">Lecture Hall List</h4>
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
                                        <table class="table w-100" id="lecture_hall_dataTable">
                                            <thead>
                                                <tr>
                                                    <th>University Name</th>
                                                    <th>Lecture Hall Name</th>
                                                    <th>Location</th>
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

                        <form autocomplete="off" action="{{ route('admin.lecture_hall.ENROLL') }}" method="POST"
                            id="form_records">
                            @csrf
                            <input type="hidden" id="isnew" name="isnew" value="{{ old('isnew') ? old('isnew') : '1' }}">
                            <input type="hidden" id="record" name="record"
                                value="{{ old('record') ? old('record') : '' }}">

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Add/Edit Lecture Hall</h4>

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

                                                {{-- UNIVERSITY --}}
                                                <div class="row mt-1">
                                                    <div class="col-md-12">

                                                        <label for="lh_university">
                                                            <small>Univeristy
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>

                                                        <select class="form-control" name="lh_university"
                                                            id="lh_university">

                                                            @foreach ($universities as $university)
                                                                <option
                                                                    {{ old('lh_university') == $university->id ? 'selected' : '' }}
                                                                    value="{{ $university->id }}">
                                                                    {{ $university->name }}
                                                                </option>
                                                            @endforeach

                                                        </select>

                                                        @error('lh_university')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror

                                                    </div>
                                                </div>

                                                {{-- NAME --}}
                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="lh_name">
                                                            <small class="text-dark">Lecture Hall Name
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>
                                                        <input value="{{ old('lh_name') }}" type="text" name="lh_name"
                                                            id="lh_name" class="form-control"
                                                            placeholder="Enter lecture hall name ..">
                                                        @error('lh_name')
                                                            <span class="text-danger"><small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- CAPACITY --}}
                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="lh_capacity">
                                                            <small class="text-dark">Lecture Hall Capacity
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>
                                                        <input value="{{ old('lh_capacity') }}" type="number"
                                                            name="lh_capacity" id="lh_capacity" class="form-control"
                                                            placeholder="Enter lecture hall capacity ..">
                                                        @error('lh_capacity')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- LOCATION --}}
                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="lh_location">
                                                            <small class="text-dark">
                                                                Lecture Hall Location
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>
                                                        <textarea placeholder="Enter lecture hall location .." class="form-control" name="lh_location" id="lh_location"
                                                            cols="30" rows="5">{{ old('lh_location') }}
                                                        </textarea>
                                                        @error('lh_location')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- DESCRIPTION --}}
                                                <div class="row mt-1">
                                                    <div class="col-md-12">

                                                        <label for="lh_description">
                                                            <small class="text-dark">
                                                                Lecture Hall Description
                                                            </small>
                                                        </label>

                                                        <textarea placeholder="Enter lecture hall description .." class="form-control" name="lh_description"
                                                            id="lh_description" cols="30" rows="5">{{ old('university_address') }}
                                                        </textarea>

                                                        @error('lh_description')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- STATUS --}}
                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="lh_status">
                                                            <small>
                                                                Status
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>
                                                        <select class="form-control" name="lh_status" id="lh_status">
                                                            <option {{ old('lh_status') == 1 ? 'selected' : '' }}
                                                                value="1">
                                                                Active
                                                            </option>
                                                            <option {{ old('lh_status') == 2 ? 'selected' : '' }}
                                                                value="2">
                                                                Inactive
                                                            </option>
                                                        </select>
                                                        @error('lh_status')
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


    @include('layouts.footer')
    @include('layouts.scripts')

    <script>
        let listTable = $('#lecture_hall_dataTable').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            serverSide: true,
            responsive: true,
            language: {
                searchPlaceholder: "Search By Name"
            },
            ajax: "{{ route('admin.lecture_hall.LIST') }}",
            columns: [{
                    name: 'university_id'
                },
                {
                    name: 'lecture_hall_name'
                },
                {
                    name: 'lecture_hall_location'
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
                    url: "{{ route('admin.lecture_hall.GET') }}",
                    data: {
                        'id': id
                    },
                    success: function(response) {
                        $('#lh_university').val(response.university_id);
                        $('#lh_name').val(response.lecture_hall_name);
                        $('#lh_capacity').val(response.student_capacity);
                        $('#lh_location').val(response.lecture_hall_location);
                        $('#lh_description').val(response.description);
                        $('#lh_status').val(response.status);
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

        @if (old('record'))
            $('#record').val({{ old('record') }});
        @endif

        @if (old('isnew'))
            $('#isnew').val({{ old('isnew') }}).trigger('change');
        @endif
        
    </script>
@endsection
