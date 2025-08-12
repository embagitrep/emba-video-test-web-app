@extends('cp.layouts.main')
@push('scripts')
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{ asset('vendor/grid-view/js/amigrid.js') }}"></script>
@endpush
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-10">
                        <h5 class="content-header-title float-left pr-1 mb-0">Translations</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active">Translations
                                </li>
                            </ol>
                        </div>
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
                            'title' => 'Translations',
                            'useFilters' => true,
                            'columnFields' => [
                                'name',
                                 [
                                    'class' => Itstructure\GridView\Columns\ActionColumn::class,
                                    'actionTypes' => [
                                        'edit' => function ($data) {
                                            return route('admin.translation.edit',['translation' => $data->id]);
                                        },
                                    ]
                                ],
                            ]
                        ];
                    @endphp
                    {!! grid_view($gridData) !!}
                <!-- datatable ends -->
                </div>
                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                    <ul class="pagination">
                        {{--                        {{ $translations->links() }}--}}
                    </ul>
                </div>
            </section>
            <!-- table success ends -->
        </div>
    </div>

@endsection
