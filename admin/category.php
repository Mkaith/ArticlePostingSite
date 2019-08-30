<?php
include_once "../includes/functions.php";
include_once "../includes/connection.php";
session_start();
if(isset($_SESSION['author_role'])){ 
  if($_SESSION['author_role']=="admin"){
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Admin Panel</title>
        <link rel="stylesheet" href="../style/bootstrap.min.css">
        <link rel="stylesheet" href="../style/style.css">
       
    </head>   
    <body>
   <?php include_once "nav.inc.php";  ?>
    
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Category</h1>
        <h6>Hello <?php echo $_SESSION['author_name'];?> | You are <?php echo $_SESSION['author_role']; ?></h6>
            </div>
            <?php
    if(isset($_GET['message'])){
        $msg=$_GET['message'];
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>'.$msg.'
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
?>
    <h1>All Categories:</h1>
    <button id="addCatBtn" class="btn btn-info">Add New</button>
    <hr>
    <div style="display:none;" id="addCatForm">
    <form action="addCat.php" method="post">
    <input type="text" name="category_name" class="form-control" aria-describedby="emailHelp" placeholder="Category Name"><br>
    <button name="submit" class="btn btn-success">Add Category</button>
    
    </form><br>
    
    
    </div>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">Category Id</th>
      <th scope="col">Category Name</th>
    </tr>
  </thead>
  <tbody>
  <?php
$sql="SELECT * FROM `category` ORDER BY category_id DESC";
$result=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
 $category_id=$row['category_id'];
 $category_name=$row['category_name'];

 

?>
<tr>
      <th scope="row"><?php echo $category_id?></th>
      <td><?php echo $category_name?></td>
    </tr>
<?php  } ?>
    
  </tbody>
</table>
          </div>
    
         </div>
    
          
        </main>
      </div>
    </div>

    
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
          $("#addCatBtn").click(function(){
            $("#addCatForm").slideToggle();
          });
        });
        </script>
    </body>
    </html>

    <?php
} 
}

?>

