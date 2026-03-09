<?php
include('conection.php');
session_start();
if (empty($_SESSION['username']) ||  empty($_SESSION['password'])) {
  header('location:index.php');
}
$req3 = 'select * from tools where id=' . $_GET['id'];
$result3 = mysqli_query($conection, $req3);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Tool Details</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="my-bootstrap.css">

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f6f5f7;
      margin: 0;
      padding: 0;
      color: #333;
    }

    .container {
      max-width: 900px !important;
      margin: 50px auto;
      background-color: #fff;
      border: 2px solid #ff6600;
      border-radius: 16px;
      padding: 30px;
      box-shadow: 0 0 10px rgba(255, 102, 0, 0.1);
      overflow: hidden;


    }

    .main-image {
      display: flex;
      justify-content: center;

      width: 98%;
      height: 400px;
      object-fit: cover;
      border-radius: 20px;
      margin-bottom: 25px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
      transition: transform 0.4s ease;
      margin-left: 1%;

    }

    .imagebody {
      max-width: 100%;
      max-height: 400px;

    }

    .main-image:hover {
      transform: scale(1.02);
    }

    .tool-title {
      font-size: 30px;
      font-weight: bold;
      color: #ff6600;
      margin-bottom: 8px;
      text-align: center;
    }

    .tool-meta {
      text-align: center;
      color: #777;
      margin-bottom: 20px;

    }

    .tool-description {
      line-height: 1.6;
      margin-bottom: 25px;
      text-align: center;
    }

    .info-box {
      border: 1px dashed #ff6600;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 25px;
    }

    .info-title {
      font-weight: bold;
      color: #444;
    }

    .images-preview {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
      justify-content: center;
    }

    .images-preview img {
      width: 130px;
      height: 90px;
      object-fit: cover;
      border-radius: 10px;
      border: 1px solid #ff6600;
    }

    .btndetail {
      display: block;
      width: 97%;
      margin: 20px auto 0;
      border :solid 2px #ff6600;
      color: #ff6600;
      padding: 12px 25px;
      border-radius: 15px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s ease;
      text-align: center;
       box-shadow: 0 0 10px rgba(255, 102, 0, 0.1);

    }
    .btn-booking{
      display: block;
      width: 97%;
      margin: 20px auto 0;
      border :solid 2px rgb(125, 121, 169);
      color:rgb(143, 139, 173);
      padding: 12px 25px;
      border-radius: 15px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s ease;
      text-align: center;
       box-shadow: 0 0 10px rgba(255, 102, 0, 0.1);

    }
    .btndetail:hover {
      background-color: #ff6600;
      color : #333;
    }
    .btn-booking:hover{
      background-color:  rgb(125, 121, 169);
      color : #fff;
    }
  </style>
</head>

<body>
  <?php include('menu.php') ?>
  <div class="container">
    <?php while ($data3 = mysqli_fetch_array($result3)) {  ?>

      <div class="main-image">
        <img src="<?= $data3['main_image_url'] ?>" class="imagebody" alt="Tool Image">
      </div>


      <h1 class="tool-title"><?= $data3['title'] ?></h1>
      <p class="tool-meta"><span class="m-2">المالك:<?= $_SESSION['name' . $_GET['id']] ?> </span>|<span class="m-3">الثمن: <?= $data3['price_per_day'] ?> </span>/<span class="m-3"><?= $data3['created_at'] ?></span> </p>

      <div class="tool-description">
        <p><?= $data3['description'] ?></p>
      </div>

      <div class="info-box">
        <p><span class="info-title">الحالة:</span> <?= $data3['tool_condition'] ?></p>
        <p><span class="info-title">المكان:</span> <?= $data3['location'] ?></p>
        <p><span class="info-title">الصنف:</span> <?= $data3['category'] ?></p>
      </div>

      <div class="images-preview">
        <?php $req4 = 'select * from tool_images where tool_id=' . $_GET['id'];
        $result4 = mysqli_query($conection, $req4);
        while ($data4 = mysqli_fetch_array($result4)) { ?>
          <img src="<?= $data['image_url'] ?>" alt="">
        <?php  } ?>
      </div>

      <a href="nigotiation.php?tool_id=<?=$_GET['id']?>" class="btndetail">nigotiation</a>
      <a href="booking.php?tool_id=<?=$_GET['id']?>" class="btn-booking">booking</a>
    <?php  }  ?>
  </div>

</body>
      <script src="outjs.js"></script>

</html>