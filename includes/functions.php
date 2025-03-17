<?php

function redirect($url) {
    header("Location: $url");
    exit();
}

function checkPermission($requiredRole) {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != $requiredRole) {
        redirect('login.php');
    }
}

function showSuccessMessage($message) {
    return '
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">' . $message . '</span>
        </div>
    ';
}

function showErrorMessage($message) {
    return '
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">' . $message . '</span>
        </div>
    ';
}

function isFieldEmpty($field) {
    return empty(trim($field));
}

function sanitizeField($field) {
    return htmlspecialchars(trim($field), ENT_QUOTES, 'UTF-8');
}