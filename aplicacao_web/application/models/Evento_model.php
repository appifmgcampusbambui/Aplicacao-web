<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Evento_model extends CI_Model {

		public $nome;
		public $descricao;
		public $data_inicial;
        public $data_final;
        public $hora_inicial;
        public $hora_final;
        public $local;
        public $arquivo_anexo;
        public $ativo;
        public $data_inclusao;
        public $usuario_inclusao;
        public $data_ult_atualizacao;
        public $usuario_ult_atualizacao;

		function __construct() {
			parent::__construct();
		}

		public function inserir($dados) {
        	return $this->db->insert('evento', $dados);
		}

		public function excluir($id) {
			$this->db->where('id', $id);
	        return $this->db->delete('evento');
		}

		public function salvarAlteracao($id, $dados) {
	        $this->db->where('id', $id);
	        return $this->db->update('evento', $dados);
		}

		public function retornarEvento($id) {
            $this->db->where('id', $id);
        	return $this->db->get('evento')->result();
		}

		public function retornarEventos($posicao = null, $registrosPorPagina = null) {
			$this->db->select('id, nome, date_format(cast(concat_ws(" ", data_inicial, hora_inicial) as datetime), "%d/%m/%Y %H:%i:%s") data_inicial, date_format(cast(concat_ws(" ", data_final, hora_final) as datetime), "%d/%m/%Y %H:%i:%s") data_final, descricao, ativo');

	        $this->db->order_by('data_inicial DESC, nome');

	        if ($posicao != null && $registrosPorPagina != null) {
	        	$this->db->limit($registrosPorPagina, $posicao);
	        }

	        return $this->db->get('evento')->result();
		}

		public function retornarQuantidadeDeEventos() {
			return $this->db->count_all('evento');
		}
	}

?>