<?php
require __DIR__ . '/app.php';
require_login();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meiricarro | Registo Conclusão de Tarefas</title>
    <style media="screen">
    .container {
        max-width: 960px;
    }

    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    .delete-row {
        cursor: pointer;
        text-decoration: underline;
    }

    #osv_peca_div,
    #matricula_peca_div {
        display: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
    </style>
</head>
<body class="bg-light">
    <main class="form-register" style="margin-top:9rem;">
        <div class="container">
            <div class="row g-5">
                <div class="col-md-12 col-lg-12">
                    <h4 class="mb-4 fw-bold">Registo de conclusão de tarefas</h4>
                    <form class="needs-validation" novalidate method="POST" id="form">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="colaborador" class="form-label">Colaborador</label>
                                <select class="form-select" id="colaborador" required name="colaborador">
                                    <option value="" hidden selected disabled>Escolha um colaborador...</option>
                                    <option value="Carlos">Carlos</option>
                                    <option value="Eunice">Eunice</option>
                                    <option value="João">João</option>
                                    <option value="Mauro">Mauro</option>
                                    <option value="Leandro">Leandro</option>
                                    <option value="Luis">Luis</option>
                                    <option value="Tânia">Tânia</option>
                                </select>
                                <div class="invalid-feedback">
                                    Por favor, escolha uma opção.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="tarefa" class="form-label">Tarefa</label>
                                <select class="form-select" id="tarefa" required name="tarefa">
                                    <option value="" hidden disabled selected>Escolha uma tarefa...</option>
                                    <option value="Intervenções Técnicas">Intervenções Técnicas</option>
                                    <option value="Lavagem">Lavagem</option>
                                    <option value="Inspeção">Inspeção</option>
                                </select>
                                <div class="invalid-feedback">
                                    Por favor, escolha uma opção.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="matricula" class="form-label">Matrícula</label>
                                <input type="matricula" class="form-control text-uppercase" id="matricula" placeholder="AA-00-AA" required name="matricula">
                                <div class="invalid-feedback">
                                    Por favor, insira uma matrícula válida.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="or" class="form-label">Ordem de serviço</label>
                                <input type="or" class="form-control" id="or" placeholder="00000" name="or" pattern="^[\d]{1,10}">
                                <div class="invalid-feedback">
                                    Por favor, insira uma ordem de serviço válida.
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-link me-md-1" type="reset" style="color:gray;" id="resetBtn">Cancelar</button>
                                <button class="btn btn-primary" type="submit" id="submitBtn">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row g-5 mt-3">
                <div class="col-md-12 col-lg-12">
                    <h4 class="mb-4 fw-bold">Registo e/ou pedido de peças</h4>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="colaborador-peca" class="form-label">Colaborador</label>
                            <select class="form-select" id="colaborador-peca" required name="colaborador-peca">
                                <option value="" hidden selected disabled>Escolha um colaborador...</option>
                                <option value="Carlos">Carlos</option>
                                <option value="Eunice">Eunice</option>
                                <option value="João">João</option>
                                <option value="Mauro">Mauro</option>
                                <option value="Leandro">Leandro</option>
                                <option value="Luis">Luis</option>
                                <option value="Tânia">Tânia</option>
                            </select>
                            <div class="invalid-feedback">
                                Por favor, escolha uma opção.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="pedido_peca" class="form-label">Tipo de pedido</label>
                            <select class="form-select" id="pedido_peca" required name="pedido_peca">
                                <option value="" hidden disabled selected>Escolha um tipo de pedido...</option>
                                <option value="OSV">OSV</option>
                                <option value="Matrícula">Matrícula</option>
                                <option value="Stock">Stock</option>
                            </select>
                            <div class="invalid-feedback invalid-pecas">
                                Por favor, escolha uma opção.
                            </div>
                        </div>
                        <div class="col-md-4" id="osv_peca_div">
                            <label for="or_peca" class="form-label">Ordem de serviço</label>
                            <input type="or_peca" class="form-control" id="or_peca" placeholder="00000" name="or_peca" pattern="^[\d]{1,10}">
                            <div class="invalid-feedback invalid-pecas">
                                Por favor, insira uma ordem de serviço válida.
                            </div>
                        </div>
                        <div class="col-md-4" id="matricula_peca_div">
                            <label for="matricula_peca" class="form-label">Matrícula</label>
                            <input type="matricula_peca" class="form-control text-uppercase" id="matricula_peca" placeholder="AA-00-AA" required name="matricula_peca">
                            <div class="invalid-feedback invalid-pecas">
                                Por favor, insira uma matrícula válida.
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-4">
                            <label for="reference" class="form-label">Referência / Descrição</label>
                            <input type="reference" class="form-control" id="reference" placeholder="Insira uma referência ou descrição..." name="reference">
                            <div class="invalid-feedback invalid-pecas">
                                Por favor, insira uma referência ou descrição válida.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="quantity" class="form-label">Quantidade</label>
                            <input type="quantity" class="form-control" id="quantity" placeholder="Insira uma quantidade..." name="quantity">
                            <div class="invalid-feedback invalid-pecas">
                                Por favor, insira uma quantidade válida.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="obs" class="form-label">Observações</label>
                            <input type="obs" class="form-control" id="obs" placeholder="Insira uma observação..." name="obs">
                            <div class="invalid-feedback invalid-pecas">
                                Por favor, insira uma observação válida.
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-link me-md-1" type="button" style="color:gray;" id="resetBtn">Limpar</button>
                            <button class="btn btn-secondary" type="button" name="button" id="adicionar-peca">Adicionar Peça</button>
                            <button class="btn btn-primary" type="button" name="button" id="enviar-peca">Enviar Pedido</button>
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-12">
                            <label class="form-label">Tabela de Stock</label>
                            <table class="table table-bordered" id="table">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Referência / Descrição</th>
                                        <th scope="col">Quantidade</th>
                                        <th scope="col">Tipo de Pedido</th>
                                        <th scope="col">Observações</th>
                                        <th scope="col" style="width:10%;">Opções</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    <tr id="empty-row">
                                        <td colspan="5" class="align-middle text-center">Sem peças adicionadas...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 1992–<?php echo date("Y"); ?> Meiricarro, Lda.</p>
        <ul class="list-inline mt-2">
            <li class="list-inline-item"><a href="https://www.meiricarro.com">Website</a></li>
            <li class="list-inline-item"><a href="https://github.com/joseareia/task-conclusion">Source code</a></li>
            <li class="list-inline-item"><a href="mailto:jose.apareia@gmail.com">Support</a></li>
        </ul>
    </footer>
</main>
</body>
<script src="js/main.js"></script>
<script src="js/form-validation.js"></script>
<script src="js/stock.js"></script>
</html>
