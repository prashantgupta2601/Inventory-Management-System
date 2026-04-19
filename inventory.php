<?php
include 'config.php';

$result = $conn->query("SELECT * FROM inventory ORDER BY last_updated DESC");

echo "<table class='w-full border-collapse'>
    <thead>
        <tr class='bg-gray-100'>
            <th class='p-3 text-left border-b'>Item Name</th>
            <th class='p-3 text-left border-b'>Quantity</th>
            <th class='p-3 text-left border-b'>Price</th>
            <th class='p-3 text-left border-b'>Last Updated</th>
        </tr>
    </thead>
    <tbody>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr class='hover:bg-gray-50'>
            <td class='p-3 border-b'>" . $row["name"] . "</td>
            <td class='p-3 border-b'>" . $row["quantity"] . "</td>
            <td class='p-3 border-b'>$" . number_format($row["price"], 2) . "</td>
            <td class='p-3 border-b'>" . $row["last_updated"] . "</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='4' class='p-3 text-center'>No items in inventory</td></tr>";
}

echo "</tbody></table>";

$conn->close();
?>