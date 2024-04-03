<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Work</title>
    <link rel="stylesheet" href="../css/bootstrap.css">

</head>
<body>

<section class="container py-5">
    <h2>Submit Your Work</h2>
    <form action="submit_work.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select id="category" name="category" class="form-control" required>
            <?php
$stmt = $pdo->query("SELECT id, name FROM categories");
while ($row = $stmt->fetch()) {
    echo "<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>";
}
?>            </select>
        </div>
        <div class="mb-3">
            <label for="evidence" class="form-label">Evidence</label>
            <input type="file" name="evidence" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Here you can add JavaScript or jQuery code to handle dynamic loading of categories, etc.
</script>

</body>
</html>
