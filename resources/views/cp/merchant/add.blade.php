@extends('cp.layouts.main')

@push('scripts')
    <script>
        function generateApiKey(length = 32) {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let apiKey = '';
            for (let i = 0; i < length; i++) {
                apiKey += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return apiKey;
        }
        $('.js--generateApiKey').click(function (e) {
            e.preventDefault();
            $('.js--apiKey').val(generateApiKey())
        })

    </script>
@endpush

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add New Merchant</h4>
                    </div>
                    <div class="card-content">
                        @include('cp.partial.errors-widget')

                        <div class="card-body">
                            <form class="form form-horizontal" action="{{ route('admin.merchant.store') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label>Name</label>
                                            <input type="text" id="first-name" value="{{ old('name') }}" class="form-control" name="name" placeholder="Name">
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label>Logo</label>
                                            <input type="file"  accept="image/*" class="form-control" name="logo">
                                        </div>

                                        <div class="col-12">
                                            <hr>
                                            <h6 class="fw-normal">API Details</h6>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label>Username</label>
                                            <input type="text" value="{{ old('api_username') }}" class="form-control" name="api_username" placeholder="Username">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Key</label>
                                            <div class="input-group">
                                                <input type="text" value="{{ old('api_key') }}" class="form-control js--apiKey" name="api_key" placeholder="Key">
                                                <button class="btn btn-outline-primary js--generateApiKey" type="button">Generate</button>
                                            </div>
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
