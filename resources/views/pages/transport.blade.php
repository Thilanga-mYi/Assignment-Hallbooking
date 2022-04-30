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
                                <h4 class="card-title">Transport List</h4>
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
                                        <table class="table w-100" id="transport_dataTable">
                                            <thead>
                                                <tr>
                                                    <th>Vehicle No</th>
                                                    <th>Date</th>
                                                    <th>Start Location</th>
                                                    <th>End Location</th>
                                                    <th>Start Time</th>
                                                    <th>End Time</th>
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
                        <form autocomplete="off" action="{{ route('admin.transport.ENROLL') }}" method="POST"
                            id="form_records">

                            @csrf
                            <input type="hidden" id="isnew" name="isnew" value="{{ old('isnew') ? old('isnew') : '1' }}">
                            <input type="hidden" id="record" name="record"
                                value="{{ old('record') ? old('record') : '' }}">
                            <div class="card">

                                <div class="card-header">
                                    <h4 class="card-title">Add/Edit Transport</h4>
                                    <a class="heading-elements-toggle">
                                        <i class="la la-ellipsis-v font-medium-3"></i>
                                    </a>
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

                                                <div class="row">

                                                    {{-- TRANSPORT VEHICLE NO --}}
                                                    <div class="col-md-6">
                                                        <label for="trans_vehicle_no">
                                                            <small class="text-dark">Vehicle No
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>
                                                        <input value="{{ old('trans_vehicle_no') }}" type="text"
                                                            name="trans_vehicle_no" id="trans_vehicle_no"
                                                            class="form-control" placeholder="Enter vehicle No ..">
                                                        @error('trans_vehicle_no')
                                                            <span class="text-danger"><small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    {{-- TRANSPORT DATE --}}
                                                    <div class="col-md-6 p-0">
                                                        <div class="col-md-12">
                                                            <label for="end">
                                                                <small class="text-dark">
                                                                    Date{!! required_mark() !!}
                                                                </small>
                                                            </label>
                                                            <input value="{{ old('trans_date') }}" type="datetime-local"
                                                                name="trans_date" id="end" class="form-control">
                                                            @error('trans_date')
                                                                <span
                                                                    class="text-danger"><small>{{ $message }}</small></span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    {{-- <div class="col-md-6 p-0">
                                                        <div class="col-md-12">

                                                            <label for="trans_type">
                                                                <small>Transport Type
                                                                    {!! required_mark() !!}
                                                                </small>
                                                            </label>

                                                            <select class="form-control" name="trans_type"
                                                                id="trans_type">
                                                                <option {{ old('trans_type') == 1 ? 'selected' : '' }}
                                                                    value="1">
                                                                    Normal Transport
                                                                </option>
                                                                <option {{ old('trans_type') == 2 ? 'selected' : '' }}
                                                                    value="2">
                                                                    Special Transport
                                                                </option>
                                                            </select>

                                                            @error('trans_type')
                                                                <span class="text-danger">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div> --}}

                                                </div>

                                                <div class="row mt-1">

                                                    {{-- TRANSPORT START TIME --}}
                                                    <div class="col-md-6 p-0">
                                                        <div class="col-md-12">
                                                            <label for="trans_start_time">
                                                                <small class="text-dark">
                                                                    Start Time
                                                                    {!! required_mark() !!}
                                                                </small>
                                                            </label>

                                                            <input value="{{ old('trans_start_time') }}" type="time"
                                                                name="trans_start_time" id="trans_start_time"
                                                                class="form-control">
                                                            @error('trans_start_time')
                                                                <span class="text-danger"><small>{{ $message }}</small>
                                                                </span>
                                                            @enderror

                                                        </div>
                                                    </div>

                                                    {{-- TRANSPORT OUT TIME --}}
                                                    <div class="col-md-6 p-0">
                                                        <div class="col-md-12">
                                                            <label for="trans_end_time">
                                                                <small class="text-dark">
                                                                    Out Time
                                                                    {!! required_mark() !!}
                                                                </small>
                                                            </label>
                                                            <input value="{{ old('trans_end_time') }}" type="time"
                                                                name="trans_end_time" id="trans_end_time"
                                                                class="form-control">
                                                            @error('trans_end_time')
                                                                <span class="text-danger"><small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row mt-1">

                                                    {{-- TRANSPORT START LOCATION --}}
                                                    <div class="col-md-6 p-0">
                                                        <div class="col-md-12">
                                                            <label for="trans_start_location">
                                                                <small class="text-dark">
                                                                    Start Location
                                                                    {!! required_mark() !!}
                                                                </small>
                                                            </label>

                                                            <input value="{{ old('trans_start_location') }}" type="text"
                                                                name="trans_start_location" id="trans_start_location"
                                                                class="form-control"
                                                                placeholder="Enter Start Location ..">
                                                            @error('trans_start_location')
                                                                <span class="text-danger"><small>{{ $message }}</small>
                                                                </span>
                                                            @enderror

                                                        </div>
                                                    </div>

                                                    {{-- TRANSPORT END LOCATION --}}
                                                    <div class="col-md-6 p-0">
                                                        <div class="col-md-12">
                                                            <label for="trans_end_location">
                                                                <small class="text-dark">
                                                                    End Location
                                                                    {!! required_mark() !!}
                                                                </small>
                                                            </label>
                                                            <input value="{{ old('trans_end_location') }}" type="text"
                                                                name="trans_end_location" id="trans_end_location"
                                                                class="form-control" placeholder="Enter End Location ..">
                                                            @error('trans_end_location')
                                                                <span class="text-danger"><small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>

                                                {{-- TRANSPORT ROUTE DESCRIPTION --}}
                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="trans_route_description">
                                                            <small class="text-dark">
                                                                Route Description
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>

                                                        <textarea placeholder="Enter route description .." class="form-control" name="trans_route_description"
                                                            id="trans_route_description" cols="30" rows="3">{{ old('trans_route_description') }}
                                                        </textarea>

                                                        @error('trans_route_description')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- TRANSPORT REMARK --}}
                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="trans_remark">
                                                            <small class="text-dark">
                                                                Remark
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>

                                                        <textarea placeholder="Enter Remark .." class="form-control" name="trans_remark" id="trans_remark" cols="30" rows="3">{{ old('trans_remark') }}
                                                        </textarea>

                                                        @error('trans_remark')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label>
                                                            <small>Available Days
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>

                                                        <ul class="ui_kit_checkbox selectable-list">

                                                            @foreach ($week_days as $key => $day)
                                                                <li class="mb-1">

                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" value="{{ ++$key }}"
                                                                            id="customCheck{{ $key }}"
                                                                            class="me-2"
                                                                            name="trans_available_days">
                                                                        <label for="customCheck{{ $key }}">
                                                                            {{ $day }}
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                            @endforeach

                                                        </ul>

                                                        @error('trans_available_days')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror

                                                    </div>
                                                </div> --}}

                                                {{-- TRANSPORT STATUS --}}
                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="trans_status">
                                                            <small>Status
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>
                                                        <select class="form-control" name="trans_status"
                                                            id="trans_status">
                                                            <option {{ old('trans_status') == 1 ? 'selected' : '' }}
                                                                value="1">
                                                                Active
                                                            </option>
                                                            <option {{ old('trans_status') == 2 ? 'selected' : '' }}
                                                                value="2">
                                                                Inactive
                                                            </option>
                                                        </select>
                                                        @error('trans_status')
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
        let listTable = $('#transport_dataTable').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            serverSide: true,
            responsive: true,
            language: {
                searchPlaceholder: "Search By Vehicle No"
            },
            ajax: "{{ route('admin.transport.LIST') }}",
            columns: [{
                    name: 'vehicle_no'
                },
                {
                    name: 'date'
                },
                {
                    name: 'start_location'
                },
                {
                    name: 'end_location'
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
                    url: "{{ route('admin.transport.GET') }}",
                    data: {
                        'id': id,
                    },
                    success: function(response) {
                        $('#trans_vehicle_no').val(response.vehicle_no);
                        $('#trans_date').val(response.date);
                        $('#trans_start_time').val(response.start_time);
                        $('#trans_end_time').val(response.end_time);
                        $('#trans_start_location').val(response.start_location);
                        $('#trans_end_location').val(response.end_location);
                        $('#trans_route_description').val(response.route_description);
                        $('#trans_remark').val(response.remark);
                        $('#trans_status').val(response.status);
                        $('#record').val(response.id);
                        $('#isnew').val('2').trigger('change');
                    }
                });
            });
        }

        function doDelete(id) {

            alert('Unable to Delete');

            showAlert('Are you sure to delete this record ?', function() {
                window.location = "{{ route('admin.transport.DELETE') }}?id=" + id;
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
