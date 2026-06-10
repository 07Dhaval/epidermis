<?php
// api.php — JSON API for dynamic data
require_once __DIR__ . '/config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'services':
        $rows = dbFetchAll("SELECT id, name, slug, icon, short_description, image_url FROM services ORDER BY is_popular DESC, id ASC");
        echo json_encode(['success' => true, 'data' => $rows]);
        break;

    case 'testimonials':
        $rows = dbFetchAll("
            SELECT t.id, t.patient_name, t.quote, t.course_duration, t.rating, t.avatar_url, s.name AS service_name
            FROM testimonials t
            LEFT JOIN services s ON t.service_id = s.id
            WHERE t.is_featured = 1
            ORDER BY t.id ASC
        ");
        echo json_encode(['success' => true, 'data' => $rows]);
        break;

    case 'updates':
        $rows = dbFetchAll("SELECT id, title, slug, excerpt, date_published FROM clinic_updates ORDER BY date_published DESC LIMIT 4");
        echo json_encode(['success' => true, 'data' => $rows]);
        break;

    case 'faqs':
        $rows = dbFetchAll("SELECT id, question, answer FROM faqs WHERE is_active=1 ORDER BY display_order ASC");
        echo json_encode(['success' => true, 'data' => $rows]);
        break;

    case 'gallery':
        $rows = dbFetchAll("SELECT id, image_url, caption FROM gallery ORDER BY display_order ASC LIMIT 6");
        echo json_encode(['success' => true, 'data' => $rows]);
        break;

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Unknown action']);
}
