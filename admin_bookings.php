<?php
// admin_bookings.php - Simple admin panel to view & delete bookings

$host = "localhost";
$user = "root";
$password = "";
$dbname = "coffee_shop";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete action
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $delStmt = $conn->prepare("DELETE FROM table_bookings WHERE id = ?");
    $delStmt->bind_param("i", $id);
    $delStmt->execute();
    $delStmt->close();
    header("Location: admin_bookings.php");
    exit;
}

// Fetch all bookings
$result = $conn->query("SELECT * FROM table_bookings ORDER BY booking_date DESC, time_slot ASC, table_no ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BlissBeans - Bookings Admin</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { padding: 2rem; }
        h1 { margin-bottom: 1.5rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { border: 1px solid #ccc; padding: 0.5rem; text-align: left; font-size: 0.9rem; }
        th { background: #f5f5f5; }
        .actions a { color: #c00; text-decoration: none; font-weight: bold; }
        .top-links { margin-bottom: 1rem; }
        .top-links a { margin-right: 1rem; text-decoration: none; }
    </style>
</head>
<body>

    <div class="top-links">
        <a href="index.html" class="btn">← Back to Site</a>
    </div>

    <h1>BlissBeans - Table Bookings</h1>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Guests</th>
                    <th>Date</th>
                    <th>Time Slot</th>
                    <th>Table No</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['guests']); ?></td>
                    <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['time_slot']); ?></td>
                    <td><?php echo htmlspecialchars($row['table_no']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    <td class="actions">
                        <a href="admin_bookings.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this booking?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No bookings found.</p>
    <?php endif; ?>

<?php
if ($result) {
    $result->free();
}
$conn->close();
?>
</body>
</html>
