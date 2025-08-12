@extends('cp.layouts.main')
@push('css')
    <style>
        .badge{
            cursor: pointer;
        }
    </style>
@endpush
@push('scripts')

@endpush
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-10">
                        <h5 class="content-header-title float-left pr-1 mb-0">Merchants</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a>
                                Merchants
                                <li class="breadcrumb-item active">Merchants
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-2 text-right">
                        <a href="{{ route('admin.merchant.add') }}" class="btn btn-primary">Add</a>
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
                    @php
                            $gridData = [
                                'dataProvider' => $dataProvider,
                                'title' => 'Merchants',
                                'useFilters' => true,
                                'columnFields' => [
                                    'name',

                                     [
                                        'class' => Itstructure\GridView\Columns\ActionColumn::class,
                                        'actionTypes' => [
                                            'edit' => function ($data) {
                                                return route('admin.merchant.edit',['merchant' => $data->id]);
                                            },

                                        ]
                                    ],
                                ]
                            ];
                    @endphp
                    {!! grid_view($gridData) !!}
                </div>
            </section>
            <!-- table success ends -->
        </div>
    </div>

@endsection
