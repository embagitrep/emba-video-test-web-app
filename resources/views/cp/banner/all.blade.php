@extends('cp.layouts.main')
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-10">
                        <h5 class="content-header-title float-left pr-1 mb-0">Banners</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active">Banners
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-2 text-right">
                        <a href="{{ route('admin.banner.add') }}" class="btn btn-primary">Add</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body"><!-- table Transactions start -->
            @if(Session::has('success'))
                <p class="alert alert-info">{{ Session::get('success') }}</p>
        @endif
        <!-- table success start -->
            <section id="table-success">
                <div class="card">
                    <!-- datatable start -->
                    <div class="table-responsive">
                        <table id="table-extended-success" class="table mb-0">
                            <thead>
                            <tr>
                                <th>name</th>
                                <th>image</th>
                                <th>sort</th>
                                <th>action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($banners as $banner)
                                <tr>
                                    <td class="text-bold-600">{{ $banner->name }}</td>
                                    <td class="text-bold-600"><img src="{{ url('uploads/'.$banner->image) }}" style="max-width: 250px" alt=""></td>
                                    <td class="text-bold-600"><span>{{ $banner->sort }}</span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="{{ route('admin.banner.edit', ['banner' => $banner->id]) }}"><i class="bx bx-edit-alt mr-1"></i>
                                                    edit</a>
                                                <a class="dropdown-item" href="{{ route('admin.banner.delete', ['banner' => $banner->id]) }}"><i class="bx bx-trash mr-1"></i>
                                                    delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- datatable ends -->
                </div>
                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                    <ul class="pagination">
                        {{ $banners->links() }}
                    </ul>
                </div>
            </section>
            <!-- table success ends -->
        </div>
    </div>

@endsection
