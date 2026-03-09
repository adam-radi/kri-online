<?php
include('conection.php');
session_start();
if (empty($_SESSION['username']) ||  empty($_SESSION['password'])) {
  header('location:index.php');
};
$content = '';
if (!empty($_POST['ctg'])) {
  $content .= '<div class="row container selectctg col-lg">';
  $ctg = $_POST['ctg'];
  if ($ctg == 'all') {
    $sql = 'select * from tools';
  } else {
    $sql = "SELECT * FROM tools WHERE category = '$ctg'";
  };
  $result = mysqli_query($conection, $sql);

  while ($data = mysqli_fetch_array($result)) {
    $req = 'select users.full_name,users.profile_picture from users where id=' . $data['owner_id'];
    $result2 = mysqli_query($conection, $req);
    $data2 = mysqli_fetch_array($result2);
    $_SESSION['name' . $data['id']] = $data2['full_name'];
    $content .= '  <div class="cart col-lg mt-5  m-4 ">
            <div><span class="profil"><img class="profil" src="' . $data2['profile_picture'] . '"> </span><span class="prix">' . $data2['full_name'] . '</span> </div>

            <div class="img">
              <img src="' . $data['main_image_url'] . '">
            </div>
            <h3 class="title   ">' . $data['title'] . '</h3><br>

            <p class="prix "><span>prix: </span>' . $data['price_per_day'] . 'DH' . '</p>
            <a href="detail.php?id=' . $data['id'] . '"><button class="buttondetail">view details</button></a>
          </div> ';
  }

$content .= '</div>';


  if (mysqli_num_rows($result) == 0) {
    echo 'no element by this category';
    exit;
  }
 else {
  echo $content;
}

}


// if (!empty($_POST['recherch']) && $_POST['recherch']!=' ') {
//   $content .= '<div class="row container selectctg col-lg">';
//   $recherch = $_POST['recherch'];
//     $sql = "SELECT * FROM tools ";
//   $result = mysqli_query($conection, $sql);
//    $plus=0;
//     while ($data = mysqli_fetch_array($result)) {
//     $list1=str_split($recherch);
//     $list2=str_split($data['title']);
//     for($elemnt=0 ; $elemnt<= count($list2) ; $elemnt++){
//        for($elemnt2=$elemnt ; $elemnt2<= count($list1) ; $elemnt2++){
//         if ($list1[$elemnt2]==$list2[$elemnt]){
//           $plus++;
         
//         }
//        }
//     }
//     if ($plus>2){

    
//     $req = 'select users.full_name,users.profile_picture from users where id=' . $data['owner_id'];
//     $result2 = mysqli_query($conection, $req);
//     $data2 = mysqli_fetch_array($result2);
//     $_SESSION['name' . $data['id']] = $data2['full_name'];
//     $content .= '  <div class="cart col-lg mt-5  m-4 ">
//             <div><span class="profil"><img class="profil" src="' . $data2['profile_picture'] . '"> </span><span class="prix">' . $data2['full_name'] . '</span> </div>

//             <div class="img">
//               <img src="' . $data['main_image_url'] . '">
//             </div>
//             <h3 class="title   ">' . $data['title'] . '</h3><br>

//             <p class="prix "><span>prix: </span>' . $data['price_per_day'] . 'DH' . '</p>
//             <a href="detail.php?id=' . $data['id'] . '"><button class="buttondetail">view details</button></a>
//           </div> ';
//             }
//   }
// }
// $content .= '</div>';


//   if (mysqli_num_rows($result) == 0) {
//     echo 'no element by this name';
//     exit;
//   }
//  else {
//   echo $content;
// }














// if (!empty($_POST['recherch']) && trim($_POST['recherch']) != '') {
//     $content = '<div class="row container selectctg col-lg">';
//     $recherch = strtolower(trim($_POST['recherch']));
//     $sql = "SELECT * FROM tools";
//     $result = mysqli_query($conection, $sql);
//     $found = false;

//     while ($data = mysqli_fetch_array($result)) {
//         $title = strtolower($data['title']);
//         $list1 = str_split($recherch);
//         $list2 = str_split($title);
//         $plus = 0;

//         for ($i = 0; $i < count($list2); $i++) {
//             for ($j = 0; $j < count($list1); $j++) {
//                 if ($list1[$j] == $list2[$i]) {
//                     $plus++;
//                     break; // تحسين: الخروج بعد أول تطابق
//                 }
//             }
//         }

//         if ($plus >= count($list1)) {
//             $found = true;
//             $req = 'SELECT users.full_name, users.profile_picture FROM users WHERE id=' . $data['owner_id'];
//             $result2 = mysqli_query($conection, $req);
//             $data2 = mysqli_fetch_array($result2);
//             $_SESSION['name' . $data['id']] = $data2['full_name'];

//             $content .= '
//                 <div class="cart col-lg mt-5  m-4 ">
//                     <div>
//                         <span class="profil"><img class="profil" src="' . $data2['profile_picture'] . '"></span>
//                         <span class="prix">' . $data2['full_name'] . '</span>
//                     </div>
//                     <div class="img">
//                         <img src="' . $data['main_image_url'] . '">
//                     </div>
//                     <h3 class="title">' . $data['title'] . '</h3><br>
//                     <p class="prix"><span>prix: </span>' . $data['price_per_day'] . 'DH</p>
//                     <a href="detail.php?id=' . $data['id'] . '"><button class="buttondetail">view details</button></a>
//                 </div>';
//         }
//     }

//     $content .= '</div>';

//     if ($found) {
//         echo $content;
//     } else {
//         echo 'no element by this name';
//     }
// }













if (!empty($_POST['recherch']) && trim($_POST['recherch']) != '') {
    $content = '<div class="row container selectctg col-lg">';
    $recherch = strtolower(trim($_POST['recherch']));
    $sql = "SELECT * FROM tools";
    $result = mysqli_query($conection, $sql);
    $found = false;

    while ($data = mysqli_fetch_array($result)) {
        $title = strtolower($data['title']);
        $similarity = 0;
        similar_text($recherch, $title, $similarity);

        // نعرض فقط الأدوات اللي عندها تشابه أكثر من 40%
        if ($similarity >= 30) {
            $found = true;

            $req = 'SELECT users.full_name, users.profile_picture FROM users WHERE id=' . $data['owner_id'];
            $result2 = mysqli_query($conection, $req);
            $data2 = mysqli_fetch_array($result2);
            $_SESSION['name' . $data['id']] = $data2['full_name'];

            $content .= '
                <div class="cart col-lg mt-5  m-4 ">
                    <div>
                        <span class="profil"><img class="profil" src="' . $data2['profile_picture'] . '"></span>
                        <span class="prix">' . $data2['full_name'] . '</span>
                    </div>
                    <div class="img">
                        <img src="' . $data['main_image_url'] . '">
                    </div>
                    <h3 class="title">' . $data['title'] . '</h3><br>
                    <p class="prix"><span>prix: </span>' . $data['price_per_day'] . 'DH</p>
                    <a href="detail.php?id=' . $data['id'] . '"><button class="buttondetail">view details</button></a>
                </div>';
        }
    }

    $content .= '</div>';

    if ($found) {
        echo $content;
    } else {
        echo 'no element by this name';
    }
}
?>