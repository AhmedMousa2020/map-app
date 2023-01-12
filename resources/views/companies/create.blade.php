@extends('layouts.app')
<style>
#test{
    color:#000;
}
</style>
@section('content')
  <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8" Style="margin-top: 20px;">
               
                <form action="{{route('company.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="border-t border-b border-gray-300 py-8">

                        <div class="md:w-2/3 w-full mb-6">
                            <label for="name" class="block text-sm font-bold text-gray-700">
                                Company name
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Company name">
                            </div>
                        </div>

                        <div class="md:w-2/3 w-full mb-6">
                            <label for="address" class="block text-sm font-bold text-gray-700">
                                Address
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" name="address" id="address" class="form-control"
                                    placeholder="address">
                            </div>
                        </div>

                        <div class="md:w-2/3 w-full mb-6">
                            <label for="lat" class="block text-sm font-bold text-gray-700">
                                lat
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" name="lat" id="lat" class="form-control" placeholder="lat">
                            </div>
                        </div>

                        <div class="md:w-2/3 w-full mb-6">
                            <label for="lng" class="block text-sm font-bold text-gray-700">
                                lng
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" name="lng" id="lng" class="form-control" placeholder="lng">
                            </div>
                        </div>
                        <div class="mt-4">
                            <div id="map" style="width:100%;height:300px;"></div>
                        <div>

                                <div class="mt-4">
                                    <label for="description" class="block text-sm font-bold text-gray-700">
                                        Description
                                    </label>
                                    <div class="mt-1">
                                        <textarea id="description" name="description" rows="7" class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label for="image" class="block text-sm font-bold text-gray-700">
                                        Image
                                    </label>
                                    <div class="mt-1">
                                        <input id="image" type="file" name="image" class="form-control" />
                                    </div>
                                </div>

                            </div>
                            <div class="mt-6 sm:mt-4">
                                <button type="submit" class="btn btn-primary mt-4">
                                    {{ __('Create') }}
                                </button>
                            </div>
                </form>
            </div>
        </div>
    </div>

<script>
let map;
let markersArray = [];
// Defining async function
async function getapi(latLng) {
let  lat = latLng.toJSON().lat;
let  lng = latLng.toJSON().lng;

let  api_url = "https://api.tomtom.com/search/2/reverseGeocode/"+lat+","+lng+".json?key=nhT6HfeUvWIJmQgFKevgPg7wX0F3RfvX&radius=10";

// Storing response
const response = await fetch(api_url);

// Storing data in form of JSON
let  data = await response.json();

getAddress(data)
  
}

let address  = '';
function getAddress(data){
     address =
     data.addresses[0].address.municipalitySubdivision + ',' + data.addresses[0].address.municipality
    + ',' + data.addresses[0].address.freeformAddress + ',' + data.addresses[0].address.countrySubdivision
    + ',' + data.addresses[0].address.country
    document.getElementById('address').value =address;
}
function initMap() {
    const myLatlng ={lng: 31.23529, lat: 30.04349};
     
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 8,
        center: myLatlng,
        mapTypeId: "terrain",
      });
     

   
  map.addListener("click", (mapsMouseEvent) => {
    deleteMarkers();
    addMarker(mapsMouseEvent.latLng); 
    getapi(mapsMouseEvent.latLng);
    document.getElementById('lat').value = mapsMouseEvent.latLng.toJSON().lat;
    document.getElementById('lng').value = mapsMouseEvent.latLng.toJSON().lng;
  });

}
function addMarker(latLng) {
   
    let marker = new google.maps.Marker({
        map: map,
        position: latLng,
        draggable: false,
    });
    //store the marker object drawn on map in global array
    markersArray.push(marker);
}
function setMapOnAll(map) {
  for (let i = 0; i < markersArray.length; i++) {
    markersArray[i].setMap(map);
  }
}
function hideMarkers() {
  setMapOnAll(null);
}
function deleteMarkers() {
  hideMarkers();
  markersArray = [];
}  
</script>

<script src="https://maps.googleapis.com/maps/api/js?sensor=false&callback=initMap"></script>

@endsection
