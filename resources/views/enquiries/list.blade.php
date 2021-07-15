@extends('layouts.app', ['activePage' => 'enquiries', 'titlePage' => __('Enquiries')])

@section('content')

    <link rel="stylesheet" href="{{ asset('web/css/draganddrop.css') }}" type="text/css" />
    <style>
        .enquiry_table th {
            background-color: #eee;
        }

    </style>
    <script src="{{ asset('web/js/draganddrop.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#sortable")
                .sortable({
                    handle: '.hand',
                    group: true,
                    update: function(event, ui) {
                        updateSequence();
                    }
                })
        });

    </script>
    <div class="content">
        <div class="container-fluid">
            <div class="row">

                @if (session('status'))

                    <div class="col-md-12">
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                            </button>
                            <span>{{ session('status') }}</span>
                        </div>
                    </div>

                @endif

                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title float-left">{{ __('Enquiries') }}</h4>
                        </div>
                        <?php $sno = 1; ?>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <form method="GET" accept="{{ route('enquiries.index') }}">
                                    <h5>Filter</h5>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-sm-3 " style="margin-bottom: 10px">
                                            <select name="status" class="selectpicker form-control">
                                                    <option >All</option>
                                                @foreach($enquiry_status as $key => $status)
                                                    <option value='{{ $key }}' @if($key == request()->get('status')) selected @endif>
                                                        {{ $status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-3">
                                            From
                                            <input type="text" name="from_date" class="form-control datepicker"
                                                value="{{ old('from_date', request()->has('from_date') ? request()->input('from_date') : date('Y-m-01')) }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-3">
                                              To
                                            <input type="text" name="to_date" class="form-control datepicker"
                                                value="{{ old('to_date', request()->has('to_date') ? request()->input('from_date') :  date('Y-m-d')) }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-3">
                                            <button type="submit" name="submit" class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>

                            </div>
                            <br>
                            <div class="table-responsive">
                                <table id="datatables"
                                    class="table table-striped table-no-bordered table-hover dataTable dtr-inline">
                                    <thead class=" text-dark text-bold">
                                        <th>
                                            S NO
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Subject
                                        </th>
                                        <th>
                                            Message
                                        </th>
                                        <th>
                                            Phone No
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            On
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </thead>
                                    <tbody>
                                        @foreach ($enquiries as $enquiry)
                                            <tr id="enquiry_{{ $enquiry->id }}">
                                                <td>{{ $sno++ }}</td>
                                                <td>{{ $enquiry->name }}</td>
                                                <td>{{ $enquiry->subject }}</td>
                                                <td>{{ substr($enquiry->message, 0, 100) }}...</td>
                                                <td><a href="tel:{{ $enquiry->phone_no }}">{{ $enquiry->phone_no }}</a></td>
                                                <td><a href="mail:{{ $enquiry->email }}">{{ $enquiry->email }}</a></td>
                                                <td>{{ $enquiry->created_at }}</td>
                                                <td>
                                                    <a id="enquiry_status_block_{{ $enquiry->id }}"
                                                        style="cursor:pointer; color: #9c27b0" class="view_enquiry"
                                                        data-recordid="{{ $enquiry->id }}">
                                                        {{ strtoupper($enquiry->status) }}
                                                    </a>
                                                </td>
                                                <td class="text-right ">
                                                    <form method="post"
                                                        action="{{ route('enquiries.destroy', $enquiry->id) }}"
                                                        onsubmit="return confirm('Are You Sure, Want to delete this ?')"
                                                        >
                                                        @csrf
                                                        @method('delete')
                                                        <a href="#" class="btn btn-link btn-warning btn-just-icon show"><i
                                                                class="material-icons">eye</i></a>
                                                        <button type="submit"
                                                            class="btn btn-link btn-danger btn-just-icon remove"><i
                                                                class="material-icons">close</i>
                                                            <div class="ripple-container"></div>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="updateEnquiryStatus" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('faqs.index') }}" onsubmit="return updateStatus()">

                    <input type="hidden" id="enquiry_id" value="" />
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="contact_person_name"></h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered enquiry_table">
                            <tbody>
                                <tr>
                                    <th class="">On</th>
                                    <td id="enquiry_created_on"></td>
                                </tr>
                                <tr>
                                    <th>Service</th>
                                    <td id="enquiry_about_service"></td>
                                </tr>
                                <tr>
                                    <th>Message</th>
                                    <td id="enquiry_message" style="text-align: justify; line-height:12px"></td>
                                </tr>
                                <tr>
                                    <th>Phone No</th>
                                    <td id="enquiry_phone_no"></td>
                                </tr>
                                <tr>
                                    <th>Email Id</th>
                                    <td id="enquiry_email_id"></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <select id="enquiry_status" name="status" class="selectpicker">
                                            <option value='pending'>Pending</option>
                                            <option value='contact'>Contact</option>
                                            <option value='follow-up'>Follow Up</option>
                                            <option value='order-confirm'>Order Confirmed</option>
                                            <option value='cancel'>Cancel</option>
                                            <option value='fake'>Fake</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Comment</th>
                                    <td>
                                        <textarea class="form-control" name="comment" id="enquiry_comment"
                                            placeholder="{{ __('Comment') }}" required></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="save_status">Save</button>&nbsp;
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ended -->
    <script>
        $(document).ready(function() {
            $("#datatables").dataTable();
            $('.datepicker').datetimepicker({
                format: "YYYY-MM-DD",
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-chevron-up",
                    down: "fa fa-chevron-down",
                    previous: "fa fa-chevron-left",
                    next: "fa fa-chevron-right",
                    today: "fa fa-screenshot",
                    clear: "fa fa-trash",
                    close: "fa fa-remove"
                }
            });
        });

        function updateStatus() {
            $.ajax({
                url: "/admin/enquiries/" + $("#enquiry_id").val(),
                type: 'put',
                dataType: 'json',
                "data": {
                    'status': $("#enquiry_status").val(),
                    'comment': $("#enquiry_comment").val()
                },
                success: function(data) {
                    alert('Updated Successfully');

                    var enquiry_block = $("#enquiry_status_block_" + $("#enquiry_id").val());
                    enquiry_block.html(($("#enquiry_status").val()).toUpperCase());
                    $("#updateEnquiryStatus").modal('hide');

                },
                error: function(jqXHR, exception) {
                    if (jqXHR.status == 422) {
                        alert(jqXHR.responseJSON.message);
                    } else {
                        alert('Something Went Wrong')
                    }

                }
            });

            return false;

        }

        $(".view_enquiry").on('click', function() {

            $.ajax({
                url: "/admin/enquiries/" + $(this).data('recordid'),
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    $("#enquiry_id").val(data.id);
                    $("#contact_person_name").html(data.name);
                    $("#enquiry_message").html(data.message);
                    $("#enquiry_created_on").html(data.created_at);
                    $("#enquiry_phone_no").html(data.phone_no);
                    $("#enquiry_email_id").html(data.email);
                    $("#enquiry_about_service").html('');
                    console.log(data.status);
                    $("#enquiry_status").val(data.status);
                    $("#enquiry_status").trigger('change');

                    $("#enquiry_comment").val(data.comment);
                    $("#updateEnquiryStatus").modal('show');


                },
                error: function(jqXHR, exception) {
                    alert('Something Went Wrong')
                }
            })
        });

    </script>

@endsection
