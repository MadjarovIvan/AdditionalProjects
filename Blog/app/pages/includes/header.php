<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Home - <?=APP_NAME?></title>

    <link href="<?=ROOT?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <style>
    .bi {
        vertical-align: -.125em;
        fill: currentColor;
    }
    </style>
    <!-- Custom styles for this template -->
    <link href="<?=ROOT?>/assets/css/headers.css" rel="stylesheet">
</head>
<body>
<header class="p-3  border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="home">
            <img class="mb-4" src="<?=ROOT?>/assets/images/logo.png" alt="" width="72" height="57">
        </a>
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="<?=ROOT?>/" class="nav-link px-2 link-secondary">Home</a></li>
                <li><a href="<?=ROOT?>/blog" class="nav-link px-2 link-body-emphasis">Blog</a></li>
                <li><a href="<?=ROOT?>/search" class="nav-link px-2 link-body-emphasis">Search</a></li>
                <li><a href="<?=ROOT?>/contact" class="nav-link px-2 link-body-emphasis">Contact </a></li>
                <div class="dropdown text-end">
                <a href="#" class="d-block nav-link link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Categories
                </a>
                <ul class="dropdown-menu text-small">
                    <?php 
                    $query = "SELECT * FROM categories";
                    $rows = query($query);
                    ?>
                    <?php if(!empty($rows)):?>
                        <?php foreach($rows as $row):?>
                            <li><a class="dropdown-item" href="<?=ROOT?>/category/<?=$row['slug']?>"><?=$row['category']?></a></li>
                            
                        <?php endforeach;?>
                    <?php endif;?>
                </ul>
            </div>
            </ul>

            <form action="<?=ROOT?>/search" class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                <div class="input-group">
                    <input value="<?=$_GET['find'] ?? ''?>" name="find" type="search" class="form-control" placeholder="Search..." aria-label="Search">
                    <button class="btn btn-primary">Search</button>
                </div>
            </form>

            <?php if(logged_in()):?>
            <div class="dropdown text-end">
                <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?=get_image(user('image'))?>" alt="mdo" width="32" height="32" class="rounded-circle">
                </a>
                <ul class="dropdown-menu text-small">
                    <li><a class="dropdown-item" href="#">Hi, <?=user('username')?></a></li>
                    <li><a class="dropdown-item" href="<?=ROOT?>/admin">Profile</a></li>
                    <li><a class="dropdown-item" href="<?=ROOT?>/admin">Admin</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?=ROOT?>/logout">Sign out</a></li>
                </ul>
            </div>
            <?php endif ?>
        </div>
    </div>
</header>

<?php 
if($url[0] == 'home')
    include '../app/pages/includes/slider.php'; 
?>
<main class="p-2">
