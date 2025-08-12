@extends('cp.layouts.main')
@push('css')
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/editors/quill/katex.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/editors/quill/quill.snow.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/editors/quill/quill.bubble.css') }}">
    <!-- END: Vendor CSS-->
    <script src="{{ url('ckeditor/ckeditor/ckeditor.js')}}"> </script>

@endpush
@push('scripts')
    <script>
        $('#languages').change(function () {
            $val = $(this).val()
            $('.vals').addClass('hidden');
            $('.vals[data-lang='+$val+']').removeClass('hidden');
            $('.val__inp').attr('disabled', true)
            $('.val__inp[data-lang='+$val+']').attr('disabled', false)
        })
    </script>
@endpush

@section('content')

    <section id="nav-filled">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Setting edit: {{ $setting->name }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">


                                <li class="nav-item current">
                                    <a class="nav-link active" id="settings-tab-fill" data-toggle="tab" href="#settings-fill" role="tab" aria-controls="settings-fill" aria-selected="false">
                                        Settings
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content pt-1">


                                <div class="tab-pane active" id="settings-fill" role="tabpanel" aria-labelledby="settings-tab-fill">
                                    <form action="{{ route('admin.setting.edit', ['setting' => $setting->id]) }}" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label>Name</label>
                                                    <input type="text" id="first-name" class="form-control" name="name" placeholder="Name" readonly="readonly" value="{{ $setting->name }}">
                                                </div>

                                                    <div class="col-md-12 form-group">
                                                        <label>Value</label>
                                                        <input type="text" id="first-name" class="form-control val__inp" name="value" placeholder="Value"  value="{{ $setting->value }}">
                                                    </div>


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
            </div>
        </div>
    </section>
@endsection()
@push('scripts')
{{--    <script src="{{ asset('public/ckeditor/ckeditor/ckeditor.js')}}"> </script>--}}
@endpush
