@extends('cp.layouts.main')
@push('scripts')
    <script>
        $('.js--openModal').click(function (e){
            e.preventDefault();
            $('#send-notification').modal('show')
        });
        $('.js--sendNotificationForm').on('submit', function (e) {
            e.preventDefault();
            let _this = $(this), formData = _this.serialize(), url = _this.attr('action');

            $.ajax({
                url,
                data: formData,
                type: 'POST',
                complete: function (data) {
                    let res = data.responseJSON;
                    if(res.success){
                        $('#send-notification').modal('hide')
                        _this.find('textarea').val('');
                        toastr.success(res.message, {
                            closeButton: 1,
                            tapToDismiss: 1,
                            progressBar: 1,
                            closeDuration: 1000000
                        });
                    }else {
                        toastr.error(res.message, {
                            closeButton: 1,
                            tapToDismiss: 1,
                            progressBar: 1,
                            closeDuration: 1000000
                        });
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
                        <h5 class="content-header-title float-left pr-1 mb-0">Notifications</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active">{{ $user->name }} Notifications
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-12">
                        <a href="javascript:void(0)" class="btn btn-primary js--openModal" data-bs-toggle="modal" data-bs-target="#send-notification">Send Notification</a>
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
                                <th>id</th>
                                <th>message</th>
                                <th>sent</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($models as $c => $model)
                                <tr>
                                    <td>{{ $c+1 }}</td>
                                    <td class="text-bold-600">{{ $model->data['message'] }}</td>
                                    <td>{{ date('d.m.Y H:i',strtotime($model->created_at)) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- datatable ends -->
                </div>
                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                    <ul class="pagination">
                        {{ $models->links() }}
                    </ul>
                </div>
            </section>

            <!-- table success ends -->
        </div>
    </div>

    <div class="modal fade" id="send-notification" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-4">Send notification</h3>
                    </div>
                    <form  action="{{ route('user.send.notification',['id' => $user->id]) }}" class="row g-3 mt-3 fv-plugins-bootstrap5 fv-plugins-framework js--sendNotificationForm"  novalidate="novalidate">
                        @csrf
                        <div class="col-12 fv-plugins-icon-container">
                            <label class="form-label" for="modalEnableOTPPhone">Note</label>
                            <textarea name="note" class="form-control"></textarea>
                        </div>
                        <div class="col-12 mt-2">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                </div>
            </div>
        </div>
    </div>

@endsection
