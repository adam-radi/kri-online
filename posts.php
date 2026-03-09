
<?php 
   include('conection.php');
   session_start();
   if (empty($_SESSION['username']) ||  empty($_SESSION['password'])){
      header('location:index.php');
   }
   $test='';
   $req5='select * from tools where owner_id='.$_SESSION['id'];
   $result5=mysqli_query($conection,$req5);
   while($data5=mysqli_fetch_array($result5)){

    $test.="<div class='cart-profile col-lg  mt-2 mb-3  m-3 '>    
                <div class='img-cart'>
                    <img class='img-profl ' src='". $data5['main_image_url'] ."'>
                </div>
                <h4 class='title'>".$data5['title']."<span> : </span>".$data5['price_per_day']."DH</h4>
            </div>";
   }
   echo $test;
?>

