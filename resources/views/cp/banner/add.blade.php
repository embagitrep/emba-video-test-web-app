@extends('cp.layouts.main')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add new banner</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" action="{{ route('admin.banner.add') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>Name</label>
                                            <input type="text" id="first-name" class="form-control" name="name" placeholder="Name">
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Type</label>
                                            <select name="type" id="" class="form-control">
                                                <option value="">Choose..</option>
                                                @foreach(bannerTypes() as $key => $type)
                                                    <option value="{{ $key }}" >{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Image</label>
                                            <input type="file" id="contact-info" accept="image/*" class="form-control" name="image">
                                        </div>
{{--                                        <div class="col-md-12 form-group">--}}
{{--                                            <label>Second Image</label>--}}
{{--                                            <input type="file" id="contact-info" accept="image/*" class="form-control" name="image2">--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-12 form-group">--}}
{{--                                            <label>Video</label>--}}
{{--                                            <input type="file" id="contact-video" accept="video/*" class="form-control" name="video">--}}
{{--                                        </div>--}}

                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
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
