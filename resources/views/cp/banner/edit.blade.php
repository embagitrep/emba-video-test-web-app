@extends('cp.layouts.main')
@push('css')
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/editors/quill/katex.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ url('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/editors/quill/quill.snow.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/editors/quill/quill.bubble.css') }}">
    <!-- END: Vendor CSS-->
    <script src="{{ url('ckeditor/ckeditor/ckeditor.js')}}"></script>

@endpush

@section('content')

    <section id="nav-filled">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Banner edit: {{ $banner->name }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">

                                @foreach(locales() as $language => $k)
                                    <li class="nav-item ">
                                        <a class="nav-link " id="{{ $language }}-tab-fill" data-toggle="tab"
                                           href="#{{ $language }}-fill" role="tab"
                                           aria-controls="{{ $language }}-fill" aria-selected="true">
                                            {{ $language }}
                                        </a>
                                    </li>
                                @endforeach

                                <li class="nav-item current">
                                    <a class="nav-link active" id="settings-tab-fill" data-toggle="tab"
                                       href="#settings-fill" role="tab" aria-controls="settings-fill"
                                       aria-selected="false">
                                        Settings
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <form action="{{ route('admin.banner.edit', ['banner' => $banner->id]) }}"
                                  class="form form-horizontal" id="{{$language}}Form" method="post"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="tab-content pt-1">
                                    @foreach(locales() as $language => $k)

                                        <div class="tab-pane " id="{{ $language }}-fill" role="tabpanel"
                                             aria-labelledby="{{ $language }}-tab-fill">
                                            <input type="hidden" name="lang" value="{{ $language }}">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-12 form-group">
                                                        <label>Name</label>
                                                        <input type="text" id="{{$language}}first-name"
                                                               class="form-control" name="{{ $language }}[name]" placeholder="Name"
                                                               value="{{ isset($banner->translation($language)->first()->name) ? $banner->translation($language)->first()->name : '' }}">
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label>Link</label>
                                                        <input type="text" class="form-control" name="{{$language}}[link]"
                                                               placeholder="Link"
                                                               value="{{ isset($banner->translation($language)->first()->link) ? $banner->translation($language)->first()->link : '' }}">
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label>Button Name</label>
                                                        <input type="text" class="form-control" name="{{$language}}[link_name]"
                                                               placeholder="Link"
                                                               value="{{ isset($banner->translation($language)->first()->link_name) ? $banner->translation($language)->first()->link_name : '' }}">
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label>Summary</label>
                                                        <textarea name="{{ $language }}[summary]" id="{{$language}}-summary"
                                                                  cols="30" rows="5" placeholder="Summary"
                                                                  class="form-control">{{ isset($banner->translation($language)->first()->summary) ? $banner->translation($language)->first()->summary : '' }}</textarea>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div id="full-wrapper">
                                                            <textarea name="{{ $language }}[body]"
                                                                      id="full-container-{{$language}}">
                                                                {{ isset($banner->translation($language)->first()->body) ? $banner->translation($language)->first()->body : '' }}
                                                            </textarea>
                                                            <script type="text/javascript">

                                                                CKEDITOR.replace('full-container-{{$language}}', {
                                                                    filebrowserBrowseUrl: "{{ url('/ckeditor/kcfinder/browse.php?opener=ckeditor&type=files') }}",
                                                                    filebrowserImageBrowseUrl: "{{ url('/ckeditor/kcfinder/browse.php?opener=ckeditor&type=images') }}",
                                                                    filebrowserFlashBrowseUrl: "    {{ url('/ckeditor/kcfinder/browse.php?opener=ckeditor&type=flash') }}",
                                                                    filebrowserUploadUrl: "{{ url('/ckeditor/kcfinder/upload.php?opener=ckeditor&type=files') }}",
                                                                    filebrowserImageUploadUrl: "{{ url('/ckeditor/kcfinder/upload.php?opener=ckeditor&type=images') }}",
                                                                    filebrowserFlashUploadUrl: "{{ url('/ckeditor/kcfinder/upload.php?opener=ckeditor&type=flash') }}",
                                                                });

                                                            </script>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach

                                    <div class="tab-pane active" id="settings-fill" role="tabpanel"
                                         aria-labelledby="settings-tab-fill">

                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label>Name</label>
                                                    <input type="text" id="first-name" class="form-control" name="name"
                                                           placeholder="Name" value="{{ $banner->name }}">
                                                </div>
                                                {{--                                                <div class="col-md-12 form-group">--}}
                                                {{--                                                    <label>Sort</label>--}}
                                                {{--                                                    <input type="number" class="form-control" name="sort" placeholder="Sort" value="{{ $banner->sort }}">--}}
                                                {{--                                                </div>  --}}
{{--                                                <div class="col-md-12 form-group">--}}
{{--                                                    <label for="">Gender</label>--}}
{{--                                                    <select name="gender" id="" class="form-control">--}}
{{--                                                        <option value="">Choose..</option>--}}
{{--                                                        <option--}}
{{--                                                            value="male" {{ $banner->gender == 'male'?'selected':'' }}>--}}
{{--                                                            Male--}}
{{--                                                        </option>--}}
{{--                                                        <option--}}
{{--                                                            value="female" {{ $banner->gender == 'female'?'selected':'' }}>--}}
{{--                                                            Female--}}
{{--                                                        </option>--}}
{{--                                                    </select>--}}
{{--                                                </div>--}}
                                                <div class="col-md-12 form-group">
                                                    <label>Type</label>
                                                    <select name="type" id="" class="form-control">
                                                        <option value="">Choose..</option>
                                                        @foreach(bannerTypes() as $key => $type)
                                                            <option
                                                                value="{{ $key }}" {{ $key == $banner->type? 'selected':'' }}>{{ $type }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label>Image</label>
                                                    <input type="file" id="contact-info" class="form-control"
                                                           name="image">
                                                </div>
                                                {{--                                                <div class="col-md-12 form-group">--}}
                                                {{--                                                    <label>Second Image</label>--}}
                                                {{--                                                    <input type="file" id="contact-info" accept="image/*" class="form-control" name="image2">--}}
                                                {{--                                                </div>--}}
                                                {{--                                                <div class="col-md-12 form-group">--}}
                                                {{--                                                    <label>Video</label>--}}
                                                {{--                                                    <input type="file" id="contact-video" accept="video/*" class="form-control" name="video">--}}
                                                {{--                                                </div>--}}
                                                <div class="col-sm-3">
                                                    <img src="{{ url('uploads/'.$banner->image) }}"
                                                         class="img-thumbnail card-img" alt="">
                                                </div>
                                                {{--                                                <div class="col-sm-3">--}}
                                                {{--                                                    <img src="{{ url('uploads/'.$banner->image2) }}" class="img-thumbnail card-img" alt="">--}}
                                                {{--                                                </div>--}}
                                                {{--                                                <div class="col-sm-3">--}}
                                                {{--                                                    <video src="{{ url('uploads/'.$banner->video) }}" controls style="width: 100%"></video>--}}
                                                {{--                                                </div>--}}
                                                <div class="col-sm-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Submit
                                                    </button>
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
    </section>
@endsection()
@push('scripts')
    {{--    <script src="{{ asset('public/ckeditor/ckeditor/ckeditor.js')}}"> </script>--}}
@endpush
