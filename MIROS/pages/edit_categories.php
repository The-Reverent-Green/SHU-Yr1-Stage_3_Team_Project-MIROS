<?php
require_once __DIR__ . '/../database/db_config.php';

function fetchCategories($pdo) {
    $sql = "SELECT * FROM categories";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateCategoryTarget($pdo, $categoryId, $newTarget) {
    $sql = "UPDATE categories SET Target = :newTarget WHERE Category_ID = :categoryId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['newTarget' => $newTarget, 'categoryId' => $categoryId]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['target']) && isset($_POST['category_id'])) {
    updateCategoryTarget($pdo, $_POST['category_id'], $_POST['target']);
}

$categories = fetchCategories($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Category Targets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../includes/render_nav.js"></script>
    <style>
        .wrapper {
            margin: 0 auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* This makes sure that the table layout is fixed */
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        td {
            width: 20%; /* Divides the table into equal column widths */
        }
        form {
            margin: 0;
        }
        select {
            width: 100%;
            padding: 8px;
            margin: 4px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../includes/header.php'; ?>
    <nav id="navbar">Loading Navigation bar...</nav>
    <section class="vh-100">
        <br>
        <div class="container">
<h1>Change Category Targets</h1>

        <div class="wrapper">
        <table>
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Target</th>
                    <th>Minimum Score</th>
                    <th>Maximum Score</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= htmlspecialchars($category['Category_ID']) ?></td>
                    <td><?= htmlspecialchars($category['Category_Name']) ?></td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="category_id" value="<?= htmlspecialchars($category['Category_ID']) ?>">
                            <select name="target" onchange="this.form.submit()">
                                <?php for ($i = 1; $i <= 20; $i++): ?>
                                    <option value="<?= $i ?>"<?= $i == $category['Target'] ? ' selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </form>
                    </td>
                    <td><?= htmlspecialchars($category['score_min']) ?></td>
                    <td><?= htmlspecialchars($category['score_max']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        </div>
    </section>
    <script src="../js/interaction.js"></script>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>
<?php require("Script.php")?>
</html>
