<?php
#--------------------------require-------------------------------------
require 'Item.php';
require 'Order.php';

# -----------------------functions-------------------------------------
function findCustomerById($customers,$id){
  foreach ($customers as $customer) {
    if ($customer->id==$id) 
    {
      return $customer;
     }
    else
    {
      continue;
    }      
  }
}
function ConvertInputToOrder($input){
  $order= new Order();
  $order->id=$input->id;
  $order->customer_id=$input->{'customer-id'};
  $order->items=$input->items;
  $order->total=$input->total;
  return $order;
}

function GetProductDetailsIntoOrder($products,$order){
  foreach ($products as $product) {
    foreach ($order->items as $item) {
      if ($product->id == $item->{'product-id'}){
        $item->category=$product->category;
        $item->description=$product->description;
      }
    }
  }
  return $order;
}
# ---------------------------Program start ----------------------------
# Get the json files from the database
$products=json_decode(file_get_contents("../data/products.json"));
$customers=json_decode(file_get_contents("../data/customers.json"));
$input=json_decode(file_get_contents("../example-orders/order3.json"));
$order=ConvertInputToOrder($input);
$order=GetProductDetailsIntoOrder($products,$order);
var_dump($order);
//$customer=findCustomerById($customers,$order->customer_id);

