<?php

	class Core
	{
		public function start($urlGet)
		{
			//Verificar se existe o parâmetro 'método'
			if (isset($urlGet['metodo'])) {
				$acao = $urlGet['metodo'];
			} else {
				$acao = 'index';
			}

			//chama a página com o nome da classe na barra de endereço
			//ucfirst deixa a primeira letra maiuscula
			if (isset($urlGet['pagina'])){
			$controller = ucfirst($urlGet['pagina'].'Controller');
		} else {
			$controller = 'HomeController';
		}
			

			
			//Controller de erro de página
			if (!class_exists($controller)) {
				$controller = 'ErroController';
			}

			//Chamar o método e a HomeController 
			//Primeiro parâmetro: nome da classe, Segundo parâmetro: nome do método, Terceiro parâmetro: valor da postegem

			if (isset($urlGet['id']) && $urlGet['id'] != null){
				$id = $urlGet['id'];
			} else {
				$id = null;
			}

			//var_dump($controller);
			//pega as informações da url
			call_user_func_array(array(new $controller, $acao), array('id' => $id));

				//echo $controller;



		}
	}