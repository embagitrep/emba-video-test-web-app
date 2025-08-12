@extends('cp.layouts.main')

@push('scripts')
    <script>
        $('#first-name').on('change', function () {
            if($(this).val().length)
                $('#submit').attr('disabled', false)
            $('#submit').attr('disabled', true)
        });
        $('#first-name').on('blur', function (e) {
            e.preventDefault();
            $title = $(this).val();
            $.ajax({
                url:  '/ajax/checkSlug/Menu?title='+$title,
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
                        <h4 class="card-title">Add New Menu</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" action="{{ route('admin.menu.add') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Name</label>
                                            <input type="text" id="first-name" class="form-control" name="name" placeholder="Name">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Slug</label>
                                            <input type="text" id="first-slug" readonly="readonly" class="form-control" name="slug" placeholder="Slug">
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label>Keyword</label>
                                            <input type="text"  class="form-control" name="keyword" placeholder="Keyword">
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label>Sort</label>
                                            <input type="number"  class="form-control" name="sort" placeholder="sort">
                                        </div>


                                        <div class="col-md-6 form-group">
                                            <label>Type</label>
                                            <select name="type" id="" class="form-control">
                                                <option value="">Choose..</option>
                                                <option value="static">Static</option>
                                                <option value="dynamic">Dynamic</option>
                                            </select>
                                        </div>

                                        <div class="col-4">
                                            <label>Active</label>
                                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline mb-1">
                                                <input type="checkbox" class="custom-control-input" name="active"  id="customSwitchShadow1">
                                                <label class="custom-control-label" for="customSwitchShadow1">
                                                </label>
                                            </div>
                                        </div>


                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button type="submit" disabled="true" id="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
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
