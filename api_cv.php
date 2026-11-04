<?php
header('Content-Type: application/json');
require_once 'database.php';

$action = $_GET['action'] ?? 'get_cv';

try {
    switch ($action) {
        case 'get_cv':
            $personal = $pdo->query("SELECT * FROM personal_info LIMIT 1")->fetch();
            $sections = $pdo->query("SELECT * FROM cv_sections WHERE is_active = 1 ORDER BY display_order ASC")->fetchAll();
            $items = $pdo->query("SELECT i.*, s.slug as section_slug FROM cv_items i JOIN cv_sections s ON i.section_id = s.id WHERE i.is_active = 1 ORDER BY s.display_order, i.display_order")->fetchAll();
            
            $cv_data = [
                'personal' => $personal,
                'sections' => []
            ];
            
            foreach ($sections as $s) {
                $section_items = array_filter($items, function($item) use ($s) {
                    return $item['section_id'] == $s['id'];
                });
                $cv_data['sections'][] = [
                    'id' => $s['id'],
                    'name' => $s['name'],
                    'slug' => $s['slug'],
                    'items' => array_values($section_items)
                ];
            }
            
            echo json_encode(['success' => true, 'data' => $cv_data]);
            break;

        case 'get_sections':
            $sections = $pdo->query("SELECT * FROM cv_sections ORDER BY display_order ASC")->fetchAll();
            echo json_encode(['success' => true, 'data' => $sections]);
            break;

        case 'get_items':
            $section_id = $_GET['section_id'] ?? null;
            if ($section_id) {
                $stmt = $pdo->prepare("SELECT * FROM cv_items WHERE section_id = ? ORDER BY display_order ASC");
                $stmt->execute([$section_id]);
                $items = $stmt->fetchAll();
            } else {
                $items = $pdo->query("SELECT * FROM cv_items ORDER BY display_order ASC")->fetchAll();
            }
            echo json_encode(['success' => true, 'data' => $items]);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
