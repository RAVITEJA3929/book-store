<?php
require_once ("php/component.php");
require_once ("php/operation.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>🌟 Beautiful Book Store</title>
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Floating Particles Background -->
    <div class="particles-bg"></div>

    <main>
        <div class="container text-center">
            <h1 class="py-4"><i class="fas fa-swatchbook"></i> ✨ Book Store ✨</h1>

            <div class="form-container">
                <div class="row">
                    <?php inputElement("<i class='fas fa-id-badge'></i>", "📖 Book ID", "book_id", setID()); ?>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <?php inputElement("<i class='fas fa-book-open'></i>", "📚 Book Name", "book_name", ""); ?>
                    </div>
                    <div class="col-md-4">
                        <?php inputElement("<i class='fas fa-building'></i>", "🏢 Publisher", "book_publisher", ""); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?php inputElement("<i class='fas fa-dollar-sign'></i>", "💰 Price", "book_price", ""); ?>
                    </div>
                    <div class="col-md-6">
                        <?php inputElement("<i class='fas fa-calendar'></i>", "📅 Year", "book_year", ""); ?>
                    </div>
                </div>
                
                <div class="btn-group">
                    <?php buttonElement("btn-create", "btn btn-success", "<i class='fas fa-plus-circle'></i> Create", "create", "data-toggle='tooltip' data-placement='bottom' title='Add New Book'"); ?>
                    <?php buttonElement("btn-read", "btn btn-primary", "<i class='fas fa-sync-alt'></i> Read All", "read", "data-toggle='tooltip' data-placement='bottom' title='Load Books'"); ?>
                    <?php buttonElement("btn-update", "btn btn-warning", "<i class='fas fa-edit'></i> Update", "update", "data-toggle='tooltip' data-placement='bottom' title='Edit Selected'"); ?>
                    <?php buttonElement("btn-delete", "btn btn-danger", "<i class='fas fa-trash-alt'></i> Delete", "delete", "data-toggle='tooltip' data-placement='bottom' title='Remove Selected'"); ?>
                    <?php deleteBtn(); ?>
                </div>
            </div>

            <!-- Enhanced Table with Search & Stats -->
            <div class="table-container">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5><i class="fas fa-search"></i> Quick Search</h5>
                        <input type="text" id="searchInput" class="form-control" placeholder="🔍 Search books...">
                    </div>
                    <div class="col-md-6 text-right">
                        <div id="stats" class="stats-badge"></div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag"></i> ID</th>
                                <th><i class="fas fa-book"></i> Title</th>
                                <th><i class="fas fa-industry"></i> Publisher</th>
                                <th><i class="fas fa-dollar-sign"></i> Price</th>
                                <th><i class="fas fa-calendar-alt"></i> Year</th>
                                <th><i class="fas fa-cogs"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <?php
                            if(isset($_POST['read'])){
                                $result = getData();
                                if($result){
                                    while ($row = mysqli_fetch_assoc($result)){ ?>
                                        <tr data-book="<?php echo strtolower($row['book_name'].' '.$row['book_publisher']); ?>">
                                            <td data-id="<?php echo $row['id']; ?>"><?php echo $row['id']; ?></td>
                                            <td data-id="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['book_name']); ?></td>
                                            <td data-id="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['book_publisher']); ?></td>
                                            <td data-id="<?php echo $row['id']; ?>">$<?php echo number_format($row['book_price'], 2); ?></td>
                                            <td data-id="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['book_year'] ?? 'N/A'); ?></td>
                                            <td>
                                                <i class="fas fa-edit btnedit" data-id="<?php echo $row['id']; ?>" title="Edit"></i>
                                                <i class="fas fa-copy btncopy" data-id="<?php echo $row['id']; ?>" title="Copy JSON"></i>
                                            </td>
                                        </tr>
                            <?php }}}
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="php/main.js"></script>
</body>
</html>
