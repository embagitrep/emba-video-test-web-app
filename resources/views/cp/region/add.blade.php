@extends('cp.layouts.main')

@push('scripts')
@endpush

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add New Region</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" action="{{ route('admin.region.add') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Name</label>
                                            <input type="text" id="first-name" class="form-control" name="name" placeholder="Name">
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
