<?php

session_start();
require_once 'auth.php';

// Testing GitHub pushes
// Second push, lab 18 "Skills test"

// Check if user is logged in
if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}

$host = 'localhost'; 
$dbname = 'computers'; 
$user = 'erik'; 
$pass = 'erik';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

// Handle book search
$search_results = null;
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = '%' . $_GET['search'] . '%';
    $search_sql = 'SELECT entry_id, cpu, gpu, ram FROM systems WHERE cpu LIKE :search';
    $search_stmt = $pdo->prepare($search_sql);
    $search_stmt->execute(['search' => $search_term]);
    $search_results = $search_stmt->fetchAll();
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cpu']) && isset($_POST['gpu']) && isset($_POST['ram'])) {
        // Insert new entry
        $cpu = htmlspecialchars($_POST['cpu']);
        $gpu = htmlspecialchars($_POST['gpu']);
        $ram = htmlspecialchars($_POST['ram']);
        
        $insert_sql = 'INSERT INTO systems (cpu, gpu, ram) VALUES (:cpu, :gpu, :ram)';
        $stmt_insert = $pdo->prepare($insert_sql);
        $stmt_insert->execute(['cpu' => $cpu, 'title' => $gpu, 'publisher' => $ram]);
    } elseif (isset($_POST['delete_id'])) {
        // Delete an entry
        $delete_id = (int) $_POST['delete_id'];
        
        $delete_sql = 'DELETE FROM systems WHERE entry_id = :entry_id';
        $stmt_delete = $pdo->prepare($delete_sql);
        $stmt_delete->execute(['id' => $delete_id]);
    }
}

// Get all books for main table
$sql = 'SELECT entry_id, cpu, gpu, ram FROM systems';
$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Erik's Prebuild Desktop PCs</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <h1 class="hero-title">Erik's Prebuild Desktop PCs</h1>
        <p class="hero-subtitle">"Here you'll find what I think are the best desktop pcs for each purpose. Either you want a Gaming, Productivity, low budget, high end, etc.!"</p>
        
        <!-- Search moved to hero section -->
        <div class="hero-search">
            <h2>Search for a System</h2>
            <form action="" method="GET" class="search-form">
                <label for="search">Search by CPU:</label>
                <input type="text" id="search" name="search" required>
                <input type="submit" value="Search">
            </form>
            
            <?php if (isset($_GET['search'])): ?>
                <div class="search-results">
                    <h3>Search Results</h3>
                    <?php if ($search_results && count($search_results) > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Entry_ID</th>
                                    <th>CPU</th>
                                    <th>GPU</th>
                                    <th>RAM</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($search_results as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['entry_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['cpu']); ?></td>
                                    <td><?php echo htmlspecialchars($row['gpu']); ?></td>
                                    <td><?php echo htmlspecialchars($row['ram']); ?></td>
                                    <td>
                                        <form action="index5.php" method="post" style="display:inline;">
                                            <input type="hidden" name="delete_id" value="<?php echo $row['entry_id']; ?>">
                                            <input type="submit" value="Delete">
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No systems found matching your search.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Table section with container -->
    <div class="table-container">
        <h2>All Systems in Database</h2>
        <table class="half-width-left-align">
            <thead>
                <tr>
                    <th>ENTRY_ID</th>
                    <th>CPU</th>
                    <th>GPU</th>
                    <th>RAM</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['entry_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['cpu']); ?></td>
                    <td><?php echo htmlspecialchars($row['gpu']); ?></td>
                    <td><?php echo htmlspecialchars($row['ram']); ?></td>
                    <td>
                        <form action="index5.php" method="post" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $row['entry_id']; ?>">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Form section with container -->
    <div class="form-container">
        <h2>Delete a System Today</h2>
        <form action="index5.php" method="post">
            <label for="cpu">CPU:</label>
            <input type="text" id="cpu" name="cpu" required>
            <br><br>
            <label for="gpu">GPU:</label>
            <input type="text" id="gpu" name="gpu" required>
            <br><br>
            <label for="ram">RAM:</label>
            <input type="text" id="ram" name="ram" required>
            <br><br>
            <input type="submit" value="Delete System">
        </form>
    </div>
</body>
</html>