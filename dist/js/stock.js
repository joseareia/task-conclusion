$(document).ready(function() {
    const parts = [];
    const table = document.getElementById("table-body");

    $('#adicionar-peca').click(function() {
        let reference = $('#reference').val();
        let quantity = $('#quantity').val();
        let part_type = $('#pedido_peca').find(":selected").val();
        let or = $('#or_peca').val();
        let license_plate = $('#matricula_peca').val();
        let observations = $('#obs').val();
        let user = $('#colaborador-peca').find(":selected").val();

        if (!reference || !quantity || !part_type || !) return;
        if ((part_type === "OSV" && !or) || (part_type === "Matrícula" && !license_plate)) return;

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
        $('#empty-row').remove();

        // Inserts new row with the information
        let row = table.insertRow();
        let ref_row = row.insertCell(0); ref_row.innerHTML = reference;
        let qua_row = row.insertCell(1); qua_row.innerHTML = quantity;
        let par_row = row.insertCell(2);

        switch (part_type) {
            case "OSV":
                par_row.innerHTML = pt + ": #" + o;
            break;
            case "Matrícula":
                par_row.innerHTML = pt + ": " + m;
            break;
            default:
                par_row.innerHTML = pt;
        }

        let obs_row = row.insertCell(3); obs_row.innerHTML = !ob ? "-" : ob;
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

    $("#enviar-peca").click(function() {
        if (p.lenght == 0) return;
        if(confirm("Têm a certeza do envio das peças registadas?")) {
            $.ajax({
                method: 'POST',
                url: 'send-parts-mail.php',
                cache: false,
                data: JSON.stringify(p),
                success: function(data) {
                    let response = JSON.parse(data);
                    if (response['code'] === 200) {
                        alert("Pedido enviado com sucesso.");
                    } else {
                        alert("Erro no envio do pedido.\nCode: " + response['code'] + "\nInfo: " + response['message']);
                    }
                    window.location.reload();
                }
            });
        }
    });
});
