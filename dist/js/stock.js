$(document).ready(function() {
    const parts = [];
    const table = document.getElementById("table-body");

    // Input fields
    const reference_input = $('#reference');
    const quantity_input = $('#quantity');
    const part_type_input = $('#pedido_peca');
    const or_input = $('#or_peca');
    const license_plate_input = $('#matricula_peca');
    const observations_input = $('#obs');
    const user_input = $('#colaborador_peca');

    const required_inputs = [reference_input, quantity_input];

    $('#adicionar-peca').click(function() {
        let reference = reference_input.val();
        let quantity = quantity_input.val();
        let part_type = part_type_input.find(":selected").val();
        let or = or_input.val();
        let license_plate = license_plate_input.val();
        let observations = observations_input.val();
        let user = user_input.find(":selected").val();

        // Input validations - True if an error has found
        if(validateInputs()) return;

        // Push the new information as JSON to the array of parts
        let parts_info = {
            "reference": reference,
            "quantity": quantity,
            "part_type": part_type,
            "or": or,
            "license_plate": license_plate,
            "obs": observations,
            "user": user
        }
        parts.push(parts_info);

        // Clears empty information on the table
        $('#empty-row').addClass("hide");

        // Inserts new row with the information
        let row = table.insertRow();
        let ref_row = row.insertCell(0); ref_row.innerHTML = reference;
        let qua_row = row.insertCell(1); qua_row.innerHTML = quantity;
        let par_row = row.insertCell(2);

        switch (part_type) {
            case "OSV":
                par_row.innerHTML = part_type + ": #" + or;
            break;
            case "Matrícula":
                par_row.innerHTML = part_type + ": " + license_plate;
            break;
            default:
                par_row.innerHTML = part_type;
        }

        let obs_row = row.insertCell(3); obs_row.innerHTML = !observations ? "-" : observations;
        let opt_row = row.insertCell(4); opt_row.innerHTML = "Eliminar"; opt_row.className = "delete-row";
    });

    $("#pedido_peca").on('change', function() {
        switch (this.value) {
            case "Matrícula":
                $("#osv_peca_div").css("display", "none");
                $("#matricula_peca_div").css("display", "block");
                break;
            case "OSV":
                $("#matricula_peca_div").css("display", "none");
                $("#osv_peca_div").css("display", "block");
                break;
            default:
                $("#matricula_peca_div").css("display", "none");
                $("#osv_peca_div").css("display", "none");
                break;
        }
    });

    $("#submitParts").click(function() {
        if (parts.lenght == 0) return;
        if(confirm("Têm a certeza do envio das peças registadas?")) {

            // Submit button disable and add spinner
            $('#submitParts').addClass('disabled');
            $('#submitParts').text(' A enviar...');
            $('#submitParts').prepend("<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>");

            // Sends array of parts to email
            $.ajax({
                method: 'POST',
                url: 'send-parts-mail.php',
                cache: false,
                data: JSON.stringify(parts),
                success: function(data) {
                    let response = JSON.parse(data);
                    if (response['code'] === 200) {
                        alert("Pedido enviado com sucesso.");
                    } else {
                        alert("Erro no envio do pedido.\nCode: " + response['code'] + "\nInfo: " + response['message']);
                    }
                    cleanButtonStyle();
                    parts.splice(0, parts.length);
                    window.location.reload();
                }
            });
        }
    });

    $(document).on("click", ".delete-row", function() {
        $(this).parent().remove();
        if ($("#table-body").find("tr").length == 1) $('#empty-row').removeClass("hide");

        let reference = $(this).parent().children()[0].innerHTML;
        let part_type = $(this).parent().children()[2].innerHTML;

        parts.forEach((i) => { if(i.reference === reference && i.part_type === part_type) parts.splice(parts.indexOf(i), 1) });
    });

    $("#stock-parts").on("keyup change", ".form-control.is-invalid", function() {
        if ($(this).val().length > 0) {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $(this).next().css('display', 'none');
        }
    });

    $("#stock-parts").on("keyup change", ".form-control.is-valid", function() {
        if ($(this).val().length == 0) {
            $(this).removeClass('is-valid').addClass('is-invalid');
            $(this).next().css('display', 'block');
        }
    });

    $("#stock-parts").on("change", ".form-select.is-invalid", function() {
        $(this).removeClass('is-invalid').addClass('is-valid');
        $(this).next().css('display', 'none');
    });

    const cleanButtonStyle = () => {
        $('#submitParts').removeClass('disabled');
        $('#submitParts').text('Enviar');
        $('.spinner-border').remove();
    }

    const validateInputs = () => {
        let error = false;

        // Required inputs
        required_inputs.forEach((i) => { if (!i.val()) error = errorHandler(i); });

        // Other selects
        if (part_type_input.find(":selected").val()) {
            switch (part_type_input.val()) {
                case 'OSV':
                    if(!or_input.val()) error = errorHandler(or_input);
                    break;
                case 'Matrícula':
                    if(!license_plate_input) error = errorHandler(license_plate_input);
                    break;
            }
        } else {
            error = errorHandler(part_type_input);
        }

        if (!user_input.find(":selected").val()) error = errorHandler(user_input);

        return error;
    }

    const errorHandler = (o) => {
        o.addClass('is-invalid');
        o.next().css('display', 'block');
        return true;
    }
});
