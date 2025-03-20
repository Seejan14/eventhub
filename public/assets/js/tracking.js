mapboxgl.accessToken =
    "pk.eyJ1IjoiYXBpbGFjZSIsImEiOiJjbGJ4dDh2MzAybTZuM3drZTd4ZWFuejBjIn0.bJ27ZkcXuoM-ZWOvzAKTbw";

var map = new mapboxgl.Map({
    container: "map",
    style: "mapbox://styles/mapbox/streets-v12",
    zoom: 6,
});

function mapGeofence() {
    var latitude = document.getElementById("lat");
    var longitude = document.getElementById("lng");
    var geofence = document.getElementById("geofence");

    // navigator.geolocation.getCurrentPosition(function (position) {
    var lng = longitude.value ? parseFloat(longitude.value) : 83.9856;
    var lat = latitude.value ? parseFloat(latitude.value) : 28.2096;

    map.setCenter([lng, lat]);

    const marker = new mapboxgl.Marker({
        color: "#490809",
        draggable: true,
    })
        .setLngLat([lng, lat])
        // .setPopup(popup)
        .addTo(map);

    const geocoder = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken, // Set the access token
        mapboxgl: mapboxgl, // Set the mapbox-gl instance
        marker: false, // Do not use the default marker style
        placeholder: "Search for places ...", // Placeholder text for the search bar
    });

    map.addControl(geocoder);

    var myCircle = new MapboxCircle({ lat: lat, lng: lng }, 50, {
        minRadius: 20,
        // maxRadius: ,
        editable: true,
        fillColor: "#000000",
    }).addTo(map);

    myCircle.setRadius(geofence.value ? geofence.value * 1000 : 20000);

    latitude.value = lat;
    longitude.value = lng;

    geocoder.on("result", (event) => {
        console.log(event.result);
        marker.setLngLat(event.result.center);
        var obj = {
            lat: event.result.center[1],
            lng: event.result.center[0],
        };
        myCircle.setCenter(obj);
    });

    marker.on("drag", function () {
        myCircle.setCenter(this.getLngLat());
        latitude.value = this.getLngLat().lat;
        longitude.value = this.getLngLat().lng;
    });

    geofence.addEventListener("input", function () {
        myCircle.setRadius(this.value * 1000);
    });

    myCircle.on("radiuschanged", function (circleObj) {
        geofence.value = circleObj.getRadius() / 1000;
    });
}
