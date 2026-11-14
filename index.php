<?php
require 'config.php';


$search = $_GET['q'] ?? '';
$search = '%' . trim($search) . '%';


$sql = "SELECT b.book_id, b.title, b.author, b.genre, b.copies_available,
               COUNT(l.loan_id) AS times_borrowed
        FROM books b
        LEFT JOIN loans l ON l.book_id = b.book_id
        WHERE b.title LIKE ? OR b.author LIKE ?
        GROUP BY b.book_id
        ORDER BY times_borrowed DESC, b.title";


$stmt = $pdo->prepare($sql);
$stmt->execute([$search, $search]);
$books = $stmt->fetchAll();
?>

<h2>Books</h2>

<form>
  <input name="q" placeholder="Search title or author">
  <button>Search</button>
</form>

<p>
  <a href="book_form.php">+ Add book</a> |
  <a href="reports.php">Reports</a>
</p>

<?php if (isset($_GET['err'])) { ?>
  <p style="color:red">Cannot delete: this book has loan history.</p>
<?php } ?>

<table border="1" cellpadding="6">
  <tr>
    <th>Title</th><th>Author</th><th>Genre</th>
    <th>Copies</th><th>Times borrowed</th><th>Actions</th>
  </tr>

  <?php foreach ($books as $book) { ?>
    <tr>
      <td><?= e($book['title']) ?></td>
      <td><?= e($book['author']) ?></td>
      <td><?= e($book['genre']) ?></td>
      <td><?= e($book['copies_available']) ?></td>
      <td><?= e($book['times_borrowed']) ?></td>
      <td>
        <a href="book_form.php?id=<?= $book['book_id'] ?>">Edit</a>

        <form method="post" action="delete.php" style="display:inline"
              onsubmit="return confirm('Delete this book?')">
          <input type="hidden" name="id" value="<?= $book['book_id'] ?>">
          <button>Delete</button>
        </form>
      </td>
    </tr>
  <?php } ?>
</table>