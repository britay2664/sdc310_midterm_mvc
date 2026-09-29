<?php
function escape_html(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Brian Taylor SDC310 Midterm</title>
    <link rel="stylesheet" href="view/styles.css">
</head>
<body>
<h1>Brian Taylor SDC310 Midterm</h1>
<h2>Address List</h2>

<table>
    <tr>
        <th>Address #</th><th>First Name</th><th>Last Name</th>
        <th>Street</th><th>City</th><th>State</th><th>Zip</th>
        <th>Edit</th><th>Delete</th>
    </tr>
    <?php foreach ($addresses as $row): ?>
        <tr>
            <td><?= escape_html($row['AddressNo']) ?></td>
            <td><?= escape_html($row['First']) ?></td>
            <td><?= escape_html($row['Last']) ?></td>
            <td><?= escape_html($row['Street']) ?></td>
            <td><?= escape_html($row['City']) ?></td>
            <td><?= escape_html($row['State']) ?></td>
            <td><?= escape_html($row['Zip']) ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="address_no" value="<?= escape_html($row['AddressNo']) ?>">
                    <input type="submit" name="edit" value="Edit">
                </form>
            </td>
            <td>
                <form method="POST">
                    <input type="hidden" name="address_no" value="<?= escape_html($row['AddressNo']) ?>">
                    <input type="submit" name="delete" value="Delete">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<h2><?= $editing ? 'Edit Address' : 'Add New Address' ?></h2>
<form method="POST">
    <input type="hidden" name="address_no" value="<?= escape_html($address_no) ?>">
    <?php foreach ([
        'first' => ['First Name', 'First', 25],
        'last' => ['Last Name', 'Last', 30],
        'street' => ['Street', 'Street', 100],
        'city' => ['City', 'City', 25],
        'state' => ['State', 'State', 2],
        'zip' => ['Zip', 'Zip', 10],
    ] as $field => [$label, $column, $length]): ?>
        <p>
            <label for="<?= $field ?>"><?= $label ?>:</label><br>
            <input type="text" id="<?= $field ?>" name="<?= $field ?>"
                   value="<?= escape_html($form_address[$column]) ?>"
                   maxlength="<?= $length ?>" required>
        </p>
    <?php endforeach; ?>
    <input type="submit" name="<?= $editing ? 'update' : 'add' ?>"
           value="<?= $editing ? 'Update Address' : 'Add Address' ?>">
</form>
</body>
</html>
