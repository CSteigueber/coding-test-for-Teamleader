<?php
Class Order {
    private const DISCOUNT_PERCENTAGE = 0.2;
    private const DISCOUNT_AMOUNT_FOR_PERCENTAGE =2;
    private const DISCOUNT_EXTRA_ITEM = 5;
    private const DISCOUNT_LOYAL =0.9;
    private const DISCOUNT_REVENUE = 1000;
    private $id;
    private $customer_id;
    private $items = array() ;
    private $total;
    private $cat1;
    private $cat2;
    private $cheapestCat1Object;
    private $discount1 = false;
    private $discount2 = false;
    private $discountLoyal = false;

    

    public function setDiscount1(bool $bool) {
      $this->discount1 = $bool;
    }

    public function getDiscount1() : bool {
      return $this->discount1;
    }
    public function setDiscount2(bool $bool) {
      $this->discount2 = $bool;
    }
    public function getDiscount2() : bool {
      return $this->discount2;
    }
    public function setDiscountLoyal(bool $bool){
      $this->discountLoyal = $bool;
    }
    public function getDiscountLoyal() : bool {
      return $this->discountLoyal;
    }
    /**
     * Get the value of customer_id
     */ 
    public function getCustomer_id()
    {
          return $this->customer_id;
    }
    
    
    /**
     * Get the value of total
     */ 
    public function getTotal()
    {
          return $this->total;
    }

    public function ConvertInputToOrder($input){
        $this->id = $input->id;
        $this->customer_id = $input->{'customer-id'};
        $this->items = $input->items;
        $this->total = $input->total;
      }
      
    public function GetProductDetailsIntoOrder($products){
        foreach ($products as $product) {
          foreach ($this->items as $item) {
            if ($product->id == $item->{'product-id'}){
              $item->category = $product->category;
              $item->description = $product->description;

              return;
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
            $this->setDiscount1(true);
          }
        }
        $this->total -= $this->cheapestCat1Object * self::DISCOUNT_PERCENTAGE;

      }
    public function giveFreeCat2() {
        foreach ($this->items as $item) {
          if ($item->category == "2"){
            $item->quantity += floor($item->quantity/self::DISCOUNT_EXTRA_ITEM);
            $this->setDiscount2(true);
          }
        }

      }
    public function LoyalCustomerDiscount(){
        $this->total *= self::DISCOUNT_LOYAL;
        $this->setDiscountLoyal(true);
    }
    public function applyDiscounts($customer){
        $this->CountCategories();
        if ($this->cat1 >= self::DISCOUNT_AMOUNT_FOR_PERCENTAGE){
            $this->discountCheapestCat1();
        }
        if ($this->cat2 >= self::DISCOUNT_EXTRA_ITEM){
            $this->giveFreeCat2();
        }
        if ($customer->revenue >= self::DISCOUNT_REVENUE){
            $this->LoyalCustomerDiscount();
        }
    }

}