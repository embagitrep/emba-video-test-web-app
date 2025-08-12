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
                        <h5 class="content-header-title float-left pr-1 mb-0">Users</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active">Users
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-2 text-right">
                        <a href="{{ route('user.add') }}" class="btn btn-primary">Add</a>
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
                            'title' => 'Users',
                            'useFilters' => true,
                            'columnFields' => [
                                'name',
                                'phone',
                                'email',
                                 [
                                    'label' => 'created date',
                                    'filter' => false,
                                    'value'  => function ($data) {
                                        return date('d-m-Y H:i', strtotime($data->created_at));
                                    }
                                 ],

                                 [
                                    'label' => 'Restricted',
                                    'filter' => false,
                                    'value'  => function ($data) {
                                        return $data->isRestricted()?'<span class="badge text-white badge-danger">Yes</span>':'<span class="badge text-white badge-success">No</span>';
                                    },
                                    'format' => 'html',
                                 ],

                                  [
                                    'label' => 'Active',
                                    'filter' => false,
                                    'value'  => function ($data) {
                                        return $data->isActive()?'<span class="badge text-white badge-success">Yes</span>':'<span class="badge text-white badge-danger">No</span>';
                                    },
                                    'format' => 'html',
                                 ],

                                 [
                                    'class' => Itstructure\GridView\Columns\ActionColumn::class,
                                    'actionTypes' => [
                                        'edit' => function ($data) {
                                            return route('user.edit',['id' => $data->id]);
                                        },
                                         'delete' => function ($data) {
                                            return route('user.delete',['id' => $data->id]);
                                        },
                                    ]
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
