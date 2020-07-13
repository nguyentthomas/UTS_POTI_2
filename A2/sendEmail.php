<?php
    session_start();
                        foreach ($_SESSION['savedCart'] as $arrNo => $item) {
                            $priceItem = $item['qty'] * $item['price'];
                            $costTotal += $priceItem;
                        }
                    //setEmail parameters
    $mailTo = $_POST[$inputEmail];
    $subject = 'Order Details';
    $text = "Thankyou for shopping at HertzUTS (ThomNguy). Total cost is: $costTotal. We will be sending it to your provided address. $inputAddress, $inputCity, $inputState, $inputPostCode"; //as per assignment outline, only total cost is required, send total cost.
    $mailFrom = "From: thomnguy@HertzUTS.com";
    mail($mailTo, $subject, $text, $mailFrom); //send Email
    $success = mail($mailTo, $subject, $text, $mailFrom); //if successful, do this
    if (!$success) {
        $case = "Unknown Error, Failed.";
    }
    else{
        $case = "An email has been sent to the provided email address.";
    }
include "dependencies.php";
?>
<html>
<div class="container">
    <body style="text-align:center;">
    <h1>Thank you for shopping at HertzUTS!</h1>
        <p><?php echo $case?></p>
    </body>
</div>
</html>


<?php
session_destroy();
?>