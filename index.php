<?php
require_once 'pessoa.php';
$p = new Pessoa("crud","localhost","root","");
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>cadastro pessoa</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="stylo.css">
</head>
<body>

<?php
if(isset($_POST['nome']))
// .............CLICOU NO BOTAO CADASTRAR OU EDITAR ....................
{ 
//............................EDITAR...................................	
	if(isset($_GET['id_up']) && !empty($_GET['id_up'])) 
{

	$id_upd = addslashes($_GET['id_up']);
	$nome = addslashes($_POST['nome']); 
	$telefone= addslashes($_POST['telefone']);
	$email= addslashes($_POST['email']);

	if(!empty($nome) && !empty($telefone) && !empty($email))
{
	// EDITAR
	$p->atualizarDados($id_upd, $nome, $telefone, $email);
	header("location:index.php");
}
	else
{
	echo "preencha todos os campos";
}

}// ............CADASTRAR.......................
	else
{
	$nome = addslashes($_POST['nome']); 
	$telefone= addslashes($_POST['telefone']);
	$email= addslashes($_POST['email']);
	
	if(!empty($nome) && !empty($telefone) && !empty($email))
{    // cadastrar
	if($p->cadastrarPessoa($nome,$telefone,$email))
{
	echo "cadastro com sucesso";
} 
	else
{
	echo" Email ja cadastrado";
}
}  
	else
{
	echo "preencha todos os campos";
}
}
}


//.............COLAR COLAR COLAR????????????..................

/*$nome = addslashes($_POST['nome']); 
$telefone= addslashes($_POST['telefone']);
$email= addslashes($_POST['email']);

if(!empty($nome) && !empty($telefone) && !empty($email))
{// cadastrar
	if($p->cadastrarPessoa($nome,$telefone,$email))
{
	echo "cadastro com sucesso";
}   else
{
	echo" Email ja cadastrado";
}
}  
	else
{
	echo "preencha todos os campos";

//..............COLAR COLAR E APAGAR??????.........
}*/
?>
<?php
//.............................editar e atualiazar dados................
	if(isset($_GET['id_up'])) //clicou no botao editar e atualizar
{
	$id_update = addslashes($_GET['id_up']);
	$res = $p->buscarDadosPessoa($id_update);
}
?>


	<section id = "esquerda">
	<form method="POST">
	<h2>CADASTRAR PESSOA</h2>
	<label for= "nome">Nome</label>
	<input type="text" name="nome" id="nome" value="<?php if(isset($res)){echo $res['nome'];}?>">

	<label for= "telefone">Telefone</label>
	<input type="text" name="telefone" id="telefone" value="<?php if(isset($res)){echo $res['telefone'];}?>">

	<label for= "email">Email</label>
	<input type="email" name="email" id="email" value="<?php if(isset($res)){echo $res['email'];}?>">

	<input type="submit" value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";} ?> ">
	</form>
	</section>


	<section id = "direita">


	<table>
		<tr id="titulo">
			<td>Nome</td>
			<td>Telefone</td>
			<td colspan="2">Email</td>
		</tr>
<?php

	$dados=$p-> buscarDados();
	if(count($dados) > 0)
{//.....................pessoa cadastrada no banco 
	for ($i=0; $i < count($dados); $i++) 
{
		echo "<tr>";
	foreach ($dados[$i] as $k => $v)
{
	if ($k != "id") 
{
		echo "<td>" .$v. "</td>";
}	
}
?>

	<td>
	<a href="index.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a>
	<a href="index.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
	</td>

<?php
	echo "</tr>";
}
}
	else
{// ..................................o banco de dados esta vazio
    echo " ainda nao há pessoa cadastradas";
}
?>

	</table>
	</section>
	</body>
	</html>

<?php
//................................botões excluir dados.............. 
	if(isset($_GET['id']))
{
 	$id_pessoa = addslashes($_GET['id']);
 	$p->excluirPessoa($id_pessoa);
 	header("location : index.php");
}
?>