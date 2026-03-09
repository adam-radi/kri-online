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
  <title>Document</title>
</head>
<style>
  body {

    background-color: #f0f2f5 !important;
    overflow-x: hidden !important;

  }

  .body {
    display: flex;
  }

  .img {
    display: flex !important;
    justify-content: center !important;
    height: 200px;
  }

  .img img {
    min-width: 19%;
    max-width: 350px;
    min-height: 180px !important;
    max-height: 200px;

    border-radius: 10px;
  }

  .container-fluid {
    padding: 0 !important;
    height: 94vh;
    scrollbar-width: none;
    overflow: scroll;


  }

  .row {

    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    justify-content: center;

  }

  .title {
    font-size: 30px;

  }

  .cart {
    box-sizing: border-box;
    min-width: 22%;
    max-width: 378px !important;
    margin: 40px !important;
    height: 410px !important;
    border-radius: 10px;
    padding: 10px;
    box-shadow: 1px 1px 5px 0px rgb(39, 40, 62);

  }

  .cart p,
  h3,
  .prix {
    font-size: 20px;
    font-weight: 600;
    display: inline;
    justify-content: space-around;
    max-width: 336px;
    margin: 0 18px 0 8px !important;
    text-align: center;

  }

  .buttondetail {
    outline: none;
    border: none !important;
    box-shadow: none !important;
    min-width: 98% !important;
    max-width: 342px !important;
    background-color: transparent !important;
    border: 3px solid #fd7924 !important;
    color: rgb(0, 0, 0) !important;
    padding-right: 10px;
    margin-top: 5px;
    border-radius: 10px;
    height: 40px !important;
    margin-left: 5px;

  }

  .buttondetail:hover {

    background: #fd7924 !important;
    color: rgb(255, 255, 255) !important;


  }

  .profil img {
    border: solid 2px #fd7924;
    margin-bottom: 5px;
    height: 63px;
    max-width: 63px;
    padding: 2px;
    border-radius: 40px;

  }

  .catigores {
    overflow: auto;
    scrollbar-width: none;
    width: 18% !important;
    /* height:100vh; */
    box-shadow: 2px 4px 5px 1px rgb(76, 72, 69);
    padding-right: 30px;
    height: 94vh;
    padding-left: 10px;


  }

  .sidebar {
    width: 260px;
    border-radius: 10px;
    padding: 20px 5px;

  }

  .sidebar h2 {
    margin-bottom: 15px;
  }

  .sidebar .ul_home {

    list-style: none;
    padding-inline-start: 1px !important;
    width: 240px;


  }

  .sidebar .ul_home li {
    padding-right: 50px !important;
    margin: 10px 0;
    cursor: pointer;
    padding: 8px 30px;
    border-radius: 6px;
    transition: background-color 0.3s;
  }

  .sidebar .ul_home li:hover {
    background-color: rgb(226, 226, 252);
    box-shadow: 0px 2px 6px 1px;

  }

  .selectioner {
    background-color: rgb(226, 226, 252);
    box-shadow: 0px 2px 6px 1px;

  }
  
</style>
<script>
  function select(ctg) {
    const items = document.querySelectorAll('.ul_home li');
    items.forEach(li => li.classList.remove('selectioner'));

    items.forEach(li => {
      if (li.textContent === ctg) {
        li.classList.add('selectioner');
      }
    });
  }
  window.onload = function() {
    document.getElementById('allctg').style.display = "flex"
    document.getElementById('selectctg').style.display = "none"


  };

  function filtre(ctg) {
    document.getElementById('allctg').style.display = "none";
    $.ajax({
      url: 'catigorie.php',
      method: 'POST',
      data: {
        ctg: ctg
      },
      success: function(data, status, xhr) {
        $('#selectctg').html(data);
        document.getElementById('selectctg').style.display = "flex";

      }
    })


  }
    function chercher(ctg) {
    document.getElementById('allctg').style.display = "none";
     recherch=document.getElementById('search').value;
     if(recherch!= ''){
         
     
    $.ajax({
      url: 'catigorie.php',
      method: 'POST',
      data: {
        recherch: recherch
      },
      success: function(data, status, xhr) {
        $('#selectctg').html(data);
        document.getElementById('selectctg').style.display = "flex";

      }
    })
    }


  }
</script>

<body>
  <?php include('menu.php') ?>
  <div class="body">
    <div class=" col-lg-2  catigores ">
      <div class="sidebar">
        <h2>Catigores</h2>
        <ul class="ul_home">
          <li onclick="filtre('all'); select('all')">all</li>
          <li onclick="filtre('Electronique'); select('Electronique')">Electronique</li>
          <li onclick="filtre('Vêtements'); select('Vêtements')">Vêtements</li>
          <li onclick="filtre('Meubles'); select('Meubles')">Meubles</li>
          <li onclick="filtre('Jeux'); select('Jeux')">Jeux</li>
          <li onclick="filtre('Livres et Magazines'); select('Livres et Magazines')">Livres et Magazines</li>
          <li onclick="filtre('Équipements sportifs'); select('Équipements sportifs')">Équipements sportifs</li>
          <li onclick="filtre('Électroménager'); select('Électroménager')">Électroménager</li>
          <li onclick="filtre('Santé & Bien-être'); select('Santé & Bien-être')">Santé & Bien-être</li>
          <li onclick="filtre('Auto & Pièces'); select('Auto & Pièces')">Auto & Pièces</li>
          <li onclick="filtre('Bijoux'); select('Bijoux')">Bijoux</li>
          <li onclick="filtre('Informatique'); select('Informatique')">Informatique</li>
          <li onclick="filtre('Art & Décoration'); select('Art & Décoration')">Art & Décoration</li>
          <li onclick="filtre('autre'); select('autre')">autre</li>
        </ul>
      </div>
    </div>
    <div class=" col-lg-10  container-fluid ">

      <div class="row container  col-lg" id="allctg">
        <?php
        $sql = 'select * from tools';
        $result = mysqli_query($conection, $sql);

        while ($data = mysqli_fetch_array($result)) {
          $req = 'select users.full_name,users.profile_picture from users where id=' . $data['owner_id'];
          $result2 = mysqli_query($conection, $req);
          $data2 = mysqli_fetch_array($result2);
          $_SESSION['name' . $data['id']] = $data2['full_name'];

        ?>
          <div class="cart col-lg mt-5  m-4 ">
            <div class="pro"><span class="profil"><img class="profil" src="<?= $data2['profile_picture'] ?>"> </span><span class="prix"><?= $data2['full_name'] ?></span><div class="drop"></div> </div>

            <div class="img">
              <img src="<?= $data['main_image_url'] ?>">
            </div>
            <h3 class="title   "><?= $data['title'] ?></h3><br>

            <p class="prix "><span>prix: </span> <?= $data['price_per_day'] . 'DH' ?></p>
            <a href="detail.php?id=<?= $data['id'] ?>"><button class="buttondetail">view details</button></a>
          </div>

        <?php } ?>

      </div>
      <div id="selectctg" class="me-4"></div>

    </div>
  </div>
</body>
<script src="outjs.js"></script>

</html>