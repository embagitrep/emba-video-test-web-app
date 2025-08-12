@extends('cp.layouts.main')
@push('css')
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/vendors.min.css') }}">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/ui/prism.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/file-uploaders/dropzone.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/css/plugins/file-uploaders/dropzone.min.css') }}">

    <link type="text/css" rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/smoothness/jquery-ui.min.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="{{ url('css/plupload.css') }}" media="screen" />


    <!-- END: Vendor CSS-->
    <script src="{{ url('ckeditor/ckeditor/ckeditor.js')}}"> </script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js" charset="UTF-8"></script>

    <style>
        .img-responsive{
            max-width: 100%;
        }
    </style>


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
            $title = $(this).val();
            $.ajax({
                url:  '/ajax/checkSlug/'+$title+'/Category',
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

    <section id="nav-filled">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Category edit: {{ $post->name }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">

                                @foreach(getAllLanguages() as $language)
                                <li class="nav-item ">
                                    <a class="nav-link " id="{{ $language->code }}-tab-fill" data-toggle="tab" href="#{{ $language->code }}-fill" role="tab" aria-controls="{{ $language->code }}-fill" aria-selected="true">
                                        {{ $language->name }}
                                    </a>
                                </li>
                                @endforeach

                                    <li class="nav-item">
                                        <a class="nav-link" id="gallery-tab-fill" data-toggle="tab" href="#gallery" role="tab" aria-controls="gallery" aria-selected="true">
                                            Gallery
                                        </a>
                                    </li>

                                <li class="nav-item current">
                                    <a class="nav-link active" id="settings-tab-fill" data-toggle="tab" href="#settings-fill" role="tab" aria-controls="settings-fill" aria-selected="false">
                                        Settings
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content pt-1">
                                @foreach(getAllLanguages() as $language)

                                <div class="tab-pane" id="{{ $language->code }}-fill" role="tabpanel" aria-labelledby="{{ $language->code }}-tab-fill">
                                    <form action="{{ route('admin.category.update', ['category' => $post->id]) }}" class="form form-horizontal" id="{{$language->code}}Form" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="lang" value="{{ $language->code }}">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label>Name</label>
                                                    <input type="text" id="{{$language->code}}first-name" class="form-control" name="name" placeholder="Name" value="{{ isset($post->translation($language->code)->first()->name) ? $post->translation($language->code)->first()->name : '' }}">
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label>SEO Keywords (comma separated)</label>
                                                    <input type="text" class="form-control" name="seo_keyword" placeholder="Seo Keywords" value="{{ isset($post->translation($language->code)->first()->seo_keyword) ? $post->translation($language->code)->first()->seo_keyword : '' }}">
                                                </div>

                                                <div class="col-md-12 form-group">
                                                <label>SEO Title</label>
                                                    <input type="text" class="form-control" name="seo_title" placeholder="Seo Title" value="{{ isset($post->translation($language->code)->first()->seo_title) ? $post->translation($language->code)->first()->seo_title : '' }}">
                                                </div>
                                                <div class="col-md-12 form-group">
                                                <label>SEO Description</label>
                                                    <input type="text" class="form-control" name="seo_description" placeholder="Seo Description" value="{{ isset($post->translation($language->code)->first()->seo_description) ? $post->translation($language->code)->first()->seo_description : '' }}">
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label>Summary</label>
                                                    <textarea name="summary" id="{{$language->code}}-summary" cols="30" rows="5" placeholder="Summary" class="form-control">{{ isset($post->translation($language->code)->first()->summary) ? $post->translation($language->code)->first()->summary : '' }}</textarea>
                                                </div>
{{--                                                <div class="col-md-12 form-group">--}}
{{--                                                    <label>Banner Name</label>--}}
{{--                                                    <textarea name="banner_name" id="{{$language->code}}-ban-name" cols="30" rows="5" placeholder="Banner Name" class="form-control">{{ isset($post->translation($language->code)->first()->banner_name) ? $post->translation($language->code)->first()->banner_name : '' }}</textarea>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-12 form-group">--}}
{{--                                                    <label>Banner Summary</label>--}}
{{--                                                    <textarea name="banner_sum" id="{{$language->code}}-ban-sum" cols="30" rows="5" placeholder="Banner Summary" class="form-control">{{ isset($post->translation($language->code)->first()->banner_sum) ? $post->translation($language->code)->first()->banner_sum : '' }}</textarea>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-12 form-group">--}}
{{--                                                    <label>Banner Link</label>--}}
{{--                                                    <textarea name="banner_link" id="{{$language->code}}-ban-llink" cols="30" rows="5" placeholder="Banner Link" class="form-control">{{ isset($post->translation($language->code)->first()->banner_link) ? $post->translation($language->code)->first()->banner_link : '' }}</textarea>--}}
{{--                                                </div>--}}
                                                    <div class="col-sm-12">
                                                        <div id="full-wrapper">
                                                            <textarea name="body" id="full-container-{{$language->code}}">
                                                                {{ isset($post->translation($language->code)->first()->body) ? $post->translation($language->code)->first()->body : '' }}
                                                            </textarea>
                                                            <script type="text/javascript">

                                                                CKEDITOR.replace( 'full-container-{{$language->code}}',{
                                                                    filebrowserBrowseUrl:"{{ url('/ckeditor/kcfinder/browse.php?opener=ckeditor&type=files') }}",
                                                                    filebrowserImageBrowseUrl:"{{ url('/ckeditor/kcfinder/browse.php?opener=ckeditor&type=images') }}",
                                                                    filebrowserFlashBrowseUrl:"    {{ url('/ckeditor/kcfinder/browse.php?opener=ckeditor&type=flash') }}",
                                                                    filebrowserUploadUrl:"{{ url('/ckeditor/kcfinder/upload.php?opener=ckeditor&type=files') }}",
                                                                    filebrowserImageUploadUrl:"{{ url('/ckeditor/kcfinder/upload.php?opener=ckeditor&type=images') }}",
                                                                    filebrowserFlashUploadUrl:"{{ url('/ckeditor/kcfinder/upload.php?opener=ckeditor&type=flash') }}",
                                                                } );

                                                            </script>
                                                        </div>
                                                    </div>
                                                <div class="col-sm-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                @endforeach


                                <div class="tab-pane active" id="settings-fill" role="tabpanel" aria-labelledby="settings-tab-fill">
                                    <form action="{{ route('admin.category.update', ['category' => $post->id]) }}" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label>Name</label>
                                                    <input type="text" id="first-name" class="form-control" name="name" placeholder="Name" value="{{ $post->name }}">
                                                </div>

                                                <div class="col-md-12 form-group">
                                                    <label>Slug</label>
                                                    <input type="text" class="form-control" id="first-slug" readonly="readonly" placeholder="Slug" value="{{ $post->slug }}">
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label>Sort</label>
                                                    <input type="number" class="form-control" name="sort" placeholder="Sort" value="{{ $post->sort }}">
                                                </div>

                                                <div class="col-md-12 form-group">
                                                    <label>Parent</label>
                                                    <select name="parent_id" id="" class="form-control">
                                                        <option>Select...</option>
                                                        @foreach(\App\Model\Category::where('parent_id', '=', null)->where('id', '!=', $post->id)->get() as $category)
                                                            <option value="{{ $category->id }}" {{ $post->parent_id == $category->id?'selected':'' }}>{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                                <div class="col-3">
                                                    <label>Active</label>
                                                    <div class="custom-control custom-switch custom-switch-shadow custom-control-inline mb-1">
                                                        <input type="checkbox" class="custom-control-input" name="active" {{ $post->active ? 'checked="checked"': '' }} id="customSwitchShadow1">
                                                        <label class="custom-control-label" for="customSwitchShadow1">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <label>In Menu</label>
                                                    <div class="custom-control custom-switch custom-switch-shadow custom-control-inline mb-1">
                                                        <input type="checkbox" class="custom-control-input" name="inmenu" {{ $post->in_menu ? 'checked="checked"': '' }} id="customSwitchShadow12">
                                                        <label class="custom-control-label" for="customSwitchShadow12">
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <label>In Menu Slider</label>
                                                    <div class="custom-control custom-switch custom-switch-shadow custom-control-inline mb-1">
                                                        <input type="checkbox" class="custom-control-input" name="in_menu_slider" {{ $post->in_menu_slider ? 'checked="checked"': '' }} id="customSwitchShadow12355">
                                                        <label class="custom-control-label" for="customSwitchShadow12355">
                                                        </label>
                                                    </div>
                                                </div>



                                                <div class="col-3">
                                                    <label>Front Banner</label>
                                                    <div class="custom-control custom-switch custom-switch-shadow custom-control-inline mb-1">
                                                        <input type="checkbox" class="custom-control-input" name="front_banner" {{ $post->front_banner ? 'checked="checked"': '' }} id="customSwitchShadow1234">
                                                        <label class="custom-control-label" for="customSwitchShadow1234">
                                                        </label>
                                                    </div>
                                                </div>


                                                <div class="col-sm-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                    <div class="tab-pane" id="gallery" role="tabpanel" aria-labelledby="gallery">

                                        <div id="uploader">
                                            <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
                                        </div>
                                        <div class="photo-rel-container row mt-75">
                                            @if(isset($photos))
                                                @foreach($photos as $photo)
                                                    <div class="col-xs-6 col-sm-4 col-md-3 mt10 photo-block">
                                                        <div class="blog-item sortable" data-sortable="{{ $photo->id }}">
                                                            <img src="/uploads/{{ $photo->image }}" class="img-responsive" alt="" style="max-height: 250px">
                                                            <div class="blog-details">
                                                                <ul class="blog-meta">
                                                                    <li><a class="delete-button delete" href="{{ route('deleteGallery', ['id' => $photo->id]) }}">Delete</a></li>
                                                                </ul>
                                                            </div>
                                                            <div class="blog-content">
                                                            </div>
                                                        </div><!-- blog-item -->
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

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

    <script type="text/javascript" src="{{ url('js/jquery1.js') }}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ url('js/plupload.full.min.js') }}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ url('js/jquery.ui.plupload.min.js') }}" charset="UTF-8"></script>


    <script type="text/javascript">
        // Initialize the widget when the DOM is ready
        $(function() {

            $('.delete-button').click(function (e) {
                e.preventDefault();
                if(confirm('This photo will be deleted. Are you sure?'))
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
                items:' .photo-block',
                placeholder: "ui-state-highlight"
            });
            $( ".photo-rel-container" ).on( "sortupdate", function( event, ui ) {
                $('.photo-rel-container .photo-block').each(function(){
                    $.ajaxSetup({
                        headers: { "x-csrf-token" : "{{ csrf_token() }}"}
                    });
                    $.ajax({
                        url: '{{ route('sortUploaded') }}',
                        method: 'POST',
                        type: 'post',
                        data:{
                            id: $(this).find('.sortable').attr('data-sortable'),
                            sort: $('.photo-rel-container .photo-block').index($(this)),
                        },
                        fail: function (data, textStatus) {
                                alert( "Request failed (not saved):  " + textStatus );
                        },
                    })
                });
            });

            $("#uploader").plupload({
                // General settings
                runtimes : 'html5,flash,silverlight,html4',
                url : "{{ route('upload', ['type' => $className, 'parent' => $post->id]) }}",
                max_file_size : '10mb',
                chunk_size: '10mb',
                // resize : {
                //     width : 200,
                //     height : 200,
                //     quality : 90,
                //     crop: true // crop to exact dimensions
                // },
                filters : [
                    {title : "Image files", extensions : "jpg,gif,jpeg,png,webp"},
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
                    "x-csrf-token" : "{{ csrf_token() }}"
                },
                // file_data_name:'Gallery[pic_name]',
                init:{'FileUploaded':function(up,file,res){
                    console.log(res)
                        req = $.ajax({
                            'url':'{{ route('getLastUploaded', ['type' => $className, 'parent' => $post->id]) }}',
                            'dataType':'html',
                            'success':function(data){
                                $('.photo-rel-container').append(data);
                            },
                        });
                        req.fail(function(jqXHR,textStatus){
                            if (confirm('Error occured, refresh please')){}
                            //window.location.reload();
                        });
                    }}
            });
        });
    </script>
@endpush
