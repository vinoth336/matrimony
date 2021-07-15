@extends('layouts.app', ['activePage' => 'testimonials', 'titlePage' => __('Typography')])

@section('content')

    <link rel="stylesheet" href="{{ asset('web/css/draganddrop.css') }}" type="text/css" />
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
                                <h4 class="card-title float-left">{{ __('Testimonials') }}</h4>
                                <a href="{{ route('testimonials.create') }}" class="btn btn-success float-right"><i class="material-icons">add</i></a>
                        </div>
                        <?php
                            $sno = 1;
                        ?>
                        <div class="card-body ">
                            <div class="table-responsive">
                                <table id="datatables" class="table table-striped table-no-bordered table-hover dataTable dtr-inline">
                                    <thead class=" text-dark text-bold">
                                        <th>
                                            S NO
                                        </th>
                                        <th>
                                            Members Name
                                        </th>
                                        <th>
                                            Message
                                        </th>

                                        <th>
                                            On
                                        </th>

                                        <th>
                                            Actions
                                        </th>
                                    </thead>
                                    <tbody>
                                        @foreach ($testimonials as $testimonial )
                                            <tr>
                                                <td>{{ $sno++ }}</td>
                                                <td>{{ $testimonial->client_name }}</td>
                                                <td>{{ substr($testimonial->comment, 0, 100) }}...</td>
                                                <td>{{ $testimonial->created_at }}</td>
                                                <td class="text-right">
                                                    <form method="post" action="{{ route('testimonials.destroy', $testimonial->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                    <a href="{{ route('testimonials.edit', $testimonial->id) }}" class="btn btn-link btn-warning btn-just-icon show"><i class="material-icons">edit</i></a>
                                                    <button type="submit" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i><div class="ripple-container"></div></button>
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
    <script>

        $(document).ready(function() {

               $("#datatables").dataTable();
        });


    </script>

@endsection
