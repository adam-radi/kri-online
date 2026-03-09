
<?php 
   include('conection.php');
   session_start();
   if (empty($_SESSION['username']) && empty($_SESSION['password'])){
      header('location:index.php');
   }
    
   
   if (isset($_POST['add_tool']) && !empty($_POST['title'])&& !empty($_POST['description'])&& !empty($_POST['condition'])&& !empty($_POST['price'])&& !empty($_POST['location']) && !empty($_FILES['images']) ){
      $title=$_POST['title'];
      $description=$_POST['description'];
      $condition=$_POST['condition'];
      $price=$_POST['price'];
      $location=$_POST['location'];

      $main_image = $_FILES['images']['name'][0];
      $main_tmp = $_FILES['images']['tmp_name'][0];
      $main_path = "uploads/" . $main_image;
       move_uploaded_file($main_tmp, $main_path);


    
      $sql="INSERT INTO `tools`( `owner_id`, `title`, `description`, `tool_condition`, `price_per_day`,`location`, `main_image_url`) VALUES ('".$_SESSION['id']."','". $title."','".$description."','". $condition."','".$price."','".$location."','".$main_path."')";
      $result=mysqli_query($conection,$sql);
           if ($result) {
        $tool_id = mysqli_insert_id($conection); 
        
       
        $count = count($_FILES['images']['name']);
       foreach ($_FILES['images']['name'] as $index => $img_name) {
          $img_tmp = $_FILES['images']['tmp_name'][$index];
          $path = "uploads/" . $img_name;

          move_uploaded_file($img_tmp, $path);

          $sql_img = "INSERT INTO tool_images (tool_id, image_url) VALUES ('$tool_id', '$path')";
          mysqli_query($conection, $sql_img);
         }

             header('Location:new_tool.php?success=1');
             exit();
        } else {
              header('Location:new_tool.php?error=1');
             exit();
        }
      
     
     }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Tool</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style>
   
     body{
        background-color: #f0f2f5 !important;
     }

    .container {
        font-family: sans-serif;
        padding: 20px;
     
    }
    .form {
       max-width: 600px;
      margin: auto;
      background: #fff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 4px  12px rgba(0,0,0,0.3);
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 24px;
      color: #333;
      font-family: 'segoe UI',sans-serif;
    }


    label {
      font-weight: bold;
      margin-top: 15px;
      display: block;
    }


    input, select, textarea ,.image {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 6px;
      border: 3px solid  #fd7924;
      font-size: 14px;
      background-color: transparent;
    }




    .buttons {
      background-color:transparent;
      color: #fd7924;
      border:solid 3px #fd7924;
      padding: 12px;
      font-size: 16px;
      border-radius: 6px !important;
      
      margin-top: 20px !important;
      width: 100%;
      cursor: pointer;
    }


    .buttons:hover {
      background-color: #fd7924;
      color: #fff;
    }


    @media(max-width: 600px) {
      .container {
        padding: 15px;
      }
    }
  </style>
</head>
<body>
<?php  include('menu.php')  ?>
<div class="container">
    <div class="form">
    <h2>Add New Tool</h2>
    <form method="POST" enctype="multipart/form-data" >
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required>


        <label for="description">Description</label>
        <textarea name="description" id="description" rows="3"></textarea>


        <label for="category">Category</label>
        <select name="category" id="category" required>
        <option value="autre">autre</option>
        <option value="Vêtements">Vêtements</option> 
        <option value="Meubles">Meubles</option> 
        <option value="Jeux">Jeux</option> 
        <option value="Livres et Magazines">Livres et Magazines</option> 
        <option value="Équipements sportifs">Équipements sportifs</option> 
        <option value="Santé & Bien-être">Santé & Bien-être</option> 
        <option value="Auto & Pièces">Auto & Pièces</option> 
        <option value="Bijoux">Bijoux</option> 
        <option value="Informatique">Informatique</option> 
        <option value="Art & Décoration">Art & Décoration</option> 
        </select>


        <label for="condition">Condition</label>
        <select name="condition" id="condition" required>
        <option value="">Select condition</option>
        <option value="new">New</option>
        <option value="used">Used</option>
        </select>


        <label for="price">Price per Day</label>
        <input type="number" name="price" id="price" step="0.01" required>


        <label for="location">Location</label>
        <input type="text" name="location" id="location" required>


        <label for="images">Upload Images</label>
        <input type="file" class="image" name="images[]" id="images" multiple accept="image/*">


        <button type="submit" name="add_tool" class="buttons">Add Tool</button>
    </form>
    </div>
</div>

</body>
      <script src="outjs.js"></script>

</html>