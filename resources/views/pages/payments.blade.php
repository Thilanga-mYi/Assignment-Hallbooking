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
                                <h4 class="card-title">Payment Request List</h4>
                                <a class="heading-elements-toggle">
                                    <i class="la la-ellipsis-v font-medium-3"></i>
                                </a>
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
                                        <table class="table w-100" id="payment_dataTable">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Student</th>
                                                    <th>Lecture</th>
                                                    <th>Paid Amount</th>
                                                    <th>Paid At</th>
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
                        <form autocomplete="off" action="{{ route('admin.payments.ENROLL') }}" method="POST"
                            id="form_records">
                            @csrf
                            <input type="hidden" id="isnew" name="isnew" value="{{ old('isnew') ? old('isnew') : '1' }}">
                            <input type="hidden" id="record" name="record"
                                value="{{ old('record') ? old('record') : '' }}">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Add/Edit Payments</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li>
                                                <label for="resetbtn"><a data-action="reload"><i
                                                            class="ft-rotate-cw"></i></a>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="payment_remark">
                                                            <small class="text-dark">Payment Remark
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>
                                                        <textarea placeholder="Enter payment remark .." class="form-control" name="description" id="description" cols="30"
                                                            rows="5">{{ old('payment_remark') }}
                                                        </textarea>
                                                        @error('payment_remark')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <label for="payment_status">
                                                            <small>Status
                                                                {!! required_mark() !!}
                                                            </small>
                                                        </label>
                                                        <select class="form-control" name="payment_status"
                                                            id="payment_status">
                                                            <option {{ old('payment_status') == 1 ? 'selected' : '' }}
                                                                value="1">
                                                                Approved
                                                            </option>
                                                            <option {{ old('payment_status') == 2 ? 'selected' : '' }}
                                                                value="2">
                                                                Rejected
                                                            </option>
                                                        </select>

                                                        @error('payment_status')
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
        let listTable = $('#payment_dataTable').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            serverSide: true,
            responsive: true,
            language: {
                searchPlaceholder: "Search By Name"
            },
            ajax: "{{ route('admin.payments.LIST') }}",
            columns: [{
                    name: 'name'
                },
                {
                    name: 'student_id'
                },
                {
                    name: 'lecture_id'
                },
                {
                    name: 'paid_amount'
                },
                {
                    name: 'created_at'
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
                    url: "{{ route('admin.payments.GET') }}",
                    data: {
                        'id': id
                    },
                    success: function(response) {
                        $('#payment_remark').val(response.remark);
                        $('#payment_status').val(response.status);
                        $('#record').val(response.id);
                        $('#isnew').val('2').trigger('change');
                    }
                });
            });
        }

        function doDelete(id) {
            showAlert('Are you sure to delete this record ?', function() {
                window.location = "{{ route('admin.payments.DELETE') }}?id=" + id;
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
