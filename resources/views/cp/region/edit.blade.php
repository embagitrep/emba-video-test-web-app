@extends('cp.layouts.main')
@push('css')
    <!-- END: Vendor CSS-->
    <script src="{{ url('ckeditor/ckeditor/ckeditor.js')}}"></script>


@endpush

@push('scripts')

@endpush
@section('content')

    <section id="nav-filled">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Region edit: {{ $region->name }}</h4>
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



                                <li class="nav-item current">
                                    <a class="nav-link active" id="settings-tab-fill" data-toggle="tab"
                                       href="#settings-fill" role="tab" aria-controls="settings-fill"
                                       aria-selected="false">
                                        Settings
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <form action="{{ route('admin.region.update', ['region' => $region->id]) }}"
                                  class="form form-horizontal" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="tab-content pt-1">
                                    @foreach(locales() as $language => $k)

                                        @include('cp.partial.translation-widget',['post' => $region])

                                    @endforeach


                                    <div class="tab-pane active" id="settings-fill" role="tabpanel"
                                         aria-labelledby="settings-tab-fill">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label>Name</label>
                                                    <input type="text" id="first-name" class="form-control" name="name"
                                                           placeholder="Name" value="{{ $region->name }}">
                                                </div>




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
