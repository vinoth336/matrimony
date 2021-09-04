@extends('layouts.app', ['activePage' => 'member', 'titlePage' => __('Members'), 'subPage' => 'viewMemberList'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-primary">
                                <h4 class="card-title float-left">{{ __('Members') }}</h4>
                                <a href="{{ route('admin.member.add') }}" class="btn btn-success float-right"><i class="material-icons">add</i></a>
                                <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown" style="margin-right: 10px;margin-top: 5px !important;">
                                    <div class="btn-group" role="group">
                                      <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Import
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <a class="dropdown-item" href="{{ route('member.import_member') }}">Import Member</a>
                                        <a class="dropdown-item" href="{{ route('member.import_profile_photo') }}">Import Member Profile Photo</a>
                                        <a class="dropdown-item" href="{{ route('member.import_horoscope') }}">Import Member Horscope</a>
                                      </div>
                                    </div>
                                </div>
                                <a href="{{ route('member.export') }}" class="btn btn-info float-right" style="margin-right: 10px;margin-top: 5px !important;">
                                    Export Xls
                                </a>
                        </div>
                        <div class="card-body ">
                            <form style="display: none" method="post" action="">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4" style="margin-bottom: 10px">
                                        <label class="col-md-12">
                                            Payment Status
                                        </label>
                                        <select class="col-md-6" name="payment_status">
                                            <option value="">All</option>
                                            <option value="1">Paid</option>
                                            <option value="0">Not Paid</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-md-12 text-right" style="margin-bottom: 10px">
                                    <a href="{{ route('admin.member.add') }}" class="btn btn-primary text-right">
                                        Add Member
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="datatable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                            <th>S NO</th>
                                            <th>Name</th>
                                            <th>Phone No</th>
                                            <th>Gender</th>
                                            <th>Account Status</th>
                                            <th>Represent By</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                            </tr>
                                        </thead>
                                        @php $sno=1 @endphp
                                        <tbody>
                                            @forelse($members as $member)
                                            <tr>
                                                <td>{{ $sno++ }}</td>
                                                <td>{{ $member->name }}</td>
                                                <td>{{ $member->phone_no }}</td>
                                                <td>{{ $member->genderName }}</td>
                                                <td>{!! $member->accountStatusText !!}</td>
                                                <td>{{ $member->represent_by->name ?? null }}</td>
                                                <td>{{ $member->created_at }}</td>
                                                <td class="text-center">
                                                    <a  class="" href="{{ route('admin.member.edit', $member->id) }}">
                                                        <i style="font-size:18px" class="text-info material-icons">edit</i>
                                                    </a>
                                                    <form style="display: inline-block" method="POST" action="{{ route('admin.member.delete', $member->id) }}" >
                                                        @csrf
                                                        @method('delete')
                                                        <a href="Javascript:void(0)" class="delete-member" data-member-name="{{ $member->name }}" data-href="{{ route('admin.member.delete', $member->id) }}">
                                                            <i style="font-size:18px" class="text-warning material-icons">delete</i>
                                                        </a>
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    No Records Found
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(".delete-member").on('click', function() {
            var memberName = $(this).data('member-name');
            if(!confirm('Are You Sure Want To Delete Member - ' + memberName + " ?")) {
                return false;
            }

            $(this).closest('form').submit();
        });

        $(document).ready(function() {
            $("#datatable").dataTable();
        });
    </script>
@endsection
