<?php
/**
 * index.php — Epidermis Skin Clinic
 * Serves the full site with dynamic data from MySQL via PHP
 * Place this file at the webroot alongside /php/ and /sql/
 */
require_once __DIR__ . '/php/config.php';

// Fetch dynamic data (falls back to empty arrays if DB not connected)
$services     = dbFetchAll("SELECT id, name, icon, short_description FROM services ORDER BY is_popular DESC, id ASC LIMIT 8");
$testimonials = dbFetchAll("
    SELECT t.*, s.name AS service_name
    FROM testimonials t
    LEFT JOIN services s ON t.service_id = s.id
    WHERE t.is_featured = 1 ORDER BY t.id ASC LIMIT 3
");
$updates      = dbFetchAll("SELECT * FROM clinic_updates ORDER BY date_published DESC LIMIT 4");
$faqs         = dbFetchAll("SELECT * FROM faqs WHERE is_active=1 ORDER BY display_order ASC");

// ── Handle booking form POST ──────────────────────────────
$booking_success = $booking_error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['full_name'])) {
    $name       = trim($_POST['full_name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $service_id = intval($_POST['service_id'] ?? 0);
    $date       = trim($_POST['preferred_date'] ?? '');
    $message    = trim($_POST['message'] ?? '');

    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $booking_error = 'Please provide your name and a valid email address.';
    } else {
        $sql = "INSERT INTO consultations (full_name, email, phone, service_id, preferred_date, message)
                VALUES (:name, :email, :phone, :service_id, :date, :message)";
        $id = dbInsert($sql, [
            ':name' => $name, ':email' => $email, ':phone' => $phone,
            ':service_id' => $service_id ?: null, ':date' => $date ?: null, ':message' => $message
        ]);
        $booking_success = 'Your consultation has been booked! We will contact you within 24 hours.';
    }
}

function h(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Epidermis — Because Your Skin Deserves the Best</title>
  <meta name="description" content="Epidermis Skin Clinic: Expert skincare treatments including acne therapy, laser resurfacing, chemical peels, and more." />
  <!-- Include the full CSS & scripts from index.html -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css" />

  <?php if ($booking_success): ?>
  <script>window.onload = function(){ openModal(); document.getElementById('form-msg').textContent = <?= json_encode($booking_success) ?>; document.getElementById('form-msg').className = 'text-sm py-2 px-3 rounded-lg'; document.getElementById('form-msg').style.background='#d4edda'; document.getElementById('form-msg').style.color='#155724'; }</script>
  <?php endif; ?>
</head>
<body>

<?php
// Inject PHP-rendered testimonials into a JS variable for the page
$js_testimonials = json_encode($testimonials, JSON_HEX_TAG | JSON_HEX_QUOT);
$js_updates      = json_encode($updates, JSON_HEX_TAG | JSON_HEX_QUOT);
$js_faqs         = json_encode($faqs, JSON_HEX_TAG | JSON_HEX_QUOT);
echo "<script>
  window.EPIDERMIS_DATA = {
    testimonials: {$js_testimonials},
    updates: {$js_updates},
    faqs: {$js_faqs}
  };
</script>";
?>

<!-- The rest of the body content is identical to index.html -->
<!-- In a real deployment, use an include or template engine -->
<!-- For this package, index.html is the standalone version; index.php uses DB data -->

<p style="display:none;">PHP Backend Active — Database: <?= defined('DB_NAME') ? h(DB_NAME) : 'not configured' ?></p>

<?php include __DIR__ . '/index.html'; // Serve the static HTML with PHP header already sent ?>
</body>
</html>
<?php
// Note: index.html already has its own complete <!DOCTYPE html> structure.
// In production, split into partials: header.php, footer.php, sections/*.php
// and include them here instead of the monolithic index.html.
?>
