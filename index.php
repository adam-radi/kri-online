<?php
session_start();
$next = '';
$erreur = '';
$_SESSION['username'] = '';
$_SESSION['password'] = '';
include('conection.php');
if (isset($_POST['login']) && isset($_POST['username']) && $_POST['username'] != '' &&  isset($_POST['password']) && $_POST['password'] != '') {
  $sql = "select * from users";
  $result = mysqli_query($conection, $sql);
  while ($data = mysqli_fetch_array($result)) {
    if ($data['username'] == $_POST['username'] && $data['password'] == $_POST['password']) {
      $_SESSION['username'] = $_POST['username'];
      $_SESSION['password'] = $_POST['password'];
      $_SESSION['id'] = $data['id'];
      $next = true;
    } elseif ($data['username'] == $_POST['username'] && $data['password'] != $_POST['password']) {
      $erreur = "password is wrong";
    } elseif ($data['username'] != $_POST['username'] && $data['password'] == $_POST['password']) {
      $erreur = " username is wrong";
    }
  }
  if ($next == true) {
    header('location:home.php');
  }
}
$script = '';
$sign_error = '';

if (
  isset($_POST['sign_up']) &&
  isset($_POST['username']) && $_POST['username'] != '' &&
  isset($_POST['phone']) && $_POST['phone'] != '' &&
  isset($_POST['full_name']) && $_POST['full_name'] != '' &&
  isset($_POST['city']) && $_POST['city'] != '' &&
  isset($_POST['email']) && $_POST['email'] != '' &&
  isset($_POST['password']) && $_POST['password'] != '' &&
  isset($_POST['con_password']) && $_POST['con_password'] != ''
) {
  if ($_POST['password'] != $_POST['con_password']) {
    $sign_error = "Passwords do not match.";
    $script = "show_sign();"; // بقا ف فورم sign up
  } else {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $full_name = $_POST['full_name'];
    $city = $_POST['city'];

    $sql = "INSERT INTO users (`username`, `full_name`, `city`, `email`, `phone`, `password`) 
                VALUES ('$username', '$full_name', '$city', '$email', '$phone', '$password')";

    if (mysqli_query($conection, $sql)) {
      $script = "show_log();"; // عرض فورم login
    } else {
      $sign_error = "Failed to register. Try again.";
      $script = "show_sign();";
    }
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="my-bootstrap.css">
  <title>Document</title>
</head>

<style>
  body {
    margin: 0;
    padding: 0;
  }

  .main-section {
    background-image: url('images/slide-01.jpg');
    background-size: cover;
    background-position: center;
    min-height: 100vh;
    display: flex;
    align-items: center;
  }

  .marg {
    margin-left: 100px;
    margin: 50px;
    margin-top: 125px;
  }

  .center {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
  }

  h2 {
    font-size: 54px;
    color: rgb(255, 255, 255);
  }

  em {
    color: #fd7924;
  }

  form {
    position: fixed;
    top: 10%;
    right: 5%;
  }

  .line {
    color: rgb(255, 255, 255);
    background-color: rgb(255, 255, 255);
    height: 4px;
    width: 160px;
    border-radius: 30px;
  }

  p {
    color: rgb(255, 255, 255);
    font-size: 20px;
  }

  .buttons {
    display: inline-flex;
  }

  .buttonn {
    outline: none;
    border: none !important;
    box-shadow: none !important;
    color: rgb(253, 250, 248) !important;
    border: 2px solid #fd7924 !important;
    font-weight: 600;
    width: 140px;
    background-color: transparent !important;
  }

  .buttonn:hover {
    background: #fd7924 !important;
    color: #262626 !important;
    border: 2px solid #fd7924 !important;
  }

  .form-box {
    background: rgba(0, 0, 0, 0.4);
    padding: 30px;
    border-radius: 12px;
    width: 500px;
    margin: auto;
    color: white;
    border: 2px soled #fd7924;
    box-shadow: 0 0 1px #00000080;
    display: flex;
    flex-wrap: wrap;
  }

  .form-box1 {
    background: rgba(0, 0, 0, 0.4);
    padding: 18px;
    border-radius: 12px;
    width: 500px;
    margin: auto;
    margin-top: 100px;
    color: white;
    border: 2px soled #fd7924 !important;
    box-shadow: 0 0 1px #00000080;
    display: flex;
    flex-wrap: wrap;
  }

  .form-control,
  .form-select {
    background-color: transparent;
    color: white;
    border: 1px solid #fd7924;
  }

  .form-control::placeholder {
    color: #ddd;
  }

  .form-label {
    font-weight: bold;
    color: white;
  }

  .btn-orange {
    background-color: transparent;
    border: 2px solid #fd7924;
    color: white;
    width: 100%;
    padding: 10px;
    font-weight: bold;
    transition: 0.3s;
  }

  .btn-orange:hover {
    background-color: #e55e0e;
  }

  .mb-3 {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 10px;
    flex: 1 1 100%;
    max-width: 300px;
  }

  .mb-2 {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 10px;
    flex: 1 1 100%;
    max-width: 180px;
  }

  .div {
    display: flex;
  }

  form .mb-3 .full-width>* {
    flex: 1 1 100%;
    min-width: 90%;
  }

  option {
    background: transparent;
    color: #262626;
  }

  /* ✅ RESPONSIVE - تابلت وموبايل */
  @media (max-width: 991px) {
    .marg {
      margin: 40px 20px;
      text-align: center;
    }

    h2 {
      font-size: 36px;
    }

    p {
      font-size: 16px;
    }

    .line {
      margin: 0 auto;
    }

    .buttons {
      justify-content: center;
      flex-wrap: wrap;
    }

    .form-box,
    .form-box1 {
      width: 90%;
      margin-top: 30px;
      padding: 20px;
      position: static;
    }

    form {
      position: static;

    }
  }

  @media (max-width: 576px) {
    h2 {
      font-size: 24px;
    }

    p {
      font-size: 16px;
    }

    .buttonn {
      width: 100%;
      margin-bottom: 10px;
    }

    .mb-3,
    .mb-2 {
      max-width: 100%;
    }

    .form-box,
    .form-box1 {
      width: 90% !important;
    }
  }

  @media (min-width: 576px) and (max-width: 1500px) {
    .marg {
      margin: 30px 40px;
      /* هامش معتدل */
      text-align: left;
    }

    h2 {
      font-size: 40px;
      /* حجم متوسط */
    }

    .form-box,
    .form-box1 {
      width: 80% !important;
      padding: 25px;
      margin-top: 40px;
      max-width: 500px;
    }

    .buttonn {
      width: 160px;
    }

    p {
      font-size: 18px;
    }

    .line {
      width: 120px;
    }

    .center {
      justify-content: space-between;
    }

    .buttons {
      justify-content: center;
    }
  }
</style>

<body>
  <div class="container-fluid  ">

    <div class="row min-vh-100 " style="background-image:url(images/slide-01.jpg)">
      <div class=" container center  ">

        <div class="col-lg-6 col-11 marg ">
          <div class="">
            <div>
              <h2>start your <em>career reting </em>anything &amp; gtting <br> anything <em> for a fixed period </em></h2>
            </div>
            <div class="col-lg-2 line my-3 mt-5 "></div>
            <div class="">
              <p>this app will enabke you to rent anything you do not need with ease and negotiate with the other party to obtian the tools officially. you can also obtian any new or used tool on this site in the easiest way</p>
            </div>

            <div class="buttons ">

              <button class="buttonn btn mx-1" onclick="show_log()">log in</button>


              <button class="buttonn btn mx-2" onclick="show_sign()">sign up</button>

            </div>
          </div>
        </div>
        <div class="col-lg-5 col-12 p-4 ps-5  ">
          <form method="post" id="login-form" class="form-box1" style="display: none;">
            <h3 class="mb-4 text-center" style="margin-bottom: 12px;">log in your account</h3>
            <div class="div  mb-1 " style="margin-bottom: 12px;">
              <label for="username" class="form-label mb-2">username</label>
              <input type="text" id="username" class="form-control mb-3" placeholder="username" name="username">
            </div>
            <div class="div  mb-1" style="margin-bottom: 12px;">
              <label for="password" class="form-label mb-2">password</label>
              <input type="password" id="password" class="form-control mb-3" placeholder="password" name="password">
            </div>
            <div class="div  mb-1">
              <label class="form-label "><?= $erreur ?></label>
            </div>
            <input type="submit" name="login" class="btn btn-orange mt-3" value="log in">
          </form>




          <form method="post" class="form-box" id="signup-form" style="display: none;">
            <h3 class="mb-4 text-center">sign up your account</h3>

            <div class="div  mb-1">
              <label for="full" class="form-label  mb-2">full name</label>
              <input type="text" id="full" class="form-control mb-3" placeholder="full name" name="full_name">
            </div>

            <div class="div  mb-1">
              <label for="email" class="form-label mb-2">Email</label>
              <input type="email" id="email" class="form-control mb-3" placeholder="email" name="email">
            </div>
            <div class="div  mb-1">
              <label for="city " class="form-label mb-2">city</label>
              <input type="text" id="city" class="form-control mb-3" placeholder="city" name="city">
            </div>
            <div class="div  mb-1">
              <label for="username" class="form-label mb-2">username</label>
              <input type="text" id="username" class="form-control mb-3" placeholder="username" name="username">
            </div>
            <div class="div  mb-1">
              <label for="phoneber" class="form-label mb-2">phone number</label>
              <input type="tel" id="phoneber" class="form-control mb-3" placeholder="phone number" name="phone">
            </div>

            <div class="div  mb-1">
              <label for="password" class="form-label mb-2">password</label>
              <input type="password" id="password" class="form-control mb-3" placeholder="password" name="password">
            </div>
            <div class="div  mb-1">
              <label for="password" class="form-label mb-2">confirm password</label>
              <input type="password" id="password" class="form-control mb-3" placeholder="confirm password" name="con_password">
            </div>
            <input type="submit" name="sign_up" value="sign_up" class="btn btn-orange mt-3">

          </form>
        </div>

      </div>

    </div>
  </div>
  <script>
    <?php if ($sign_error != '') { ?>
      alert(<?= $sign_error ?>);
    <?php }  ?>

    <?= $script ?>;

    function show_log() {
      document.getElementById("login-form").style.display = "block";
      document.getElementById("signup-form").style.display = "none";

    }

    function show_sign() {
      document.getElementById("login-form").style.display = "none";
      document.getElementById("signup-form").style.display = "block";

    };
  </script>
</body>

</html>