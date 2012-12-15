### Tests

test all counter cache fields

### Misc

pci complicance - http://www.pcicomplianceguide.org/pcifaqs.php#1

add counter cache to ShopProductType

### Stock

add supplier to stock logs
add purchase order to stock logs
add cost to stock logs

stock turn over rate
stock value + per department / whole store

### Purchase orders

generate purchse orders for products based on the supplier for the products purchased
	quantity
	cost
	part number

linked to supplier

new purchses get added to existing PO's

### Images

figure out colour of the image
auto build the virtualFields when using fields array

### Supplier

new fields:
	website
	account number
	contact
add address form in backend
description
Add notes?


### Shopping cart

add special instructions

change product options in the cart

### Product type

add dispatch time which
	added to deliver estimation
		max for all products in cart
		added to product seperatly

link to content layouts for default layout.

### Products

add field to set option selection
	default with configs
	overload per product type, category or product
	Layouts:
		table with radios
		select with ajax

link to content layouts for overload of product type
product attributes - arb values to a product
last viewed
most viewed exculding purchesed (for sending emails with products they are interested in)
others that purchsed this also purchased ...
others that purchsed this also viewed ...
others that viewed this also viewed ...
others that viewed this purchesed ...

watch products - email users when changes occur
	- add checkbox in backend on product for to send mail on save

free products

call for price products

ability to create products on the fly

email admin when stock is low
	add stock limit field (maybe to variants)

search products by supplier

pricing per customer type
	add group_id to ShopPrice
	if null then public
	option to show different prices or only what the user is.


### Product options

Set options to whole categories
Set option to higher up category filters down
overload option values prices per product
option output type
	select	(default)
	file upload (no values, somehow save file for later use),
	input (no values, save somehow)

custom text - price per word / letter

add slug field - look up option by slug (to ignore for importer)


### specials / featured

allow linking specials to categories (product_id should be fk + model)

add field to special
	name (so its easy to find in the backend)

add max usage times

make specials work for the cart (no product specified + code == coupon)

change spotlight product_id to fk + model (allow categories as a spot light)

add php that can create random specials + promotions
	far into the future, with configurable time spans eg: 1 week, 3 days, 1 month etc
	can look for products that are
		new
		less viewed
		less purchased
		high profit margin

### users

shopper type - whole sale, public etc.
cant edit address while order is in progress
leave address name empty to use User full_name

### orders

assign orders to 'staff'
	add staff_id to order


### payments

associate status ids

### shipping

add shipping provider table
	linked to zones
	specify certain providers for zones
	disable supplier disables shipping method
add shippin zone ignore

add flat rate linked to product / category directly
	eg: product tv - flat rate 50GBP
	figure out shipping totals with multi products.
add per product / category surcharge for special cases

### Product promotion

Create a special
	use fixed value off
	% off
	free shipping option
	set start/end date for the special
	link to multiple products
	link multiple specials to a single product (future dates etc)