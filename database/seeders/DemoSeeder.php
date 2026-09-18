<?php
declare(strict_types=1);

/**
 * Seeds demo data for local development: one admin user, store categories,
 * a handful of stores and a few products per store.
 * Usage: php database/seeders/DemoSeeder.php
 */
require dirname(__DIR__, 2) . '/bootstrap/app.php';

use Skoolyst\Core\Database;

$pdo = Database::connection();

function seed_upsert(PDO $pdo, string $table, string $uniqueCol, array $data): int
{
    $cols = array_keys($data);
    $sql = 'INSERT INTO ' . $table . ' (' . implode(',', $cols) . ') VALUES (' . implode(',', array_map(fn ($c) => ":$c", $cols)) . ')'
        . ' ON DUPLICATE KEY UPDATE ' . implode(',', array_map(fn ($c) => "$c = VALUES($c)", $cols));
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
    $existing = $pdo->prepare("SELECT id FROM {$table} WHERE {$uniqueCol} = :val");
    $existing->execute(['val' => $data[$uniqueCol]]);
    return (int) $existing->fetchColumn();
}

// Admin user
seed_upsert($pdo, 'store_users', 'email', [
    'name' => 'Skoolyst Admin',
    'email' => 'admin@skoolyst.pk',
    'password' => password_hash('password', PASSWORD_DEFAULT),
    'role' => 'admin',
]);
echo "Seeded admin user (admin@skoolyst.pk / password)\n";

// Store categories
$storeCategories = [
    ['name' => 'Uniforms', 'slug' => 'uniforms', 'icon' => 'fa-shirt'],
    ['name' => 'Shoes', 'slug' => 'shoes', 'icon' => 'fa-shoe-prints'],
    ['name' => 'School Bags', 'slug' => 'bags', 'icon' => 'fa-briefcase'],
    ['name' => 'Stationery', 'slug' => 'stationery', 'icon' => 'fa-pen-ruler'],
    ['name' => 'Books', 'slug' => 'books', 'icon' => 'fa-book'],
];
$categoryIds = [];
foreach ($storeCategories as $cat) {
    $categoryIds[$cat['slug']] = seed_upsert($pdo, 'store_store_categories', 'slug', $cat);
}
echo count($storeCategories) . " store categories seeded\n";

// Product categories (mirror store categories for simplicity at this stage)
$productCategoryIds = [];
foreach ($storeCategories as $cat) {
    $productCategoryIds[$cat['slug']] = seed_upsert($pdo, 'store_product_categories', 'slug', [
        'name' => $cat['name'],
        'slug' => $cat['slug'],
    ]);
}

// Stores
$stores = [
    [
        'name' => 'School Choice Store', 'slug' => 'school-choice-store', 'category' => 'uniforms',
        'city' => 'Karachi', 'address' => 'Tariq Road, Karachi', 'store_type' => 'retail',
        'phone' => '+92 21 111 222 333', 'email' => 'info@schoolchoice.pk', 'website' => null,
        'logo' => 'https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=200',
        'description' => 'Your one-stop shop for quality school uniforms and accessories in Karachi.',
        'status' => 'active', 'verified' => 1, 'rating' => 4.9,
    ],
    [
        'name' => 'Student Essentials', 'slug' => 'student-essentials', 'category' => 'bags',
        'city' => 'Lahore', 'address' => 'Main Boulevard, Gulberg III, Lahore', 'store_type' => 'retail',
        'phone' => '+92 42 111 222 333', 'email' => 'info@studentessentials.pk', 'website' => null,
        'logo' => 'https://images.pexels.com/photos/5212320/pexels-photo-5212320.jpeg?auto=compress&cs=tinysrgb&w=200',
        'description' => 'Trusted destination for school uniforms, bags, stationery and everyday educational supplies.',
        'status' => 'active', 'verified' => 1, 'rating' => 4.7,
    ],
    [
        'name' => 'Karachi School Mart', 'slug' => 'karachi-school-mart', 'category' => 'shoes',
        'city' => 'Karachi', 'address' => 'North Nazimabad, Karachi', 'store_type' => 'retail',
        'phone' => '+92 21 444 555 666', 'email' => 'info@karachischoolmart.pk', 'website' => null,
        'logo' => 'https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=200',
        'description' => 'Premium school shoes, bags and accessories for students of all ages.',
        'status' => 'active', 'verified' => 1, 'rating' => 4.8,
    ],
    [
        'name' => 'Education Point', 'slug' => 'education-point', 'category' => 'books',
        'city' => 'Islamabad', 'address' => 'Blue Area, Islamabad', 'store_type' => 'retail',
        'phone' => '+92 51 777 888 999', 'email' => 'info@educationpoint.pk', 'website' => null,
        'logo' => 'https://images.pexels.com/photos/5212320/pexels-photo-5212320.jpeg?auto=compress&cs=tinysrgb&w=200',
        'description' => 'Books, stationery and educational supplies for schools across Islamabad.',
        'status' => 'pending', 'verified' => 0, 'rating' => 4.6,
    ],
    [
        'name' => 'Lahore Book Corner', 'slug' => 'lahore-book-corner', 'category' => 'books',
        'city' => 'Lahore', 'address' => 'Anarkali Bazaar, Lahore', 'store_type' => 'wholesale',
        'phone' => '+92 42 222 333 444', 'email' => 'info@lahorebookcorner.pk', 'website' => null,
        'logo' => 'https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=200',
        'description' => 'Textbooks, reference books and novels for all grade levels.',
        'status' => 'active', 'verified' => 1, 'rating' => 4.5,
    ],
];

$storeIds = [];
foreach ($stores as $store) {
    $category = $store['category'];
    unset($store['category']);
    $store['category_id'] = $categoryIds[$category];
    $storeIds[$store['slug']] = seed_upsert($pdo, 'store_stores', 'slug', $store);
}
echo count($stores) . " stores seeded\n";

// Products
$products = [
    ['store' => 'school-choice-store', 'category' => 'uniforms', 'name' => 'School Uniform Set — White Shirt & Navy Trousers', 'slug' => 'school-uniform-set', 'price' => 1850, 'sale_price' => null, 'stock' => 45, 'image' => 'https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['store' => 'school-choice-store', 'category' => 'stationery', 'name' => 'Mathematical Geometry Box — 10 Pcs', 'slug' => 'geometry-box-10pcs', 'price' => 450, 'sale_price' => null, 'stock' => 87, 'image' => 'https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['store' => 'student-essentials', 'category' => 'bags', 'name' => 'Premium School Backpack — Water Resistant', 'slug' => 'premium-school-backpack', 'price' => 2500, 'sale_price' => null, 'stock' => 28, 'image' => 'https://images.pexels.com/photos/19090/pexels-photo.jpg?auto=compress&cs=tinysrgb&w=400'],
    ['store' => 'student-essentials', 'category' => 'stationery', 'name' => 'Complete Stationery Set — 24 Pcs', 'slug' => 'complete-stationery-set', 'price' => 750, 'sale_price' => null, 'stock' => 0, 'image' => 'https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['store' => 'karachi-school-mart', 'category' => 'shoes', 'name' => 'Black Leather School Shoes — Size 32-38', 'slug' => 'black-leather-school-shoes', 'price' => 2200, 'sale_price' => 1980, 'stock' => 12, 'image' => 'https://images.pexels.com/photos/298863/pexels-photo-298863.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['store' => 'education-point', 'category' => 'books', 'name' => 'Mathematics Textbook — Class 8', 'slug' => 'mathematics-textbook-class-8', 'price' => 680, 'sale_price' => null, 'stock' => 56, 'image' => 'https://images.pexels.com/photos/256541/pexels-photo-256541.jpeg?auto=compress&cs=tinysrgb&w=400'],
    ['store' => 'lahore-book-corner', 'category' => 'books', 'name' => 'English Grammar Book — Class 6', 'slug' => 'english-grammar-book-class-6', 'price' => 520, 'sale_price' => null, 'stock' => 40, 'image' => 'https://images.pexels.com/photos/159775/books-library-education-knowledge-159775.jpeg?auto=compress&cs=tinysrgb&w=400'],
];

foreach ($products as $product) {
    $product['store_id'] = $storeIds[$product['store']];
    $product['category_id'] = $productCategoryIds[$product['category']];
    unset($product['store'], $product['category']);
    $product['status'] = $product['stock'] > 0 ? 'active' : 'out_of_stock';
    seed_upsert($pdo, 'store_products', 'slug', $product);
}
echo count($products) . " products seeded\n";

echo "Done.\n";
