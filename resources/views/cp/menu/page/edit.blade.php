@extends('cp.layouts.main')
@push('css')
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/vendors.min.css') }}">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/ui/prism.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/file-uploaders/dropzone.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/css/plugins/file-uploaders/dropzone.min.css') }}">

    <link type="text/css" rel="stylesheet"
          href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/smoothness/jquery-ui.min.css"
          media="screen"/>
    <link type="text/css" rel="stylesheet" href="{{ url('css/plupload.css') }}" media="screen"/>


    <!-- END: Vendor CSS-->
    <script src="{{ url('ckeditor/ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"
            charset="UTF-8"></script>

    <link rel="stylesheet" type="text/css" href="{{ url('vendor/css/bootstrap-colorpicker.css') }}">

@endpush

@push('scripts')
    <script>
        $('#first-name').on('change', function () {
            if ($(this).val().length)
                $('#submit').attr('disabled', false)
            $('#submit').attr('disabled', true)
        });
        $('#first-name').on('blur', function (e) {
            e.preventDefault();
            $title = $(this).val();
            $.ajax({
                url: '/ajax/checkSlug/Page?title=' + $title,
                type: 'GET',
                method: 'GET',
                complete: function (data) {
                    $resp = data.responseJSON;
                    if ($resp.success) {
                        $('#first-slug').val($resp.slug);
                        $('#submit').attr('disabled', false)
                    }
                }
            })
        })
    </script>
    <script src="{{ url('vendor/js/bootstrap-colorpicker.js')}}"></script>
    <script>
        if($('.color-pickers').length)
            $('.color-pickers').colorpicker();

        let linkCounter = 1;

        $('.js--addInput').click(function () {
            let _this = $(this);
            let newInps = '<div class="col-md-5 mt-1"> ' +
                '<input type="text" class="form-control" name="links[' + linkCounter + '][name]" placeholder="Name"> ' +
                '</div>' +
                ' <div class="col-md-6 mt-1"> ' +
                '<input type="text" class="form-control" name="links[' + linkCounter + '][link]" placeholder="Link"> ' +
                '</div> ' +
                '<div class="col-md-1 mt-1"> ' +
                '<i class="bx bx-minus js--removeInp"></i> ' +
                '</div>';
            _this.closest('.row').append(newInps);
            linkCounter++;
        })

        $(document).on('click', '.js--removeInp', function () {
            let parent = $(this).parents('.col-md-1'), neig = parent.prev('.col-md-6'), neig1 = neig.prev('.col-md-5')
            parent.remove();
            neig.remove()
            neig1.remove()
        })

    </script>
@endpush

@section('content')

    <div class="content-header row">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-10">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item active">
                                <a href="{{ route('admin.menu.content', ['menu' => $post->menu_id]) }}">List</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="nav-filled">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Page edit: {{ $post->name }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">

                                @foreach(locales() as $language => $k)
                                    <li class="nav-item ">
                                        <a class="nav-link " id="{{ $language }}-tab-fill" data-toggle="tab"
                                           href="#{{ $language }}-fill" role="tab" aria-controls="{{ $language }}-fill"
                                           aria-selected="true">
                                            {{ $language }}
                                        </a>
                                    </li>
                                @endforeach

                                <li class="nav-item">
                                    <a class="nav-link" id="gallery-tab-fill" data-toggle="tab" href="#gallery"
                                       role="tab" aria-controls="gallery" aria-selected="true">
                                        Gallery
                                    </a>
                                </li>

                                <li class="nav-item current">
                                    <a class="nav-link active" id="settings-tab-fill" data-toggle="tab"
                                       href="#settings-fill" role="tab" aria-controls="settings-fill"
                                       aria-selected="false">
                                        Settings
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <form action="{{ route('admin.page.update', ['page' => $post->id]) }}"
                                  class="form form-horizontal" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="tab-content pt-1">

                                    @foreach(locales() as $language => $k)
                                            <?php $link = true; $seo = true ?>
                                        @include('cp.partial.translation-widget')
                                    @endforeach


                                    <div class="tab-pane active" id="settings-fill" role="tabpanel"
                                         aria-labelledby="settings-tab-fill">

                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label>Name</label>
                                                    <input type="text" id="first-name" class="form-control" name="name"
                                                           placeholder="Name" value="{{ $post->name }}">
                                                </div>

                                                <div class="col-md-12 form-group">
                                                    <label>Slug</label>
                                                    <input type="text" class="form-control" id="first-slug" name="slug"
                                                           readonly="readonly" placeholder="Slug"
                                                           value="{{ $post->slug }}">
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <label>Keyword</label>
                                                    <input type="text" class="form-control" name="keyword"
                                                           value="{{ $post->keyword }}" placeholder="Keyword">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label>Sort</label>
                                                    <input type="number" class="form-control" name="sort"
                                                           value="{{ $post->sort }}" placeholder="sort">
                                                </div>
                                                <div class="col-12"></div>


                                                {{--                                                <div class="col-md-12 form-group">--}}
                                                {{--                                                    <label>Type</label>--}}
                                                {{--                                                    <select name="type" id="" class="form-control">--}}
                                                {{--                                                        <option value="">Choose..</option>--}}
                                                {{--                                                        <option value="static">Static</option>--}}
                                                {{--                                                        <option value="dynamic">Dynamic</option>--}}
                                                {{--                                                    </select>--}}
                                                {{--                                                </div>--}}

                                                {{--                                                <div class="col-md-12 form-group">--}}
                                                {{--                                                    <label>Video Link</label>/--}}
                                                {{--                                                    <input type="text" class="form-control color-pickers" name="video_link" placeholder="Video Link" value="{{ $post->video_link }}">--}}
                                                {{--                                                </div>--}}

                                                {{--                                                <div class="col-md-12 form-group">--}}
                                                {{--                                                    <label>Text Color</label>--}}
                                                {{--                                                    <input type="text" class="form-control color-pickers" name="color" placeholder="Text Color" value="{{ $post->color }}">--}}
                                                {{--                                                </div>--}}
                                                {{--                                                <div class="col-md-12 form-group">--}}
                                                {{--                                                    <label>BG Color</label>--}}
                                                {{--                                                    <input type="text" class="form-control color-pickers" name="bg_color" placeholder="BG Color" value="{{ $post->bg_color }}">--}}
                                                {{--                                                </div>--}}
                                                {{--                                                <div class="col-md-6 form-group">--}}
                                                {{--                                                    <label>Icon</label>--}}
                                                {{--                                                    <input type="text" class="form-control" name="icon" placeholder="Icon" value="{{ $post->icon }}">--}}
                                                {{--                                                </div>--}}

                                                <div class="col-2">
                                                    <label>Active</label>
                                                    <div class="custom-control custom-switch custom-switch-shadow custom-control-inline mb-1">
                                                        <input type="checkbox" class="custom-control-input"
                                                               name="active"
                                                               {{ $post->active ? 'checked="checked"': '' }} id="customSwitchShadow1">
                                                        <label class="custom-control-label" for="customSwitchShadow1">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <label>Show In Menu</label>
                                                    <div class="custom-control custom-switch custom-switch-shadow custom-control-inline mb-1">
                                                        <input type="checkbox" class="custom-control-input"
                                                               name="in_menu"
                                                               {{ $post->in_menu ? 'checked="checked"': '' }} id="customSwitchShadow12">
                                                        <label class="custom-control-label" for="customSwitchShadow12">
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @include('cp.partial.gallery-widget')

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

    <script type="text/javascript" src="{{ url('js/jquery1.js') }}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ url('js/plupload.full.min.js') }}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ url('js/jquery.ui.plupload.min.js') }}" charset="UTF-8"></script>


    <script type="text/javascript">
        // Initialize the widget when the DOM is ready
        $(function () {

            $('.delete-button').click(function (e) {
                e.preventDefault();
                if (confirm('This photo will be deleted. Are you sure?'))
                    $.ajax({
                        url: $(this).attr('href'),
                        context: this,
                        data: {'ajax': 1},
                        success: function (data) {
                            $(this).parents('.photo-block').hide()
                        }
                    })
            })

            $('.photo-rel-container').sortable({
                items: ' .photo-block',
                placeholder: "ui-state-highlight"
            });
            $(".photo-rel-container").on("sortupdate", function (event, ui) {
                $('.photo-rel-container .photo-block').each(function () {
                    $.ajaxSetup({
                        headers: {"x-csrf-token": "{{ csrf_token() }}"}
                    });
                    $.ajax({
                        url: '{{ route('sortUploaded') }}',
                        method: 'POST',
                        type: 'post',
                        data: {
                            id: $(this).find('.sortable').attr('data-sortable'),
                            sort: $('.photo-rel-container .photo-block').index($(this)),
                        },
                        fail: function (data, textStatus) {
                            alert("Request failed (not saved):  " + textStatus);
                        },
                    })
                });
            });
            $(document).on('blur', '.js--galleryPosition', function (e) {
                let form = $(this), formData = {
                    '_token': "{{ csrf_token() }}",
                    'position': form.val()
                }
                $.ajax({
                    url: form.data('link'),
                    type: 'post',
                    data: formData,
                    complete: function (data) {
                        let res = data.responseJSON
                        if (res.success) {
                            // alert('Saved')
                        }
                    }
                })
            })

            $("#uploader").plupload({
                // General settings
                runtimes: 'html5,flash,silverlight,html4',
                url: "{{ route('upload', ['type' => $className, 'parent' => $post->id]) }}",
                max_file_size: '10mb',
                chunk_size: '10mb',
                // resize : {
                //     width : 200,
                //     height : 200,
                //     quality : 90,
                //     crop: true // crop to exact dimensions
                // },
                filters: [
                    {title: "Image files", extensions: "jpg,gif,jpeg,png,svg,webp"},
                    {title: "PDF files", extensions: "pdf"},
                    {title: "WORD files", extensions: "doc,docx"},
                ],
                rename: true,
                sortable: true,
                dragdrop: true,
                views: {
                    list: true,
                    thumbs: true, // Show thumbs
                    active: 'thumbs'
                },
                headers: {
                    "x-csrf-token": "{{ csrf_token() }}"
                },
                // file_data_name:'Gallery[pic_name]',
                init: {
                    'FileUploaded': function (up, file, res) {
                        console.log(res)
                        req = $.ajax({
                            'url': '{{ route('getLastUploaded', ['type' => $className, 'parent' => $post->id]) }}',
                            'dataType': 'html',
                            'success': function (data) {
                                $('.photo-rel-container').append(data);
                            },
                        });
                        req.fail(function (jqXHR, textStatus) {
                            if (confirm('Error occured, refresh please')) {
                            }
                            //window.location.reload();
                        });
                    }
                }
            });
        });
    </script>
@endpush
