<?php
// Receive them data
$data = json_decode(file_get_contents("php://input"));
$username = $data->username;
$password = $data->password;
$role = $data->role;


if (!empty($username) && !empty($password) && !empty($role)) {

    // Database name
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "login_register";

    // Create a connection to the database
    $conn = mysqli_connect($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_errno()) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Hash for em password security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert the data into the users table
    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";

    // Prepare the statement
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die(mysqli_error($conn));
    }

    // Bind the parameters and execute the statement
    mysqli_stmt_bind_param($stmt, "sss", $username, $hashedPassword, $role);
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["success" => true, "message" => "User registered successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error registering user."]);
    }

    // Close 
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
}
?>
