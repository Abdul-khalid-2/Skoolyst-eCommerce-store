<?php
/**
 * Shared <head> partial.
 * Vars: $title, $description (optional), $extraCss (array of extra stylesheet paths, optional).
 */
$title = $title ?? 'Skoolyst Stores';
$description = $description ?? "Pakistan's education marketplace connecting schools, parents, students and school-related businesses.";
$extraCss = $extraCss ?? [];
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= clean($title) ?></title>
<meta name="description" content="<?= clean($description) ?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="<?= url('assets/css/app.css') ?>">
<?php foreach ($extraCss as $href): ?>
<link rel="stylesheet" href="<?= url($href) ?>">
<?php endforeach; ?>
