# internet-programming-sem5

This is a ERP website where users can either login as shopkeepers, customers or admin. Fill in their respective profile details and shop for their favourite items.

## Getting started
* clone the project into xampp/htdocs folder
```sh
git clone https://github.com/soham-1/internet-programming-sem5.git
```

## Run on Docker :whale2:
### build containers
```sh
docker-compose up -d --build
```
* access the site on [http://localhost:8100/views/](http://localhost:8100/views/)
* access the phpmyadmin on [http://localhost:8082/](http://localhost:8082/)
* import the erpdb.sql file in Erp/Database folder into ErpDb in phpmyadmn

### stop container
```sh
docker-compose stop
```
### start again using
```sh
docker-compose start
```

## Run locally
### Prerequisites
* PHP (xampp or any php server)
### steps
- Create database ErpDb in phpmyadmin
- import the erpdb.sql file in Erp/Database folder into ErpDb in phpmyadmn
- start the xampp server and mysql server
- access the using localhost port and address till ErpSite/views

## Workflow
* create a user account of each of the types
  * customer
  * enterprise
  * admin
* set up the profile page first and then browse to other pages.
* as enterprise account, add different products to inventory so customers can see order and pay for them
* as customer do some transactions (shopping), so enterprise can see a report of their sales
* give feedbacks from customer and enterprise, so admin can see a overall report of users.

### functionalities of all stakeholders
1. Enterprise
    - ✅ set profile
    - ✅ add inventory
    - ✅ send email reminders for uncleared payments ( in file pending_payments.php set the necessary details from line 45 onwards)
    - ✅ view reports for sales (categorical and historical)

2. Customer
   - ✅ set profile
   - ✅ shop
   - ✅ view list of shops providing particular product
   - ✅ add to cart
   - ✅ order
   - ✅ pay using paytm id
   - ✅ pay later
3. Admin
   - ✅ remove user
   - ✅ view feedback analysis from users

## web pages
### profile and add_prod
<img src="/screenshots/profile.PNG" alt="screenshot" width="400" height="400"><img src="/screenshots/add_prod.PNG" alt="screenshot" width="400" height="400" align="right">

### inventory
<img src="/screenshots/inventory.PNG" alt="screenshot" width="600" height="400">

### payment reminder
<img src="/screenshots/payment_reminder.PNG" alt="screenshot" width="700" height="400">

### sales report and shopping
<img src="/screenshots/sales_category.PNG" alt="screenshot" width="300" height="300"> <img src="/screenshots/shopping.PNG" alt="screenshot" width="300" height="300" align="right">

## Deployements
heorku - https://sheltered-chamber-70498.herokuapp.com (currently not active)

## Authors
> soham patkar https://github.com/soham-1

> hemantkumar yadav https://github.com/hemant-17

> preet thakker https://github.com/preetthakker
