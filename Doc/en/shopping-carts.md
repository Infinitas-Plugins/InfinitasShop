### Shopping carts

All shopping cart information within Infinitas Shop is stored in the database. This is due to the complex relations of products and options, but also to allow reporting in the backend such as what products have been aded to the cart but not bought, carts that have been abandoned and so on.

As all the information is stored in the database, shopping carts work the same for guest customers and logged in customers.

### Shopping cart vs Wish list

Customers are able to create multiple `shopping lists`. There is little distinction between a **shopping cart** and a **wish list**. The current list being used is stored within the session and a cookie. Which ever list is currently selected and stored in the session will be the customers **shopping cart**. 

Customers are able to add products to any of their lists at any point. They may also switch to and checkout any list they have created at any point through their shopping session.

### Shopping list config

Each shopping list can be configured with a default shipping and or billing address. Customers may also configure the default payment method and shipping options. These presets can be changed on checkout through the usual means, and new options can also be saved to replace existing configuration.

This allows customers to easily create lists for home and work, or save products for later purchases while still being able to purchase products in one of their other shopping lists

### Checkout

Once a customer has finished shopping they would open the checkout page, finalise any options and complete the purchase. If they are using a [payment method](/infinitas_docs/Shop/payment\_methods) such as PayPal they would be redirect to the payment gateway to pay. 

At this point the items in the selected shopping cart would be cleared and the order created. Normally an email would be sent detailing and confirming the order that has been placed. The shopping list would still be available but would be empty as it was before they started shipping.

### Guest Checkout

If the shop is configured to allow guest checkout, guests would be able to purchase products just as regular logged in customer would do. There should be no noticable difference shopping as a guest or as a logged in customer
