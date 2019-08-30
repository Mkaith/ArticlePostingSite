<nav class="navbar navbar-dark sticky-top bg-dark shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Company name</a>
      
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="logout.php">Sign out</a>
        </li>
      </ul>
    </nav>
    
    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="index.php">
                  <span data-feather="home"></span>
                  Dashboard <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="post.php">
                  <span data-feather="file"></span>
                  All Posts
                </a>
              </li>
              <?php if(isset($_SESSION['author_role'])){
               if($_SESSION['author_role']=="admin"){
                 ?>
<li class="nav-item">
                <a class="nav-link" href="category.php">
                  <span data-feather="shopping-cart"></span>
                  All Categories
                </a>
              </li>
             <?php  } 
                
              }
                ?>
              
              <li class="nav-item">
                <a class="nav-link" href="page.php">
                  <span data-feather="users"></span>
                  All Pages
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="bar-chart-2"></span>
                  Reports
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="layers"></span>
                  Integrations
                </a>
              </li>
            </ul>
    
           
          </div>
        </nav>