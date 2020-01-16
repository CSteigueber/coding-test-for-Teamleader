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


# ---------------------------Program start ----------------------------
# Get input:
$products = json_decode(file_get_contents("../data/products.json"));
$customers = json_decode(file_get_contents("../data/customers.json"));
$input = json_decode(file_get_contents("../example-orders/order3.json")); // Here you can change the order which is read.

#Built order:
$order = new Order();
$order->ConvertInputToOrder($input);
$order->GetProductDetailsIntoOrder($products);

# Built customer:
$customer=findCustomerById($customers,$order->customer_id);

# calculate discounts:
$order->CountCategories();
if ($order->cat1 > 1){
  $order->discountCheapestCat1();
}
if ($order->cat2 >= 5){
  $order->giveFreeCat2();
}
if ($customer->revenue >= 1000){
  $order->LoyalCustomerDiscount();
}

# create the output:
$message = "</br>You have to pay ".round($order->total,2)." EUR. You recieved the following discount(s): </br>";

if ($order->discount1 == true){
   $message .= "discount 1: You pay less for the cheapest item</br>";
}                  
if ($order->discount2 == true){
   $message .= "discount 2: You get one or more additionel items free of charge</br>"; 
}
if ($order->discountLoyal == true){
   $message .= "Loyal discount: You pay 10% less for the entire order </br>";
} 
if ($order->discount1 == false && $order->discount2 == false && $orderLoyal == false){
  $message .= "none</br>";
}      

$message .= "Thank you for your order!";

echo $message;