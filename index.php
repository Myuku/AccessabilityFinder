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
        <h2 letter-spacing=".2rem">Accessibility Finder!</h2>
    </section>

    <section class="main">
        <div class="comments">
            <h1 id="reviewLocation">Reviews</h1>
            <div id="display"></div>
            <input type="number" id="ratingsInput" placeholder="Rating (1-5)">
            <input type="text" id="reviewInput" placeholder ="Comment">
            <button onclick="btnAddReview()">Add Review</button>

            <script>
                let myArray = [];
                var inputKey;
                
                function displayName() {
                    getReviews();
                    let key = document.getElementById("pac-input").value;
                    let element = document.getElementById("reviewLocation");
                    element.textContent = "Reviews for:\n " + key;
                }

                function btnAddReview() {
    
                    const now = new Date();
                    const year = now.getFullYear(); // return year
                    const month = now.getMonth() + 1; // return month(0 - 11)
                    const date = now.getDate(); // return date (1 - 31)
                    const hours = now.getHours(); // return number (0 - 23)
                    const minutes = now.getMinutes(); // return number (0 -59)
                    
                    let lon = inputKey[0];
                    let lat = inputKey[1];
                    let rating = document.getElementById("ratingsInput").value;
                    let currdate = `${date}/${month}/${year}`
                    let comment = document.getElementById("reviewInput").value;

                    let arr = [lon, lat, rating, currdate, comment];
                    myArray.push(arr);
                    saveReviews();
                    displayArray();
                    
                }

                function displayArray() {
                    let displayElement = document.getElementById("display");
                    displayElement.innerHTML = ""; // clear the previous display
                    for (let i = 0; i < myArray.length; i++) {
                        if (myArray[i][0] == inputKey[0] && myArray[i][1] == inputKey[1]) {
                            let value = myArray[i][3] +" | Ratings: "+ myArray[i][2] + " | Comment: "+ myArray[i][4];
                            let valueElement = document.createElement("p");
                            valueElement.textContent = value;
                            displayElement.appendChild(valueElement);    
                        }
   
                    }
                }
                
                function getReviews() {
                    const storedArrayJSON = localStorage.getItem('reviewKey');
                    if (storedArrayJSON != null) {
                        
                        // Parse the JSON string into a JavaScript array
                        const storedArray = JSON.parse(storedArrayJSON);
                        myArray = storedArray;
                    }
                    displayArray();
                }
                

                function saveReviews() {
                    const reviewJSON = JSON.stringify(myArray);

                    // Store the JSON string in localStorage
                    localStorage.setItem('reviewKey', reviewJSON);
                }
                
            </script>

        </div>
        <div class="map">

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
                <strong>Address:</strong> <span id="place-address"></span> <br>
                <strong>Phone Number:</strong> <span id="place-phone-number"></span> <br />
                <strong>Accessibility Rating:</strong> <span id="place-rating"></span> <br />  
                <strong>Wheelchair Accessibility:</strong> <span id="place-wheelchair-accessibility-entrance"></span> <br />              
                <strong>Website:</strong> <span id="place-website"></span> <br />




            </div>

            <script
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBq7-eWrP0E0JORqLGv14We7saZT1VciQ&callback=initMap&libraries=places&v=weekly"
                defer
            ></script>

            <script>
                
                let markers = [];

                function setMarkers(map) {
                    for (let i = 0; i < markers.length; i++) {
                        let marker = markers[i];
                        
                        let newMarker = new google.maps.Marker({
                            position: {lat: marker.geometry.location.lat(), lng: marker.geometry.location.lng()},
                            map,
                            title: marker.name
                            

                        })
                        console.log(newMarker);
                    }
                  
                }

               

                function initMap() {

                    const map = new google.maps.Map(document.getElementById("map"), {
                        center: { lat: 49.2488, lng: -122.9805 },
                        zoom: 13,
                    });

                    const input = document.getElementById("pac-input");
                    // Specify just the place data fields that you need.
                    const autocomplete = new google.maps.places.Autocomplete(input, {
                        fields: ["place_id", "geometry", "formatted_address", "name", "rating", "geometry/location", "formatted_phone_number", "opening_hours", "website"],
                    });

                    autocomplete.bindTo("bounds", map);
                    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                    const infowindow = new google.maps.InfoWindow();
                    const infowindowContent = document.getElementById("infowindow-content");

                    infowindow.setContent(infowindowContent);

                    const marker = new google.maps.Marker({ map: map });

                    let ratingList = [];
                    
                    for (let i = 0; i < myArray.length; i++) {
                        if (myArray[i][0] == inputKey[0] && myArray[i][1] == inputKey[1]) {
                            ratingList.push[myArray[i][2]];
                        }
                    }

                    marker.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png')
                 
                    
                    // if(calculateMeanColor(ratingList) == "blue")
                    // {
                    //     marker = new google.maps.Marker({
                    //             icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                    //         });
                    // }
                    // else if(calculateMeanColor(ratingList) == "red")
                    // {
                    //     marker = new google.maps.Marker({
                    //             icon: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'
                    //         });
                    // }
                    // else
                    // {
                    //     marker = new google.maps.Marker({
                    //             icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
                    //         });
                    // }

                    marker.addListener("click", () => {
                        infowindow.open(map, marker);
                    });
                    autocomplete.addListener("place_changed", () => {
                        infowindow.close();

                        const place = autocomplete.getPlace();
                        // ADD MARKER TO MAP 
                        markers.push(place)
                        console.log(markers.length)
                        console.log(markers)
                        setMarkers(map);

                        marker.addListener("click", () => {
                        infowindow.open(map, marker);
                         });

                        if (!place.geometry || !place.geometry.location) {
                        return;
                        }

                        if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                        } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);
                        }
                        
                        let wheelchair_accessibility_entrance = Math.round((Math.random() * (5 - 3) + 3) * 10)/10;

                        // Set the position of the marker using the place ID and location.
                        // @ts-ignore This should be in @typings/googlemaps.

                        
                        marker.setPlace({
                        placeId: place.place_id,
                        location: place.geometry.location,
                        
                        });
                        marker.setVisible(true);
                        
                        infowindowContent.children.namedItem("place-name").textContent = place.name;
                        infowindowContent.children.namedItem("place-address").textContent = place.formatted_address;
                        infowindowContent.children.namedItem("place-rating").textContent = place.rating;
                        infowindowContent.children.namedItem("place-wheelchair-accessibility-entrance").textContent = wheelchair_accessibility_entrance;
                        infowindowContent.children.namedItem("place-phone-number").textContent = place.formatted_phone_number;
                        infowindowContent.children.namedItem("place-website").textContent = place.website;

                        infowindow.open(map, marker);
                        
                    inputKey = [place.geometry.location.lng(), place.geometry.location.lat()];
                    displayName();
                    infowindow.open(map, marker);
                    });

                    circle = new google.maps.Circile({
                        strokeColor:"FF0000",
                        strokeOpacity:0.8,
                        strokeWeight:2,
                        fillColor:"#FF0000",
                        map:map,
                        center:{lat:0, lng:0},
                        radius:5000,

                    })
                }

                window.initMap = initMap;
            </script>

            <script>

                function calculateMeanColor(ratings) {
                    // Calculate the mean of ratings
                    let total = 0;

                    for(var i = 0; i < ratings.length; i++) {
                        total += ratings[i];
                    }
                    let mean = total/ratings.length;

                    // Define the color ranges
                    let redRange = [0, 2.5];
                    let greenRange = [2.5, 4.5];
                    let blueRange = [4.5, 5];

                    // Determine the color based on the mean value
                    if (mean >= redRange[0] && mean <= redRange[1]) {
                        return "red";
                    } else if (mean >= greenRange[0] && mean <= greenRange[1]) {
                        return "green";
                    } else if (mean >= blueRange[0] && mean <= blueRange[1]) {
                        return "blue";
                    }
                }

            </script>

        </div>
    </section>



</body>

<include src="./footer.html"></include>

</html>
