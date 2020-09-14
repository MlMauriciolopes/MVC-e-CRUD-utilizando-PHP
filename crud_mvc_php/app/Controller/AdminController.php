<?php

	class AdminController
	{
		public function index()
		{
				//loader copiado do Twig(documentação externa)
				$loader = new \Twig\Loader\FilesystemLoader('app/View');
				$twig = new \Twig\Environment($loader);
				$template = $twig->load('admin.html');

				$objPostagens = Postagem::selecionaTodos();

				$parametros = array();
				$parametros['postagens'] = $objPostagens;
				
				$conteudo = $template->render($parametros);
				echo $conteudo;
		}

		public function create()
		{
				//loader copiado do Twig(documentação externa)
				$loader = new \Twig\Loader\FilesystemLoader('app/View');
				$twig = new \Twig\Environment($loader);
				$template = $twig->load('create.html');

				$parametros = array();
				
				$conteudo = $template->render($parametros);
				echo $conteudo;
		}

		//recebe os dados do formulário
		public function insert ()
		{
			try {
				Postagem::insert($_POST);

				echo '<script>alert("Publicação inserida com sucesso !");</script>';
				echo '<script>location.href="http://localhost/crud_mvc_php/?pagina=admin&metodo=index"</script>';
			} catch (Exception $e) {
				echo '<script>alert("'.$e->getMessage().'");</script>';
				echo '<script>location.href="http://localhost/crud_mvc_php/?pagina=admin&metodo=create"</script>';

			}
			
		}

		//Função alterar
		public function change($paramId)
		{
			$loader = new \Twig\Loader\FilesystemLoader('app/View');
			$twig = new \Twig\Environment($loader);
			$template = $twig->load('update.html');

			//Retorna o Objeto Postagem
			$post = Postagem::selecionaPorId($paramId);



			$parametros = array();
			//pegar a informação da postagem e do título
			$parametros['id'] = $post->id;
			$parametros['titulo'] = $post->titulo;
			$parametros['conteudo'] = $post->conteudo;

				
			$conteudo = $template->render($parametros);
			echo $conteudo;
		}

		//Alterar dados
		public function update()
		{
			try {
				Postagem::update($_POST);

				echo '<script>alert("Publicação alterada com sucesso !");</script>';
				echo '<script>location.href="http://localhost/crud_mvc_php/?pagina=admin&metodo=index"</script>';
			} catch (Exception $e) {
				echo '<script>alert("'.$e->getMessage().'");</script>';
				echo '<script>location.href="http://localhost/crud_mvc_php/?pagina=admin&metodo=change&id='.$_POST['id'].'"</script>';
			}

		}

		//Deletar dados
		public function delete($paramId)
		{
			try {
				//$id = $_GET['id'];
			 	Postagem::delete($paramId);

			 	echo '<script>alert("Publicação deletada com sucesso !");</script>';
				echo '<script>location.href="http://localhost/crud_mvc_php/?pagina=admin&metodo=index"</script>';
			} catch (Exception $e) {
				echo '<script>alert("'.$e->getMessage().'");</script>';
				echo '<script>location.href="http://localhost/crud_mvc_php/?pagina=admin&metodo=index"</script>';

			}
			
		}
	}