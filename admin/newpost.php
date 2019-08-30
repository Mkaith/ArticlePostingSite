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
            <h1 class="h2">Add new Post</h1>
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
    <form method="post" enctype="multipart/form-data">
    Post Title:
    <input type="text" name="post_title" class="form-control" aria-describedby="emailHelp" placeholder="Post Title"><br>
    Post Category:
    <select name="post_category" class="form-control" id="exampleFormControlSelect1">
    <?php
    $sql="SELECT * FROM `category` ";
    $result=mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($result)){
        ?>
        <option value="<?php echo $row['category_id']?>"><?php echo $row['category_name']?></option>
        <?php
    }
    ?>
      
    </select><br>
    Post Content:
    <textarea class="form-control" name="post_content" id="exampleFormControlTextarea1" rows="3"></textarea><br>
    Post Image:
    <input type="file" name="post_image" class="form-control-file" id="exampleFormControlFile1"><br>
    Post Keywords:
    <input type="text" name="post_keywords" class="form-control" aria-describedby="emailHelp" placeholder="Post keyword"><br>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
    <?php
    if(isset($_POST['submit'])){
        $post_title=mysqli_real_escape_string($conn,$_POST['post_title']);
        $post_category=mysqli_real_escape_string($conn,$_POST['post_category']);
        $post_content=mysqli_real_escape_string($conn,$_POST['post_content']);
        $post_keywords=mysqli_real_escape_string($conn,$_POST['post_keywords']);
        $post_author = $_SESSION['author_id'];
        $post_date=date("d/m/y");
        //if empty fields
        if(empty($post_title) OR empty($post_category) OR empty($post_content)){
            header("Location:newpost.php?message=Empty+Fields");
            exit();
        }

        $file=$_FILES['post_image'];
        $fileName=$file['name'];
        $filetype=$file['type'];
        $fileTmp=$file['tmp_name'];
        $fileErr=$file['error'];
        $fileSize=$file['size'];

        $fileEXT= explode('.',$fileName);
        $fileExtension=strtolower(end($fileEXT));
        $allowedExt=array("jpg","jpeg","png","gif");
        if(in_array($fileExtension,$allowedExt)){
            if($fileErr === 0){
                if($fileSize<3000000){
                    $newFileName=uniqid('',true).'.'.$fileExtension;
                    $destination="../uploads/$newFileName";
                    $dbdestination="uploads/$newFileName";
                    move_uploaded_file($fileTmp,$destination);
$sql= "INSERT INTO posts(`post_title`,`post_content`,`post_category`,`post_author`,`post_date`,`post_keywords`,`post_image`) 
VALUES('$post_title','$post_content','$post_category',
'$post_author','$post_date','$post_keywords','$dbdestination');";

                    if(mysqli_query($conn,$sql)){
                        header("Location:post.php?message=Post+Published");
                    }else{
                        header("Location:newpost.php?message=Error");
                    }
                }else{
                    header("Location:newpost.php?message=File+too+big");
                    exit();
                }

            }else{
                header("Location:newpost.php?message=Error+uploading");
                exit();
            }
        }else{
            header("Location:newpost.php?message=Uploaded+wrong+file");
            exit();
        }

    }
    
    ?>
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

