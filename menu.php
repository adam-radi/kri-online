<?php


$sql1 = 'select * from users  where id=' . $_SESSION['id'];
$resultx = mysqli_query($conection, $sql1);
$datax = mysqli_fetch_assoc($resultx);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="my-bootstrap.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <title>Document</title>
</head>
<style>
    nav {
        background-color: rgb(247, 247, 247);
        height: 50px;
        width: 100% !important;
        box-shadow: 0px 1px 6px rgb(104, 106, 114);
        display: flex;
    }

    .nav-link {
        display: flex;
        padding: 0 !important;
        padding-left: 100px !important;
        margin-left: 80px !important;
        margin-right:50px ;
    }

    .nav-item {
        list-style: none;
        font-weight: 600;
        margin-top: 13px;


    }

    a,
    li label {
        text-decoration: none !important;
        color: black;

    }

    ul {
        margin-right: 0 !important;
        padding-right: 0 !important;
    }

    .a:hover,
    li label:hover {

        background-color: #fd7924;
        padding: 5px 10px 6px 10px;
        border-radius: 6px;
    }

    .active {
        background-color: #fd7924;
        padding: 5px 10px 6px 10px;
        border-radius: 6px;
    }

    .logo {
        position: absolute;
        top: 0px;
        left: 15px;
        font-weight: 700;
        font-size: 32px;

    }

    .inputx {
        border: solid 3px #fd7924;
        border-radius: 6px;
        margin-top: 8px !important;
        padding: 0;
        width: 350px;
        background-color: transparent;
        padding-left: 20px;
        height: 34px;
        width: 77%;
    }



    .button {
        width: 120px;
        display: flex;
        background: none !important;
        border: 3px solid #fd7924;
        border-radius: 10px;
        height: 40px;
        align-items: center;
        
        padding-right: 10px;
        margin-top: 5px;



    }

    .button:hover {
        background-color: #fd7924 !important;
    }

    .add {
        font-size: 35px;
        margin-bottom: 5px;

    }

    .username {
        padding-top: 7px;
        font-weight: 800;
    }

    .pctr-menu:hover {
        background-color: rgb(255, 255, 255);
    }

    .dropdown-menu a.dropdown-item:hover {
        background-color: #f1f1f1;
    }

    .dropdown-menu .dropdown-divider {
        margin: 0.5rem 0;
    }

    .profile-image {

        border-radius: 50%;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        height: 43px !important;
        width: 43px !important;
    }

    .pro-bor {
        height: 48px !important;
        width: 48px !important;
        border: 2px solid #fd7924;
        border-radius: 50%;
        position: absolute;
        top: 1px;
        right: 1px;
        padding-top: 1px;
        padding-left: 1px;

    }

    .dropdown-toggle::after {
        display: none !important;
    }

    .recherche {
        position: static !important;
        /* تلغي position:absolute تحت 1500 */
        margin: 0 15px;
        flex-grow: 1;
        
    }

    .new-tool-btn {
        margin-left: 15px;
        display: flex;
        justify-self:start;
    }

    @media ( max-width: 1400px ){
        .new-tool-btn {
            display: inline-flex !important;
        }

        /* اخفي العناصر داخل القائمة (nav-item) */
        .nav-item {
            display: none;
        }
        .nav-link{
            width: 100px !important;
            padding-left: 0px !important;
            margin-left: 0px !important;
        }
        /* الاسم يبقى مخفي */
      

        /* ابقى البحث ظاهر بطريقة بسيطة */
        .recherche {
            position: static !important;
            margin: 0 10px;
            flex-grow: 1;
            max-width: none;

            
        }
       
    }
    

</style>


<body>
    <nav class="  ps-4 ">
         <div class="logo ">kri-online</div>
        <ul class="nav-link  col-lg  col-md-2">
           
            <li class="nav-item  col "><a href="home.php" class="a">home</a></li>
            <li class="nav-item col me-3 "><a href="new_tool.php" class="a">new tool</a></li>
            <li class="nav-item col mx-3 "><a href="nigotiation.php" class="a">nigotiation</a></li>
            <li class="nav-item col mx-3 "><a href="profile.php" class="a">profile</a></li>


        </ul>

        <div class=" recherche col-lg col-md-5 my-0 py-0"><label for="search" class=" a" style="width: 15% ;" onclick="chercher()">search</label><input type="search" id="search" placeholder="search" class="inputx ms-3 "></div>

        <a class="button a col-lg-1 new-tool-btn " href="new_tool.php">
            <span class="add">+</span>
            <span class="tool">new tool</span>
        </a>
        <div class="  ms-3 ps-5  mt-1  col-lg-2 col-md-2"><a class="a" href="profile.php">

                <div class="username  fs-5 "><?= $datax['username'] ?></div>
            </a>
        </div>

        <div class="dropdown pro-bor  text-center me-2">
            <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= $datax['profile_picture'] ?? 'def.png' ?>" alt="Pr" width="40" height="40" class="profile-image">
            </a>
            <ul class="dropdown-menu text-small shadow border-0 dropdown-menu-end mt-2" aria-labelledby="profileDropdown" style="border-radius: 12px; min-width: 220px;">
                <li class="px-3 py-2">
                    <strong class="d-block"><?= $datax['username'] ?></strong>
                    <small class="text-muted"><?= $datax['email'] ?? 'no-email@example.com' ?></small>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="profile.php">👤 Profile</a></li>
                <li><a class="dropdown-item text-danger" href="log_out.php">🚪 Log out</a></li>
            </ul>
        </div>



    </nav>
</body>

</html>