<?php
#--------------------------require-------------------------------------
require 'Order.php';

# -----------------------functions-------------------------------------
function findCustomerById($customers,$id){
  foreach ($customers as $customer) {
    if ($customer->id == $id) 
    {
      return $customer;
     }
    else
    {
      continue;
    }      
  }
}

function createOutput($order){
  $message = "</br>You have to pay ".round($order->total,2)." EUR. You recieved the following discount(s): </br>";

  if ($order->discount1){
     $message .= "discount 1: You pay less for the cheapest item</br>";
  }                  
  if ($order->discount2){
     $message .= "discount 2: You get one or more additionel items free of charge</br>"; 
  }
  if ($order->discountLoyal){
     $message .= "Loyal discount: You pay 10% less for the entire order </br>";
  } 
  if (!$order->discount1 && !$order->discount2 && !$order->discountLoyal){
    $message .= "none</br>";
  }       
  $message .= "Thank you for your order!";
  echo $message;
}

# ---------------------------Program start ----------------------------
# Get input:
$products = json_decode(file_get_contents("../data/products.json"));
$customers = json_decode(file_get_contents("../data/customers.json"));
$input = json_decode(file_get_contents("../example-orders/order2.json")); // Here you can change the order which is read.

# Build order:
$order = new Order();
$order->ConvertInputToOrder($input);
$order->GetProductDetailsIntoOrder($products);

# Build customer:
$customer=findCustomerById($customers,$order->customer_id);

# Calculate discounts:
$order->applyDiscounts($customer);

# Create the output:
createOutput($order);