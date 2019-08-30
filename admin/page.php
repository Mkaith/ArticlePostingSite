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
            <h1 class="h2">Pages</h1>
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
    <h1>All Pages:</h1>
    <button id="toggleForm" class="btn btn-info">Add New</button>
    <hr>
    <div style="display:none;" id="newPageForm">
    <form action="newpage.php" method="post">
    <input type="text" name="page_title" class="form-control" placeholder="Enter title of Page"><br>
    <textarea name="page_content" class="form-control" rows="3"></textarea><br>
    <button name="submit" class="btn btn-success">Add Page</button>

    </form><br>
    </div>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">Page Id</th>
      <th scope="col">Page title</th>
      <?php if($_SESSION['author_role'] =="admin"){ ?>
      <th scope="col">Action</th>
      <?php } ?>
    </tr>
  </thead>
  <tbody>
  <?php
$sql="SELECT * FROM `page` ORDER BY page_id DESC";
$result=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
 $page_id=$row['page_id'];
 $page_title=$row['page_title'];



?>
<tr>
      <th scope="row"><?php echo $page_id?></th>
      <td><?php echo $page_title?></td>
      
     
      <td><a href="editpage.php?id=<?php echo $page_id?>"><button class="btn btn-info">EDIT</button></a>
      <a onclick ="return confirm('Are you sure')" href="deletepage.php?id=<?php echo $page_id?>"><button class="btn btn-danger">DELETE</button></a>
      </td>
      
    </tr>
<?php } ?>
    
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
          $("#toggleForm").click(function(){
            $("#newPageForm").slideToggle();
          });
        });
        </script>
    </body>
    </html>

    <?php
}
}
else{
    header("Location:login.php?message=Please+Login");
}
?>

