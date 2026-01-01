<?php
require_once "php/component.php";
require_once "php/operation.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 Premium BookStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="bg-bookshelf">
    <!-- Floating Books -->
    <div class="floating-books">
        <div class="floating-book"></div>
        <div class="floating-book" style="background: linear-gradient(45deg, #ff9a9e, #fecfef);"></div>
        <div class="floating-book" style="background: linear-gradient(45deg, #a8edea, #fed6e3);"></div>
        <div class="floating-book" style="background: linear-gradient(45deg, #ffecd2, #fcb69f);"></div>
    </div>

    <main class="min-vh-100 py-5">
        <div class="container">
            <!-- Hero -->
            <div class="hero-section text-center text-white mb-5">
                <h1 class="hero-title display-2 fw-bold mb-3">Premium BookStore</h1>
                <p class="hero-subtitle lead">Advanced Book Management with Live Analytics ✨</p>
            </div>

            <!-- Form -->
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <form method="POST" class="super-form card-glass shadow-lg">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <?php inputElement('id-badge', 'Auto ID', 'book_id', setID()); ?>
                            </div>
                            <div class="col-md-6">
                                <?php inputElement('book-open', 'Book Title *', 'book_name', ''); ?>
                            </div>
                            <div class="col-md-4">
                                <?php inputElement('industry', 'Publisher *', 'book_publisher', ''); ?>
                            </div>
                            <div class="col-md-4">
                                <?php inputElement('dollar-sign', 'Price *', 'book_price', ''); ?>
                            </div>
                            <div class="col-md-4">
                                <?php inputElement('calendar', 'Year', 'book_year', date('Y')); ?>
                            </div>
                            <div class="col-md-4">
                                <?php inputElement('star', 'Rating (1-5)', 'book_rating', '5'); ?>
                            </div>
                            <div class="col-md-4">
                                <?php inputElement('tags', 'Genre', 'book_genre', ''); ?>
                            </div>
                            <div class="col-md-4">
                                <?php inputElement('user', 'Author', 'book_author', ''); ?>
                            </div>
                        </div>
                        
                        <div class="action-hub mt-5">
                            <?php buttonElement('create', 'btn-premium btn-premium-success', 'plus-circle', 'create', 'title="Add Book"'); ?>
                            <?php buttonElement('read', 'btn-premium btn-premium-primary', 'refresh', 'read', 'title="Load All"'); ?>
                            <?php buttonElement('update', 'btn-premium btn-premium-warning', 'edit', 'update', 'title="Update"'); ?>
                            <?php buttonElement('delete', 'btn-premium btn-premium-danger', 'trash', 'delete', 'title="Delete"'); ?>
                            <?php if (isset($_POST['read'])) deleteBtn(); ?>
                            <button type="button" class="btn btn-outline-light btn-lg" onclick="exportCSV()" title="Export">
                                <i class="fas fa-download"></i> CSV
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Live Stats -->
            <?php if (isset($_POST['read'])): ?>
            <div class="stats-grid mt-5">
                <div class="stat-metric">
                    <div class="stat-icon bg-primary">
                        <i class="fas fa-book"></i>
                    </div>
                    <span class="stat-number" id="totalBooks">0</span>
                    <div class="stat-label">Total Books</div>
                </div>
                <div class="stat-metric">
                    <div class="stat-icon bg-success">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <span class="stat-number" id="totalValue">$0</span>
                    <div class="stat-label">Total Value</div>
                </div>
                <div class="stat-metric">
                    <div class="stat-icon bg-warning">
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="stat-number" id="avgRating">0</span>
                    <div class="stat-label">Avg Rating</div>
                </div>
                <div class="stat-metric">
                    <div class="stat-icon bg-info">
                        <i class="fas fa-users"></i>
                    </div>
                    <span class="stat-number" id="uniqueAuthors">0</span>
                    <div class="stat-label">Authors</div>
                </div>
            </div>

            <!-- Smart Table -->
            <div class="smart-table mt-5">
                <div class="control-panel">
                    <div class="search-super position-relative">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="searchInput" class="form-control form-control-super" 
                               placeholder="🔍 Search books, authors, genres...">
                    </div>
                    <button class="btn btn-outline-light" onclick="clearFilters()">
                        <i class="fas fa-times"></i> Clear
                    </button>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag"></i> ID</th>
                                <th><i class="fas fa-book"></i> Title</th>
                                <th><i class="fas fa-user"></i> Author</th>
                                <th><i class="fas fa-building"></i> Publisher</th>
                                <th><i class="fas fa-dollar-sign"></i> Price</th>
                                <th><i class="fas fa-calendar"></i> Year</th>
                                <th><i class="fas fa-star"></i> Rating</th>
                                <th><i class="fas fa-tag"></i> Genre</th>
                                <th>⚙️</th>
                            </tr>
                        </thead>
                        <tbody id="bookTable">
                            <?php 
                            if(isset($_POST['read'])){
                                $result = getData();
                                if($result){
                                    while($row = mysqli_fetch_assoc($result)){ ?>
                                        <tr data-all="<?php echo strtolower(implode(' ', array_values($row))); ?>">
                                            <td><?php echo $row['id']; ?></td>
                                            <td class="fw-bold"><?php echo htmlspecialchars($row['book_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['book_author'] ?? 'Unknown'); ?></td>
                                            <td><?php echo htmlspecialchars($row['book_publisher']); ?></td>
                                            <td class="text-success fw-bold">$<?php echo number_format($row['book_price'], 2); ?></td>
                                            <td><?php echo $row['book_year']; ?></td>
                                            <td class="rating-stars"><?php echo str_repeat('⭐', $row['book_rating'] ?? 5); ?></td>
                                            <td><span class="genre-badge"><?php echo htmlspecialchars($row['book_genre']); ?></span></td>
                                            <td>
                                                <div class="action-icons">
                                                    <i class="fas fa-edit btn-edit me-2" data-id="<?php echo $row['id']; ?>"></i>
                                                    <i class="fas fa-copy btn-copy me-2" data-id="<?php echo $row['id']; ?>"></i>
                                                    <i class="fas fa-share btn-share" data-id="<?php echo $row['id']; ?>"></i>
                                                </div>
                                            </td>
                                        </tr>
                            <?php } } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="php/main.js"></script>
</body>
</html>
