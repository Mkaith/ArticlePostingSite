<?php
session_start();
include_once "../includes/connection.php";
if(!isset($_GET['id'])){
header("Location: index.php");
}else{
if(!isset($_SESSION['author_role'])){
    header("Location:login.php?message=Please+Login");
}else{
    if($_SESSION['author_role'] != "admin"){
        echo "ERROR:Yor can not access this page";
        exit();
    }else if($_SESSION['author_role']=="admin"){
        $id=$_GET['id'];

        $sqlcheck = "SELECT * FROM posts WHERE post_id='$id'";
        $result=mysqli_query($conn,$sqlcheck);
        if(mysqli_num_rows($result)<=0){
            header("Location:post.php?message=No+Posts");
            exit();
        }
        $sql= "DELETE FROM posts WHERE post_id='$id'";
        if(mysqli_query($conn,$sql)){
            header("Location:post.php?message=Successfully+Deleted");
            exit();
        }else{
            header("Location:post.php?message=cannot+delete");
        }
    }
}
}

?>