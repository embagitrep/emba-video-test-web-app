@extends('cp.layouts.main')
@section('content')

            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">Edit {{ $usr->name }} <small class="text-muted">@ {{ $usr->username }}</small></h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('profile', ['username' => Auth::user()->username?Auth::user()->username:Auth::user()->email]) }}">Profile</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a>
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
                                        <form class="form form-vertical" action="{{ route('profile.edit', ['username' => Auth::user()->username?Auth::user()->username:Auth::user()->email]) }}" method="post" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-icon">Avatar</label>
                                                            <div class="position-relative has-icon-left">
                                                                <img src="{{ url('/uploads/'.$usr->image) }}" alt="" class="rounded">
                                                                <hr>
                                                                <input type="file" id="first-name-icon" class="form-control" name="avatar" >
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-icon">Name</label>
                                                            <div class="position-relative has-icon-left">
                                                                <input type="text" id="first-name-icon" class="form-control" name="name" value="{{ $usr->name }}" placeholder="Name">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-user"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-icon">Username</label>
                                                            <div class="position-relative has-icon-left">
                                                                <input type="text" id="first-name-icon" class="form-control" {{ $usr->username == 'superadmin'?'disabled':'' }} name="username" value="{{ $usr->username }}" placeholder="Username">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-user"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="email-id-icon">Email</label>
                                                            <div class="position-relative has-icon-left">
                                                                <input type="email" id="email-id-icon" class="form-control" name="email" value="{{ $usr->email }}" placeholder="Email">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-mail-send"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="contact-info-icon">Mobile</label>
                                                            <div class="position-relative has-icon-left">
                                                                <input type="number" id="contact-info-icon" class="form-control" name="phone" value="{{ $usr->phone }}" placeholder="Mobile">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-mobile"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="contact-info-icon">Address</label>
                                                            <div class="position-relative has-icon-left">
                                                                <input type="text" id="contact-info-icon" class="form-control" name="address" value="{{ $usr->address }}" placeholder="Address">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-map-pin"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="password-icon">Password</label>
                                                            <div class="position-relative has-icon-left">
                                                                <input type="password" id="password" class="form-control" name="password" placeholder="Password">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-lock"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="password-icon">Confirm Password</label>
                                                            <div class="position-relative has-icon-left">
                                                                <input type="password" id="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-lock"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                                        <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Reset</button>
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
