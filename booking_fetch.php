<?php
include('conection.php'); // تأكد أن هاد الملف فيه الاتصال بـ mysqli

if (!isset($_GET['tool_id'])) {
    echo json_encode([]);
    exit;
}

$tool_id = intval($_GET['tool_id']);

$sql = "SELECT start_date, end_date FROM bookings WHERE tool_id = $tool_id";
$result = mysqli_query($conection, $sql);

$disabledDates = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $start = new DateTime($row['start_date']);
        $end = new DateTime($row['end_date']);

        while ($start <= $end) {
            $disabledDates[] = $start->format('Y-m-d');
            $start->modify('+1 day');
        }
    }
}

echo json_encode($disabledDates);
?>