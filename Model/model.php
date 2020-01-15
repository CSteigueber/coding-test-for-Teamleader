<?php
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
$products=json_decode(file_get_contents("../data/products.json"));
$customers=json_decode(file_get_contents("../data/customers.json"));
$order= array(
    "id"=> "1",
    "customer-id"=> "1",
    "items"=> array
      (
        "product-id"=> "B102",
        "quantity"=> "10",
        "unit-price"=> "4.99",
        "total"=> "49.90"
      )
    ,
    "total"=> "49.90"
);
$customer=findCustomerById($customers,$order['customer-id']);