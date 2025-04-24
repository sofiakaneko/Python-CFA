<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Management</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        /* Background */
        body {
            background: url('./img/bird.jpeg') no-repeat center center fixed;
            background-size: cover;
            padding: 40px;
            font-family: Arial, sans-serif;
        }

        /* Back Button */
        .back-button {
            display: inline-block;
            background-color: #333;
            color: #fff;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
            margin-bottom: 20px;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #555;
        }

        /* Header */
        h2 {
            text-align: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            border-radius: 8px;
        }

        /* Table */
        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        th {
            background-color: #fbb03b;
            color: black;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        tr.no-data td {
            text-align: center;
            font-style: italic;
            color: #888;
        }

        @media screen and (max-width: 768px) {
            table {
                width: 100%;
            }
            th, td {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

    <a href="admin_dashboard.php" class="back-button">← Back to Dashboard</a>

    <h2>Payment List</h2>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Card Number</th>
                <th>Expiry Month</th>
                <th>Expiry Year</th>
                <th>CVV</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "sneaker_store";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT name, phone, address, card_number, expiry_month, expiry_year FROM payments";
            $result = $conn->query($sql);

            if (!$result) {
                die("Query failed: " . $conn->error);
            }

            $serialNumber = 1;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $maskedCard = '**** **** **** ' . substr($row["card_number"], -4);
                    echo "<tr>";
                    echo "<td>" . $serialNumber . "</td>";
                    echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["phone"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["address"]) . "</td>";
                    echo "<td>" . $maskedCard . "</td>";
                    echo "<td>" . htmlspecialchars($row["expiry_month"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["expiry_year"]) . "</td>";
                    echo "</tr>";
                    $serialNumber++;
                }
            } else {
                echo "<tr class='no-data'><td colspan='7'>No payments found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>

</body>
</html>
