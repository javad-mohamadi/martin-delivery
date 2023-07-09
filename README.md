=============================== Martin Delivery ===============================

    php version 8.2, mysql version 8.0.33


- you can run the project by following the steps below:

    - clone the project
    - copy .env.example to .env
    - composer install
    - set db environment
    - crate database
    - run migration
    - run seeder
    - run php artisan passport:keys for generate oauth keys

    - Login as admin and super admin to check and view orders and courier orders:
      superadmin@test.com 
      admin@test.com
    
    - login as a company service for register order:
      shop company : shop.company@test.com 
      food company : food.company@test.com 
      password = 123456

    - login as a courier service for accepted order:
      pedram courier : pedram.courier@test.com 
      peyman courier : peyman.courier@test.com 
      password = 123456
    

=============================== Martin Delivery ===============================

- Complex APIs (prefix: /api/v1)

- login:
    - POST /login

- company order list:
    - GET /company/orders

- create order:
    - POST /company/orders
    - example request body :{
      {
      "company_id":1,
      "provider_name":"shop company",
      "provider_mobile":"09213910615",
      "provider_address":"num6 25 alley goal street tehran",
      "provider_latitude":"32.8795521",
      "provider_longitude":"52.5487124",
      "receiver_name":"alex joseph",
      "receiver_mobile":"09359341940",
      "receiver_address":"num12 85 alley malek street tehran",
      "receiver_latitude":"31.5487965",
      "receiver_longitude":"51.5487124"
       }

- show order:
    - GET /company/orders/{id}
    - example request params:
        {
            "company_id":1
        }

- update company order:
   - GET /company/orders/{id}
   - example request body:
   - {
     "status":"canceled",
     "company_id":1
     }
  
- Courier APIs (prefix: /api/v1)

- login:
    - POST /login

- list of courier own orders
    - GET /courier/orders

- list of all pending orders
    - GET /courier/orders/pending

- register accepted courier order:
    - POST /courier/orders
    - example request body:
    - {
      "order_id":2
      }
  
- update status of courier order(accepted, received, delivered, emergency_canceled):
    - PATCH /courier/orders/{id}
    - example request body:
       {
        "status":"accepted" or "received" or "delivered" or "emergency_canceled"
        }
