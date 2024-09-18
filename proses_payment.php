$rental_date = new DateTime($_POST['rental_date']);
$return_date = new DateTime($_POST['return_date']);
$interval = $rental_date->diff($return_date);
$days_rented = $interval->days;

$total_price = $product['price'] * $days_rented;
