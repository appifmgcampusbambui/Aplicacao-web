<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Noticia_model extends CI_Model {

		public $titulo;
		public $texto;
		public $data_hora_publicacao;
        public $usuario_publicacao;
        public $data_hora_atualizacao;
        public $usuario_atualizacao;
        public $qtd_visualizacoes;
        public $status;

		function __construct() {
			parent::__construct();
		}

		public function inserir($dados) {
        	return $this->db->insert('noticia', $dados);
		}

		public function alterarStatus($id) {
			$this->db->where('id', $id);
	        $this->db->set('status', 'CASE WHEN status="A" THEN "I" ELSE "A" END', false);
	        return $this->db->update('noticia');
		}

		public function salvarAlteracao($id, $dados) {
	        $this->db->where('id', $id);
	        return $this->db->update('noticia', $dados);
		}

		public function retornarNoticia($id) {
			$this->db->where('id', $id);
        	return $this->db->get('noticia')->result();
		}

		public function retornarTituloNoticia($id) {
			$this->db->select('id, titulo');
			$this->db->where('id', $id);
        	return $this->db->get('noticia')->result();
		}

		public function retornarNoticias($posicao = null, $registrosPorPagina = null, $status = null) {
			$this->db->select('n.id, n.titulo, date_format(n.data_hora_publicacao, "%d/%m/%Y %H:%i:%s") data_hora_publicacao, n.status, n.qtd_visualizacoes, u.nome autor');
			$this->db->join('usuario u', 'n.usuario_publicacao=u.id', 'inner');

			if ($status != null)
				$this->db->where('n.status', $status);

	        $this->db->order_by('n.data_hora_publicacao', 'DESC');

	        if ($posicao != null && $registrosPorPagina != null) {
	        	$this->db->limit($registrosPorPagina, $posicao);
	        }

	        return $this->db->get('noticia n')->result();
		}

		public function retornarQuantidadeDeNoticias() {
			return $this->db->count_all('noticia');
		}

		public function atualizarVisualizacoes($id) {
			$this->db->where('id', $id);
	        $this->db->set('qtd_visualizacoes', 'qtd_visualizacoes+1', false);
	        return $this->db->update('noticia');
		}
	}

?>