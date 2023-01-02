<?php 

  if(empty($_SESSION['dealerapp']))  {
    header("Location:".BASE_URL."index.php/login"); 
  }  
?> 
<!doctype html>
<html lang="en" >

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />

  <!-- Bootstrap CSS -->
  <link href="<?php echo(BASE_URL); ?>assets/css/bootstrap.css" rel="stylesheet" />
  <link href="<?php echo(BASE_URL); ?>assets/custom-css/style.css" rel="stylesheet" />
  <link href="<?php echo(BASE_URL); ?>assets/css/icons.css" rel="stylesheet"> 
   
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo(BASE_URL); ?>assets/custom-css/bootstrap-icons.css">
  <!-- loader-->

  <title>Dealer App</title>
  <script>
    BASEURL = "<?php echo(BASE_URL); ?>index.php/";
  </script>
  <div id="appendScript"></div>
</head>

<body>
  <!--start wrapper-->
  <div class="wrapper">
  <nav class="navbar navbar-dark menu-bg fixed-tops">
  <!-- <nav class="navbar navbar-dark menu-bg fixed-top"> -->
  <div class="container">
    <a class="navbar-brand" href="#">Dealer App</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end sidebar-bg" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Dealer App</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <!-- <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dev_installation_log">Device Installation</a>
          </li> -->
          <li> <a class="menuItemX" href="#" data-href="dev_installation_log"> Device Installations</a>
          </li>  
          <li class="nav-item">
            <a class="nav-link active" href="#">Link</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Dropdown
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
        </ul>
        
      </div>
    </div>
  </div>
</nav>

<main class="page-content " id="mainContentArea">