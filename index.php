<?php
session_start();

// Ürünleri tanımlayalım
$products = [
    ['id' => 1, 'name' => 'Ürün 1', 'price' => 10],
    ['id' => 2, 'name' => 'Ürün 2', 'price' => 20],
    ['id' => 3, 'name' => 'Ürün 3', 'price' => 30],
];

// Sepetin başlatılması
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Sepete ürün ekleme
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        $_SESSION['cart'][$product_id] = [
            'name' => $products[$product_id - 1]['name'],
            'price' => $products[$product_id - 1]['price'],
            'quantity' => 1
        ];
    }
}

// Sepetten ürün çıkarma
if (isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];
    if (isset($_SESSION['cart'][$product_id])) {
        if ($_SESSION['cart'][$product_id]['quantity'] > 1) {
            $_SESSION['cart'][$product_id]['quantity']--;
        } else {
            unset($_SESSION['cart'][$product_id]);
        }
    }
}

// Sepetin toplam tutarını hesaplama
function calculate_total() {
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basit PHP Sepet Uygulaması</title>
</head>
<body>
    <h1>Ürünler</h1>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <?php echo $product['name']; ?> - <?php echo $product['price']; ?> TL
                <form method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <button type="submit" name="add_to_cart">Sepete Ekle</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <h1>Sepet</h1>
    <ul>
        <?php foreach ($_SESSION['cart'] as $product_id => $item): ?>
            <li>
                <?php echo $item['name']; ?> - <?php echo $item['price']; ?> TL - Adet: <?php echo $item['quantity']; ?>
                <form method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <button type="submit" name="remove_from_cart">Sepetten Çıkar</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Toplam Tutar: <?php echo calculate_total(); ?> TL</h2>
</body>
</html>
