<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Hacktive8 GoClass Final Task</title>

  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url()?>theme/startbootstrap-clean-blog-master/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="<?php echo base_url()?>theme/startbootstrap-clean-blog-master/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

  <!-- Custom styles for this template -->
  <link href="<?php echo base_url()?>theme/startbootstrap-clean-blog-master/css/clean-blog.min.css" rel="stylesheet">
  <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand" href="<?php echo site_url('home')?>">Ghanbiyan</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url('home')?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url('about')?>">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url('contact')?>">Contact</a>
          </li>
          <?php if($this->session->userdata('authorized') != TRUE) { ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('login')?>">LOGIN</a>
            </li>
            <?php }else{ ?>
            <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dashboard')?>">ADMIN</a>
            </li>
            <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('logout')?>">LOGOUT</a>
            </li>
            <?php }?>
        </ul>
      </div>
    </div>
  </nav>

  






