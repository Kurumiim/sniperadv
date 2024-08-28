<?php 
@session_start();
$mostrar_registros = @$_SESSION['registros'];
$id_usuario = @$_SESSION['id'];
require_once("../verificar.php");
require_once("../../conexao.php");

$texto = $_POST['texto'];
$cabecalho_form = @$_POST['cabecalho_form'];

//inserir o texto na tabela temporaria
$query = $pdo->prepare("INSERT INTO temp_texto SET texto = :texto");
$query->bindValue(":texto", "$texto");
$query->execute();
$id = $pdo->lastInsertId();

$html = file_get_contents($url_sistema."painel/rel/contrato.php?id=$id&mostrar_registros=$mostrar_registros&id_usuario=$id_usuario&token=A5030&cabecalho=$cabecalho_form");

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
	'contrato.pdf',
	array("Attachment" => false)
);

 ?>