@extends('layouts.app')

@section('content')

    @include('layouts.navbar')
    @include('layouts.sidebar')
    <!-- END: Main Menu-->
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Revenue, Hit Rate & Deals -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add/Edit Usertype </h4>
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
                                        <table class="table w-100" id="usertypesTable">
                                            <thead>
                                                <tr>
                                                    <th>Usertype</th>
                                                    <th>Permitted Routes</th>
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
                        <form action="{{ route('admin.usertypes.enroll') }}" method="POST" id="driver_form">
                            @csrf
                            <input type="hidden" id="isnew" name="isnew" value="{{ old('isnew') ? old('isnew') : '1' }}">
                            <input type="hidden" id="record" name="record"
                                value="{{ old('record') ? old('record') : '' }}">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Create User System</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><label for="resetbtn"><a data-action="reload"><i
                                                            class="ft-rotate-cw"></i></a></label></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="usertype"><small class="text-dark">Usertype
                                                        {!! required_mark() !!}</small></label>
                                                <input value="{{ old('usertype') }}" type="text" name="usertype"
                                                    id="usertype" class="form-control" placeholder="Enter Usertype">
                                                @error('usertype')
                                                    <span class="text-danger"><small>{{ $message }}</small></span>
                                                @enderror
                                            </div>
                                            <div class="col-md-12 mt-1">
                                                <label for="status"><small>Status {!! required_mark() !!}</small></label>
                                                <select class="form-control" name="status" id="status">
                                                    <option {{ old('status') == 1 ? 'selected' : '' }} value="1">Active
                                                    </option>
                                                    <option {{ old('status') == 2 ? 'selected' : '' }} value="2">Inactive
                                                    </option>
                                                </select>
                                                @error('status')
                                                    <span class="text-danger">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-12 mt-1">
                                                <label for="turnno"><small class="text-dark">Permissions
                                                        {!! required_mark() !!}</small></label>
                                                <br>
                                                <div class="row">

                                                    @foreach ($routes as $route)
                                                        <div class="col-md-12 mt-1 ml-2">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input value="{{ $route->id }}"
                                                                        class="permissions"
                                                                        id="permission{{ $route->id }}"
                                                                        name="permissions[]" type="checkbox"
                                                                        data-size="small" data-onstyle="success"
                                                                        data-toggle="toggle">
                                                                    <small> {{ $route->name }}</small>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                        </div>
                                        <hr class="my-2">
                                        <div class="row">
                                            <div class="col-md-6"> <input id="submitbtn"
                                                    class="btn btn-success w-100" type="submit" value="Submit">
                                            </div>
                                            <div class="col-md-6 mt-md-0 mt-1"><input class="btn btn-danger w-100"
                                                    type="button" form="driver_form" id="resetbtn" value="Reset"></div>
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
    <!-- END: Content-->



    @include('layouts.footer')
    @include('layouts.scripts')

    <script>
        let listTable = $('#usertypesTable').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            serverSide: true,
            responsive: true,
            language: {
                searchPlaceholder: "Usertype"
            },
            ajax: "{{ route('admin.usertypes.list') }}",
            columns: [{
                    name: 'usertype'
                },
                {
                    name: 'permitted',
                    orderable: false,
                    searchable: false
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
                    url: "{{ route('admin.usertypes.get.one') }}",
                    data: {
                        'id': id
                    },
                    success: function(response) {
                        $('#usertype').val(response.usertype);
                        $('.permissions').bootstrapToggle('off');
                        response.permissionandroutesdata.forEach(permission => {
                            $('#permission' + permission.route).bootstrapToggle('on');
                        });
                        $('#status').val(response.status);
                        $('#record').val(response.id);
                        $('#isnew').val('2').trigger('change');
                    }
                });
            });
        }

        function doDelete(id) {
            showAlert('Are you sure to delete this record ?', function() {
                window.location = "{{ route('admin.usertypes.delete.one') }}?id=" + id;
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
