<?php use Flux\Core\Http\Request; ?>
<!Doctype html>
<html lang="en-US">
<head>
    <title>Index Page</title>
    <link rel="stylesheet" href="/public/main.css">
</head>
<body>
<nav class="navigation">
    <ul class="nav-list">
        <li class="nav-item"><a href="/">Login</a></li>
        <li class="nav-item"><a href="/register">Register</a></li>
        <?php if(Request::is('/dashboard')): ?>
            <form action="/logout" method="post">
            <input type="submit" value="Logout" name="submit" style="padding: 0;margin:0;">
            </form>
            <!-- <a href="/logout" class="btn">LOGOUT</a> -->
    <?php endif; ?>
    </ul>
</nav>