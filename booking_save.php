<?php
// include('conection.php');
// session_start();

// if (!isset($_POST['tool_id']) || !isset($_POST['start_date']) || !isset($_POST['end_date'])) {
//     echo "Missing data.";
//     exit;
// }

// $tool_id = intval($_POST['tool_id']);
// $start_date = $_POST['start_date'];
// $end_date = $_POST['end_date'];

// // تحقق من المستخدم
// if (empty($_SESSION['id'])) {
//     echo "User not logged in.";
//     exit;
// }

// $username = $_SESSION['id'];
// $sql = "INSERT INTO bookings (tool_id, start_date, end_date, renter_id) VALUES (?, ?, ?, ?)";
// $stmt = mysqli_prepare($conection, $sql);
// mysqli_stmt_bind_param($stmt, "isss", $tool_id, $start_date, $end_date, $username);
// mysqli_stmt_execute($stmt);

// if (mysqli_stmt_affected_rows($stmt) > 0) {
//     echo "Booking confirmed from $start_date to $end_date";
// } else {
//     echo "Error saving booking.";
// }
?>
<?php
session_start();
include("conection.php");

if (empty($_SESSION['username'])) {
    echo "User not logged in";
    exit;
}

$tool_id = intval($_POST['tool_id']);
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$renter_id = intval($_SESSION['id']);

// جلب الثمن اليومي من جدول الأدوات
$tool_query = "SELECT price_per_day FROM tools WHERE id = $tool_id";
$tool_result = mysqli_query($conection, $tool_query);
$tool_data = mysqli_fetch_assoc($tool_result);

if (!$tool_data) {
    echo "Tool not found.";
    exit;
}

$price_per_day = floatval($tool_data['price_per_day']);

// حساب عدد الأيام
$start = new DateTime($start_date);
$end = new DateTime($end_date);
$interval = $start->diff($end)->days + 1; // +1 باش يكون شامل البداية والنهاية

$total_price = $price_per_day * $interval;

// حفظ الحجز مع الثمن الإجمالي
$sql = "INSERT INTO bookings (tool_id, renter_id, start_date, end_date, total_price)
        VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conection, $sql);
mysqli_stmt_bind_param($stmt, "iissd", $tool_id, $renter_id, $start_date, $end_date, $total_price);

if (mysqli_stmt_execute($stmt)) {
    echo "✅ Booking saved successfully. Total price: $total_price DH";
} else {
    echo "❌ Error: " . mysqli_error($conection);
}
?>