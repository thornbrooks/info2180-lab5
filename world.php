<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Check if a country parameter exists in the GET request
if (isset($_GET['country']) && !empty($_GET['country'])) {
    $country = $_GET['country'];
    $lookup = isset($_GET['lookup']) ? $_GET['lookup'] : ''; // Check if the lookup is for cities

    if ($lookup === 'cities') {
        // SQL query to get cities for the specified country using JOIN
        $stmt = $conn->prepare("
            SELECT cities.name AS city_name, cities.district, cities.population
            FROM cities
            INNER JOIN countries ON cities.country_code = countries.code
            WHERE countries.name LIKE :country
        ");
        $stmt->execute(['country' => "%$country%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if cities were found
        if ($results) {
            echo "<table border='1'>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>District</th>
                            <th>Population</th>
                        </tr>
                    </thead>
                    <tbody>";
            foreach ($results as $row) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['city_name']) . "</td>
                        <td>" . htmlspecialchars($row['district']) . "</td>
                        <td>" . htmlspecialchars($row['population']) . "</td>
                    </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No cities found for '$country'.</p>";
        }
    } else {
        // SQL query to get country data
        $stmt = $conn->prepare("SELECT name, continent, independence_year, head_of_state FROM countries WHERE name LIKE :country");
        $stmt->execute(['country' => "%$country%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if countries were found
        if ($results) {
            echo "<table border='1'>
                    <thead>
                        <tr>
                            <th>Country Name</th>
                            <th>Continent</th>
                            <th>Independence Year</th>
                            <th>Head of State</th>
                        </tr>
                    </thead>
                    <tbody>";
            foreach ($results as $row) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['continent']) . "</td>
                        <td>" . htmlspecialchars($row['independence_year'] ?? 'N/A') . "</td>
                        <td>" . htmlspecialchars($row['head_of_state'] ?? 'N/A') . "</td>
                    </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No results found for '$country'.</p>";
        }
    }
} else {
    echo "<p>No country parameter provided.</p>";
}
?>
