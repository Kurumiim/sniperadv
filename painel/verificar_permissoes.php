<?php 

@session_start();
$id_usuario = $_SESSION['id'];

$home = 'ocultar';
$configuracoes = 'ocultar';
$caixas = 'ocultar';
$tarefas = 'ocultar';
$lancar_tarefas = 'ocultar';
$abertura_contratos = 'ocultar';
$rel_contratos = 'ocultar';
$processos = 'ocultar';
$processos_andamento = 'ocultar';
$audiencias = 'ocultar';

//grupo pessoas
$usuarios = 'ocultar';
$fornecedores = 'ocultar';
$funcionarios = 'ocultar';
$clientes = 'ocultar';


//grupo cadastros
$grupo_acessos = 'ocultar';
$acessos = 'ocultar';
$frequencias = 'ocultar';
$cargos = 'ocultar';
$formas_pgto = 'ocultar';
$tipos_servicos = 'ocultar';
$contratos = 'ocultar';

//grupo financeiro
$receber = 'ocultar';
$pagar = 'ocultar';
$rel_financeiro = 'ocultar';
$rel_sintetico_despesas = 'ocultar';
$rel_sintetico_receber = 'ocultar';
$rel_balanco = 'ocultar';
$rel_inadimplementes = 'ocultar';


//grupo contas
$edicao_contas = 'ocultar';
$exclusao_contas = 'ocultar';
$detalhes_contas = 'ocultar';
$arquivos_contas = 'ocultar';
$baixar_contas = 'ocultar';
$parcelar_contas = 'ocultar';
$recibos_contas = 'ocultar';
$inserir_contas = 'ocultar';
$cobrar_contas = 'ocultar';

//grupo processos
$inserir_processos = 'ocultar';
$editar_processos = 'ocultar';
$excluir_processos = 'ocultar';
$arquivos_processos = 'ocultar';
$historico_processos = 'ocultar';
$mov_processos = 'ocultar';
$detalhamento_processos = 'ocultar';
$valores_processos = 'ocultar';


//grupo abertura contratos
$inserir_ab = 'ocultar';
$editar_ab = 'ocultar';
$excluir_ab = 'ocultar';
$finalizado_ab = 'ocultar';
$arquivos_ab = 'ocultar';
$contas_ab = 'ocultar';
$pdf_ab = 'ocultar';
$contrato_ab = 'ocultar';


//grupo clientes
$inserir_clientes = 'ocultar';
$editar_clientes = 'ocultar';
$excluir_clientes = 'ocultar';
$arquivos_clientes = 'ocultar';
$contas_clientes = 'ocultar';
$whatsapp_clientes = 'ocultar';
$detalhes_clientes = 'ocultar';
$copiar_clientes = 'ocultar';
$senha_clientes = 'ocultar';
$exportar_clientes = 'ocultar';


$query = $pdo->query("SELECT * FROM usuarios_permissoes where usuario = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	for($i=0; $i < $total_reg; $i++){
		foreach ($res[$i] as $key => $value){}
		$permissao = $res[$i]['permissao'];

		$query2 = $pdo->query("SELECT * FROM acessos where id = '$permissao'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$nome = @$res2[0]['nome'];
		$chave = @$res2[0]['chave'];
		$id = @$res2[0]['id'];

		if($chave == 'home'){
			$home = '';
		}

		if($chave == 'configuracoes'){
			$configuracoes = '';
		}

		if($chave == 'caixas'){
			$caixas = '';
		}

		if($chave == 'tarefas'){
			$tarefas = '';
		}

		if($chave == 'lancar_tarefas'){
			$lancar_tarefas = '';
		}

		if($chave == 'abertura_contratos'){
			$abertura_contratos = '';
		}

		if($chave == 'rel_contratos'){
			$rel_contratos = '';
		}

		if($chave == 'processos'){
			$processos = '';
		}

		if($chave == 'processos_andamento'){
			$processos_andamento = '';
		}

		if($chave == 'audiencias'){
			$audiencias = '';
		}







	
		if($chave == 'usuarios'){
			$usuarios = '';
		}

		if($chave == 'fornecedores'){
			$fornecedores = '';
		}

		if($chave == 'funcionarios'){
			$funcionarios = '';
		}

		if($chave == 'clientes'){
			$clientes = '';
		}

		if($chave == 'exportar_clientes'){
			$exportar_clientes = '';
		}





		if($chave == 'grupo_acessos'){
			$grupo_acessos = '';
		}

		if($chave == 'acessos'){
			$acessos = '';
		}

		if($chave == 'frequencias'){
			$frequencias = '';
		}

		if($chave == 'cargos'){
			$cargos = '';
		}

		if($chave == 'formas_pgto'){
			$formas_pgto = '';
		}

		if($chave == 'tipos_servicos'){
			$tipos_servicos = '';
		}

		if($chave == 'contratos'){
			$contratos = '';
		}



		if($chave == 'receber'){
			$receber = '';
		}


		if($chave == 'pagar'){
			$pagar = '';
		}

		if($chave == 'rel_financeiro'){
			$rel_financeiro = '';
		}

		if($chave == 'rel_sintetico_receber'){
			$rel_sintetico_receber = '';
		}

		if($chave == 'rel_sintetico_despesas'){
			$rel_sintetico_despesas = '';
		}

		if($chave == 'rel_balanco'){
			$rel_balanco = '';
		}

		if($chave == 'rel_inadimplementes'){
			$rel_inadimplementes = '';
		}




		if($chave == 'edicao_contas'){
			$edicao_contas = '';
		}

		if($chave == 'exclusao_contas'){
			$exclusao_contas = '';
		}

		if($chave == 'detalhes_contas'){
			$detalhes_contas = '';
		}

		if($chave == 'arquivos_contas'){
			$arquivos_contas = '';
		}

		if($chave == 'baixar_contas'){
			$baixar_contas = '';
		}

		if($chave == 'parcelar_contas'){
			$parcelar_contas = '';
		}

		if($chave == 'recibos_contas'){
			$recibos_contas = '';
		}


		if($chave == 'inserir_contas'){
			$inserir_contas = '';
		}

		if($chave == 'cobrar_contas'){
			$cobrar_contas = '';
		}






		if($chave == 'inserir_processos'){
			$inserir_processos = '';
		}

		if($chave == 'editar_processos'){
			$editar_processos = '';
		}


		if($chave == 'excluir_processos'){
			$excluir_processos = '';
		}


		if($chave == 'arquivos_processos'){
			$arquivos_processos = '';
		}

		if($chave == 'historico_processos'){
			$historico_processos = '';
		}


		if($chave == 'mov_processos'){
			$mov_processos = '';
		}


		if($chave == 'detalhamento_processos'){
			$detalhamento_processos = '';
		}


		if($chave == 'valores_processos'){
			$valores_processos = '';
		}




		if($chave == 'inserir_ab'){
			$inserir_ab = '';
		}


		if($chave == 'editar_ab'){
			$editar_ab = '';
		}


		if($chave == 'excluir_ab'){
			$excluir_ab = '';
		}


		if($chave == 'finalizado_ab'){
			$finalizado_ab = '';
		}

		if($chave == 'arquivos_ab'){
			$arquivos_ab = '';
		}


		if($chave == 'contas_ab'){
			$contas_ab = '';
		}


		if($chave == 'pdf_ab'){
			$pdf_ab = '';
		}


		if($chave == 'contrato_ab'){
			$contrato_ab = '';
		}




		if($chave == 'inserir_clientes'){
			$inserir_clientes = '';
		}


		if($chave == 'editar_clientes'){
			$editar_clientes = '';
		}


		if($chave == 'excluir_clientes'){
			$excluir_clientes = '';
		}


		if($chave == 'arquivos_clientes'){
			$arquivos_clientes = '';
		}


		if($chave == 'contas_clientes'){
			$contas_clientes = '';
		}


		if($chave == 'whatsapp_clientes'){
			$whatsapp_clientes = '';
		}


		if($chave == 'detalhes_clientes'){
			$detalhes_clientes = '';
		}


		if($chave == 'copiar_clientes'){
			$copiar_clientes = '';
		}

		if($chave == 'senha_clientes'){
			$senha_clientes = '';
		}


		if($chave == 'exportar_clientes'){
			$exportar_clientes = '';
		}


	}

}



$pag_inicial = '';
if($home != 'ocultar'){
	$pag_inicial = 'home';
}else{
	$query = $pdo->query("SELECT * FROM usuarios_permissoes where usuario = '$id_usuario'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);	
	if($total_reg > 0){
		for($i=0; $i<$total_reg; $i++){
			$permissao = $res[$i]['permissao'];		
			$query2 = $pdo->query("SELECT * FROM acessos where id = '$permissao'");
			$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
			if($res2[0]['pagina'] == 'Não'){
				continue;
			}else{
				$pag_inicial = $res2[0]['chave'];
				break;
			}	
				
		}
				

	}else{
		echo 'Você não tem permissão para acessar nenhuma página, acione o administrador!';
		echo '<br>';
		echo '<a href="../index.php">Clique aqui</a> para ir para o Login!';
		echo "<script>localStorage.setItem('id_usu', '')</script>";
		exit();
	}
}



if($usuarios == 'ocultar' and $funcionarios == 'ocultar' and $fornecedores == 'ocultar' and $clientes == 'ocultar'){
	$menu_pessoas = 'ocultar';
}else{
	$menu_pessoas = '';
}


if($grupo_acessos == 'ocultar' and $acessos == 'ocultar' and $cargos == 'ocultar' and $frequencias == 'ocultar' and $formas_pgto == 'ocultar' and $tipos_servicos == 'ocultar' and $contratos == 'ocultar'){
	$menu_cadastros = 'ocultar';
}else{
	$menu_cadastros = '';
}


if($receber == 'ocultar' and $pagar == 'ocultar' and $rel_balanco == 'ocultar' and $rel_sintetico_despesas == 'ocultar' and $rel_sintetico_receber == 'ocultar' and $rel_financeiro == 'ocultar' and $rel_inadimplementes == 'ocultar'){
	$menu_financeiro = 'ocultar';
}else{
	$menu_financeiro = '';
}




?>