<?php
session_start();

require_once("php/CreateDb1.php");
require_once("php/component.php");
$db = new CreateDb($dbname = "Productdb", $tablename = "Producttb");

if (isset($_POST['remove'])) {
    // if click button with form action, start command if {}
    if ($_GET['action'] == 'remove') {
        foreach ($_SESSION['cart'] as $key => $value) {
            if ($value['product_id'] === $_GET['id']) {
                unset($_SESSION['cart'][$key]);
                echo "<script>alert('Product has been removed')</script>";
                echo "<script>window.location = 'cart.php'</script>";
            }
        }
    }

}

?>


<html lang="english">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css"/>

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
<?php
require_once('php/header.php')
?>

<div class="container-fluid">
    <div class="row px-5">
        <div class="col-md-7">
            <div class="shopoing-cart">
                <h6 class="py-2">My cart</h6>
                <hr>
                <?php
                $total = 0;

                if (isset($_SESSION['cart'])) {

                    $product_id = array_column($_SESSION['cart'], $column = 'product_id');//                    variable
                    // of products id
                    $result = $db->getData();//                get data from db and put him in result
                    while ($row = mysqli_fetch_assoc($result)) {
                        //provera da li je id kartice jednak id-u u redu
                        foreach ($product_id as $id) {
                            if ($row['id'] == $id) {
                                cartElement($row['product_image'], $row['product_name'], $row['product_price'], $row['id']);
                                $total = $total + (int)$row['product_price'];
                            }
                        }
                    }
                } else {
                    echo "<h5>Cart is Empty<h5/>";
                }

                ?>


            </div>
        </div>
        <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">
            <div class="pt-4">
                <h6>Price Details</h6>
                <hr>
            </div>
            <div class="row price-detalis">
                <div class="col-md-6">
                    <?php
                    if (isset($_SESSION['cart'])) {
                        $count = count($_SESSION['cart']);
                        echo "<h6>Price ($count items)<h6/>";
                    } else {
                        echo "<h6>Price(0 items)</h6>";
                    }

                    ?>
                    <h6>Delivery Charges</h6>
                    <hr>
                    <h6>Amount Payable</h6>
                </div>
                <div class="col-md-6">
                    <h6>$<?php echo $total; ?></h6>
                    <h6 class="text-success">Free</h6>
                    <hr>
                    <h6>
                        
                        $<?php echo $total ?>
                    </h6>
                </div>
            </div>
        </div>
    </div>


</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>