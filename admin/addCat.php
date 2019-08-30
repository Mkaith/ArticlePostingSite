<?php
include_once "../includes/connection.php";
session_start();
if(!isset($_POST['submit'])){
    header("Location:category.php?message=please+add+a+category");
    exit();
}else{
    if(!isset($_SESSION['author_role'])){
        header("Location:login.php?message=Please+login");
    }else{
        if($_SESSION['author_role']!="admin"){
            echo "you can't access this page";
            exit();
        }else if($_SESSION['author_role']=="admin"){
            $category_name=$_POST['category_name'];
            $sql="INSERT INTO category (`category_name`) VALUES ('$category_name');";
            if(mysqli_query($conn,$sql)){
                header("Loction:category.php?message=Category+added");
                exit();
            }else{
                header("Loction:category.php?message=Error");
                exit();
            }
        }
    }
}
?>