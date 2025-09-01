@extends('cp.layouts.main')
@push('css')
    <style>
        .badge{
            cursor: pointer;
        }
    </style>
@endpush
@push('scripts')
    <script>
        function playVideo(videoUrl) {
            const mainPlayer = document.getElementById('mainVideoPlayer');
            const source = document.getElementById('mainVideoSource');
            source.src = videoUrl;
            mainPlayer.load();
            mainPlayer.play();
        }
    </script>
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
                                <li class="breadcrumb-item active">Video Records: {{ $appId }}
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-2 text-right">
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-8">
                    <video id="mainVideoPlayer" width="640" height="360" controls>
                        <source id="mainVideoSource" src="" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <div class="col-4">
                    <div class="overflow-x-scroll" style="height: 500px;">
                                 @foreach($orders as $order)
                            <div class="card" onclick="playVideo('{{ route('admin.orders.video.stream', ['appId' => $order->app_id]) }}')">
                                <video src="{{ route('admin.orders.video.stream',['appId' => $order->app_id]) }}" ></video>
                                <div class="card-body">
                                    <a href="javascript:void(0)" class="btn btn-outline-primary">Click to watch</a>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
