
<?php
include('conection.php');
session_start();
if (empty($_SESSION['username']) || empty($_SESSION['password'])) {
    header('location:index.php');
    exit();
}
$tool_id = intval($_GET['tool_id'] ?? 0);
if ($tool_id <= 0) {
    echo "Invalid tool ID.";
    exit();
}
$sql = "SELECT * FROM tools WHERE id = $tool_id";
$result = mysqli_query($conection, $sql);
$data = mysqli_fetch_assoc($result);
if (!$data) {
    echo "Tool not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Booking System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />

    <style>
        body {
            font-family: 'Tahoma', sans-serif;
            background: #f2f2f2;
            height: 100vh;
            margin: 0;
            direction: ltr;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 100px;
        }

        .booking-container {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input[type="text"],
        button {
            padding: 12px;
            font-size: 16px;
            width: 100%;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        button {
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .note {
            margin-top: 10px;
            color: #999;
            font-size: 14px;
        }

        .confirmation {
            margin-top: 20px;
            font-weight: bold;
            color: green;
        }
    </style>
</head>

<body>
    <?php include('menu.php'); ?>
    <div class="container">
        <div class="booking-container">
            <h2>Book Your Stay</h2>
            <input type="text" readonly value="<?= htmlspecialchars($data['title']); ?>" />
            <input type="text" id="bookingDate" placeholder="Select start and end date" />
            <button onclick="confirmBooking()">Confirm Booking</button>
            <p class="note">Booked dates are disabled and cannot be selected</p>
            <p class="confirmation" id="confirmationMessage"></p>
        </div>
    </div>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        let selectedRange = null;
        const toolId = <?= $tool_id ?>;

        // Fetch booked dates from the server
        fetch("booking_fetch.php?tool_id=" + toolId)
            .then(response => response.json())
            .then(disabledDates => {
                flatpickr("#bookingDate", {
                    mode: "range",
                    dateFormat: "Y-m-d",
                    disable: disabledDates,
                    onChange: function(selectedDates, dateStr) {
                        selectedRange = dateStr;
                    }
                });
            })
            .catch(err => {
                console.error("Error fetching booked dates:", err);
                // In case of error, initialize without disabled dates
                flatpickr("#bookingDate", {
                    mode: "range",
                    dateFormat: "Y-m-d",
                    onChange: function(selectedDates, dateStr) {
                        selectedRange = dateStr;
                    }
                });
            });

        function confirmBooking() {
            if (!selectedRange) {
                alert("Please select a booking date range first.");
                return;
            }

            const dates = selectedRange.split(" to ");
            if (dates.length !== 2) {
                alert("Please select both a start and end date.");
                return;
            }

            const startDate = dates[0];
            const endDate = dates[1];

            // Send booking to backend
            fetch("booking_save.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body:`tool_id=${toolId}&start_date=${startDate}&end_date=${endDate}`
            })
            .then(response => response.text())
            .then(result => {
                document.getElementById("confirmationMessage").innerText = result;
            })
            .catch(err => {
                alert("Error saving booking.");
                console.error(err);
            });
        }
    </script>
</body>

</html>
