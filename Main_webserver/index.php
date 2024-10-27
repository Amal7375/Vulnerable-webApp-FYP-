<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "fyp");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch rooms from the database
$sql = "SELECT id, name FROM room";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rooms</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #444;
        }

        .room-container {
            max-width: 600px;
            width: 100%;
        }

        .room-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            padding: 15px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .room-card:hover {
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .room-card h2 {
            font-size: 1.5em;
            margin: 0 0 10px;
            color: #333;
        }

        .room-card form {
            text-align: right;
        }

        .room-card button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .room-card button:hover {
            background-color: #0056b3;
        }

        .no-rooms {
            text-align: center;
            font-size: 1.2em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="room-container">
        <h1>Available Rooms</h1>

        <?php
        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='room-card'>";
                    echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
                    echo "<form action='room.php' method='GET'>";
                    echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>";
                    echo "<button type='submit'>Join This Room</button>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "<p class='no-rooms'>No rooms available.</p>";
            }
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
