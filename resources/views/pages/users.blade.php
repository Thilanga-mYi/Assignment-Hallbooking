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
                                <h4 class="card-title">User List</h4>
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
                                        <table class="table w-100" id="usersTable">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Usertype</th>
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
                        <form autocomplete="off" action="{{ route('admin.users.enroll') }}" method="POST" id="user_form">
                            @csrf
                            <input type="hidden" id="isnew" name="isnew" value="{{ old('isnew') ? old('isnew') : '1' }}">
                            <input type="hidden" id="record" name="record"
                                value="{{ old('record') ? old('record') : '' }}">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Add/Edit Users</h4>
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
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="name"><small
                                                                class="text-dark">Name{!! required_mark() !!}</small></label>
                                                        <input value="{{ old('name') }}" type="text" name="name" id="name"
                                                            class="form-control" placeholder="Your Name ..">
                                                        @error('name')
                                                            <span
                                                                class="text-danger"><small>{{ $message }}</small></span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="nic"><small
                                                                class="text-dark">NIC{!! required_mark() !!}</small></label>
                                                        <input value="{{ old('nic') }}" type="text" name="nic" id="nic"
                                                            class="form-control" placeholder="Your NIC ..">
                                                        @error('nic')
                                                            <span
                                                                class="text-danger"><small>{{ $message }}</small></span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="mobile"><small class="text-dark">Mobile
                                                                Number{!! required_mark() !!}</small></label>
                                                        <input value="{{ old('mobile') }}" type="text" name="mobile"
                                                            id="mobile" class="form-control"
                                                            placeholder="User Mobile Number">
                                                        @error('mobile')
                                                            <span
                                                                class="text-danger"><small>{{ $message }}</small></span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="email"><small
                                                                class="text-dark">Email{!! required_mark() !!}</small></label>
                                                        <input autocomplete="false" value="{{ old('email') }}" type="text"
                                                            name="email" id="email" class="readonly form-control"
                                                            placeholder="Email">
                                                        @error('email')
                                                            <span
                                                                class="text-danger"><small>{{ $message }}</small></span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="password"><small class="text-dark">Password (Min 8
                                                                Characters){!! required_mark() !!}</small></label>
                                                        <input autocomplete="false" value="{{ old('password') }}"
                                                            type="password" name="password" id="password"
                                                            class="form-control" placeholder="Password">
                                                        @error('password')
                                                            <span
                                                                class="text-danger"><small>{{ $message }}</small></span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="password_confirmation"><small
                                                                class="text-dark">Password
                                                                Confirmation{!! required_mark() !!}</small></label>
                                                        <input value="{{ old('password_confirmation') }}" type="password"
                                                            name="password_confirmation" id="password_confirmation"
                                                            class="form-control" placeholder="Confirmation">
                                                        @error('password_confirmation')
                                                            <span
                                                                class="text-danger"><small>{{ $message }}</small></span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="usertype"><small>Usertype
                                                                {!! required_mark() !!}</small></label>
                                                        <select class="form-control" name="usertype" id="usertype">
                                                            @foreach ($usertypes as $usertype)
                                                                <option
                                                                    {{ old('usertype') == $usertype->id ? 'selected' : '' }}
                                                                    value="{{ $usertype->id }}">
                                                                    {{ $usertype->usertype }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('usertype')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="status"><small>Status
                                                                {!! required_mark() !!}</small></label>
                                                        <select class="form-control" name="status" id="status">
                                                            <option {{ old('status') == 1 ? 'selected' : '' }} value="1">
                                                                Active
                                                            </option>
                                                            <option {{ old('status') == 2 ? 'selected' : '' }} value="2">
                                                                Inactive
                                                            </option>
                                                        </select>
                                                        @error('status')
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
                                                            type="button" form="user_form" id="resetbtn" value="Reset">
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
    <!-- END: Content-->



    @include('layouts.footer')
    @include('layouts.scripts')
    <script>
        let listTable = $('#usersTable').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            serverSide: true,
            responsive: true,
            language: {
                searchPlaceholder: "Name / Email"
            },
            ajax: "{{ route('admin.users.list') }}",
            columns: [{
                    name: 'name'
                },
                {
                    name: 'email'
                },
                {
                    name: 'usertype'
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
                    url: "{{ route('admin.users.get.one') }}",
                    data: {
                        'id': id
                    },
                    success: function(response) {
                        $('#name').val(response.name);
                        $('#mobile').val(response.mobile);
                        $('#mac').val(response.mac);
                        $('#nic').val(response.nic);
                        $('#email').val(response.email);
                        $('#email').attr('readonly', '');
                        $('#usertype').val(response.usertype);
                        $('#password').val('');
                        $('#password_confirmation').val('');
                        $('#status').val(response.status);
                        $('#record').val(response.id);
                        $('#isnew').val('2').trigger('change');
                    }
                });
            });
        }

        function doDelete(id) {
            showAlert('Are you sure to delete this record ?', function() {
                window.location = "{{ route('admin.users.delete.one') }}?id=" + id;
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
