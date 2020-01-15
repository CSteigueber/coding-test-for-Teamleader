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
      # The following if-statement is looking for the cheapest object of the category 2.
      # Outsourcing it into another function would ease overview and maintenance.
      # But it would reduce performance, as the same list would be itterated over again.
      if ($product->id == $item->{'product-id'}){
        $item->category=$product->category;
        $item->description=$product->description;
      break; #avoiding that the algorithm runs through a long list of products after already matching the id from the order
    }
    
  }
}
return $order;
}

function CountCategories($order){
  foreach ($order->items as $item) {
    switch ($item->category){
      case "1": $order->cat1 += $item->quantity; break;
      case "2": $order->cat2 += $item->quantity; break;
    }
  }
  return $order;
}
function discountCheapestCat1($order){
  foreach ($order->items as $item) {
    if ($item->category=="1" && ($item->{'unit-price'} < $order->cheapestCat1Object || $order->cheapestCat1Object==0)){
      $order->cheapestCat1Object=$item->{'unit-price'};
      $order->discount1=true;
    }
  }
  $order->total-=$order->cheapestCat1Object*0.2;
  return $order;
}
function giveFreeCat2($order) {
  foreach ($order->items as $item) {
    if ($item->category=="2"){
      $item->quantity+= floor($item->quantity/5);
      $order->discount2=true;
    }
  }
  return $order;
}
function LoyalCustomerDiscount($order){
  $order->total*=0.9;
  $order->discountLoyal=true;
  return $order;
}
# ---------------------------Program start ----------------------------
# Get and sort input:
$products=json_decode(file_get_contents("../data/products.json"));
$customers=json_decode(file_get_contents("../data/customers.json"));
$input=json_decode(file_get_contents("../example-orders/order2.json"));
$order=ConvertInputToOrder($input);
$customer=findCustomerById($customers,$order->customer_id);
$order=GetProductDetailsIntoOrder($products,$order);

# calculate discounts:
$order=CountCategories($order);
if ($order->cat1 > 1){
  $order=discountCheapestCat1($order);
}
if ($order->cat2 >= 5){
  $order=giveFreeCat2($order);
}
if ($customer->revenue>=1000){
  $order=LoyalCustomerDiscount($order);
}
$message="</br>You have to pay ".$order->total." EUR. You recieved the following discount(s): </br>";
if ($order->discount1==true){
   $message.="discount 1: You pay less for the cheapest item</br>";
}                  
if ($order->discount2==true){
   $message.="discount 2: You get one or more additionel items free of charge</br>"; 
}
if ($order->discountLoyal==true){
   $message.="Loyal discount: You pay 10% less for the entire order </br>";
} 
if ($order->discount1==false && $order->discount2==false && $orderLoyal==false){
  $message.="none</br>";
}      



$message.="Thank you for your order!";
echo $message;