<!doctype html>
<!-- code by webdevtrick (https://webdevtrick.com) -->
<html lang="en">
  <head>
    <title>ICON! Score Leaderboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    
    <script>
      <?php require '../reload.js'; ?>
    </script>
	  
  </head>
  <body  style="background: #23103C">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <label class="navbar-brand">ICON Playground 2019</label>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item  <?php if(!$startup):?> active <?php endif;?>">
		  <a class="nav-link" href="/poin/pengunjung">Pengunjung </a>
      </li>
      <li class="nav-item <?php if($startup):?> active <?php endif;?>">
        <a class="nav-link" href="/poin/startup">Startup</a>
      </li>      
      
    </ul>
  </div>
</nav>
