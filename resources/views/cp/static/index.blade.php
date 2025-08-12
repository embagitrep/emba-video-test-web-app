@extends('cp.layouts.main')
@push('css')
    <style>
        .badge{
            cursor: pointer;
        }
    </style>
@endpush
@push('scripts')
    <script>
        $('.badge-active').click(function (e) {
            e.preventDefault();
            $type = $(this).data('type');
            $id = $(this).data('id');
            $active = $(this).data('active');
            $_this = $(this)
            $.ajax({
                url: '/admin/ajax/activatePost/'+$id+'/'+$type+'/'+$active,
                method: 'GET',
                complete: function (data) {
                    $res = data.responseJSON;
                    if($res.success){
                        if($res.active == 0){
                            $_this.removeClass('badge-light-success')
                            .addClass('badge-light-danger')
                            .html('NO')
                            .data('active',1)
                        }else{
                            $_this.removeClass('badge-light-danger')
                                .addClass('badge-light-success')
                                .html('YES')
                                .data('active',0)
                        }
                    }
                }
            })
        });

        $('.badge-front').click(function (e) {
            e.preventDefault();
            $type = $(this).data('type');
            $id = $(this).data('id');
            $active = $(this).data('active');
            $_this = $(this);
            $.ajax({
                url: '/admin/ajax/frontPost/'+$id+'/'+$type+'/'+$active,
                method: 'GET',
                complete: function (data) {
                    $res = data.responseJSON;
                    if($res.success){
                        if($res.front == 0){
                            $_this.removeClass('badge-light-success')
                            .addClass('badge-light-danger')
                            .html('NO')
                            .data('active',1)
                        }else{
                            $_this.removeClass('badge-light-danger')
                                .addClass('badge-light-success')
                                .html('YES')
                                .data('active',0)
                        }
                    }
                }
            })
        })
    </script>
@endpush
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-10">
                        <h5 class="content-header-title float-left pr-1 mb-0">Categories</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a>
                                    Categories
                                <li class="breadcrumb-item active">Categories
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-2 text-right">
                        <a href="{{ route('admin.category.add') }}" class="btn btn-primary">Add</a>
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
                                <th>active</th>
                                <th>action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td class="text-bold-600">{{ $post->name }}</td>
                                    <td class="text-bold-600"><img src="/uploads/<?php echo isset($post->gallery) && count($post->gallery) ? $post->gallery[0]->image:''?>" class="img-lg" alt=""></td>
                                    <td class="text-bold-600"><span><?php echo $post->active ? '<span class="badge badge-active badge-light-success badge-pill ml-50" data-id="'.$post->id.'" data-type="Product" data-active="0">Yes</span>': '<span data-active="1" data-id="'.$post->id.'" data-type="Product" class="badge badge-active badge-light-danger badge-pill ml-50">No</span>' ?></span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="{{ route('admin.category.edit', ['category' => $post->id]) }}"><i class="bx bx-edit-alt mr-1"></i>
                                                    edit</a>
                                                <a class="dropdown-item" href="{{ route('admin.category.delete', ['category' => $post->id]) }}"><i class="bx bx-trash mr-1"></i>
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
                        {{ $posts->links() }}
                    </ul>
                </div>
            </section>
            <!-- table success ends -->
        </div>
    </div>

@endsection
