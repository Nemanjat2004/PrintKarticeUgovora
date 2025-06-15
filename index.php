<?php
    include_once 'db.class.7.php'; // Uključivanje klase za rad sa bazom podataka

    $db = DBstambena();

    // Uzimanje svih ugovora iz tabele 'ugovori'
    $sql    = "SELECT * FROM ugovori";
    $result = $db->query($sql);
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Ugovori</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background: #eee; }
        a.button { padding: 5px 10px; background: #007bff; color: #fff; text-decoration: none; border-radius: 4px; }
        a.button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Tabela ugovora</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Naziv</th>
            <th>Datum</th>
            <th>Iznos</th>
            <th>Opcije</th>
        </tr>
<?php while ($row = $db->fetchNextObject($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row->id) ?></td>
                    <td><?php echo htmlspecialchars($row->broj_ugovora) ?></td>
                    <td><?php echo htmlspecialchars($row->datum_vazenja) ?></td>
                    <td><?php echo htmlspecialchars($row->ukupan_iznos) ?></td>
                    <td>
                        <a class="button" href="print_ugovor.php?id=<?php echo urlencode($row->id) ?>">Ispiši karticu</a>
                    </td>
                </tr>
            <?php endwhile; ?>

    </table>
</body>
</html>
<?php
$db->close();
?>