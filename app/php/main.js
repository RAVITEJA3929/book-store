let id = $("input[name*='book_id']");
id.attr("readonly", "readonly");

$(".btnedit").click(e => {
    let textvalues = displayData(e);
    let bookname = $("input[name*='book_name']");
    let bookpublisher = $("input[name*='book_publisher']");
    let bookprice = $("input[name*='book_price']");
    let bookyear = $("input[name*='book_year']");

    id.val(textvalues[0]);
    bookname.val(textvalues[1]);
    bookpublisher.val(textvalues[2]);
    bookprice.val(textvalues[3].replace(/[$\s]/g, ""));
    bookyear.val(textvalues[4] || "");
    
    // Smooth scroll to form
    $('html, body').animate({ scrollTop: $(".form-container").offset().top - 100 }, 800);
});

$(".btncopy").click(e => {
    let data = displayData(e);
    let json = JSON.stringify({
        id: data[0],
        title: data[1],
        publisher: data[2],
        price: data[3],
        year: data[4] || 'N/A'
    }, null, 2);
    
    navigator.clipboard.writeText(json).then(() => {
        showToast("📋 JSON copied to clipboard!", "success");
    });
});

// Real-time search
$("#searchInput").on("keyup", function() {
    let value = $(this).val().toLowerCase();
    $("#tbody tr").filter(function() {
        $(this).toggle($(this).data("book").includes(value));
    });
    
    updateStats();
});

// Update stats
function updateStats() {
    let total = $("#tbody tr").length;
    let visible = $("#tbody tr:visible").length;
    $("#stats").html(`
        <span class="badge badge-primary mr-2">📊 Total: ${total}</span>
        <span class="badge badge-success">👁️ Visible: ${visible}</span>
    `);
}

// Toast notifications
function showToast(message, type) {
    let toast = $(`
        <div class="toast-notification ${type}">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            ${message}
        </div>
    `);
    
    $(".container").append(toast);
    toast.fadeIn(300).delay(3000).fadeOut(300, () => toast.remove());
}

// Initialize
$(document).ready(() => {
    updateStats();
    
    // Animate on scroll
    $(window).scroll(() => {
        $(".form-container, .table-container").each(function() {
            let top = $(this).offset().top;
            let height = $(this).height();
            if ($(window).scrollTop() > top - 300) {
                $(this).addClass("animate-in");
            }
        });
    });
});
