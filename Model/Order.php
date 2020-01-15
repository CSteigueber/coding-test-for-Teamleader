<?php
Class Order {
    public $id;
    public $customer_id;
    public $items=array();
    public $total;
    public $cat1; # count the amount of category1 items in the order
    public $cat2; # count the amount of category2 items in the order
    public $cheapestCat1Object;
    public $discount1=false;
    public $discount2=false;
    public $discountLoyal=false;
}