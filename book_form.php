<?php require 'config.php';
$id = (int)($_GET['id'] ?? 0);
$book = ['title'=>'','author'=>'','genre'=>'','copies_available'=>1];
if ($id) {
  $s = $pdo->prepare("SELECT * FROM books WHERE book_id = ?");
  $s->execute([$id]);
  $book = $s->fetch() ?: $book;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = [trim($_POST['title']), trim($_POST['author']), trim($_POST['genre']), (int)$_POST['copies']];
  if ($id) {
    $pdo->prepare("UPDATE books SET title=?, author=?, genre=?, copies_available=? WHERE book_id=?")
        ->execute([...$data, $id]);
  } else {
    $pdo->prepare("INSERT INTO books (title, author, genre, copies_available) VALUES (?,?,?,?)")
        ->execute($data);
  }
  header('Location: index.php'); exit;
}
?>
<h2><?= $id ? 'Edit' : 'Add' ?> book</h2>
<form method="post">
  Title <input name="title" required value="<?= e($book['title']) ?>"><br>
  Author <input name="author" required value="<?= e($book['author']) ?>"><br>
  Genre <input name="genre" value="<?= e($book['genre']) ?>"><br>
  Copies <input type="number" name="copies" min="0" value="<?= e($book['copies_available']) ?>"><br>
  <button>Save</button> <a href="index.php">Cancel</a>
</form>