<?php 

  use protonx\basemvc\core\Application; 

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <title><?= $this->title; ?></title>
  </head>
  <body>

  <?php 
      // echo '<pre>';
      // var_dump(Application::$app->user);  
      // echo '</pre>';
  ?>

    <nav class="navbar navbar-expand-sm navbar-dark bg-primary">
        <a class="navbar-brand" href="#">BaseMVC</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
              <li class="nav-item active">
                  <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="/contact">Contact</a>
              </li>
          </ul>

          <?php if(Application::isGuest()): ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="/login">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/register">Register</a>
                </li>
            </ul>
          <?php else: ?>
              <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                  <span class="" style="display: inline-block; padding: .5rem .5rem;">
                    <?= Application::$app->user->getDisplayName(); ?>
                  </span>
                <li class="nav-item active">
                      <a class="nav-link" href="/profile">Profil</a>
                </li>
                </li>
                <li class="nav-item">
                  <a class="nav-link" style="display: inline-block;" href="/logout">Logout</a>
                </li>
                <!-- <li class="nav-item">
                      <?= Application::$app->user->getDisplayName(); ?> | 
                      <a class="nav-link" style="display: inline-block;" href="/logout">Logout</a>
                </li> -->
            </ul>
          <?php endif; ?>

        </div>
    </nav>

    <div style="height:30px;">&nbsp;</div>

    <div class="container">

      <?php if(Application::$app->session->getFlash('success')): ?>
        <div class="alert alert-success">
          <?= Application::$app->session->getFlash('success'); ?>
        </div>
      <?php endif; ?>

      {{CONTENT}}
    </div>

    <script src="assets/libs/jquery-3.5.1.slim.min.js"></script>
    <script src="assets/libs/bootstrap.bundle.min.js"></script>
    
  </body>
</html>