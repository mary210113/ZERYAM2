<?php
// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zeryam";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if add to cart button is clicked
if(isset($_POST['add_to_cart'])) {
    // Get product ID from form submission
    $product_id = $_POST['product_id'];

    // Check if product ID is valid
    $query = "SELECT * FROM products WHERE id = '$product_id'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) == 1) {
        // Product exists, get product details
        $product = mysqli_fetch_assoc($result);

        // Get product quantity from form submission
        $quantity = $_POST['quantity'];

        // Add product to cart
        if(isset($_SESSION['cart'])) {
            // Cart exists, check if product already in cart
            if(array_key_exists($product_id, $_SESSION['cart'])) {
                // Product already in cart, update quantity
                $_SESSION['cart'][$product_id]['quantity'] += $quantity;
            }
            else {
                // Product not in cart, add it
                $_SESSION['cart'][$product_id] = array(
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity
                );
            }
        }
        else {
            // Cart does not exist, create it and add product
            $_SESSION['cart'] = array(
                $product_id => array(
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity
                )
            );
        }

        // Redirect to cart page
        header('Location: cart.php');
        exit;
    }
}

// Query database for products
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0) {
    // Output products in HTML table
    echo "<table>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['price'] . "</td>";
        echo "<td>";
        echo "<form method='POST'>";
        echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
        echo "<input type='number' name='quantity' value='1' min='1'>";
        echo "<input type='submit' name='add_to_cart' value='Add to Cart'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Close database connection
mysqli_close($conn);
?>
