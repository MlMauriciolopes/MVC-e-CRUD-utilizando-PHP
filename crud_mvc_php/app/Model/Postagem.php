<?php

	class Postagem
	{
		public static function selecionaTodos()
		{
			$con = Connection::getConn();

			$sql = "SELECT * FROM Postagem 	ORDER BY id DESC";
			$sql = $con->prepare($sql);
			$sql->execute();

			$resultado = array();

			//fetchObject: transforma array em objeto
			while ($row = $sql->fetchObject('Postagem')){
				$resultado[] = $row;
			}

			if (!$resultado) {
				throw new Exception(" Não foi encontrado nenhum registro no banco de dados");
			}

			return $resultado;
			//var_dump($sql->fetchall());
		}

		public static function selecionaPorId($idPost)
		{
			$con = Connection::getConn();

			//pega a postagem pelo id
			$sql = "SELECT * FROM postagem WHERE id = :id";
			$sql = $con->prepare($sql);
			$sql->bindValue(':id', $idPost, PDO::PARAM_INT);
			$sql->execute();

			//recebe o valor do resultado caso a encontre.
			$resultado = $sql->fetchObject('Postagem');

			if (!$resultado) {
				throw new Exception(" Não foi encontrado nenhum registro no banco de dados");
			} else {
				$resultado->comentarios = Comentario::selecionarComentarios($resultado->id);
				/*
				if (!$resultado->comentarios) {
					$resultado->comentarios = 'Não existe nenhum comentário para essa postagem !';
				}
				*/
			}

			return $resultado;
		}

		//Recebe parâmetros do formulário
		public static function insert($dadosPost)
		{
			//tratamento de erro 
			if (empty($dadosPost['titulo']) OR empty($dadosPost['conteudo'])) {
				throw new Exception("Preencha todos os campos !");

				return false;
			}

			$con = Connection::getConn();

			$sql = $con->prepare('INSERT INTO postagem (titulo, conteudo) VALUES (:tit, :cont)');
			$sql->bindValue(':tit', $dadosPost['titulo']);
			$sql->bindValue(':cont', $dadosPost['conteudo']);
			$res = $sql->execute();

			//var_dump($sql);

			//Verificar se cadastrou os dados, ou não
			if ($res == 0) {
				throw new Exception("Falha ao inserir os dados !");

				return false;

			}

			return false;
		}

		//receber parâmetros POST : id, titulo e conteúdo
		public static function update($parans)
		{
			$con = Connection ::getConn();

			$sql = "UPDATE postagem SET titulo = :tit, conteudo = :cont WHERE id = :id";
			$sql = $con->prepare($sql);
			$sql->bindValue(':tit',$parans['titulo']);
			$sql->bindValue(':cont',$parans['conteudo']);
			$sql->bindValue(':id',$parans['id']);
			$resultado = $sql->execute();

			if ($resultado == 0) {
				throw new Exception("Falha ao alterar publicação");

				return false;
				
			}

			return true;
		}

		//Model delete
		public static function delete($id)
		{
			$con = Connection ::getConn();

			$sql = "DELETE FROM postagem WHERE id = :id";
			$sql = $con->prepare($sql);
			$sql->bindValue(':id',$id);
			$resultado = $sql->execute();

			if ($resultado == 0) {
				throw new Exception("Falha ao deletar publicação");

				return false;
				
			}

			return true;
		}
	}