function limpaCamposNovaSenha() {
    document.getElementById("frmNovaSenha").reset();
}

$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();

    $('#ModalNovaSenha').on('hide.bs.modal', function (e) {
        limpaCamposNovaSenha();
    });
    
    //Tenta gerar uma nova senha para o usuário
    $('#frmNovaSenha').submit(function() {    	
    	event.preventDefault();

		$.ajax({
        	beforeSend: function() {
        		$('#btnCancelarNovaSenha').attr('disabled', true);
				$('#btnNovaSenha').attr('disabled', true);
				$('#btnNovaSenha').html('Enviando...');
			},

    		url: base_url+'Usuario/novaSenha',
    		type: 'POST',
    		data: $('#frmNovaSenha').serialize(),
    		dataType: 'json',
    		success: function(data) {
    			if (data.status) {
    				limpaCamposNovaSenha();
                    $('#ModalNovaSenha').modal('hide');
    				alert('Solicitação realizada com sucesso! Uma nova senha foi enviada para o e-mail cadastrado.');
    			} else {
                    alert ('A solicitação não foi realizada, pois os dados informados não foram encontrados no sistema.');
                }

                $('#btnCancelarNovaSenha').attr('disabled', false);
                $('#btnNovaSenha').attr('disabled', false);
				$('#btnNovaSenha').html('Solicitar nova senha');
    		},
    		error: function(jqXHR, text, error) {
    			alert('Ocorreu um erro ao tentar gerar uma nova senha para o Usuário.');

    			$('#btnCancelarNovaSenha').attr('disabled', false);
    			$('#btnNovaSenha').attr('disabled', false);
				$('#btnNovaSenha').html('Solicitar nova senha');
    		}
    	});

        return false;
    });
});