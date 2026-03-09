<?php 
include('conection.php');
session_start();
if (empty($_SESSION['username']) ||  empty($_SESSION['password'])) {
    header('location:index.php');
};
if(!empty($_POST['msg']) && !empty($_POST['receiver']) &&!empty($_POST['sender']) && !empty($_POST['tool']) ){
$msg=$_POST['msg'];
$receiver= intval ($_POST['receiver']);
$sender= intval($_POST['sender']);
$tool= intval($_POST['tool']);
$req="INSERT INTO `messages` (`sender_id`, `receiver_id`, `content`, `tool_id`)  VALUES ($sender, $receiver, '$msg', $tool)";
$result=mysqli_query($conection,$req);

}
?>
