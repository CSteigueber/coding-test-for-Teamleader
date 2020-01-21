<?php
//echo php_ini_loaded_file();
// ini_set('display_startup_errors', 1);
// ini_set('display_errors', 1);
// error_reporting(-1);
#--------------------------requirements-------------------------------------
require 'Order.php';

# -----------------------functions-------------------------------------
function findCustomerById(array $customers,int $id) {
  foreach ($customers as $customer) {
    if ($customer->id == $id) 
    {
      return $customer;
     }  
  }
}

function createOutput($order){
  $message = "</br>You have to pay ".round($order->getTotal(),2)." EUR. You recieved the following discount(s): </br>";

  if ($order->getDiscount1()){
     $message .= "discount 1: You pay less for the cheapest item</br>";
  }                  
  if ($order->getDiscount2()){
     $message .= "discount 2: You get one or more additionel items free of charge</br>"; 
  }
  if ($order->getDiscountLoyal()){
     $message .= "Loyal discount: You pay 10% less for the entire order </br>";
  } 
  if (!$order->getDiscount1() && !$order->getDiscount2() && !$order->getDiscountLoyal()){
    $message .= "none</br>";
  }       
  $message .= "Thank you for your order!";
  echo $message;
}

# ---------------------------Program start ----------------------------
# Get input:
$products = json_decode(file_get_contents("../data/products.json"));
$customers = json_decode(file_get_contents("../data/customers.json"));
$input = json_decode(file_get_contents("../example-orders/order3.json")); // Here you can change the order which is read.

# Build order:
$order = new Order();
$order->ConvertInputToOrder($input);
$order->GetProductDetailsIntoOrder($products);

# Build customer:
$customer=findCustomerById($customers,$order->getCustomer_id());

# Calculate discounts:
$order->applyDiscounts($customer);

# Create the output:
createOutput($order);