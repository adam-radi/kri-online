<?php 
  include('conection.php');
  if (!empty($_POST['status']) && !empty($_POST['payment_status'])){
    $req='update bookings set  status="'.$_POST['status'].'" , payment_status="'.$_POST['payment_status'].'" where id='.$_POST['id'];
    $result=mysqli_query($conection,$req);

  }
  echo 'all is good';
?>