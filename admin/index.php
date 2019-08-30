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
            <h1 class="h2">Dashboard</h1>
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
            <h1>Your Profile</h1>
            <div id="index-admin-form">
            <form method="post">
            Name:<input type="text" name="author_name" class="form-control" id="exampleInputname" aria-describedby="emailHelp" value="<?php echo $_SESSION['author_name'];?>" placeholder="Enter name"><br>
         E-mail:<input type="email" name="author_email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $_SESSION['author_email'];?>" placeholder="Enter email"><br>
        Password:<input type="password" name="author_password" class="form-control" id="exampleInputPassword1"  placeholder="Password"><br>
        Your Bio:<textarea name="author_bio" class="form-control" id="exampleFormControlTextarea1"  rows="3"><?php echo $_SESSION['author_bio'];?></textarea><br>

            
            <button name="update" type="submit" class="btn btn-primary">Update</button>
            </form>
            <?php
            if(isset($_POST['update'])){
                $author_name=mysqli_real_escape_string($conn,$_POST['author_name']);
                $author_email=mysqli_real_escape_string($conn,$_POST['author_email']);
                $author_password=mysqli_real_escape_string($conn,$_POST['author_password']);
                $author_bio=mysqli_real_escape_string($conn,$_POST['author_bio']);
              if(empty($author_name) OR empty($author_email) OR empty($author_bio)){
                  echo "Empty Fields";
              }else{
                  if(!filter_var($author_email,FILTER_VALIDATE_EMAIL)){
                      echo "Please Enter a Valid email!";
                  }else{
                      
                      if(empty($author_password)){
                        $author_id=$_SESSION['author_id'];
                        $sql = "UPDATE `author` SET author_name='$author_name'
                        ,author_email='$author_email',author_bio='$author_bio' WHERE author_id='$author_id'";
                      if(mysqli_query($conn,$sql)){
                
                          $_SESSION['author_name']=$author_name;
                          $_SESSION['author_email']=$author_email;
                          $_SESSION['author_bio']=$author_bio;
                        header("Location:index.php?message=Records+Updated");
                      }else{
                          echo "Error!";
                      }
                      }else{
                          $hash=password_hash($author_password,PASSWORD_DEFAULT);
                        $author_id=$_SESSION['author_id'];
                        $sql = "UPDATE `author` SET author_name='$author_name'
                        ,author_email='$author_email',author_bio='$author_bio',author_password='$hash' WHERE author_id='$author_id'";
                      if(mysqli_query($conn,$sql)){
                          session_unset();
                          session_destroy();
                        header("Location:login.php?message=Records+Updated+You+May+Login+Again");
                      }else{
                          echo "Error!";
                      }
                      }
                  }
              }
            }
            
            
            ?>
          </div>
    
          <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
    
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

