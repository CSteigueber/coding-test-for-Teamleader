# Choice of task:

I chose to work on the backend problem with the discounts.

# Time investment:

This repository was created within 24 hours.

# Running the program:

To run the program please execute Model/model.php
Which order to read is hardcoded in model.php because I didn't focus on how to receive the order and rather coded the discount calculation.

# Reasoning of the program:

First the .json files are incorporated into the program to get the input. The example-order is inserted into the $input variable.
In the next step an Order object is created and fed with the input data. The data from the products.json is loaded into the Order object to include all necessities for the order.
Next, a customer object is build (from the customers file) matching its id with the customer-id from the order.
In the following step, the order is checked for available discounts, which are applied if reasonable.
At last, an output message is created to communicate the total amount the customer has to pay, as well as information about the applied discounts.  

# Further reasoning:

I created an Order class to increase readability, maintenance, and reusability of the code.
All functions concerning the Order object are included as methods. Again, I hope this eases readability, maintenance and reusability.

Below is the original readme.md file provided by [Teamleader](https://www.teamleader.eu/company/engineering) (with minor changes)
# ------------------------------------------------------

# Coding Test

Do you want to join the engineering team at [Teamleader](https://www.teamleader.eu/company/engineering)? -> Yes I do!

We have created this exercise in order to gain insights into your development skills.

## What to do?

We have several problems to solve. Our recruiter would have normally told you which one(s) to solve.

You are free to use whatever technologies you want, unless instructed otherwise.

- [Problem 1 : Discounts](./1-discounts.md)              -> I chose this problem 
- [Problem 2 : Ordering](./2-ordering.md)
- [Problem 3 : Local development](./3-local-development.md)

## Procedure

We would like you to send us (a link to) a git repository (that we can access).  

Make sure to add some documentation on how to run your app.

There is no time limit on this exercise, take as long as you need to show us your development skills.

## Problems?

Feel free to contact us if something is not clear.
