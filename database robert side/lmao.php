<?php
    $categories = $_POST['categories'];
    $item = $_POST['item'];
    $quantity = $_POST['quantity'];

    if (!empty($categories) && !empty($item) && !empty($quantity)){

    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "hiram storage";

    $conn = mysqli_connect($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_errno()) {
        die("Connection failed: " . mysqli_connect_error());
    } 
        $sql = "INSERT INTO storage(categories, item, quantity)
                VALUE (?, ?, ?)";

        $stmt = mysqli_stmt_init($conn);

        if( ! mysqli_stmt_prepare($stmt, $sql)){
          die(mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "isi", 
                               $categories,
                               $item,
                               $quantity);

        mysqli_stmt_execute($stmt);
        echo "Item Added!";
    } else {
        echo "All fields are required except remove.";
        die();
    }
    ?>