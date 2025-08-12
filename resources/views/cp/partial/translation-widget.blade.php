
@push('css')
    <script src="{{ url('ckeditor/ckeditor/ckeditor.js')}}"></script>
@endpush

<div class="tab-pane" id="{{ $language }}-fill" role="tabpanel"
     aria-labelledby="{{ $language }}-tab-fill">
    <input type="hidden" name="lang" value="{{ $language }}">
    <div class="form-body">
        <div class="row">
            <div class="col-md-12 form-group">
                <label>Name</label>
                <input type="text" id="{{$language}}first-name"
                       class="form-control" name="{{ $language }}[name]"
                       placeholder="Name"
                       value="{{ $post->getTranslation('name',$language) }}">
            </div>
            @isset($link)
            <div class="col-md-12 form-group">
                <label>Link</label>
                <input type="text" id="{{$language}}first-link"
                       class="form-control" name="{{ $language }}[link]"
                       placeholder="Link"
                       value="{{ $post->getTranslation('link',$language)  }}">
            </div>
                <div class="col-md-12 form-group">
                    <label>Button Name</label>
                    <input type="text" id="{{$language}}first-link"
                           class="form-control" name="{{ $language }}[link_name]"
                           placeholder="Button Name"
                           value="{{ $post->getTranslation('link_name',$language)  }}">
                </div>
            @endisset
            @isset($seo)
                <div class="col-md-12 form-group">
                    <label>SEO Keywords (comma separated)</label>
                    <input type="text" class="form-control"
                           name="{{ $language }}[seo_keyword]"
                           placeholder="Seo Keywords"
                           value="{{ $post->getTranslation('seo_keyword',$language)  }}">
                </div>

                <div class="col-md-12 form-group">
                    <label>SEO Title</label>
                    <input type="text" class="form-control"
                           name="{{ $language }}[seo_title]" placeholder="Seo Title"
                           value="{{ $post->getTranslation('seo_title',$language) }}">
                </div>
                <div class="col-md-12 form-group">
                    <label>SEO Description</label>
                    <input type="text" class="form-control"
                           name="{{ $language }}[seo_description]"
                           placeholder="Seo Description"
                           value="{{ $post->getTranslation('seo_description',$language) }}">
                </div>
            @endisset

            <div class="col-md-12 form-group">
                <label>Summary</label>
                <textarea name="{{ $language }}[summary]"
                          id="{{$language}}-summary" cols="30" rows="5"
                          placeholder="Summary"
                          class="form-control">{{ $post->getTranslation('summary',$language) }}</textarea>
            </div>
            @isset($desc)
            <div class="col-sm-12">
                <div id="full-wrapper">
                    <textarea name="{{ $language }}[body]" id="full-container-{{$language}}">
                        {{ $post->getTranslation('body',$language) }}
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
            @endisset
            <div class="col-sm-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit
                </button>
            </div>
        </div>
    </div>
</div>
