<?php require 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $pdo->prepare("DELETE FROM books WHERE book_id = ?")->execute([(int)$_POST['id']]);
    header('Location: index.php');
  } catch (PDOException $ex) {
    header('Location: index.php?err=1');  
  }
}