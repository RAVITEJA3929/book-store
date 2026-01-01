<?php
require_once "db.php";

$con = Createdb();

// Handle all actions
if(isset($_POST['create'])) { createData(); }
if(isset($_POST['read'])) { displayBooks(); }
if(isset($_POST['update'])) { UpdateData(); }
if(isset($_POST['delete'])) { deleteRecord(); }
if(isset($_POST['deleteall'])) { deleteAll(); }

function clean($data) {
    global $con;
    return trim(mysqli_real_escape_string($con, $data));
}

function createData() {
    global $con;
    $name = clean($_POST['book_name']);
    $publisher = clean($_POST['book_publisher']);
    $price = floatval($_POST['book_price']);
    $year = clean($_POST['book_year']);
    $author = clean($_POST['book_author']);
    $rating = intval($_POST['book_rating']);
    $genre = clean($_POST['book_genre']);

    if($name && $publisher && $price > 0) {
        $sql = "INSERT INTO books (book_name, book_publisher, book_price, book_year, book_author, book_rating, book_genre) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssdssis", $name, $publisher, $price, $year, $author, $rating, $genre);
        if($stmt->execute()) {
            echo "<div class='alert alert-success m-4'>✅ '$name' added to collection!</div>";
        } else {
            echo "<div class='alert alert-danger m-4'>❌ Create failed</div>";
        }
    }
}

function displayBooks() {
    global $con;
    $sql = "SELECT * FROM books ORDER BY id DESC";
    $result = $con->query($sql);
    if($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr data-search='" . strtolower($row['book_name'] . ' ' . $row['book_author'] . ' ' . $row['book_genre']) . "'>
                <td>{$row['id']}</td>
                <td class='fw-bold text-white'>{$row['book_name']}</td>
                <td>{$row['book_author']}</td>
                <td>{$row['book_publisher']}</td>
                <td class='text-success fw-bold'>\$" . number_format($row['book_price'],2) . "</td>
                <td>{$row['book_year']}</td>
                <td>" . str_repeat('⭐', $row['book_rating']) . "</td>
                <td><span class='badge bg-info text-dark'>{$row['book_genre']}</span></td>
                <td>
                    <button class='btn btn-sm btn-outline-light btn-edit' data-id='{$row['id']}'>
                        <i class='fas fa-edit'></i>
                    </button>
                    <button class='btn btn-sm btn-outline-success btn-copy' data-id='{$row['id']}'>
                        <i class='fas fa-copy'></i>
                    </button>
                </td>
            </tr>";
        }
    }
}

function UpdateData() {
    global $con;
    $id = intval($_POST['book_id']);
    if(!$id) return;
    
    $name = clean($_POST['book_name']);
    $publisher = clean($_POST['book_publisher']);
    $price = floatval($_POST['book_price']);
    $year = clean($_POST['book_year']);
    $author = clean($_POST['book_author']);
    $rating = intval($_POST['book_rating']);
    $genre = clean($_POST['book_genre']);

    $sql = "UPDATE books SET book_name=?, book_publisher=?, book_price=?, book_year=?, book_author=?, book_rating=?, book_genre=? WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssdssisi", $name, $publisher, $price, $year, $author, $rating, $genre, $id);
    if($stmt->execute()) {
        echo "<div class='alert alert-success m-4'>✏️ Updated successfully!</div>";
    }
}

function deleteRecord() {
    global $con;
    $id = intval($_POST['book_id']);
    if($id) {
        $stmt = $con->prepare("DELETE FROM books WHERE id=?");
        $stmt->bind_param("i", $id);
        if($stmt->execute()) {
            echo "<div class='alert alert-success m-4'>🗑️ Deleted!</div>";
        }
    }
}

function deleteAll() {
    global $con;
    $con->query("TRUNCATE TABLE books");
    echo "<div class='alert alert-warning m-4'>🧹 Cleared all books!</div>";
}

function setID() {
    global $con;
    $result = $con->query("SELECT COALESCE(MAX(id), 0) + 1 as nextid FROM books");
    return $result->fetch_assoc()['nextid'];
}

function deleteBtn() {
    global $con;
    $count = $con->query("SELECT COUNT(*) as cnt FROM books")->fetch_assoc()['cnt'];
    echo "<button type='submit' name='deleteall' class='btn btn-danger btn-lg ms-3' 
            onclick='return confirm(\"Clear {$count} books?\")'>
            <i class='fas fa-broom'></i> Clear All ({$count})
          </button>";
}
