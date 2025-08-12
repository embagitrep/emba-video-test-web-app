@push('css')

    <link type="text/css" rel="stylesheet"
          href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/smoothness/jquery-ui.min.css"
          media="screen"/>
    <link type="text/css" rel="stylesheet" href="{{ url('css/plupload.css') }}" media="screen"/>

    <style>
        @media (max-width: 765px) {
            .plupload_wrapper {
                min-width: 100%;
            }
        }
    </style>

    <!-- END: Vendor CSS-->
    <script src="{{ url('ckeditor/ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"
            charset="UTF-8"></script>

@endpush
@push('scripts')

    <script type="text/javascript" src="{{ url('js/jquery1.js') }}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ url('js/plupload.full.min.js') }}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ url('js/jquery.ui.plupload.min.js') }}" charset="UTF-8"></script>


    <script type="text/javascript">
        // Initialize the widget when the DOM is ready
        $(function () {

            $(document).on('click','.delete-button',function (e) {
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
            });
            $(document).on('change','.js--galleryPosition',function (e) {
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
                            alert('Saved')
                        }
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
                    {title: "Image files", extensions: "jpg,gif,jpeg,png,svg,webp,mp4"},
                    {title: "Document files", extensions: "doc,docx,pdf"},
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


<div class="tab-pane" id="gallery" role="tabpanel" aria-labelledby="gallery">

    <div id="uploader">
        <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
    </div>
    <div class="photo-rel-container row mt-75">
        @if(isset($photos))
            @foreach($photos as $photo)
                @php
                    $filename = public_path().'/uploads/'.$photo->image;
                      $ext = pathinfo($filename, PATHINFO_EXTENSION);
                @endphp
                <div class="col-xs-6 col-sm-4 col-md-3 mt10 photo-block">
                    <div class="blog-item sortable" data-sortable="{{ $photo->id }}">
                        @if($ext == 'pdf'|| $ext== 'doc' || $ext=='docx')
                            <a href="/uploads/{{ $photo->image }}">
                                <i class="bx bx-file"></i>
                                Show
                            </a>
                        @else
                            @php
                                $imgPath = $photo->file_name;
                                if (!filter_var($imgPath,FILTER_VALIDATE_URL)){
                                    $imgPath = "/uploads/$className/".$photo->file_name;
                                }
                            @endphp
                            <img src="{{ $imgPath }}" class="img-responsive" alt="" style="max-height: 250px">
                        @endif
                        <div class="blog-details">
                            <ul class="blog-meta pl-0">
                                <li class="list-inline-item"><a class="delete-button delete btn btn-danger" href="{{ route('deleteGallery', ['id' => $photo->id]) }}">Delete</a></li>
                                <li class="list-inline-item mt-1">
                                    <select data-link="{{ route('editGallery', ['id' => $photo->id]) }}" class="js--galleryPosition form-control">
                                        <option value="">Select type</option>
                                        @foreach(getVenuePhotoTypes() as $key => $type)
                                            <option {{ $photo->file_type==$key?'selected':'' }} value="{{ $key }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </li>
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
