<?php

	class PostController
	{
		public function index($params)
		{
			try{
				$postagem = Postagem::selecionaPorId($params);


				//loader copiado do Twig(documentação externa)
				$loader = new \Twig\Loader\FilesystemLoader('app/View');
				$twig = new \Twig\Environment($loader);
				$template = $twig->load('single.html');

				$parametros = array();
				$parametros['id'] = $postagem->id;
				$parametros['titulo'] = $postagem->titulo;
				$parametros['conteudo'] = $postagem->conteudo;
				$parametros['comentarios'] = $postagem->comentarios;

				$conteudo = $template->render($parametros);
				echo $conteudo;
				//echo 'Home';
				

				//var_dump($colecPostagens);
			} catch (Exception $e){
			echo $e->getMessage();
			}

		}

		//Receber a requisição dos dados nome e postagem 'single.html'
		public function addComent()
		{
			try{
				Comentario::inserir($_POST);

				header('location: http://localhost/crud_mvc_php/?pagina=post&id='.$_POST['id']);
			} catch (Exception $e) {
				echo '<script>alert("'.$e->getMessage().'");</script>';
				echo '<script>location.href="http://localhost/crud_mvc_php/?pagina=post&id='.$_POST['id'].'"</script>';
			}
			
		}
	}