<?php 
   include('conection.php');
   session_start();
   if (empty($_SESSION['username']) ||  empty($_SESSION['password'])){
      header('location:index.php');
   }
   $test='';
   $req8='select * from reviews where reviewed_user_id='.$_SESSION['id'];
   $result8=mysqli_query($conection,$req8);
   while($data8=mysqli_fetch_array($result8)){
       $req9='select * from users where id='.$data8['reviewer_id'];
       $result9=mysqli_query($conection,$req9);
       while($data9=mysqli_fetch_assoc($result9)){
        $test.="<div class='cart-review col-lg-12   m-6 '>    
                    <div class='img-review'>
                        <div class='ratining'><img class='prfl-review ' src=".$data9['profile_picture']." ><span class='user_review ms-2'>".$data9['username']."</span> </div>
                        
                        <div class='user_rating m-3'>" .str_repeat('⭐',$data8['rating'])    ." </div>
                    </div>
                    
                    
                    <div class='user_comment'>".$data8['comment']." </div>
                    <div class='creat_at'>".date("Y-m-d", strtotime($data8['created_at']))." </div>
                </div>";
        }
   }
   echo $test;
?>