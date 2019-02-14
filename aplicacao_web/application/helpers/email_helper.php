<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
function enviar($destinatario, $assunto, $mensagem) {
	//O comando get_instance() retorna o acesso ao objeto global do CI
    //Como a biblioteca "email" já está no autoload, não precisa carregar explicitamente aqui
    $ci = & get_instance();

    //Preenche os dados específicos do e-mail
	$ci->email->from('cesecbd@gmail.com', 'SISAE/IFMG');
	$ci->email->to($destinatario);
	$ci->email->subject($assunto);
	$ci->email->message($mensagem);
	
	return $ci->email->send();
}