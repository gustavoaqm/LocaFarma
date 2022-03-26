<?php
$pdo = new PDO("mysql:host=localhost; dbname=dblocafarma; charset=utf8;", "root", "");
$dados = $pdo->prepare("SELECT nome FROM tb_medicamento_anvisa GROUP BY nome");
// ASC LIMIT 7
$dados->execute();
echo json_encode($dados->fetchAll(PDO::FETCH_ASSOC));
?>

