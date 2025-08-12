@extends('cp.layouts.main')
@push('scripts')
    <script src="{{ url('/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ url('/app-assets/js/scripts/forms/select/form-select2.min.js') }}"></script>
    <script>
        $('#generatePass').click(function (e) {
            e.preventDefault()
            $pass = generatePassword();
            $('.password__holder').val($pass);
            $('.generated__pass').html($pass);

        })
        function generatePassword() {
            var length = 8,
                charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
                retVal = "";
            for (var i = 0, n = charset.length; i < length; ++i) {
                retVal += charset.charAt(Math.floor(Math.random() * n));
            }
            return retVal;
        }
        $(document).ready(function() {
            $('#load-banks').select2({
                ajax: {
                    url: '{{ route("admin.bank.search") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            term: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.results,
                            more: data.more
                        };
                    },
                    cache: true
                },
                placeholder: 'Search for options',
                minimumInputLength: 3
            });
        });
    </script>
@endpush
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Edit {{ $user->name }}</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('user.all') }}">Users</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('user.edit', ['id' => $user->id]) }}">Edit {{ $user->name }}</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(Session::has('success'))
            <p class="alert alert-info">{{ Session::get('success') }}</p>
        @endif



    <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card" >
                        <div class="card-header">
                            <h4 class="card-title">Edit sections which want to change</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-vertical" action="{{ route('user.edit', ['id'=>$user->id]) }}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-body">
                                        <div class="row">

                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="first-name-icon">Name</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="first-name-icon" class="form-control" value="{{ $user->name }}" name="name" placeholder="Name">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-user"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="first-name-icon">Username</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" value="{{ $user->username }}" name="username" placeholder="Username">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-user"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="first-email-icon">Email</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="first-email-icon" value="{{ $user->email }}" class="form-control" name="email" placeholder="Email">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-mail-send"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="contact-info-icon">Phone</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="contact-info-icon" value="{{ $user->phone }}" class="form-control" name="phone"  placeholder="Phone">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-mobile"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-3 form-group">
                                                <label>Bank</label>
                                                <select name="bank_id" class="form-control" id="load-banks">
                                                    <option value="">Select</option>
                                                    <option value="{{ $user->bank_id }}" selected>{{ $user->bank?->name }}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label>Role</label>
                                                <select name="role" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach($roles as $key => $role)
                                                        <option value="{{ $key }}" {{ $user->hasRole($key)?'selected':'' }}>{{ $role }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-12"></div>
                                            <div class="col-md-6 form-group">
                                                <label>Password</label>
                                                <input type="password" placeholder="Password" name="password" class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>Password Confirmation</label>
                                                <input type="password" placeholder="Password" name="password_confirmation" class="form-control">
                                            </div>



                                            <div class="col-md-12"></div>

                                            <div class="col-3">
                                                <label>Active</label>
                                                <div
                                                    class="custom-control custom-switch custom-switch-shadow custom-control-inline mb-1">
                                                    <input {{ $user->active?'checked':'' }} type="checkbox" class="custom-control-input"
                                                           name="active" id="customSwitchShadow1">
                                                    <label class="custom-control-label" for="customSwitchShadow1">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-3">
                                                <label>Restricted</label>
                                                <div
                                                        class="custom-control custom-switch custom-switch-shadow custom-control-inline mb-1">
                                                    <input {{ $user->restricted?'checked':'' }} type="checkbox" class="custom-control-input"
                                                           name="restricted" id="customSwitchShadow2">
                                                    <label class="custom-control-label" for="customSwitchShadow2">
                                                    </label>
                                                </div>
                                            </div>


                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic Vertical form layout section end -->

    </div>
@endsection
