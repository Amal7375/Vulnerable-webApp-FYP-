<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "fyp");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get room details based on ID
$room_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT name, description, ip_address FROM room WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $room = $result->fetch_assoc();
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo htmlspecialchars($room['name']); ?></title>
        <style>
            /* Styles for layout and design */
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f9;
                color: #333;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .room-details-container {
                background-color: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 30px;
                max-width: 600px;
                width: 100%;
                box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
                text-align: center;
            }

            h1 {
                font-size: 2em;
                margin: 0 0 20px;
            }

            p {
                font-size: 1.1em;
                line-height: 1.6;
                color: #555;
                margin-bottom: 15px;
            }

            .button, .copy-button {
                display: inline-block;
                margin: 15px 0;
                padding: 10px 20px;
                color: #fff;
                background-color: #007bff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .button:hover, .copy-button:hover {
                background-color: #0056b3;
            }

            .hidden {
                display: none;
            }

            .timer {
                font-size: 1.2em;
                color: #ff0000;
            }

            .back-link {
                display: inline-block;
                margin-top: 20px;
                color: #007bff;
                text-decoration: none;
            }
        </style>
        <script>
            function startRoomAndShowIp() {
                let timer = 5;
                const timerElement = document.getElementById("timer");
                const ipAddressElement = document.getElementById("ipAddress");
                const copyButton = document.getElementById("copyButton");
                const startRoomButton = document.getElementById("startRoomButton");

                // Hide the Start Room button
                startRoomButton.classList.add("hidden");

                // Show the timer
                timerElement.classList.remove("hidden");
                
                const countdown = setInterval(() => {
                    timerElement.textContent = "Starting room and showing IP in " + timer + " seconds...";
                    if (timer === 0) {
                        clearInterval(countdown);
                        timerElement.classList.add("hidden");
                        ipAddressElement.classList.remove("hidden");
                        copyButton.classList.remove("hidden");
                    }
                    timer--;
                }, 1000);
            }

            function copyToClipboard() {
                const ipAddress = document.getElementById("ipAddress").textContent;
                navigator.clipboard.writeText(ipAddress).then(() => {
                    alert("IP Address copied to clipboard!");
                });
            }
        </script>
    </head>
    <body>
        <div class="room-details-container">
            <h1><?php echo htmlspecialchars($room['name']); ?></h1>
            <p><?php echo htmlspecialchars($room['description']); ?></p>
            
            <button id="startRoomButton" class="button" onclick="startRoomAndShowIp()">Start Room</button>
            <p id="timer" class="timer hidden"></p>
            
            <p id="ipAddress" class="hidden"><?php echo htmlspecialchars($room['ip_address']); ?></p>
            <button id="copyButton" class="copy-button hidden" onclick="copyToClipboard()">Copy IP Address</button><br><br>

            <a href="index.php" class="back-link">Back to Room List</a>
        </div>
    </body>
    </html>
    
    <?php
} else {
    echo "<p>Room not found.</p>";
}

$stmt->close();
$conn->close();
?>
