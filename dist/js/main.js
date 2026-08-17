$(document).ready(function() {
    const form = document.getElementById('form');

    if (form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            if (!form.checkValidity()) {
                event.stopPropagation();
                form.classList.add('was-validated');
                return;
            }

            $('#submitBtn').addClass('disabled');
            $('#submitBtn').text(' A enviar...');
            $('#submitBtn').prepend("<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>");

            $.ajax({
                method: 'POST',
                url: 'send-mail.php',
                cache: false,
                data: $(form).serialize(),
                success: function(data) {
                    let response = JSON.parse(data);
                    if (response['code'] === 200) {
                        alert("Registo enviado com sucesso.");
                    } else {
                        alert("Erro no envio do registo.\nCode: " + response['code'] + "\nInfo: " + response['message']);
                    }
                    clean();
                }
            });

            form.classList.add('was-validated');
        });
    }

    $('#resetBtn').click(function() {
        if (form) {
            form.classList.remove('was-validated');
        }
    });

    function clean() {
        $('#submitBtn').removeClass('disabled');
        $('#submitBtn').text('Enviar');
        $('.spinner-border').remove();
        form.classList.remove('was-validated');
        $('#resetBtn').click();
    }
});
