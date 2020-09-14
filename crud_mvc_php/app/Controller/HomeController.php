<?php

	class HomeController
	{
		public function index()
		{
			try{
				$colecPostagens = Postagem::selecionaTodos();

				//loader copiado do Twig(documentação externa)
				$loader = new \Twig\Loader\FilesystemLoader('app/View');
				$twig = new \Twig\Environment($loader);
				$template = $twig->load('home.html');

				$parametros = array();
				$parametros['postagens'] = $colecPostagens;

				$conteudo = $template->render($parametros);
				echo $conteudo;
				//echo 'Home';
				

				//var_dump($colecPostagens);
			} catch (Exception $e){
			echo $e->getMessage();
			}

		}
	}