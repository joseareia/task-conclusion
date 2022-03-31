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
              <main>
                <div class="row g-5">
                    <div class="col-md-12 col-lg-12">
                        <h4 class="mb-4">Registo de conclusão de tarefas</h4>
                        <form class="needs-validation" novalidate action="send-mail.php" method="POST" id="form">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="colaborador" class="form-label">Colaborador</label>
                                    <select class="form-select" id="colaborador" required name="colaborador">
                                        <option value="" hidden selected disabled>Escolha um colaborador...</option>
                                        <option value="Alexandre">Alexandre</option>
                                        <option value="Carlos">Carlos</option>
                                        <option value="Eunice">Eunice</option>
                                        <option value="João">João</option>
                                        <option value="Mauro">Mauro</option>
                                        <option value="Nicolas">Nicolas</option>
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
                                        <option value="Intervenções Técnicos">Intervenções Técnicas</option>
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
                                    <input type="or" class="form-control" id="or" placeholder="00000" name="or" value="00000">
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
                </main>

                <footer class="my-5 pt-5 text-muted text-center text-small fixed-bottom">
                    <p class="mb-1">&copy; 1992–<?php echo date("Y"); ?> Meiricarro, Lda.</p>
                    <ul class="list-inline mt-2">
                        <li class="list-inline-item"><a href="https://www.meiricarro.com">Website</a></li>
                        <li class="list-inline-item"><a href="https://github.com/joseareia/task-conclusion">Source code</a></li>
                        <li class="list-inline-item"><a href="mailto:jose.apareia@gmail.com">Support</a></li>
                    </ul>
                </footer>
            </div>
        </div>
    </main>
    </body>
    <script src="js/main.js"></script>
    <script src="js/form-validation.js"></script>
</html>
