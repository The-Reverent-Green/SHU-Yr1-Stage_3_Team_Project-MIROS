<?php
include __DIR__ . '/../database/db_config.php';

// Function to get valid combinations, adjusted for PDO from your db_config
function getValidCombinations($pdo) {
    $sql = "SELECT 
                c.Category_ID, 
                c.Category_Name,
                i.Item_ID, 
                i.Item_Name,
                si.Sub_Item_ID,
                si.Sub_Item_Name
            FROM 
                categories c
            LEFT JOIN items i ON c.Category_ID = i.Category_ID
            LEFT JOIN sub_items si ON i.Item_ID = si.Item_ID
            ORDER BY 
                c.Category_ID, 
                i.Item_ID, 
                si.Sub_Item_ID";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetching the valid combinations
$combinations = getValidCombinations($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Display</title>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 8px;
  text-align: left;
}
th {
  background-color: #f2f2f2;
}
</style>
</head>
<body>

<table>
    <tr>
        <th>Category ID</th>
        <th>Category Name</th>
        <th>Item ID</th>
        <th>Item Name</th>
        <th>Sub-Item ID</th>
        <th>Sub-Item Name</th>
    </tr>
    <?php foreach($combinations as $row): ?>
    <tr>
        <td><?= htmlspecialchars($row['Category_ID']) ?></td>
        <td><?= htmlspecialchars($row['Category_Name']) ?></td>
        <td><?= htmlspecialchars($row['Item_ID']) ?></td>
        <td><?= htmlspecialchars($row['Item_Name']) ?></td>
        <td><?= is_null($row['Sub_Item_ID']) ? 'N/A' : htmlspecialchars($row['Sub_Item_ID']) ?></td>
        <td><?= is_null($row['Sub_Item_Name']) ? 'N/A' : htmlspecialchars($row['Sub_Item_Name']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
