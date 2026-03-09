
<?php 
   include('conection.php');
   session_start();
   if (empty($_SESSION['username']) ||  empty($_SESSION['password'])){
      header('location:index.php');
   }
   $test='';
   $req6='select * from favorites where user_id='.$_SESSION['id'];
   $result6=mysqli_query($conection,$req6);
   while($data6=mysqli_fetch_array($result6)){
       $req7='select * from tools where id='.$data6['tool_id'];
       $result7=mysqli_query($conection,$req7);
       while($data7=mysqli_fetch_assoc($result7)){
        $test.="<div class='cart-profile col-lg  mt-2 mb-3  m-3 '>    
                    <div class='img-cart'>
                        <img class='img-profl ' src=".$data7['main_image_url']." >
                    </div>
                    <h4 class='title'>".$data7['title']."<span>prix: </span>".$data7['price_per_day']."DH</h4>
                </div>";
        }
   }
   echo $test;
?>