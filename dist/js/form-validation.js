$(document).ready(function() {
    $('#submitBtn').unbind().bind('click', function(e) {
        let formData = $('#form').serialize();
        let forms = document.querySelectorAll('.needs-validation');

        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                if (!form.checkValidity()) {
                    event.stopPropagation();
                } else {
                    $('#submitBtn').addClass('disabled');
                    $('#submitBtn').text(' A enviar...');
                    $('#submitBtn').prepend("<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>");
                    $.ajax({
                        method: 'POST',
                        url: 'send-mail.php',
                        cache: false,
                        data: formData,
                        success: function(data) {
                            let response = JSON.parse(data);
                            if (response['code'] === 200) {
                                alert("Registo enviado com sucesso.");
                            } else {
                                alert("Erro no envio do registo.\nCode: " + response['code'] + "\nInfo: " + response['message']);
                            }
                            clean();
                            // window.location.reload();
                        }
                    });
                }
                form.classList.add('was-validated');
            }, false);
        });
    });

    $('#resetBtn').click(function() {
        let forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.classList.remove('was-validated');
        });
    });

    function clean() {
        $('#submitBtn').removeClass('disabled');
        $('#submitBtn').text('Enviar');
        $('.spinner-border').remove();
        form.classList.remove('was-validated');
        $('#resetBtn').click();
    }
});
