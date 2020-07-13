<?php
session_start(); //start session global variable
include "dependencies.php";
?>
<html>
    <head>
        <title>Checkout | Hertz UTS Car Rental</title>
    </head>
    <div class="container">
    <h1 style="text-align:center;">Checkout</h1>
    <h2>Purchase Form and Payment</h2>
    <p>Please fill in the form, providing your personal details. <span style="color:red;">*</span> indicates fields that are required.</p>
<form action="sendEmail.php" onsubmit="return(validateFields());" name="coForm">
  <div class="form-row">
  <div class="form-group col-md-6">
      <label for="inputFName">First Name<span style="color:red;">*</span></label>
      <input type="text" class="form-control" id="inputFName" placeholder="e.g. John">
    </div>
    <div class="form-group col-md-6">
      <label for="inputLName">Last Name<span style="color:red;">*</span></label>
      <input type="text" class="form-control" id="inputLName" placeholder="e.g. Doe">
    </div>
    <div class="form-group col-md-12">
      <label for="inputEmail">Email<span style="color:red;">*</span></label>
      <input type="email" class="form-control" id="inputEmail" placeholder="E.g. John@email.com">
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Address Line 1<span style="color:red;">*</span></label>
    <input type="text" class="form-control" id="inputAddress" placeholder="E.g. 123 Example St">
  </div>
  <div class="form-group">
    <label for="inputAddress2">Address Line 2</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">City<span style="color:red;">*</span></label>
      <input type="text" class="form-control" id="inputCity" placeholder="Sydney">
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">State<span style="color:red;">*</span></label>
      <select id="inputState" class="form-control">
        <option value="Australian Capital Territory">Australian Capital Territory</option>
        <option value="New South Wales">New South Wales</option>
        <option value="Northern Territory">Northern Territory</option>
        <option value="Queensland">Queensland</option>
        <option value="South Australia">South Australia</option>
        <option value="Tasmania">Tasmania</option>
        <option value="Victoria">Victoria</option>
        <option value="Western Australia">Western Australia</option>
      </select>
    </div>
    <div class="form-group col-md-2">
      <label for="inputPostCode">Post Code<span style="color:red;">*</span></label>
      <input type="text" class="form-control" id="inputPostCode" placeholder="2000">
    </div>
    <div class="form-group col-md-12">
  <?php
  //Displays items into the shopping cart table, total amount should be displayed here...
  $costTotal = 0;
  foreach ($_SESSION['savedCart'] as $arrItem => $item) {
      $priceItem = $item['qty'] * $item['price'];
      $costTotal += $priceItem;
  }
  ?>
  <h1>You agree to pay the total amount of: $<?php echo $costTotal;?></h1>
    </div>
    <div class="form-group col-md-4">
      <label for="inputPayment">Payment Method<span style="color:red;">*</span></label>
      <select id="inputPayment" class="form-control">
        <option value="Bank Transfer">Bank Transfer</option>
        <option value="MasterCard">MasterCard</option>
        <option value="Paypal">Paypal</option>
        <option value="VISA">VISA</option>
      </select>
    </div>
  </div>
  <button type="submit" value="Checkout" class="btn btn-warning">Checkout</button>
  </form>
  </div>
  </div>
<script>
  function validateFields(){ //from Assignment 1 with changes...
        var inputFName = document.getElementById('inputFName').value;
        var inputLName = document.getElementById('inputLName').value;
        var inputEmail = document.getElementById('inputEmail').value;
        var inputAddress = document.getElementById('inputAddress').value;
        var inputCity = document.getElementById('inputCity').value;
        var inputState = document.getElementById('inputState').value;
        var inputPostCode = document.getElementById('inputPostCode').value;
        var inputPayment = document.getElementById('inputPayment').value;
        
        if (!inputFName || !inputLName || !inputEmail || !inputAddress || !inputCity || !inputState || !inputPostCode || !inputPayment) { //checking for empty fields
            alert("There are empty fields, please fill in the required fields.");
          return false;
        }
        else if(!emailValid(inputEmail)){ //if pass valid Email
          alert("Email was invalid, please enter a valid email address");
          return false;
        }
        else { //else if nothing else fails, continue
          return true;
          }
}

function emailValid(inputEmail){ //https://stackoverflow.com/questions/46155/how-to-validate-an-email-address-in-javascript
    var regExp = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/; //constrains the values to suit typical email format. NOT A CATCH ALL
    return regExp.test(inputEmail);
}

</script>

</html>