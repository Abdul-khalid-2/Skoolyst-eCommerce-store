<?php
/**
 * Shared <head> partial.
 * Vars: $title, $description (optional), $canonical (optional), $extraCss (array, optional).
 */
$title = $title ?? 'Skoolyst Store';
$description = $description ?? "Discover trusted school uniform, shoe, stationery and book stores near you \u{2014} Skoolyst's education store directory.";
$extraCss = $extraCss ?? [];
$canonical = $canonical ?? url(trim(Skoolyst\Core\Request::uri(), '/'));
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= clean($title) ?></title>
<meta name="description" content="<?= clean($description) ?>">
<link rel="canonical" href="<?= clean($canonical) ?>">
<meta property="og:title" content="<?= clean($title) ?>">
<meta property="og:description" content="<?= clean($description) ?>">
<meta property="og:url" content="<?= clean($canonical) ?>">
<meta property="og:type" content="website">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?= url('assets/css/app.css') ?>">
<link rel="stylesheet" href="<?= url('assets/css/components.css') ?>">
<?php foreach ($extraCss as $href): ?>
<link rel="stylesheet" href="<?= url($href) ?>">
<?php endforeach; ?>
