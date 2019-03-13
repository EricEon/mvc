<?php use Flux\Core\Http\Request;?>
<!Doctype html>
<html lang="en-US">
<head>
    <title>Index Page</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="/public/main.css">
</head>
<body>
<nav class="navigation">
    <ul class="nav-list">
    <?php if(!isLoggedIn()):?>
        <li class="nav-item"><a href="/">Login</a></li>
        <li class="nav-item"><a href="/register">Register</a></li>
    <?php endif;?>
        <?php if (isLoggedIn()): ?>
            <form action="/logout" method="post" style="padding: 0;margin:0;">
            <input type="submit" value="Logout" name="submit" style="padding: 0;margin:0;">
            </form>
            <!-- <a href="/logout" class="btn">LOGOUT</a> -->
    <?php endif;?>
    </ul>
</nav>