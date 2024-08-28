<?php 
@session_start();
$mostrar_registros = @$_SESSION['registros'];
$id_usuario = @$_SESSION['id'];
$nivel_usuario = @$_SESSION['nivel'];
require_once("../verificar.php");
require_once("../../conexao.php");

if($nivel_usuario == 'Escritório'){
	$id_usuario = 0;
	$mostrar_registros = 'Não';
}

$html = file_get_contents($url_sistema."painel/rel/balanco_anual.php?mostrar_registros=$mostrar_registros&id_usuario=$id_usuario&token=A5030");

//CARREGAR DOMPDF
require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

header("Content-Transfer-Encoding: binary");
header("Content-Type: image/png");

//INICIALIZAR A CLASSE DO DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', TRUE);
$pdf = new DOMPDF($options);


//Definir o tamanho do papel e orientação da página
$pdf->set_paper('A4', 'portrait');

//CARREGAR O CONTEÚDO HTML
$pdf->load_html($html);

//RENDERIZAR O PDF
$pdf->render();
//NOMEAR O PDF GERADO


$pdf->stream(
	'balanco_anual.pdf',
	array("Attachment" => false)
);

 ?>