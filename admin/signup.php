<?php
include_once "../includes/functions.php";
include_once "../includes/connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>SIGN UP</title>
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
 
  <h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
  <input type="text" id="input" name="author_name" class="form-control" placeholder="Enter Name" required autofocus>
  <input type="email" id="inputEmail" name="author_email" class="form-control" placeholder="Enter email address" required autofocus>
  <input type="password" id="inputPassword" name="author_password" class="form-control" placeholder="Enter Password" required>
  
  <button class="btn btn-lg btn-primary btn-block" name="signup" type="submit">Sign up</button>
 
</form>
</div>
<?php
if(isset($_POST['signup'])){
    //checking for empty variables
    $author_name=mysqli_real_escape_string($conn,$_POST['author_name']);
    $author_email=mysqli_real_escape_string($conn,$_POST['author_email']);
    $author_password=mysqli_real_escape_string($conn,$_POST['author_password']);
    if(empty($author_name) OR empty($author_email) OR empty($author_password)){
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
        if(mysqli_num_rows($result)>0){
            header("Location: signup.php?message=Email+Already+Exist");
            exit();
        } else{
            //Hashing password
            $hash=password_hash($author_password,PASSWORD_DEFAULT);
       $sql= "INSERT INTO `author` (`author_name`,`author_email`,`author_password`,`author_bio`,`author_role`) VALUES
              ('$author_name','$author_email','$hash','Enter Bio','author')";

            if(mysqli_query($conn,$sql)){
                header("Location: signup.php?message=Successfully+Registered");
                exit();
            }else{
                header("Location: signup.php?message=Registration+Failed");
                exit();
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