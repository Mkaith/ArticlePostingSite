<?php
include_once "includes/connection.php";
include_once "includes/functions.php";
if(!isset($_GET['id'])){
    header("Location:index.php");
}else{
    $id=mysqli_real_escape_string($conn,$_GET['id']);
    if(!is_numeric($id)){
        header("Location:index.php?ghjnkm");
        exit();
    }else if(is_numeric($id)){
        $sql ="SELECT * FROM category WHERE category_id='$id'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)<=0){
        header("Location:index.php");
        }else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Blogging Site</title>
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
</head>   
<body>

<!-- NAVIGATION BAR -->
<?php include_once "includes/nav.php"; ?>
<!-- NAVIGATION BAR END -->


<div class="container">
<h1 style="width:100%;padding-top:25px;padding-bottom:25px;;background-color:grey;color:white;text-align:center;">Showing All Posts for Category:<?php getCategoryName($id);?></h1>
<div class="card-columns">
<?php
$sql="SELECT * FROM `posts` WHERE post_category='$id' ORDER BY post_id DESC";
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

<div class="card" style="width: 18rem;">
  <img src="<?php echo $post_image ?>" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title"><?php echo $post_title ?></h5>
    <h6 class="card-subtitle mb-2 text-muted"><?php echo $post_author_name ?></h6>
    <p class="card-text"><?php echo substr($post_content,0,100)."..."?></p>
    <a href="post.php?id=<?php echo $post_id?>" class="btn btn-primary">Read more...</a>
  </div>
  
</div>
<?php } } ?>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>


<?php 
     
    }

}
}
?>                