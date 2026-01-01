<?php
require_once ("db.php");
require_once ("component.php");

$con = Createdb();

// Handle form submissions
if(isset($_POST['create'])){ createData(); }
if(isset($_POST['update'])){ UpdateData(); }
if(isset($_POST['delete'])){ deleteRecord(); }
if(isset($_POST['deleteall'])){ deleteAll(); }

function createData(){
    global $con;
    $bookname = textboxValue("book_name");
    $bookpublisher = textboxValue("book_publisher");
    $bookprice = floatval(textboxValue("book_price"));
    $bookyear = textboxValue("book_year");

    if($bookname && $bookpublisher && $bookprice){
        $sql = "INSERT INTO books (book_name, book_publisher, book_price, book_year) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssds", $bookname, $bookpublisher, $bookprice, $bookyear);
        
        if($stmt->execute()){
            TextNode("success", "✅ New book added successfully!");
        } else {
            TextNode("error", "❌ Failed to create book");
        }
    } else {
        TextNode("error", "⚠️ Please fill all required fields");
    }
}

function textboxValue($name){
    return mysqli_real_escape_string($GLOBALS['con'], trim($_POST[$name] ?? ''));
}

function TextNode($class, $msg){
    echo "<div class='{$class}'>{$msg}</div>";
}

function getData(){
    $sql = "SELECT * FROM books ORDER BY id DESC";
    $result = mysqli_query($GLOBALS['con'], $sql);
    return mysqli_num_rows($result) > 0 ? $result : false;
}

function UpdateData(){
    global $con;
    $bookid = intval(textboxValue("book_id"));
    $bookname = textboxValue("book_name");
    $bookpublisher = textboxValue("book_publisher");
    $bookprice = floatval(textboxValue("book_price"));
    $bookyear = textboxValue("book_year");

    if($bookname && $bookpublisher && $bookprice && $bookid){
        $sql = "UPDATE books SET book_name=?, book_publisher=?, book_price=?, book_year=? WHERE id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssdsi", $bookname, $bookpublisher, $bookprice, $bookyear, $bookid);
        
        if($stmt->execute()){
            TextNode("success", "✏️ Book updated successfully!");
        } else {
            TextNode("error", "❌ Update failed");
        }
    } else {
        TextNode("error", "⚠️ Select a book to edit");
    }
}

function deleteRecord(){
    global $con;
    $bookid = intval(textboxValue("book_id"));
    
    if($bookid){
        $sql = "DELETE FROM books WHERE id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $bookid);
        
        if($stmt->execute()){
            TextNode("success", "🗑️ Book deleted successfully!");
        } else {
            TextNode("error", "❌ Delete failed");
        }
    }
}

function deleteBtn(){
    $result = getData();
    $count = $result ? mysqli_num_rows($result) : 0;
    if($count > 3){
        echo '<button name="deleteall" class="btn btn-danger ml-2" id="btn-deleteall">
                <i class="fas fa-broom"></i> Clear All
              </button>';
    }
}

function deleteAll(){
    global $con;
    $sql = "DROP TABLE IF EXISTS books";
    if(mysqli_query($con, $sql)){
        TextNode("success", "🧹 All books cleared! Database reset.");
        Createdb();
    } else {
        TextNode("error", "❌ Failed to clear database");
    }
}

function setID(){
    $result = getData();
    $id = 0;
    if($result){
        while ($row = mysqli_fetch_assoc($result)){
            $id = $row['id'];
        }
    }
    return $id + 1;
}
