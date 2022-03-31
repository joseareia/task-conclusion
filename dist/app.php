<?php
    require_once realpath(dirname(__DIR__) . '/vendor/autoload.php');

    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->safeLoad();

    $dotenv->required('HASH_TYPE')->notEmpty();
    $dotenv->required('HASH_USER')->notEmpty();
    $dotenv->required('HASH_PASSWORD')->notEmpty();
    $dotenv->required('MAIL_MAILER')->notEmpty();
    $dotenv->required('MAIL_HOST')->notEmpty();
    $dotenv->required('MAIL_PORT')->notEmpty();
    $dotenv->required('MAIL_USERNAME')->notEmpty();
    $dotenv->required('MAIL_PASSWORD')->notEmpty();
    $dotenv->required('MAIL_FROM_ADDRESS')->notEmpty();
    $dotenv->required('MAIL_FROM_NAME')->notEmpty();

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

    function login(string $username, string $password) :bool {
        $hashed_user_given = hash($_ENV['HASH_TYPE'], $username);
        $hashed_pass_given = hash($_ENV['HASH_TYPE'], $password);
        if ($hashed_user_given === trim($_ENV['HASH_USER']) && $hashed_pass_given === trim($_ENV['HASH_PASSWORD'])) {
            $_SESSION['username'] = $username;
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            return true;
        }
        return false;
    }

    function is_post_request(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
?>
