<?php
include_once "../includes/functions.php";
include_once "../includes/connection.php";
session_start();
if(isset($_SESSION['author_role'])){ 
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
            <h1 class="h2">Posts</h1>
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
    <h1>All Posts:</h1>
    <a href="newpost.php"><button class="btn btn-info">Add New</button></a>
    <hr>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">Post Id</th>
      <th scope="col">Post Image</th>
      <th scope="col">Post Title</th>
      <th scope="col">Post Author</th>
      <?php if($_SESSION['author_role'] =="admin"){ ?>
      <th scope="col">Action</th>
      <?php } ?>
    </tr>
  </thead>
  <tbody>
  <?php
$sql="SELECT * FROM `posts` ORDER BY post_id DESC";
$result=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
 $post_title=$row['post_title'];
 $post_image=$row['post_image'];
 $post_author=$row['post_author'];
 $post_content=$row['post_content'];
 $post_id=$row['post_id'];

 $sqlauth= "SELECT * FROM author WHERE author_id='$post_author'";
 $resultauth=mysqli_query($conn,$sqlauth);
 while($authrow=mysqli_fetch_assoc($resultauth)){
   $post_author_name=$authrow['author_name'];
 

?>
<tr>
      <th scope="row"><?php echo $post_id?></th>
      <td><img src="../<?php echo $post_image?>" width="50px" height="50px"></td>
      <td><?php echo $post_title?></td>
      <td><?php echo $post_author_name?></td>
      <?php if($_SESSION['author_role'] == "admin"){ ?>
      <td><a href="editpost.php?id=<?php echo $post_id?>"><button class="btn btn-info">EDIT</button></a>
      <a onclick ="return confirm('Are you sure')" href="deletepost.php?id=<?php echo $post_id?>"><button class="btn btn-danger">DELETE</button></a>
      </td>
      <?php } ?>
    </tr>
<?php } } ?>
    
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
    </body>
    </html>

    <?php
}
else{
    header("Location:login.php?message=Please+Login");
}
?>

