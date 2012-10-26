### Shipping options

Shipping options can be configured from the [backend](/admin/shop/shop\_shipping\_methods) in a number of ways. Besides setting up the usual information such as rates tables you are also able to control exactly who uses which shipping method.

* Specify that a particular method is only for _guests_ or _logged in_ [customers](/infinitas\_docs/Shop/user\_types)
* Specify the **minimum** and / or **maximum** amount a shipping method can be used for

    Method A is only available for orders `above` $10.00

Other information that can be configured on a shipping method includes

- Add aditional surcharge for a particular shipping method
- Estimated delivery time

    If estimate on shipping is 48 hours, the time displayed to the user would be the max lead time for the products in the cart + the delivery estimate

### Creating a shipping method

Before creating a shipping method you should configure a [shipping provider](/infinitas\_docs/Shop/suppliers). Shipping methods are linked to suppliers so that you can easily track expenses that you may incur running your online store.

Once you have configured the shipping provider you can start adding shipping methods. If you were doing `Royal Mail` for example, you would start by creating a method called `First Class`. 

Within the `First Class` method you can create rates for different types such as registered, normal and / or international. Each of the various rates can be configured as described above.

### Shipping providers

Shipping methods are linked to a specific suppliers. This enables the application to track all shipping expenses incured through running your online business. It also enables you to store various contact information such as email, phone and address of the provider allowing you to have access to all the information regarding your business in one place.