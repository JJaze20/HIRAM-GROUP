<?php
// Database connection
$servername = "localhost";
$username = "root"; // Default XAMPP MySQL username
$password = ""; // Default XAMPP MySQL password
$dbname = "hiram storage"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the posted data (ID of the item to delete)
$data = json_decode(file_get_contents('php://input'), true);

// Check if the data is valid
if (isset($data['id'])) {
    $itemId = $data['id'];

    // Prepare and execute the delete query
    $sql = "DELETE FROM storage WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $itemId); // Bind the ID to the SQL query

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting item']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
}

$conn->close();
?>
