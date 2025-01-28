<?php
function isAuthenticated() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }
}

function isAdminOrManager() {
    if (!in_array($_SESSION['role'], ['admin', 'manager'])) {
        http_response_code(403);
        echo "403 - Forbidden";
        exit;
    }
}
