<?php
if (!isset($post)){
    $post = (object) [
        'lat' => false,
        'lng' => false,
    ];
}
?>

{{--<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />--}}



<div class="row mt-25"></div>
<div class="col-12"></div>
<div class="col-md-4 form-group">
    <input type="text" id="autocomplete" class="form-control" placeholder="Type place">
</div>
<div class="col-md-12 mb-25">
    <div id="map" class='map-canvas' style="width:100%;height:500px;"></div>
</div>
<input type="hidden" name="lat" id="lat" value="{{ $post->lat }}">
<input type="hidden" name="lng" id="lng" value="{{ $post->lng }}">

@push('css')
    <style>
        .map-autocomplete{
            position: absolute;
            z-index: 233333;
        }
    </style>
@endpush
@push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places"></script>
{{--<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>--}}

    <script>


        {{--var mymap = L.map('map').setView([{{ $post->lat?:'40.3741837' }}, {{ $post->lng?:'49.839971' }}], 9);--}}

        {{--// Add OpenStreetMap tile layer--}}
        {{--L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {--}}
        {{--    attribution: '© OpenStreetMap contributors'--}}
        {{--}).addTo(mymap);--}}

        {{--var marker =null;--}}

        {{--@if($post->lat && $post->lng)--}}
        {{--marker = L.marker([{{ $post->lat }}, {{ $post->lng }}]).addTo(mymap);--}}
        {{--@endif--}}

        {{--mymap.on('click', function(e) {--}}
        {{--    var coordinates = e.latlng;--}}
        {{--    var lat = coordinates.lat;--}}
        {{--    var lng = coordinates.lng;--}}
        {{--    console.log(marker)--}}
        {{--    if (typeof marker !== 'undefined' && marker !== null) {--}}
        {{--        // Marker exists, update its location--}}
        {{--        marker.setLatLng([lat, lng]);--}}
        {{--    } else {--}}
        {{--        // Marker doesn't exist, create a new one--}}
        {{--        marker = L.marker([lat, lng]).addTo(mymap);--}}
        {{--    }--}}
        {{--    $('#lat').val(lat);--}}
        {{--    $('#lng').val(lng);--}}

        {{--});--}}


        var mapOptions = {
            zoom: 12,
            center: new google.maps.LatLng({{ $post->lat?:'40.377354' }}, {{ $post->lng?:'49.8454314' }})
        };

        var map = new google.maps.Map(document.getElementsByClassName('map-canvas')[0], mapOptions);

        var marker = new google.maps.Marker({
            position: map.getCenter(),
            map: map,
            title: 'Click to zoom'
        });

        google.maps.event.addListener(map, 'click', function (e) {
            // 3 seconds after the center of the map has changed, pan back to the
            // marker.
            marker.setPosition(e.latLng);
            $('#lat').val(e.latLng.lat());
            $('#lng').val(e.latLng.lng());

            //map.setCenter(this.latLng);
        });

        google.maps.event.addListener(marker, 'click', function (e) {
            map.setZoom(12);
            map.setCenter(this.latLng);
        });

        const center = { lat: 58.5389405, lng: 24.4975242 };

        const defaultBounds = {
            north: center.lat + 0.1,
            south: center.lat - 0.1,
            east: center.lng + 0.1,
            west: center.lng - 0.1,
        };
        const options = {
            bounds: defaultBounds,
            componentRestrictions: { country: "az" },
            strictBounds: true,
        };

        const autocomplete = new google.maps.places.Autocomplete(document.getElementById('autocomplete'),options);

        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            let lat = place.geometry.location.lat(), lng = place.geometry.location.lng(),
                name = place.name

            map.setCenter({ lat: lat, lng: lng });
            marker.setPosition({ lat: lat, lng: lng });
            $('#lat').val(lat);
            $('#lng').val(lng);
            map.setCenter(place.geometry.location);
            map.fitBounds(place.geometry.viewport);
        });



    </script>
@endpush
