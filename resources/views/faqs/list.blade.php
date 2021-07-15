@extends('layouts.app', ['activePage' => 'typography', 'titlePage' => __('Typography')])

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
                        <h4 class="card-title float-left">{{ __('Faqs') }}</h4>
                        <a href="{{ route('faqs.create') }}" class="btn btn-success float-right"><i class="material-icons">add</i></a>
                    </div>
                    <div class="card-body ">

                        <ul class="accordion" id="sortable">
                            @foreach ($faqs as $faq )
                            <li class="card">
                                <div class="card-header" id="heading{{ $faq->id }}">
                                    <div class="pull-left">
                                        <h5 class="mb-0" data-toggle="collapse"
                                                data-target="#collapse{{ $faq->id }}" aria-expanded="true"
                                                aria-controls="collapse{{ $faq->id }}">
                                                <a class="hand"><i class="material-icons">reorder</i></a>
                                                {{ ucwords($faq->question) }}
                                        </h5>
                                        <input type="hidden" name="sequence[]" value="{{ $faq->id }}" />
                                    </div>
                                    <div class="pull-right">
                                        <form onsubmit="Javascript: return confirm('Are You Sure, Want To Remove This ?');"  method="POST" action="{{ route('faqs.destroy', $faq->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('faqs.edit', $faq->id) }}" class="btn btn-sm btn-success" data-original-title title><i class="material-icons">edit</i></a>
                                           <button type="submit" class="btn  btn-sm btn-danger"><i class="material-icons" data-original-title title>close</i></button>
                                        </form>
                                    </div>
                                </div>

                                <div id="collapse{{ $faq->id }}" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        {{ $faq->answer }}
                                    </div>
                                </div>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
        </div>
    </div>
</div>
</div>
<script>

    function updateSequence()
    {
        $.ajax({
            "url" : "/admin/faqs/update_sequence",
            "type" : "put",
            "dataType": "json",
            "data" : $("#sortable").find('[name="sequence[]"]').serialize(),
            "success" : function(data) {
                    console.log(data);
                    alert("Update Successfully");
            }
        });

    }

</script>

@endsection
