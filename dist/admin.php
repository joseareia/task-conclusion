<?php
require __DIR__ . '/app.php';
require_admin();

$error = '';

if (is_post_request()) {
    $list = $_POST['list'] ?? '';
    $action = $_POST['action'] ?? '';
    $value = trim($_POST['value'] ?? '');

    if (!in_array($list, ['colaboradores', 'tarefas'], true)) {
        $error = 'Lista inválida.';
    } elseif ($action === 'add' && $value === '') {
        $error = 'Por favor, insira um valor.';
    } else {
        $items = read_list($list . '.json');

        if ($action === 'add') {
            $items[] = $value;
        } elseif ($action === 'remove') {
            $items = array_filter($items, fn($item) => $item !== $value);
        }

        write_list($list . '.json', $items);
        redirect_to('admin.php');
    }
}

$colaboradores = get_colaboradores();
$tarefas = get_tarefas();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meiricarro - Gestão</title>
    <style media="screen">
    .container { max-width: 720px; }

    ::placeholder {
        color: #d7d7d7 !important;
        opacity: 1;
    }

    ::-ms-input-placeholder {
        color: #d7d7d7 !important;
    }

    button {
        font-size: 14.5px !important;
        padding: 0.575rem 0.95rem !important
    }

    .list-group-item {
        font-size: 0.95rem;
    }
    </style>
</head>
<body class="bg-light">
    <main class="form-register" style="margin-top:7rem;">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Gestão de Colaboradores e Tarefas</h4>
                <a href="index.php" class="btn btn-link">Voltar</a>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="row g-5">
                <div class="col-md-6">
                    <h5 class="fw-bold">Colaboradores</h5>
                    <ul class="list-group mb-3">
                        <?php foreach ($colaboradores as $colaborador): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo htmlspecialchars($colaborador); ?>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="list" value="colaboradores">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="value" value="<?php echo htmlspecialchars($colaborador); ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger delete-btn">Remover</button>
                                </form>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <form method="POST" class="d-flex gap-2">
                        <input type="hidden" name="list" value="colaboradores">
                        <input type="hidden" name="action" value="add">
                        <input type="text" name="value" class="form-control" placeholder="Nome do colaborador" required>
                        <button type="submit" class="btn btn-primary text-nowrap">Adicionar</button>
                    </form>
                </div>

                <div class="col-md-6">
                    <h5 class="fw-bold">Tarefas</h5>
                    <ul class="list-group mb-3">
                        <?php foreach ($tarefas as $tarefa): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo htmlspecialchars($tarefa); ?>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="list" value="tarefas">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="value" value="<?php echo htmlspecialchars($tarefa); ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger delete-btn">Remover</button>
                                </form>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <form method="POST" class="d-flex gap-2">
                        <input type="hidden" name="list" value="tarefas">
                        <input type="hidden" name="action" value="add">
                        <input type="text" name="value" class="form-control" placeholder="Nome da tarefa" required>
                        <button type="submit" class="btn btn-primary text-nowrap">Adicionar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="js/vendor.js"></script>
</html>
