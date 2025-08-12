@extends('cp.layouts.main')

@push('scripts')
@endpush

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit: {{ $model->name }}</h4>
                    </div>
                    <div class="card-content">
                        @include('cp.partial.errors-widget')
                        @include('cp.partial.alert-widget')

                        <div class="card-body">
                            <form class="form form-horizontal" action="{{ route('admin.vendor.update',['vendor' => $model->id]) }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label>Name</label>
                                            <input type="text" id="first-name" value="{{ $model->name }}" class="form-control" name="name" placeholder="Name">
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label>Processing time</label>
                                            <input type="text" class="form-control" value="{{ $model->process_time }}" name="process_time" placeholder="Processing time">
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label>Max installment</label>
                                            <input type="text" class="form-control" value="{{ $model->max_installment }}" name="max_installment" placeholder="Max installment">
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label>Provider</label>
                                            <select name="provider" class="form-control" >
                                                {!! $providerOpt !!}
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label>Logo</label>
                                            <input type="file"  accept="image/*" class="form-control" name="logo">
                                            <div>
                                                <br>
                                                <img src="/uploads/{{ $model->logo }}" alt="" >
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <hr>
                                            <h6 class="fw-normal">API Details</h6>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Base URL</label>
                                            <input type="text" value="{{ $model->api_endpoint }}" class="form-control" name="api_endpoint" placeholder="Base URL">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Key</label>
                                            <input type="text" value="{{ old('api_key') }}" class="form-control" name="api_key" placeholder="Key">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Secret</label>
                                            <input type="text" value="{{ old('api_secret') }}" class="form-control" name="api_secret" placeholder="Secret">
                                        </div>



                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button type="submit" id="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
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
