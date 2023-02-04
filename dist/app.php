<?php
    require_once realpath(dirname(__DIR__) . '/vendor/autoload.php');

    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->safeLoad();

    $dotenv->required('USERNAME')->notEmpty();
    $dotenv->required('PASSWORD')->notEmpty();
    $dotenv->required('MAIL_MAILER')->notEmpty();
    $dotenv->required('MAIL_HOST')->notEmpty();
    $dotenv->required('MAIL_PORT')->notEmpty();
    $dotenv->required('MAIL_USERNAME')->notEmpty();
    $dotenv->required('MAIL_PASSWORD')->notEmpty();
    $dotenv->required('MAIL_FROM_ADDRESS')->notEmpty();
    $dotenv->required('MAIL_FROM_NAME')->notEmpty();
    $dotenv->required('MAIL_TO_ADDRESS')->notEmpty();
    $dotenv->required('MAIL_TO_NAME')->notEmpty();
    $dotenv->required('MAIL_TO_ADDRESS_CC')->notEmpty();

    session_start();

    function redirect_to($url, $status_code = 303) {
        header('Location: ' . $url, true, $status_code);
        die();
    }

    function is_user_logged_in(): bool {
        return isset($_SESSION['username']) && $_SESSION['valid'];
    }

    function require_login(): void {
        if (!is_user_logged_in()) {
            redirect_to('login.php');
        }
    }

    function login(string $username, string $password) : bool {
        $hashed_pass_given = password_hash($password, PASSWORD_BCRYPT);

        if ($username === trim($_ENV['USERNAME']) && password_verify(trim($_ENV['PASSWORD']), $hashed_pass_given)) {
            $_SESSION['username'] = $username;
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            return true;
        }

        return false;
    }

    function is_post_request() : bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
?>
