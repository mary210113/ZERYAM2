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

// Query database for products
$sql = "SELECT id,  name, image, price FROM trendy";
// $sql1 = "SELECT category_id, category_name FROM category";
$result = mysqli_query($conn, $sql);

// Loop through results and output data
if (mysqli_num_rows($result) > 0) {
    $products_array = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $product_item = array(
            "id" => $row["id"],
            "name" => $row["name"],
            "image" => $row["image"],
            "price" => $row["price"],
            // "category_name" => $row["category_name"],
        );
        array_push($products_array, $product_item);
    }
    echo json_encode($products_array);
} else {
    echo json_encode(array("message" => "No products found."));
}

// if (mysqli_num_rows($result) > 0) {
//     $category_array = array();
//     while ($row = mysqli_fetch_assoc($result)) {
//         $category_item = array(
//             // "id" => $row["id"],
//             // "product_name" => $row["product_name"],
//             // "product_image" => $row["product_image"],
//             // "price" => $row["price"],
//             "category_name" => $row["category_name"],
//         );
//         array_push($category_array, $category_item);
//     }
//     echo json_encode($category_array);
// } else {
//     echo json_encode(array("message" => "No products found."));
// }

// Close connection
mysqli_close($conn);
