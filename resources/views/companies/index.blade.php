@extends('layouts.app')
<style>
    #map {
        width: 100vw;
        height: 100vh;
    }

    #test {
        color: #000;
    }
</style>
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8" Style="margin-top: 20px;">
            <div class="md:w-2/3 w-full mb-6">
                <label for="name" class="block text-sm font-bold text-gray-700">
                    Address
                </label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <input type="text" class="form-control" id="search_text" value="" />
                </div>
            </div>
            <div class="mt-6" style=" margin-top: 16px;">
                <button id="but_search" class="btn btn-primary">Search</button>
            </div>
            <div class="mt-4">
                <div id="map" style="width:100%;height:300px;"></div>
                <div>
                </div>
            </div>
            <script>
                let map;
                let markersArray = [];
                let polyline = null;
                let marker;
                /**************/
                // Search
                var locations;
                var latLng;

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $(document).ready(function() {
                    $('#but_search').click(function() {
                        var search_text = $('#search_text').val();
                        // AJAX POST request
                        $.ajax({
                            url: 'getAddress',
                            type: 'post',
                            data: {
                                _token: CSRF_TOKEN,
                                search_text: search_text
                            },
                            dataType: 'json',
                            success: function(response) {

                                createlocations(response);
                                initMap(locations['data'][0].latitude, locations['data'][0].longitude)
                            }
                        });


                    });
                });

    function createlocations(response) {

        locations = response;
for (i = 0; i < locations['data'].length; i++) {  

    let contentString =
    '<div id="content">' +
    '<div id="siteNotice">' +
    "</div>" +
    '<img style="width:200px;height:200px;" src="'+locations['data'][i].image_path+'"/>'+
    '<h1 id="firstHeading" class="firstHeading">'+locations['data'][i].name+'</h1>' +
    '<div id="bodyContent">' +
    '<p>'+locations['data'][i].description+'</p>' +
    "</div>" +
    "</div>";

    locations['data'][i]['content'] = contentString;
}

console.log(locations);
        
    }
              

     function initMap(lat=null,lng=null) {
                  if(!lat){
                    lat = 30.03397927657854;
                  }
                  if(!lng){
                    lng = 31.490722128906253;
                  }
            var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 7,
            center: new google.maps.LatLng(lat,lng),
            mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var infowindow = new google.maps.InfoWindow();

            var marker, i;
            var markers = [];

            for (i = 0; i < locations['data'].length; i++) {  
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations['data'][i].latitude, locations['data'][i].longitude),
                map: map,
                title: locations['data'][i].name,
            });

            markers.push(marker);

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                infowindow.setContent(locations['data'][i].content);
                infowindow.open(map, marker);
                }
            })(marker, i));
            }
    }
            </script>

            <script src="https://maps.googleapis.com/maps/api/js?sensor=false&callback=initMap"></script>
        @endsection
