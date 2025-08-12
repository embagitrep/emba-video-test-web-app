@extends('cp.layouts.main')

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
                url:  '/ajax/checkSlug/Menu?title='+$title,
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
@endpush

@section('content')

    <section id="nav-filled">
        <div class="row">
            <div class="col-md-12">
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">{{ getTranslation($error) }}</div>
                    @endforeach
                @endif
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Product edit: {{ $post->name }}</h4>
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
                            <form action="{{ route('admin.menu.update', ['menu' => $post->id]) }}"
                                  class="form form-horizontal" id="{{$language}}Form" method="post"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="tab-content pt-1">
                                    @foreach(locales() as $language => $k)
                                        <?php $link = true; $seo = true?>
                                        @include('cp.partial.translation-widget')
                                    @endforeach


                                    <div class="tab-pane active" id="settings-fill" role="tabpanel"
                                         aria-labelledby="settings-tab-fill">

                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label>Name</label>
                                                    <input type="text" id="first-name" class="form-control" name="name"
                                                           placeholder="Name" value="{{ $post->name }}">
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <label>Slug</label>
                                                    <input type="text" class="form-control" id="first-slug" name="slug"
                                                           readonly="readonly" placeholder="Slug"
                                                           value="{{ $post->slug }}">
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <label>Keyword</label>
                                                    <input type="text"  class="form-control" name="keyword" value="{{ $post->keyword }}" placeholder="Keyword">
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <label>Link</label>
                                                    <input type="text" class="form-control" name="link"
                                                           placeholder="Link"
                                                           value="{{ $post->link }}">
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <label>Sort</label>
                                                    <input type="number" class="form-control" name="sort"
                                                           placeholder="sort" value="{{ $post->sort }}">
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <label>Type</label>
                                                    <select name="type" id="" class="form-control">
                                                        <option value="">Choose..</option>
                                                        <option
                                                            {{ $post->type === 'static'? 'selected':'' }} value="static">
                                                            Static
                                                        </option>
                                                        <option
                                                            {{ $post->type === 'dynamic'? 'selected':'' }} value="dynamic">
                                                            Dynamic
                                                        </option>
                                                    </select>
                                                </div>



                                                <div class="col-4">
                                                    <label>Active</label>
                                                    <div
                                                        class="custom-control custom-switch custom-switch-shadow custom-control-inline mb-1">
                                                        <input type="checkbox" class="custom-control-input"
                                                               name="active"
                                                               {{ $post->active ? 'checked="checked"': '' }} id="customSwitchShadow1">
                                                        <label class="custom-control-label" for="customSwitchShadow1">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <label>Blank</label>
                                                    <div
                                                        class="custom-control custom-switch custom-switch-shadow custom-control-inline mb-1">
                                                        <input type="checkbox" class="custom-control-input"
                                                               name="blank"
                                                               {{ $post->blank ? 'checked="checked"': '' }} id="customSwitchShadow1blank">
                                                        <label class="custom-control-label" for="customSwitchShadow1blank">
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <label>In Menu</label>
                                                    <div
                                                        class="custom-control custom-switch custom-switch-shadow custom-control-inline mb-1">
                                                        <input type="checkbox" class="custom-control-input"
                                                               name="inmenu"
                                                               {{ $post->in_menu ? 'checked="checked"': '' }}  id="customSwitchShadow123">
                                                        <label class="custom-control-label" for="customSwitchShadow123">
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

