<?php 

    try {
        $pdo = new PDO("mysql:dbname=projeto_comentarios;host=localhost", "root","");
    } catch(PDOException $e){
        echo "ERRO: ".$e->getMessage();
        exit;
    }

if(isset($_POST['nome']) && !empty($_POST['nome']) ) {
    $nome = addslashes($_POST['nome']);
    $mensagem = addslashes($_POST['mensagem']);

    $sql = $pdo->prepare( " INSERT INTO mensagens SET nome = :nome, msg = :msg, data_msg = NOW() " );
    $sql->bindValue(":nome", $nome);
    $sql->bindValue(":msg", $mensagem);
    $sql->execute();

}

?>

<fieldset>
    <form method="POST">
        <label for="nome">Nome:</label> 
        <br>
        <input type="text" name="nome">
        <br><br>

        <label for="mensagem">Mensagem:</label> 
        <br>
        <textarea name="mensagem"></textarea> 
        <br><br>

        <button type="submit">Enviar Mensagem</button>
    </form>
</fieldset>
<br><br>


<?php 

$sql = "SELECT * FROM mensagens ORDER BY data_msg DESC";
$sql = $pdo->query($sql);
    if($sql->rowCount() > 0) {
        foreach ($sql->fetchAll() as $mensagem) :
    ?>
        <strong><?= $mensagem['nome']; ?></strong>
        <br>
        <p><?= $mensagem['msg']; ?></p>
        <br>
        <?= $mensagem['data_msg']; ?>
        <hr>
    <?php         
        endforeach;
    } else {
        echo "Não há mensagens.";
    }

?>
