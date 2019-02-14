function limpaCamposSenha() {
    document.getElementById("frmAlterarSenha").reset();
}

function limpaCamposUsuario() {
    document.getElementById("frmAlterarUsuario").reset();
}

$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();

    $('#ModalAlterarSenha').on('hide.bs.modal', function (e) {
        limpaCamposSenha();
    });

    $('#ModalAlterarUsuario').on('hide.bs.modal', function (e) {
        limpaCamposUsuario();
    });
    
    //Salva a alteração de senha do Usuário
    $('#frmAlterarSenha').submit(function() {
    	event.preventDefault();
        $.ajax({
    		url: base_url+'Usuario/alterarSenha',
    		type: 'POST',
    		data: $('#frmAlterarSenha').serialize(),
    		dataType: 'json',
    		success: function(data) {
    			if(data.status) {
    				limpaCamposSenha();
                    $('#ModalAlterarSenha').modal('hide');
    				alert('A senha foi alterada com sucesso!');
    			} else {
                    alert ('A senha atual informada não está correta.');
                }
    		},
    		error: function(jqXHR, text, error){
    			alert('Ocorreu um erro ao tentar salvar os dados do aluno.');
    		}
    	});
        return false;
    });

    //Busca os dados do Usuário quando clica para alterar
    $(document).on('click', '#btnAlterarUsuario', function(){  
        var idUsuario = $(this).attr('name');  
        $.ajax({  
            url: base_url+'Usuario/retornarUsuario',
            method: 'POST',  
            data: {idUsuario: idUsuario},  
            dataType: 'json',  
            success: function(data) {  
                $('#txtNome').val(data[0].nome);
                $('#txtLogin').val(data[0].login);
                $('#txtEmail').val(data[0].email);
                $('#ModalAlterarUsuarioTitle').text('Meus dados');
                $('#ModalAlterarUsuario').modal('show');
            },
            error: function() {
                alert('Ocorreu um erro ao buscar os dados do Usuário.');
            }
        });  
    });

    //Salva a alteração dos dados do Usuário
    $('#frmAlterarUsuario').submit(function() {
        event.preventDefault();
        $.ajax({
            url: base_url+'Usuario/alterar',
            type: 'POST',
            data: $('#frmAlterarUsuario').serialize(),
            dataType: 'json',
            success: function(data) {
                if (data.status) {
                    limpaCamposUsuario();

                    //Altera o nome do Usuário na barra de menu
                    $('#mnUsuario').text(data.nomeUsuario);

                    $('#ModalAlterarUsuario').modal('hide');
                    alert('Os dados do Usuário foram alterados com sucesso!');
                }
            },
            error: function(jqXHR, text, error){
                alert('Ocorreu um erro ao tentar salvar os dados do Usuário.');
            }
        });
        return false;
    });
});