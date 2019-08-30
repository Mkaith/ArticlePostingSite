<?php
session_start();
include_once "../includes/functions.php";
include_once "../includes/connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>SIGN IN</title>
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>   
<body>
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

<div style="width:500px;margin:auto auto;margin-top:200px;">
<form method="post" class="form-signin">
 
  <h1 class="h3 mb-3 font-weight-normal">Please Login</h1>
  <input type="email" id="inputEmail" name="author_email" class="form-control" placeholder="Enter email address" required autofocus>
  <input type="password" id="inputPassword" name="author_password" class="form-control" placeholder="Enter Password" required>
  
  <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Login</button>
 
</form>
</div>
<?php
if(isset($_POST['login'])){
    //checking for empty variables
    $author_email=mysqli_real_escape_string($conn,$_POST['author_email']);
    $author_password=mysqli_real_escape_string($conn,$_POST['author_password']);
    if(empty($author_email) OR empty($author_password)){
        header("Location: signup.php?message=Empty+Fields");
        exit();
    }

    //Checking the email
    if(!filter_var($author_email,FILTER_VALIDATE_EMAIL)){
        header("Location: signup.php?message=Please+Enter+A+Valid+Email");
        exit();
    }
    else{
        //If email exist
        $sql2 ="SELECT * FROM `author` WHERE author_email='$author_email'";

        $result=mysqli_query($conn,$sql2);
        if(mysqli_num_rows($result)<=0){
            header("Location: login.php?message=Login+Error");
            exit();
        } else{
           while($row=mysqli_fetch_assoc($result)){
            //checking for password
            if(!password_verify($author_password,$row['author_password'])){
                header("Location: login.php?message=Login+Error");
                exit();
            }else if(password_verify($author_password,$row['author_password'])){
                $_SESSION['author_id']=$row['author_id'];
                $_SESSION['author_name']=$row['author_name'];
                $_SESSION['author_email']=$row['author_email'];
                $_SESSION['author_bio']=$row['author_bio'];
                $_SESSION['author_role']=$row['author_role'];
                header("Location: index.php?");
            }
           }
        }
    }

}
?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>