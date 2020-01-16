<?php
Class Order {
    public $id;
    public $customer_id;
    public $items = array();
    public $total;
    public $cat1; # count the amount of category1 items in the order
    public $cat2; # count the amount of category2 items in the order
    public $cheapestCat1Object;
    public $discount1 = false;
    public $discount2 = false;
    public $discountLoyal = false;
    public function ConvertInputToOrder($input){
        $this->id = $input->id;
        $this->customer_id = $input->{'customer-id'};
        $this->items = $input->items;
        $this->total = $input->total;
      }
      
    public function GetProductDetailsIntoOrder($products){
        foreach ($products as $product) {
          foreach ($this->items as $item) {
            # The following if-statement is looking for the cheapest object of the category 2.
            # Outsourcing it into another function would ease overview and maintenance.
            # But it would reduce performance, as the same list would be itterated over again.
            if ($product->id == $item->{'product-id'}){
              $item->category = $product->category;
              $item->description = $product->description;
            break; #avoiding that the algorithm runs through a long list of products after already matching the id from the this
          }
          
        }
      }
      }
      
    public function CountCategories(){
        foreach ($this->items as $item) {
          switch ($item->category){
            case "1": $this->cat1 += $item->quantity; break;
            case "2": $this->cat2 += $item->quantity; break;
          }
        }

      }
    public function discountCheapestCat1(){
        foreach ($this->items as $item) {
          if ($item->category == "1" && ($item->{'unit-price'} < $this->cheapestCat1Object || $this->cheapestCat1Object == 0)){
            $this->cheapestCat1Object = $item->{'unit-price'};
            $this->discount1 = true;
          }
        }
        $this->total -= $this->cheapestCat1Object * 0.2;

      }
    public function giveFreeCat2() {
        foreach ($this->items as $item) {
          if ($item->category == "2"){
            $item->quantity += floor($item->quantity/5);
            $this->discount2 = true;
          }
        }

      }
    public function LoyalCustomerDiscount(){
        $this->total *= 0.9;
        $this->discountLoyal = true;
    }
    public function applyDiscounts($customer){
        $this->CountCategories();
        if ($this->cat1 > 1){
            $this->discountCheapestCat1();
        }
        if ($this->cat2 >= 5){
            $this->giveFreeCat2();
        }
        if ($customer->revenue >= 1000){
            $this->LoyalCustomerDiscount();
}
    }

}