<?php
include "dependencies.php";
session_start();
?>
<html>
<style>
.buttonBtm {
  position: absolute;
  bottom: 0;
  margin-bottom: 10px;
  left: 35%;
}
</style>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE11" />
<title>Home | Hertz UTS Car Rental</title>
</head>
<body onload="javascript:loadDoc()">
<!--should output a table below.-->
<div class="container"><div id="cars"></div> <!--function carXML(XML) is called into this div-->
</div>
<script type="text/javascript">
var carArr; //create variable array that exists outside of functions.
function loadDoc() { //from - https://www.w3schools.com/js/js_ajax_xmlfile.asp, this code creates a connection and links the XML, loading it into the webpage.
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    carXML(this);
    }
  };
  xhttp.open("GET", "cars.xml", true); //Question 1,2,3. -XMLHTTPRequest(method,url,async)
  xhttp.send();
}
//Question 3
function carXML(xml) { //this allows us to visualise how we want the data to be shown on the webpage, with bootstrap we can style it easily.
  var i;
  var xmlDoc = xml.responseXML;
  cars = xmlDoc.documentElement; //https://www.w3schools.com/xml/prop_document_documentelement.asp
  availability = cars.getElementsByTagName("availability");
  var cardLayout = "<div class='row'></div>";
  carArr = xmlDoc.getElementsByTagName("car"); //for each element that is car...
  for (i = 0; i < carArr.length; i++) { //display relevant data.
    cardLayout += "<div class='card' style='width:350px; height:750px; float:left; display:inline; margin:10px;'><img class='card-img-top' src='images/" +
    //relating to each of the iterations in the array, do...
    //fetch Image
    carArr[i].getElementsByTagName("model")[0].childNodes[0].nodeValue +
    ".jpg' style='width:100%; height:280px;'><div class='card-body'><h4 class='card-title'>" +
    //list Brand, model and ModelY
    carArr[i].getElementsByTagName("brand")[0].childNodes[0].nodeValue + " " +
    carArr[i].getElementsByTagName("model")[0].childNodes[0].nodeValue + ", " +
    carArr[i].getElementsByTagName("modelYear")[0].childNodes[0].nodeValue +
    //Category
    "</h4><p class='card-text'><b>Category Type: </b>" +
    carArr[i].getElementsByTagName("category")[0].childNodes[0].nodeValue +
    //Availability
    "<br><b>Availability: </b>" +
    carArr[i].getElementsByTagName("availability")[0].childNodes[0].nodeValue +
    //Mileage
    "<br><b>Mileage: </b>" +
    carArr[i].getElementsByTagName("mileage")[0].childNodes[0].nodeValue +
    //Fuel Type
    "<br><b>Fuel Type: </b>" +
    carArr[i].getElementsByTagName("fuelType")[0].childNodes[0].nodeValue +
    //Number of Seats
    "<br><b>Number of Seats: </b>" +
    carArr[i].getElementsByTagName("seats")[0].childNodes[0].nodeValue +
    //Price Per Day
    "<br><b>Price Per Day: </b>$" +
    carArr[i].getElementsByTagName("pricePerDay")[0].childNodes[0].nodeValue +
    //Description
    "<br><b>Description: </b>" +
    carArr[i].getElementsByTagName("description")[0].childNodes[0].nodeValue +
    //each of these iterates the lowest nodes' values, pretty much calling the value.
    //then create a session or form to carry necessary data to cart page to save.
    //needs the modelYear, modelName, brand, picture and price per day.
    //using form format from assignment 1.
    "</p><form action='shoppingCart.php' method='GET' onsubmit='return fetchAvail("+ i +")' name='form'><input type='hidden' name='model' value='" + carArr[i].getElementsByTagName("model")[0].childNodes[0].nodeValue + "'><input type ='hidden' name='combo' value='"
  + carArr[i].getElementsByTagName("brand")[0].childNodes[0].nodeValue + " " + carArr[i].getElementsByTagName("model")[0].childNodes[0].nodeValue + " " + carArr[i].getElementsByTagName("modelYear")[0].childNodes[0].nodeValue + "'><input type='hidden' name='price' value='"
  + carArr[i].getElementsByTagName("pricePerDay")[0].childNodes[0].nodeValue + "'><input type='hidden' name='qty' value='" + carArr[i].getElementsByTagName("qty")[0].childNodes[0].nodeValue +
  "'><input type='submit' name='add_to_cart' id='add_to_cart' class='btn btn-warning buttonBtm' value='Add to Cart'></form></div></div>";
  }
  cardLayout += "</div>";
  document.getElementById("cars").innerHTML = cardLayout; //displays element called into HTML div where id = cars
}

function fetchAvail(i) { //https://stackoverflow.com/questions/2672380/how-do-i-check-in-javascript-if-a-value-exists-at-a-certain-array-index
    if (availability.item(i).firstChild.data == "True"){ //(carArr[i].getElementsByTagName("availability")[0].childNodes[0].nodeValue == "true") - the commented solution was bugged on iE but, this way works... ONLY the true statement had a null reference, for some reason...
        alert("Successfully added to your cart.");
        return true;
    } else if (carArr[i].getElementsByTagName("availability")[0].childNodes[0].nodeValue == "False") {
        alert("Sorry, the car is not available now. Please try other cars."); //as per assignment outline, send an alert..
        return false;
    }
}
</script>

</body>
</html>
