//using google API to convert source address into X and Y coordinates
function searchAddressSource(dlng, dlat, source) {

    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({
        address: source
    }, function(results, status) {

        if (status == google.maps.GeocoderStatus.OK) {

            var myResult = results[0].geometry.location;
            var lat = results[0].geometry.location.lat();
            var lng = results[0].geometry.location.lng();
            withinSG(dlng, dlat, lat, lng, "Source");

        } else {
			 //fail to geocode
			document.getElementById("gettingThereTAB").style.display = "none";
			  window.location.href = "index.php?invalidSrc=1";
        }
    });

}



//using google API to convert destination address into X and Y coordinates
function searchAddressDestination() {
    var geocoder = new google.maps.Geocoder();

    if (destinationAdd != "") {
        geocoder.geocode({
            address: destinationAdd
        }, function(results, status) {

            if (status == google.maps.GeocoderStatus.OK) {
                var myResult = results[0].geometry.location;
                var lat = results[0].geometry.location.lat();
                var lng = results[0].geometry.location.lng();
                withinSG("", "", lat, lng, "Destination");
				
				} else {
					document.getElementById("gettingThereTAB").style.display = "none";
					 window.location.href = "index.php?invalidDest=1";
                
				
			
            }

        });
    }
}

function addMarkerDestination(destLat, destLng) {

    pt = new google.maps.LatLng(destLat, destLng);
    //marker options
    marker = new google.maps.Marker({
        position: pt,
        map: map,
        icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',

    });
}
//using google API to plot markers on the map
function addMarker(destLat, destLng, name, telephone, type, address, id) {

    pt = new google.maps.LatLng(destLat, destLng);
    contentString = "<table border='0'><tr><td colspan='2' style='text-align:center;'><h5>" + name + "</h5></td></tr><tr><td width='80px'>Address : </td><td width='200px'>" + address + "</td></tr><tr><td>Telephone : </td><td>" + telephone + "</td></tr><tr><td>Clinic Type : </td><td>" + type + "</td></tr><tr><td colspan='2' style='text-align:right;'><input type='button' href='#myModal' value ='Route' data-toggle='modal' id='" + id + "' data-target='#route-modal' class='btn btn-info btn-fill'/></td></tr></table>";

    var infowindow = new google.maps.InfoWindow({
        content: contentString,
    });

    //marker options
    marker = new google.maps.Marker({
        position: pt,
        map: map,

    });
    //zoom into the nearby clinics
    map.setZoom(14);
    map.panTo(marker.position);

    //on click, display information of tasks
    marker.addListener('click', function() {
        //Close active window if exists 
        if (activeWindow != null)
            activeWindow.close();

        //Open new window 
        infowindow.open(map, this);

        //Store new window in global variable 
        activeWindow = infowindow;

        //zoom & pan into selected marker
        map.setZoom(15);
        map.panTo(marker.position);
    });


}

//Using google API to get directions
function initMap(destLat, destLng, srcLat, srcLng, mode) {

    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer({
        draggable: false,
        map: map,
        panel: document.getElementById(mode)
    });

    displayRoute(destLat, destLng, srcLat, srcLng, directionsService, directionsDisplay, mode);

}

//using google API to display directions
function displayRoute(destLat, destLng, srcLat, srcLng, service, display, mode) {
    service.route({
        origin: {
            lat: srcLat,
            lng: srcLng
        },
        destination: {
            lat: destLat,
            lng: destLng
        },
        travelMode: mode,
    }, function(response, status) {
        if (status === 'OK') {
            display.setDirections(response);


        } else { //hide for individual mode, if not found
            if (mode == "WALKING") {
                document.getElementById("walkingTAB").style.display = "none";
            } else if (mode == "DRIVING") {
                document.getElementById("drivingTAB").style.display = "none";
            } else if (mode == "TRANSIT") {
                document.getElementById("transitTAB").style.display = "none";
            }
			
            //fail to display route
            $(document).ready(function() {

                $.notify({
                    icon: 'ti-thumb-down',
                    message: "Failed display route for " + mode

                }, {
                    type: 'danger',
                    timer: 4000
                });

            });
        }
    });
}

function openDirection(dlat, dlng, lat, lng, evt, mode) {

    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(mode).style.display = "block";
    evt.currentTarget.className += " active";

    window.location.href = "index.php?destLat=" + dlat + "&destLng=" + dlng + "&srcLat=" + lat + "&srcLng=" + lng + "&mode=" + mode + "&click=1";

}

function withinSG(dlng, dlat, lat, lng, field) {
    var geocoder = new google.maps.Geocoder;
    var latlng = {
        lat,
        lng
    };
    geocoder.geocode({
        'location': latlng
    }, function(results, status) {
        if (status === 'OK' && results[0]) {
            if ((results[1].formatted_address).includes("Singapore")){
                if (field == "Destination")
                    window.location.href = "index.php?destLat=" + lat + "&destLng=" + lng;
                else if (field == "Source")
                window.location.href = "index.php?destLat=" + dlat + "&destLng=" + dlng + "&srcLat=" + lat + "&srcLng=" + lng;
			}
            else {
				  document.getElementById("gettingThereTAB").style.display = "none";
				  window.location.href = "index.php?notInSG="+field;
             
				
            }

        }
    });

}