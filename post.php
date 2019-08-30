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
        $sql ="SELECT * FROM posts WHERE post_id='$id'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)<=0){
        header("Location:index.php");
        }else if(mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_assoc($result)){
                $post_title=$row['post_title'];
                $post_content=$row['post_content'];
                $post_date=$row['post_date'];
                $post_image=$row['post_image'];
                $post_keywords=$row['post_keywords'];
                $post_category=$row['post_category'];
                $post_author=$row['post_author'];
                ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $post_title; ?></title>
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
</head>   
<body>

<!-- NAVIGATION BAR -->
<?php include_once "includes/nav.php"; ?>
<!-- NAVIGATION BAR END -->

<div class="container">
<img style="width:50%;" src="<?php echo $post_image; ?>">
<h1><?php echo $post_title; ?></h1>
<hr>
<h6>Posted on:<?php echo $post_date; ?>| By:<?php getAuthorName($post_author) ; ?></h6>
<h4>Category:<a href="category.php?id=<?php echo $post_category; ?>"><?php getCategoryName($post_category) ; ?></a></h4>
<p><?php echo $post_content; ?></p>
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
}
?>