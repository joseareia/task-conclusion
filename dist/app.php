<?php
    require_once realpath(dirname(__DIR__) . '/vendor/autoload.php');

    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->safeLoad();

    $dotenv->required('USERNAME')->notEmpty();
    $dotenv->required('PASSWORD')->notEmpty();
    $dotenv->required('ADMIN_USERNAME')->notEmpty();
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

    function is_admin(): bool {
        return is_user_logged_in() && $_SESSION['username'] === trim($_ENV['ADMIN_USERNAME']);
    }

    function require_admin(): void {
        require_login();

        if (!is_admin()) {
            redirect_to('index.php');
        }
    }

    function login(string $username, string $password) : bool {
        if ($username === trim($_ENV['USERNAME']) && hash_equals(trim($_ENV['PASSWORD']), $password)) {
            session_regenerate_id(true);
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

    function data_path(string $filename): string {
        return dirname(__DIR__) . '/data/' . $filename;
    }

    function read_list(string $filename): array {
        $path = data_path($filename);

        if (!file_exists($path)) {
            return [];
        }

        $items = json_decode(file_get_contents($path), true);

        return is_array($items) ? $items : [];
    }

    function write_list(string $filename, array $items): void {
        $items = array_values(array_unique(array_filter(array_map('trim', $items))));
        sort($items, SORT_LOCALE_STRING);

        file_put_contents(data_path($filename), json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    function get_colaboradores(): array {
        return read_list('colaboradores.json');
    }

    function get_tarefas(): array {
        return read_list('tarefas.json');
    }
?>
