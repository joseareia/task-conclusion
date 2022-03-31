<?php
    require __DIR__ . '/app.php';

    if (is_user_logged_in()) {
        redirect_to('index.php');
    }

    if (is_post_request()) {
        if (login($_POST['username'], $_POST['password'])) {
            redirect_to('index.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Meiricarro | Iniciar Sessão</title>
        <link href="css/login.css" rel="stylesheet">
        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>
      </head>
      <body>
          <main class="form-signin">
              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                  <div class="mb-3">
                      <label for="username" class="form-label">Username</label>
                      <input type="text" class="form-control" id="username" name="username">
                  </div>
                  <div class="mb-3">
                      <label for="username" class="form-label">Password</label>
                      <input type="password" class="form-control" id="username" name="password">
                  </div>
                  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                      <button class="btn btn-primary" type="submit" name="login" style="width:30%;">Login</button>
                  </div>
              </form>
          </main>

          <footer class="my-5 pt-5 text-muted text-center text-small fixed-bottom">
              <p class="mb-1">&copy; 1992–<?php echo date("Y"); ?> Meiricarro, Lda.</p>
              <ul class="list-inline mt-2">
                  <li class="list-inline-item"><a href="https://www.meiricarro.com">Website</a></li>
                  <li class="list-inline-item"><a href="mailto:jose.apareia@gmail.com">Support</a></li>
              </ul>
          </footer>
      </body>
      <script src="js/main.js"></script>
</html>
