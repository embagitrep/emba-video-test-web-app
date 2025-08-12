@extends('client.layouts.main')
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0">Account Settings</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Pages</a>
                                </li>
                                <li class="breadcrumb-item active"> Account Settings
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body"><!-- account setting page start -->

            @if(Session::has('success'))
                <p class="alert alert-info">{{ Session::get('success') }}</p>
                @elseif(Session::has('error'))
                <p class="alert alert-danger">{{ Session::get('error') }}</p>
            @endif

            <section id="page-account-settings">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <!-- left menu section -->
                            <div class="col-md-3 mb-2 mb-md-0 pills-stacked">
                                <ul class="nav nav-pills flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center active" id="account-pill-password"
                                           data-toggle="pill" href="#account-vertical-password" aria-expanded="false">
                                            <i class="bx bx-lock"></i>
                                            <span>Change Password</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center" id="account-pill-notifications"
                                           data-toggle="pill" href="#account-vertical-notifications"
                                           aria-expanded="false">
                                            <i class="bx bx-bell"></i>
                                            <span>Notifications</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- right content section -->
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div class="tab-pane fade active show" id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                                    <form action="{{ route('user.reset') }}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>Old Password</label>
                                                                        <input type="password" class="form-control" required="" name="old_password" placeholder="Old Password" data-validation-required-message="This old password field is required">
                                                                        <div class="help-block"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>New Password</label>
                                                                        <input type="password" name="password"
                                                                               class="form-control"
                                                                               placeholder="New Password" required=""
                                                                               data-validation-required-message="The password field is required"
                                                                               minlength="6">
                                                                        <div class="help-block"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>Retype new Password</label>
                                                                        <input type="password" name="password_confirmation"
                                                                               class="form-control" required=""
                                                                               data-validation-match-match="password"
                                                                               placeholder="New Password"
                                                                               data-validation-required-message="The Confirm password field is required"
                                                                               minlength="6">
                                                                        <div class="help-block"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                                <button type="submit"
                                                                        class="btn btn-primary glow mr-sm-1 mb-1">Save
                                                                    changes
                                                                </button>
                                                                <button type="reset" class="btn btn-light mb-1">Cancel
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane fade" id="account-vertical-notifications"
                                                     role="tabpanel" aria-labelledby="account-pill-notifications"
                                                     aria-expanded="false">
                                                    <div class="row">
                                                        <h6 class="m-1">Activity</h6>
                                                        <div class="col-12 mb-1">
                                                            <div
                                                                class="custom-control custom-switch custom-control-inline">
                                                                <input type="checkbox" class="custom-control-input"
                                                                       checked="" id="accountSwitch1">
                                                                <label class="custom-control-label mr-1"
                                                                       for="accountSwitch1"></label>
                                                                <span class="switch-label w-100">Email me when someone comments
                                                        onmy
                                                        article</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-1">
                                                            <div
                                                                class="custom-control custom-switch custom-control-inline">
                                                                <input type="checkbox" class="custom-control-input"
                                                                       checked="" id="accountSwitch2">
                                                                <label class="custom-control-label mr-1"
                                                                       for="accountSwitch2"></label>
                                                                <span class="switch-label w-100">Email me when someone answers on
                                                        my
                                                        form</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-1">
                                                            <div
                                                                class="custom-control custom-switch custom-control-inline">
                                                                <input type="checkbox" class="custom-control-input"
                                                                       id="accountSwitch3">
                                                                <label class="custom-control-label mr-1"
                                                                       for="accountSwitch3"></label>
                                                                <span class="switch-label w-100">Email me hen someone follows
                                                        me</span>
                                                            </div>
                                                        </div>
                                                        <h6 class="m-1">Application</h6>
                                                        <div class="col-12 mb-1">
                                                            <div
                                                                class="custom-control custom-switch custom-control-inline">
                                                                <input type="checkbox" class="custom-control-input"
                                                                       checked="" id="accountSwitch4">
                                                                <label class="custom-control-label mr-1"
                                                                       for="accountSwitch4"></label>
                                                                <span
                                                                    class="switch-label w-100">News and announcements</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-1">
                                                            <div
                                                                class="custom-control custom-switch custom-control-inline">
                                                                <input type="checkbox" class="custom-control-input"
                                                                       id="accountSwitch5">
                                                                <label class="custom-control-label mr-1"
                                                                       for="accountSwitch5"></label>
                                                                <span
                                                                    class="switch-label w-100">Weekly product updates</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-1">
                                                            <div
                                                                class="custom-control custom-switch custom-control-inline">
                                                                <input type="checkbox" class="custom-control-input"
                                                                       checked="" id="accountSwitch6">
                                                                <label class="custom-control-label mr-1"
                                                                       for="accountSwitch6"></label>
                                                                <span
                                                                    class="switch-label w-100">Weekly blog digest</span>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                            <button type="submit"
                                                                    class="btn btn-primary glow mr-sm-1 mb-1">Save
                                                                changes
                                                            </button>
                                                            <button type="reset" class="btn btn-light mb-1">Cancel
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- account setting page ends -->
        </div>
    </div>
@endsection
