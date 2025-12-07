<?php
// Database configuration
$host = "localhost";
$user = "root";
$password = "";
$dbname = "coffee_shop";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table with unique constraint to prevent double-booking same table, date, slot
$conn->query("CREATE TABLE IF NOT EXISTS table_bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) DEFAULT NULL,
    guests INT NOT NULL,
    booking_date DATE NOT NULL,
    time_slot VARCHAR(50) NOT NULL,
    table_no INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_booking (booking_date, time_slot, table_no)
)");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['send'])) {
    $name   = trim($_POST['name']);
    $phone  = trim($_POST['number']);
    $email  = isset($_POST['email']) ? trim($_POST['email']) : "";
    $guests = intval($_POST['guest']);
    $date   = $_POST['date'];
    $slot   = $_POST['time_slot'];
    $table  = intval($_POST['table_no']);

    if ($name === "" || $phone === "" || $guests <= 0 || $date === "" || $slot === "" || $table <= 0) {
        echo "<script>alert('Please fill all required fields correctly.'); window.history.back();</script>";
        exit;
    }

    // Check if this table is already booked for same date & slot
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM table_bookings WHERE booking_date = ? AND time_slot = ? AND table_no = ?");
    $checkStmt->bind_param("ssi", $date, $slot, $table);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        echo "<script>alert('This table is already booked for the selected date and time slot. Please choose a different table or slot.'); window.history.back();</script>";
        exit;
    }

    // Insert booking
    $stmt = $conn->prepare("INSERT INTO table_bookings (name, phone, email, guests, booking_date, time_slot, table_no)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssisss", $name, $phone, $email, $guests, $date, $slot, $table);

    if ($stmt->execute()) {

        // --- Email confirmation (works if mail() is configured on server) ---
        if (!empty($email)) {
            $subject = "BlissBeans - Table Booking Confirmation";
            $message = "Dear $name,\n\n"
                     . "Your table booking is confirmed.\n"
                     . "Details:\n"
                     . "Date: $date\n"
                     . "Time Slot: $slot\n"
                     . "Table No: $table\n"
                     . "Guests: $guests\n\n"
                     . "Thank you for choosing BlissBeans!";
            $headers = "From: no-reply@blissbeans.local";
            @mail($email, $subject, $message, $headers);
        }

        // --- SMS confirmation (placeholder: integrate any SMS API here) ---
        // Example:
        // $smsMessage = "BlissBeans: Your table is booked on $date, $slot, Table $table.";
        // send_sms_via_api($phone, $smsMessage);

        echo "<script>alert('Table booked successfully!'); window.location='index.html#contact';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

/*
// Example placeholder function for SMS using an external API
function send_sms_via_api($phone, $message) {
    // Use any SMS provider like Twilio, Fast2SMS, etc.
    // Call their API from here with your API key.
}
*/
?>