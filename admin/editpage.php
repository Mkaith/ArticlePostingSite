<?php
include_once "../includes/connection.php";
include_once "../includes/functions.php";
if(!isset($_GET['id'])){
    header("Location:page.php?message=Please+click+edit+button");
    exit();
}else{
    if(!isset($_SESSION['author_role'])){
        header("Location:login.php?message=please+login");
        exit();
    }else{
        if($_SESSION['author_role']!="admin"){
            echo "You cant access this page";
        }else{
            $page_id =$_GET['id'];
            $sql="SELECT * FROM page WHERE page_id='$page_id'";
            $result=mysqli_query($xonn,$sql);
            if(mysqli_num_rows($result)){
                header("Location:page.php?message=Page+not+found");
                exit();
            }else{

?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Edit Post</title>
        <link rel="stylesheet" href="../style/bootstrap.min.css">
        <link rel="stylesheet" href="../style/style.css">
    </head>   
    <body>
   <?php include_once "nav.inc.php";  ?>
    
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Edit Page</h1>
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
<?php
$post_id=$_GET['id'];
$formsql="SELECT * FROM page WHERE page_id='$page_id'";
$formresult=mysqli_query($conn,$formsql);
while($formrow=mysqli_fetch_assoc($formresult)){
    $pageTitle=$formrow['page_title'];
    $pageContent=$formrow['page_content'];
   
  
?>

    <form method="post" enctype="multipart/form-data">
    Page Title:
    <input type="text" value="<?php echo $pageTitle; ?>" name="page_title" class="form-control" aria-describedby="emailHelp" placeholder="Post Title"><br>
    Page Content:
    <textarea class="form-control"  name="page_content" id="exampleFormControlTextarea1" rows="9"><?php echo $pageContent; ?></textarea><br>
   
    <button type="submit" name="submit" class="btn btn-primary">Update</button>
    </form>
<?php } ?>
    <?php
    if(isset($_POST['submit'])){
        //$post_id=$_GET['id'];
        $post_title=mysqli_real_escape_string($conn,$_POST['post_title']);
        $post_content=mysqli_real_escape_string($conn,$_POST['post_content']);
        $post_keywords=mysqli_real_escape_string($conn,$_POST['post_keywords']);
       
        //if empty fields
        if(empty($post_title) OR empty($post_content)){
        
            echo '<script>window.location = "post.php?message=Empty+Fields";</script>';
            exit();
        }

        if(is_uploaded_file($_FILES['post_image']['tmp_name'])){
           
            //user want to update file
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
$sql= "UPDATE posts SET post_title='$post_title',post_content='$post_content',
post_keywords='$post_keywords',post_image='$dbdestination' WHERE post_id='$post_id'";
                 if(mysqli_query($conn,$sql)){

                            echo '<script>window.location="post.php?message=Post+Updated";</script>';
                           

                        }else{
                            echo '<script>window.location="newpost.php?message=Error";</script>';
                            exit();
                        }
                    }else{
                        echo '<script>window.location="newpost.php?message=File+too+big";</script>';
                        exit();
                    }
    
                }else{
                   
                    echo '<script>window.location="newpost.php?message=Error+uploading";</script>';
                    exit();
                }
            }else{
                
                echo '<script>window.location="newpost.php?message=Uploaded+wrong+file";</script>';
                exit();
            }
        }else{
            //user dont want to update
            $sql= "UPDATE posts SET post_title='$post_title',post_content='$post_content',
             post_keywords='$post_keywords' WHERE post_id='$post_id'";
            if(mysqli_query($conn,$sql)){
                echo "<script>window.location='post.php?message=Post+Updated';</script>";
                exit();
            }else{
               
                echo '<script>window.location="newpost.php?message=Error";</script>';
                exit();
            }
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
        }
    }
}

?>