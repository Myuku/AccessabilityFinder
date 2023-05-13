<!DOCTYPE html>
<html lang="en">
    <?php include "includes/header.html" ?>

<body>
    <?php include "includes/navbar.html" ?>
    <section class="title">
        <h1>You're doing GREAT!</h1>
    </section>

    <section class="main">
        <div class="comments">
            
            <div id="display"></div>
            <input type="text" id="inputKey">
            <button onclick="addValue()">Add Value</button>
            
            <script>
                let myArray = [];

                function addValue() {
                    let key = document.getElementById("inputKey").value;
                    myArray.push(key);
                    console.log(myArray); // for testing purposes
                    displayArray()
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
                <iframe
                    height="100%"
                    width="100%"
                    style="border:0"
                    loading="lazy"
                    allowfullscreen
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCBq7-eWrP0E0JORqLGv14We7saZT1VciQ
                    &q=Space+Needle,Simon Fraser University">
                </iframe>
            </div>
    </section>

    

</body>

<include src="./footer.html"></include>

</html>