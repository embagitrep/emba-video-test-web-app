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
                        <h5 class="content-header-title float-left pr-1 mb-0">Sent SMS</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a>
                                Sent SMS
                                <li class="breadcrumb-item active">Sent SMS
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
                                'title' => 'Sent SMS',
                                'useFilters' => true,
                                'columnFields' => [
                                    'phone',
                                    'message',
                                    [
                                        'label' => 'Merchants',
                                        'filter' => [
                                            'class' => Itstructure\GridView\Filters\DropdownFilter::class,
                                            'name' => 'merchant_id',
                                            'value' => $selectedMerchant,
                                            'data' => $merchants,
                                            ],
                                        'value' => function ($row) {
                                           return $row->merchant->name;
                                         },
                                        'format' => 'html',
                                    ],
                                    'status'
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
