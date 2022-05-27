<?php
//.............................................conexao..........................
	Class Pessoa
{

	private $pdo;

	public function __construct($dbname, $host, $user, $senha )
{
	try
{
	$this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
}
	catch(PDOException $e){
	echo "errrado errado:" .$e->getMessage();
	exit();
}
	catch(Exception $e)
{
	echo "errrado" .$e->getMessage();
	exit();
}
}

//..............................................lado direito buscar dados..............
	public function buscarDados()
{
	$res = array();
	$cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
	$res = $cmd->fetchALL(PDO::FETCH_ASSOC);
	return $res;
}
//..........................inserir dados e verificar se ja tem cadastro ...
	public function cadastrarPessoa($nome,$telefone,$email)
{
	$cmd= $this->pdo->prepare("SELECT id from pessoa WHERE email = :e");
	$cmd->bindValue(":e",$email);
	$cmd->execute();
	if($cmd->rowCount() > 0)
{ //email ja existe 
		return false;
}
	else 
{// nao foi encontrado o email duplicado
	$cmd=$this->pdo->prepare("INSERT INTO pessoa(nome,telefone,email) VALUES(:n, :t, :e)");
	$cmd->bindValue(":n", $nome);
	$cmd->bindValue(":t", $telefone);
	$cmd->bindValue(":e", $email);
	$cmd->execute();
	return true;
}
}
//.......................................exclui dados .......................
	public function excluirPessoa($id)
{
		$cmd =$this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
		$cmd->bindValue(":id",$id);
		$cmd->execute();
}
	//..................Busca dados de uma Pessoa- para o botao editar...........

	public function buscarDadosPessoa($id)
{
		$res = array();
		$cmd = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
		$cmd->bindValue(":id",$id);
		$cmd->execute();
		$res = $cmd->fetch(PDO::FETCH_ASSOC);
		return $res;
}

	//....................ATUALIZAR DADOS NO BANCO DE DADOS 

	public function atualizarDados($id, $nome, $telefone, $email)
{
	
        $cmd = $this->pdo->prepare("UPDATE pessoa SET nome = :n, telefone = :t, email = :e WHERE id = :id");
		$cmd->bindValue(":n",$nome);
		$cmd->bindValue(":t",$telefone);
		$cmd->bindValue(":e",$email);
		$cmd->bindValue(":id",$id);
		$cmd->execute();
}
}
?>