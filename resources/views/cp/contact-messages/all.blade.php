@extends('cp.layouts.main')
@push('scripts')
    <script src="{{ asset('js/app.js') }}"></script>

@endpush
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-10">
                        <h5 class="content-header-title float-left pr-1 mb-0">Contact Messages</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active">Contact Messages
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
                            'title' => 'Contact Messages',
                            'useFilters' => true,
                            'columnFields' => [
                                [
                                    'label' => 'name',
                                    'value'  => function ($data) {
                                        return $data->user?$data->user->name:$data->name;
                                    },
                                    'filter' => [
                                        'class' => Itstructure\GridView\Filters\TextFilter::class,
                                        'name' => 'name'
                                        ],
                                 ],
                                 [
                                    'label' => 'Last name',
                                    'attribute' => 'user_last',
                                    'value'  => function ($data) {
                                        return $data->user?$data->user->name:$data->user_last;
                                    },
                                    'filter' => [
                                        'class' => Itstructure\GridView\Filters\TextFilter::class,
                                        'name' => 'user_last'
                                        ]
                                 ],
                                 [
                                    'label' => 'email',
                                    'value'  => function ($data) {
                                        return $data->user?$data->user->email:$data->email;
                                    },
                                    'filter' => [
                                        'class' => Itstructure\GridView\Filters\TextFilter::class,
                                        'name' => 'email'
                                        ]
                                 ],
                                  [
                                    'label' => 'phone',
                                    'value'  => function ($data) {
                                        return $data->user?$data->user->email:$data->phone;
                                    },
                                    'filter' => [
                                        'class' => Itstructure\GridView\Filters\TextFilter::class,
                                        'name' => 'phone'
                                        ]
                                 ],
                                 'message',
                                 [
                                    'label' => 'Registered User',
                                    'filter' => false,
                                    'value'  => function ($data) {
                                        return $data->user? '<a href="'.route('user.edit',['id' => $data->user_id]).'" class="btn btn-warning">
                                        <i class="bx bx-user"></i>
                                        </a>':'';
                                    },
                                    'format' => 'html'
                                 ],
                                 [
                                    'label' => 'created date',
                                    'filter' => false,
                                    'value'  => function ($data) {
                                        return date('d-m-Y H:i', strtotime($data->created_at));
                                    }
                                 ],
                            ]
                        ];
                    @endphp
                    {!! grid_view($gridData) !!}


                    <!-- datatable ends -->
                </div>

            </section>

            <!-- table success ends -->
        </div>
    </div>

@endsection
