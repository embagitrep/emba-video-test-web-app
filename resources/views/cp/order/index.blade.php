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
                        <h5 class="content-header-title float-left pr-1 mb-0">Video Records</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a>
                                    Video Records
                                <li class="breadcrumb-item active">Video Records
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-2 text-right">
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
                                'title' => 'Video Records',
                                'useFilters' => true,
                                'rowsPerPage' => 36,
                                'columnFields' => [
                                    'name',
                                    'phone',
                                    'app_id',
                                    [
                                        'label' => 'Merchants',
                                        'filter' => [
                                            'class' => Itstructure\GridView\Filters\DropdownFilter::class,
                                            'name' => 'merchant.',
                                            'value' => $selectedMerchant,
                                            'data' => $merchants,
                                            ],
                                        'value' => function ($row) {
                                           return $row->merchant->name;
                                         },
                                        'format' => 'html',
                                    ],
                                    [
                                        'label' => 'Status',
                                        'filter' => [
                                            'class' => Itstructure\GridView\Filters\DropdownFilter::class,
                                            'name' => 'status',
                                            'data' => \App\Enums\VideoStatusEnum::toArray(),
                                            ],
                                        'value' => function ($row) {
                                           return $row->status;
                                         },
                                        'format' => 'html',
                                    ],
                                    [
                                        'label' => 'Created',
                                        'filter' => false,
                                        'value' => function ($row) {
                                           return $row->created_at ? $row->created_at->format('d-m-Y/ H:i') : '';
                                         },
                                    ],
                                    [
                                        'label' => 'Watch',
                                        'filter' => false,
                                        'format' => 'html',
                                        'value' => function ($data) {
                                            return '<a href="'.route('admin.orders.videos',['appId' => $data->app_id,'merchant' => $data->merchant_id]).'" class="btn btn-success">Watch</a>';
                                        }
                                    ]
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

