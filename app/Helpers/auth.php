<?php
function auth_user(): ?array { return $_SESSION['user'] ?? null; }
function is_authenticated(): bool { return auth_user() !== null; }
function auth_id(): ?int { return isset(auth_user()['id']) ? (int) auth_user()['id'] : null; }
function auth_role(): ?string { return auth_user()['role'] ?? null; }
function is_admin(): bool { return auth_role() === 'admin'; }
function is_store_admin(): bool { return auth_role() === 'store_admin'; }
