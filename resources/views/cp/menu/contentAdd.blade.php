@extends('cp.layouts.main')
@push('css')

    <link rel="stylesheet" type="text/css" href="{{ url('vendor/css/bootstrap-colorpicker.css') }}">

@endpush
@push('scripts')
    <script>
        $('#first-name').on('change', function () {
            if($(this).val().length)
                $('#submit').attr('disabled', false)
            $('#submit').attr('disabled', true)
        });
        $('#first-name').on('blur', function (e) {
            e.preventDefault();
            let title = $(this).val();
            $.ajax({
                url:  '{{ route('admin.str.slug',['type' => 'Page']) }}?title='+title,
                type: 'GET',
                method: 'GET',
                complete: function (data) {
                    $resp = data.responseJSON;
                    if($resp.success){
                        $('#first-slug').val($resp.slug);
                        $('#submit').attr('disabled', false)
                    }
                }
            })
        })
    </script>

@endpush

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add New Page</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" action="{{ route('admin.menu.add.content', ['menu' => $menu->id]) }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>Name</label>
                                            <input type="text" id="first-name" class="form-control" name="name" placeholder="Name">
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Slug</label>
                                            <input type="text" id="first-slug" readonly="readonly" class="form-control" name="slug" placeholder="Slug">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Keyword</label>
                                            <input type="text"  class="form-control" name="keyword" placeholder="Keyword">
                                        </div>
{{--                                        <div class="col-md-12 form-group">--}}
{{--                                            <label>Video Link</label>--}}
{{--                                            <input type="text" class="form-control color-pickers" name="video_link" placeholder="Video Link" value="">--}}
{{--                                        </div>--}}

{{--                                        <div class="col-md-12 form-group">--}}
{{--                                            <label>Text Color</label>--}}
{{--                                            <input type="text" class="form-control color-pickers" name="color" placeholder="Text Color" value="">--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-12 form-group">--}}
{{--                                            <label>BG Color</label>--}}
{{--                                            <input type="text" class="form-control color-pickers" name="bg_color" placeholder="BG Color" value="">--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6 form-group">--}}
{{--                                            <label>Icon</label>--}}
{{--                                            <input type="text" class="form-control" name="icon" placeholder="Icon" value="">--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6 form-group">--}}
{{--                                            <label>Icon List</label><br>--}}
{{--                                            <a href="http://ufcedu.az/az/fa-icons" target="_blank" class="btn btn-primary">List</a>--}}
{{--                                        </div>--}}

                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button type="submit" id="submit" disabled class="btn btn-primary mr-1 mb-1">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection()
