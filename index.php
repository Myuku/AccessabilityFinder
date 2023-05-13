<!DOCTYPE html>
<html lang="en">
    <?php include "includes/header.html" ?>
    <head>
        <title>Place ID Finder</title>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

        <link rel="stylesheet" type="text/css" href="./style.css" />
        <script type="module" src="./index.js"></script>
    </head>
<body>
    <?php include "includes/navbar.html" ?>
    <section class="title">
        <h1>You're doing GREAT!</h1>
    </section>

    <section class="main">
        <div class="comments">
            <h1 id="reviewLocation"></h1>
            <div id="display"></div>
            <input type="text" id="inputKey">
            <button onclick="addValue()">Add Value</button>

            <script>
                let myArray = [];
                var inputKey;

                function displayName() {
                    let key = document.getElementById("pac-input").value;
                    let element = document.getElementById("reviewLocation");
                    element.textContent = "Reviews for:\n " + key;
                }
                function displayArray() {
                    let displayElement = document.getElementById("display");
                    displayElement.innerHTML = ""; // clear the previous display
                    for (let i = 0; i < myArray.length; i++) {
                        let value = myArray[i];
                        let valueElement = document.createElement("p");
                        valueElement.textContent = value;
                        displayElement.appendChild(valueElement);
                    }
                }
            </script>








        </div>
        <div class="map">
            <!-- <iframe
                height="100%"
                width="100%"
                style="border:0"
                loading="lazy"
                allowfullscreen
                referrerpolicy="no-referrer-when-downgrade"
                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCBq7-eWrP0E0JORqLGv14We7saZT1VciQ
                &q=Space+Needle,Simon Fraser University">
            </iframe> -->


            <div style="display: none">
                <input
                    id="pac-input"
                    class="controls"
                    type="text"
                    placeholder="Enter a location"
                />
            </div>
            <div id="map"></div>
            <div id="infowindow-content">
                <span id="place-name" class="title"></span><br />
                <strong>Place ID:</strong> <span id="place-id"></span><br />
                <span id="place-address"></span>
            </div>

            <script
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBq7-eWrP0E0JORqLGv14We7saZT1VciQ&callback=initMap&libraries=places&v=weekly"
                defer
            ></script>

            <script>

                function initMap() {
                const map = new google.maps.Map(document.getElementById("map"), {
                    center: { lat: 49.2488, lng: -122.9805 },
                    zoom: 13,
                });
                const input = document.getElementById("pac-input");
                // Specify just the place data fields that you need.
                const autocomplete = new google.maps.places.Autocomplete(input, {
                    fields: ["place_id", "geometry", "formatted_address", "name"],
                });

                autocomplete.bindTo("bounds", map);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                const infowindow = new google.maps.InfoWindow();
                const infowindowContent = document.getElementById("infowindow-content");

                infowindow.setContent(infowindowContent);

                const marker = new google.maps.Marker({ map: map });

                marker.addListener("click", () => {
                    infowindow.open(map, marker);
                });
                autocomplete.addListener("place_changed", () => {
                    infowindow.close();

                    const place = autocomplete.getPlace();

                    if (!place.geometry || !place.geometry.location) {
                    return;
                    }

                    if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                    } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                    }

                    // Set the position of the marker using the place ID and location.
                    // @ts-ignore This should be in @typings/googlemaps.
                    marker.setPlace({
                    placeId: place.place_id,
                    location: place.geometry.location,
                    });
                    marker.setVisible(true);
                    infowindowContent.children.namedItem("place-name").textContent = place.name;
                    infowindowContent.children.namedItem("place-id").textContent =
                    place.place_id;
                    infowindowContent.children.namedItem("place-address").textContent =
                    place.formatted_address;

                    inputKey = [place.geometry.location.lng(), place.geometry.location.lat()];
                    displayName();
                    infowindow.open(map, marker);
                });
                }

                window.initMap = initMap;
            </script>

        </div>
    </section>



</body>

<include src="./footer.html"></include>

</html>
