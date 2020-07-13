<html>
<?php
include "dependencies.php";
session_start(); //start session global variable

//needs the form: the modelYear, modelName, bramd, picture and price per day.
//set a default value of 1 rental day.

if (!isset($_SESSION['savedCart'])) {
    $_SESSION['savedCart'] = array(); //create an array
}

if (isset($_GET['model']) && isset($_GET['combo']) && isset($_GET['price']) && isset($_GET['qty']) && isset($_GET['add_to_cart'])) {
    $carArray = array( //store values into array
        'model' => $_GET['model'], //model from prev page
        'combo' => $_GET['combo'], //combo (model, year, brand)
        'price' => $_GET['price'], //priceperday
        'qty' => $_GET['qty'] //qty
        );
    $_SESSION['savedCart'][] =  $carArray;
    header('Location: ' . $_SERVER['PHP_SELF']); //using GET method, shows the values in the URL, but using this sets it back to the page name, whilst retaining values.
} 
elseif (isset($_GET['remove'])) { //Remove specific car Functionality
    unset($_SESSION['savedCart'][$_GET['remove']]); //when remove is prompted, do and reset
    header('Location: ' . $_SERVER['PHP_SELF']);
}
 elseif (isset($_POST['update'])) {
    foreach ($_POST['cars_qty'] as $arrNo => $qty) { //for each car, set their quantity
        if ($qty == 0) { //bugged but still functions...
            //unset($_SESSION['savedCart'][$arrNo]);
            //echo "<script>alert('Rental Days can't be zero or null');"; //doesnt alert, but still works... LOL, doesnt update
            //echo "</script>";
        } elseif ($qty >= 1) { //value must be greater than one to be present.
            $_SESSION['savedCart'][$arrNo]['qty'] = $qty; //set the car.
        }
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
}
?>
<?php if (empty($_SESSION['savedCart'])) { //if cart is empty, do this in the table || TODO: ADD VALIDATION, IF NOTHING IN CART, DO NOT ALLOW TO PROCEED.
                            echo "<script>alert('No cars have been reserved.');
                            window.location='index.php';
                            </script>";
                            //https://www.codeproject.com/Questions/343563/Before-redirecting-to-a-php-page-alert-is-not-show - do this first, so nothing displays...
                        } ?>
    <head>
        <title>Cart | Hertz UTS Car Rental</title>
    </head>
    <body>
            <div class="container">
            <h1 style="text-align:center;">Reservations</h1>
            <p>Enter how many days you require to rent the car, then click 'Update' or the 'Refresh' icon and then click 'Proceed' to begin checking out.</p>
                <div>
                    <form action="shoppingCart.php" onsubmit="return(validateDays());" method="POST">
                        <table class="table">
                                <tr>
                                    <th>Image</th>
                                    <th>Car (Brand, Model, Year)</th>
                                    <th>Price Per Day ($)</th>
                                    <th>Rental Days</th>
                                    <th>Actions</th>
                                </tr>
                                <tr>
                                <?php
                                    $costTotal = 0;
                                    foreach ($_SESSION['savedCart'] as $arrNo => $car) {
                                        $priceItem = $car['qty'] * $car['price'];
                                        $costTotal += $priceItem; 
                                ?>

                                <tr id="car<?php echo $arrNo; ?>">
                                    <td><img src="images/<?php echo $car['model']; ?>.jpg" style="width:180px;height:120px;"></td>
                                    <td><?php echo $car['combo']; ?></td>
                                    <td><?php echo $car['price']; ?></td>
                                    <td><input style=text-align:right; name="cars_qty[<?php echo $arrNo; ?>]" type="text" id="cars_qty[<?php echo $arrNo; ?>]" value="<?php echo $car['qty']; ?>" min="0" max="366"></td>
                                    <td><a class="btn btn-warning" href="?remove=<?php echo $arrNo; ?>">Remove</a></td>
                                </tr>
                                <?php
                                    }
                                ?>
                        </table>
                        <table class="table">
                        <tr>
                            <td><input class="btn btn-warning" type="submit" name="update" id="update" value="Update" onsubmit=return(validateDays());></td>
                            <td style="text-align:right;"><button type="button" class="btn btn-warning" onclick="window.location.href='checkout.php'">Proceed</button></td>
                        </tr>
                        </table>
                    </form>
                </div>
            </div>
    </body>
<script>
    function validateDays() {
        var RentAmt = document.getElementById('cars_qty[<?php echo $arrNo; ?>]').value; //problem with validation, this only does the LATEST car, need to create implementation that sorts the array
        if (RentAmt < 0) { // for less than 0
            alert("Rental Days has to be more than 0.");
            return false;
        }
        else if (RentAmt == 0 || RentAmt == null) { // for 0 and null values
            alert("Rental Days can't be zero or null.");
            return false;
        }
        else if (isNaN(RentAmt)) { // for characters other than numbers
          alert("Rental Days has to be a number");
            return false;
        }
        else if (RentAmt > 30) { //just so its not an absurd number.
            alert("Due to company policies, 30 days is the max, you can order a car.");
            return false;
        }
        else { //else send it to the next page
          window.location.href = "checkout.php";
          return true;
        }
    }
</script>
</html>