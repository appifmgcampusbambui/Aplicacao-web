<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Usuario_model extends CI_Model {

		public $nome;
		public $login;
		public $senha;
		public $email;
        public $tipo;
		public $status;
		public $ultimo_login;
		public $data_ult_atualizacao;
		public $usuario_ult_atualizacao;
		public $tentativas_login;
		
		function __construct() {

			//Método que cria todos os métodos da classe
			parent::__construct();
		}

		public function inserir($dados) {
        	return $this->db->insert('usuario', $dados);
		}

		public function excluir($id) {
			$this->db->where('id', $id);        
	        return $this->db->delete('usuario');
		}

		public function salvarAlteracao($id, $dados) {
	        $this->db->where('id', $id);
	        return $this->db->update('usuario', $dados);
		}

		public function alterarSenha($id, $senhaNova) {
	        $this->db->where('id', $id);
	        $this->db->set('senha', $senhaNova);
	        return $this->db->update('usuario');	        
	    }

		public function retornarSenhaAtual($id) {
			$this->db->select('senha');
	        $this->db->where('id', $id);
	        return $this->db->get('usuario')->result();
		}

		public function retornarUsuario($id) {
			$this->db->where('id', $id);
        	return $this->db->get('usuario')->result();
		}

		public function retornarUsuarioPorLoginEmail($login, $email) {
			$this->db->where('login', $login);
			$this->db->where('email', $email);
        	return $this->db->get('usuario')->result();
		}

		public function alterarUltimoLogin($id) {
			$this->db->where('id', $id);
			$this->db->set('ultimo_login', date("Y-m-d H:i:s"));
			$this->db->update('usuario');
		}

		public function registrarHistoricoLogin($dadosHistorico) {
			return $this->db->insert('historico_login', $dadosHistorico);
		}

		public function zerarTentativasLogin($id) {
			$this->db->where('id', $id);
	        $this->db->set('tentativas_login', 0);
	        return $this->db->update('usuario');
		}

		public function incrementarTentativasLogin($id) {
			$this->db->where('id', $id);
			$this->db->set('tentativas_login', '`tentativas_login` + 1', FALSE);
			return $this->db->update('usuario');
		}

		public function retornarTentativasRestantes($id) {
			$this->db->select('10 - `tentativas_login` AS qtd', FALSE);
			$this->db->where('id', $id);
			$row = $this->db->get('usuario')->row();
			return $row->qtd;
		}

		public function inativar($id) {
	        $this->db->where('id', $id);
	        $this->db->set('status', 'I');
	        return $this->db->update('usuario');	        
	    }
	}

?>