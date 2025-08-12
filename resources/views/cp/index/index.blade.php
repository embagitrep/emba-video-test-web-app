@extends('cp.layouts.main')

@section('content')
        <div class="content-header row">
            <div class="col-12">
                @if(session()->has('success'))
                    <div class="alert alert-success">{{ session()->get('success') }}</div>
                @endif
            </div>
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-2">
                        <a href="{{ route('admin.clear.cache') }}" class="btn btn-primary">Clear cache</a>
                    </div>
                    <div class="col-2">
                        <a href="{{ route('admin.translates.to.file') }}" class="btn btn-primary">Refresh Translations</a>
                    </div>
                </div>
            </div>
        </div>

@endsection()
