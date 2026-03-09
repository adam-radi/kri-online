<?php
include('conection.php');
session_start();
if (empty($_SESSION['username']) ||  empty($_SESSION['password'])) {
  header('location:index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="JQuery.js"></script>
  <link rel="stylesheet" href="my-bootstrap.css">
  <title>Profile Page</title>

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f2f5 !important;
      color: #333;
    }

    .container-fluid {
      display: flex;
      max-width: 1400px;
      margin: 30px auto;
      gap: 20px;
    }

    .sidebar {
      width: 280px;
      height: 122vh;
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .sidebar h3 {
      margin-bottom: 15px;
    }

    .sidebar ul {
      list-style: none;
    }



    .main {
      flex: 1;
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      padding-top: 3px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      height: 122vh;
      overflow: auto;
      scrollbar-width: none;

    }

    .profile-header {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-bottom: 20px;
      max-width: 230px;
      padding-top: 15px;
    }

    .profile-pic {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      background-color: #ddd;
      background-size: cover;
      background-position: center;
    }

    .profile-info {
      flex-grow: 1;
    }

    .profile-info h2 {
      font-size: 24px;
      margin-bottom: 5px;
    }

    .profile-info p {
      color: #777;
    }

    .stats-bar {
      display: flex;
      justify-content: space-between;
      margin: 12px 20px 12px 30px;
      padding: 20px 60px;
      background-color: #f9f9f9;
      border-radius: 8px;
      width: 750px;
      max-height: 90px !important;
    }

    .head-profile {
      display: flex;
    }

    .stat-item {
      text-align: center;
    }

    .stat-item span {
      display: block;
      font-weight: bold;
      color: #3b5998;
    }

    .nav-tabs {
      display: flex;
      gap: 15px;
      margin-bottom: 20px;
      border-bottom: 1px solid #ddd;
      width: 100%;
    }

    .nav-tabs button {
      width: 32%;
      background: none;
      border: none;
      padding: 10px;
      cursor: pointer;
      font-weight: bolder;
      color: #555;
      font-size: 120%;
    }

    .nav-tabs button.activee {
      color: #3b5998;
      border-bottom: 3px solid #3b5998;
    }

    .content-section {
      min-height: 200px;


    }

    .content {
      display: flex;
      flex-wrap: wrap;



    }

    .cart-profile {
      height: 310px;
      max-width: 325px !important;

      justify-content: center;

    }

    .img-cart {

      height: 290px;
      border: 1px solid #000;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .img-profl {
      max-width: 315px !important;
      padding: 6px;
      max-height: 290px;

    }

    .cart-review {
      background-color: #f9f9f9;
      border-radius: 15px;
      box-shadow: 1px 1px 6px 1px rgba(173, 174, 183, 0.39);
      padding: 10px;
    }

    .prfl-review {
      border: solid 2px #fd7924;
      margin-bottom: 5px;
      height: 63px;
      max-width: 63px;
      padding: 2px;
      border-radius: 40px;

    }

    .prfl-bkng {

      margin-bottom: 5px;
      height: 63px;
      max-width: 63px;
      padding: 2px;

    }

    .img-review {
      display: flex;
      justify-content: space-between;
    }

    .user_review {
      font-size: large;
      font-weight: bold;
    }

    .creat_at {
      text-align: end;

      padding: 10px 5px;
    }

    .side-link {
      margin: 10px 0;
      padding: 4px 10px;
      cursor: pointer;
      border: none;
      background-color: transparent;
      border-radius: 6px;
      transition: background-color 0.3s;
    }

    .side-link.activet {
      margin: 10px 0;
      padding: 5px 15px;
      cursor: pointer;
      text-align: start;
      width: 80%;

      border-radius: 6px;

      background-color: #f0f0f0;

    }

    .tab-bar.activee {
      background-color: #007bff;
      color: white;
      border-radius: 5px;
    }

    .main {
      display: none;
    }

    .main.show {
      display: block;
    }

    .cart-bkng {
      background-color: #f9f9f9;
      border-radius: 15px;
      box-shadow: 1px 1px 6px 1px rgba(173, 174, 183, 0.39);
      padding: 10px;
      margin-top: 10px !important;
      margin-bottom: 20px !important;
    }

    .user_bkng {
      text-align: start;
      font-size: 20px;
      font-weight: 500;
      margin-bottom: 4px;

    }

    .status_all {

      display: flex;
      justify-content: space-between;
    }

    .status {
      text-align: start;
      border: solid 2px #fd7924;
      background: transparent;
      width: 220px;
      border-radius: 6px;
      padding: 10px 5px;

    }

    .payment_status {
      text-align: center;
      border: solid 2px #fd7924;
      background: transparent;
      width: 220px;
      border-radius: 6px;
      padding: 10px 5px;
    }
  </style>
</head>

<body>

  <?php include('menu.php') ?>
  <div class="container-fluid">
    <div class="sidebar">
      <h3>Options</h3>
      <ul>
        <li><button class="side-link activet" data-target="main">Overview</button></li>
        <li><button class="side-link" data-target="stats">Stats</button></li>
        <li><button class="side-link" data-target="bookings">bookings</button></li>
        <li><button class="side-link" data-target="settings">Settings</button></li>
      </ul>
    </div>

    <div class="main show" id="main">
      <div class="head-profile">
        <div class="profile-header">
          <div class="profile-pic"></div>
          <div class="profile-info">
            <h2>Adam Radi</h2>
            <p>@adamradi</p>
          </div>
        </div>

        <div class="stats-bar">

          <div class="stat-item">
            Tools <span>7</span>
          </div>
          <div class="stat-item">
            Views <span>1.2K</span>
          </div>
          <div class="stat-item">
            Likes <span>321</span>
          </div>
        </div>
      </div>

      <div class="nav-tabs">
        <button class="tab-btn" data-target="posts.php">Posts</button>
        <button class="tab-btn" data-target="favorites.php">Favorites</button>
        <button class="tab-btn" data-target="reviews.php">reviews</button>
      </div>

      <div class="content-section">
        <div class="content " id="content">

        </div>
      </div>
    </div>
    <div class="main stats " id="stats">

    </div>
    <div class="main bookings " id="bookings">
      <?php
      $test = '';

      $sql1 = 'select * from tools  where owner_id=' . $_SESSION['id'];
      $result = mysqli_query($conection, $sql1);
      while ($data = mysqli_fetch_array($result)) {
        
        $sql2 = "SELECT * FROM bookings WHERE tool_id=" . $data['id'] . " ORDER BY id DESC" ;
        $result2 = mysqli_query($conection, $sql2);
        while ($data2 = mysqli_fetch_array($result2)) {
          if (!empty($data2)) {
            $req9 = 'select * from users where id=' . $data2['renter_id'];
            $result9 = mysqli_query($conection, $req9);
            $data9 = mysqli_fetch_assoc($result9);

            $test .= "<div class=' col-lg-12 cart-bkng   m-6 '>    
                    <div class='img-review'>
                        <div class='ratining'><img class='prfl-bkng ' src=" . $data['main_image_url'] . " ><span class='user_review ms-2'>" . $data['title'] . "</span> </div>
                        
                        <div class='user_rating m-3'>Total Price :" . $data2['total_price'] . "DH </div>
                    </div>
                    <div class='user_bkng '> booking by <span class='espace mx-1'></span> "  .  $data9['username']  .  "  <span class='espace mx-1'></span>  from" . $data2['start_date'] . " to " . $data2['end_date'] . "</div>
                    <div class='status_all' >
                    <select id='status_" . $data2['id'] . "' class='status' onchange='updetbk(" . $data2['id'] . ")' >
                       <option value='pending' " . ($data2['status'] == 'pending' ? 'selected' : '') . " >pending</option>
                       <option value='confirmed' " . ($data2['status'] == 'confirmed' ? 'selected' : '') . ">confirmed</option>
                       <option value='cancelled' " . ($data2['status'] == 'cancelled' ? 'selected' : '') . ">cancelled</option>
                    </select>
                    <select id='payment_status_" . $data2['id'] . "' class='payment_status' a<q7892onchange='updetbk(" . $data2['id'] . ")'>
                    <option value='unpaid' " . ($data2['payment_status'] == 'unpaid' ? 'selected' : '') . " >unpaid</option>
                    <option value='paid'  " . ($data2['payment_status'] == 'paid' ? 'selected' : '') . ">paid</option>
                    <option value='partially_paid'  " . ($data2['payment_status'] == 'partially_paid' ? 'selected' : '') . ">partially_paid</option>
                    </select>
                             <a href='nigotiation.php?tool_id=" . $data['id'] . " ' class='payment_status' >nigotiation</a>
                    <div class='creat_at'>" . $data2['created_at'] . " </div> 
                    </div>
                </div>";
          }
        }
      }
      echo $test;
      ?>
    </div>
    <div class="main settings " id="settings">

    </div>
  </div>

</body>
<script src="outjs.js"></script>

<script>
  $(document).ready(function() {
    $('.side-link').click(function() {
      const targetid = $(this).data('target');

      $('.side-link').removeClass('activet');
      $(this).addClass('activet');

      $('.main').removeClass('show');
      $('#' + targetid).addClass('show');

      if (targetid === 'main') {
        $('.tab-btn[data-target="posts.php"]').click();
      }
    });

    $('.tab-btn').click(function() {
      if (!$('#main').hasClass('show')) return;

      $('.tab-btn').removeClass('activee');
      $(this).addClass('activee');

      const target = $(this).data('target');

      $('#content').html('<p>جار التحميل...</p>');

      $.ajax({
        url: target,
        method: 'GET',
        success: function(data) {
          $('#content').html(data);
        },
        error: function() {
          $('#content').html('<p>حدث خطأ أثناء جلب البيانات.</p>');
        }
      });
    });

    // ✅ تعيين الحالة الأولية عند تحميل الصفحة
    $('.side-link[data-target="main"]').addClass('activet');
    $('.tab-btn[data-target="posts.php"]').addClass('activee').click();


  });

  function updetbk(id) {
    status = document.getElementById('status_' + id).value;
    payment_status = document.getElementById('payment_status_' + id).value;
    $.ajax({
      url: 'updatebk.php',
      method: 'POST',
      data: {
        id: id,
        status: status,
        payment_status: payment_status
      },
      success: function(data) {
        alert('you add a status')
      },
      error: function() {
        alert('you an erreur in the select status')
      }
    })
  }
</script>

</html>