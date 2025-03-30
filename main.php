<?php
    // Database connection
    $host = 'localhost';
    $db = 'meetspa1444_blog_db';
    $user = 'meetspa1444_leston'; 
    $pass = 'Vinjim35??#'; 
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    // Pagination variables
    $items_per_page = 6; // Reduced number of items per page to account for larger cards
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($current_page - 1) * $items_per_page;

    // Get total count of blogs
    $count_sql = "SELECT COUNT(*) FROM blogs";
    $count_stmt = $pdo->query($count_sql);
    $total_blogs = $count_stmt->fetchColumn();
    $total_pages = ceil($total_blogs / $items_per_page);

    // Get blogs with pagination
    $sql = "SELECT blogs.*, locations.city, locations.country 
            FROM blogs 
            LEFT JOIN locations ON blogs.id = locations.blog_id 
            ORDER BY blogs.id DESC
            LIMIT :offset, :limit";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $items_per_page, PDO::PARAM_INT);
    $stmt->execute();
    $blogs = $stmt->fetchAll();
?>