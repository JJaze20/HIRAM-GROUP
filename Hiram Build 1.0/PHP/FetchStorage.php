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

// Query to fetch inventory data
$sql = "SELECT categories, item, quantity FROM storage";
$result = $conn->query($sql);

$inventoryData = [];

// Mapping category numbers to words
$categoryNames = [
    1 => "Sports Gears",
    2 => "School Items",
    3 => "Library Equipments",
    4 => "Canteen Utensils"
];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Translate category number to word
        $categoryWord = isset($categoryNames[$row['categories']]) ? $categoryNames[$row['categories']] : "Unknown";
        $row['categories'] = $categoryWord;
        $inventoryData[] = $row;
    }
} else {
    $inventoryData[] = ["message" => "No items found"];
}

echo json_encode($inventoryData); // Return data as JSON

$conn->close();
?>
