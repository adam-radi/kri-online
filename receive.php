<?php
include('conection.php');
session_start();
if (empty($_SESSION['username']) ||  empty($_SESSION['password'])) {
    header('location:index.php');
};
$content = '';

if (!empty($_POST['tool']) && !empty($_POST['sender']) ) {
    $idtool = $_POST['tool'];
    $idsender = $_POST['sender'];
    $idreceiver = $_POST['receiver'];
    $sql5 = 'select * from messages where tool_id='.$idtool.' and ((sender_id='.$idsender.' and receiver_id='.$idreceiver .') or (sender_id='.$idreceiver.' and receiver_id='.$idsender .') ) order by sent_at asc';
    $reponce5 = mysqli_query($conection, $sql5);
    while ($data = mysqli_fetch_array($reponce5)) {
        if ($data['sender_id'] == $idsender) {
            $send = 'sender';
        } elseif ($data['sender_id'] == $idreceiver) {
            $send = 'receiver';
        }
        $content .= '<div class="msgcont"><div class="' . $send . ' row"><p class="msgajax col-12">' . $data['content'] . '</p><p class="date offset-7 col-3">' . date('h:i:s', strtotime($data['sent_at'])). '</p></div></div>';
    }
}
echo $content;

