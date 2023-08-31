
@extends('layouts.app')

@section('content')
<div class="container">
    <div id="map" style="height: 500px;"></div>
</div>

<script>
function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 40.712776, lng: -74.005974}, // Default center
        zoom: 12, // Default zoom level
    });

    @foreach ($xml->Document->Placemark as $placemark)
        var coordinates = "{{ $placemark->Point->coordinates }}".split(',');
        var latLng = new google.maps.LatLng(parseFloat(coordinates[1]), parseFloat(coordinates[0]));

        new google.maps.Marker({
            position: latLng,
            map: map,
            title: "{{ $placemark->name }}",
        });
        @elseif (isset($placemark->Polygon) || isset($placemark->LineString))
            var coordinates = "{{ $placemark->Polygon->outerBoundaryIs->LinearRing->coordinates }}".split('\n');
            var path = [];
            coordinates.forEach(function(coordString) {
                var coords = coordString.trim().split(',');
                if (coords.length === 3) {
                    path.push({ lat: parseFloat(coords[1]), lng: parseFloat(coords[0]) });
                }
            });

            var geometry;
            @if (isset($placemark->Polygon))
                geometry = new google.maps.Polygon({
                    paths: path,
                    map: map,
                    fillColor: "#A600CC33",
                    fillOpacity: 1,
                    strokeColor: "#40000000",
                    strokeWeight: 3,
                });
            @else
                geometry = new google.maps.Polyline({
                    path: path,
                    map: map,
                    strokeColor: "#E60000FF",
                    strokeWeight: 15,
                });
            @endif
            google.maps.event.addListener(geometry, 'click', function(event) {
                var infoWindow = new google.maps.InfoWindow({
                    content: "{{ $placemark->description }}",
                });
                infoWindow.setPosition(event.latLng);
                infoWindow.open(map);
            });
        @endif
    @endforeach
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
@endsection
