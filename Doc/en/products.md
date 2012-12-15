### Managing products

Products are complex and can be made in a number of ways. The major components of a product are listed below.

- [Product Types](/infinitas\_docs/Shop/products-types): The type of product
- [Images](/infinitas\_docs/Shop/images): The products images
- [Categories](/infinitas\_docs/Shop/categories): The categories the product belongs to
- [Suppliers](/infinitas\_docs/Shop/suppliers): The default supplier
- [Brand](/infinitas\_docs/Shop/brands): The brand of the product
- [Stock](/infinitas\_docs/Shop/stock): The stock available
- [Options](/infinitas\_docs/Shop/products-options): The options for the product
- [Attributes](/infinitas\_docs/Shop/products-attributes): The products attributes
- [Specials](/infinitas\_docs/Shop/products-specials): Specials the product has
- [Featured](/infinitas\_docs/Shop/products-featured): Featured products

Besides the above, products are also made up of the following details.

#### Name

The name of the product is what is displayed to customers on the frontend. This should have good [SEO](/infinitas\_docs/Shop/seo) as well as being enticing to visitors to the store.

#### Slug

The slug is what is displayed in the url and should, like the name, contain value for [SEO](/infinitas\_docs/Shop/seo). If the slug is left blank it will be automatically generated from the products name.

#### Product Type

The [product type](/infinitas\_docs/Shop/products-types) is a way to [categories](/infinitas\_docs/Shop/categories) products beyond simple cateogries, along with a means to attach [product options](/infinitas\_docs/Shop/products-options) over a wide range of products as opposed to a per product basis.

Product types also have a status option which allows disabling all the products of a particular type should there be a problem with supply or other wise.

#### Product Code

Product codes can function in three distinct ways.

- `Hard coded`: Something like `PROD123` will remain the same regardless of the options available
- `Left empty`: Any product codes defined in [product options](/infinitas\_docs/Shop/products-options) will be joined together as the new product code. This option is not recomened for products without options as you will end up with orders for products without codes.
- `Dynamic`: A mixture of the two options above, you can enter a code like `PROD:size:colour` which would take the base code of `PROD` and append the codes from the **size** and **colour** options to form the final code.

#### Default Image

This is the main [image](/infinitas\_docs/Shop/images) that will be displayed throughout the store. Customers will see this image in product listings and normally as a larger image on product pages.

#### Available

This is the date when the product will be available from. If the product is already available when creating your product you can leave it at the default. If the product is not yet available you can set this field for a future date and the product will automatically become available after the specified date.

#### Categories

These are the [categories](/infinitas\_docs/Shop/categories) to which the product is available in. This allows you to have a product appear in multiple places throught the store without having to create duplicates of the product.

A product needs to be in at least one active category before it will become available to customers.

#### Active

Check this box to make the product active. There are a number of other factors that will prevent a product from being available to customers. The [backend](/admin/shop/shop\_products) will display an information box when hovering over an inactive product status icon.

#### Details and Specifications

These are free form text fields that can be used for entering the details for the product. If required they can be configured to use a [wysiyg editor](/infinitas\_docs/Libs/wysiwyg) for creating [HTML](http://en.wikipedia.org/wiki/HTML) markup easily.

#### Images

Should your product have more than one [image](/infinitas\_docs/Shop/images) you can select additional images from your image library. There is no limit to the number of images that can be added to a product, but a large number of images can impact the loading speed of pages.

#### Quantities

#### Quantity Unit

This is the multiples that a product is sold in, for example you may be selling rope and supply in multiples of `0.5 meters`. Setting this to `0.5` will **not** allow customers ordering `0.75` for example, but `2.5` __would be valid__.

#### Quantity Minimum

This is the minimum amount that can be purchased. Users will not be able to order a quantity **below** this amount

#### Quantity Maximum

This is the maximum amount that can be purchased. Users will not be able to order a quantity **above** this amount

#### Supplier

This is the [default supplier](/infinitas\_docs/Shop/suppliers) for the product. When adding new [stock](/infinitas\_docs/Shop/stock) this supplier will be selected by default. A disabled supplier will prevent a product from displaying to customers.

#### Brand

The brand is another way of categorising products over and above the usual [categories](/infinitas\_docs/Shop/categories). Besides classification there is no other use for [brands](/infinitas\_docs/Shop/brands). Brand lists can be made available to customers and can also be used to filter and order products.

#### Costing

A product has three price values attached, the `cost` which is how much you are paying for the product, `selling` which is the selling price customers would usually pay for the product and `retail` which is the general or [RRP](http://en.wikipedia.org/wiki/Recommended_retail_price) of the particular product.

Any business that is going to be profitable needs to have good records of what is being spent vs what is being made. Inputing all these details make the job of accounting and paperwork much more simple leaving more time for other tasks. All sales are recorded with the current `cost` price of a product so historic data is available, including things such as average cost.

The Infinitas Shop is able to show products that are not making has much money as they should be, or report on products selling below cost. The cost information used together with conversion rates is also used to automate tasks such as creating [featured products](/infinitas\_docs/Shop/products-featured) and [specials](/infinitas\_docs/Shop/products-specials).

#### Pricing products

When you create a product with options there are a number of factors that influence the final price that is displayed to the customer. This section will not deal with specials and discounts as those are normally applied after the actual price for the product has been calculated.

The first place a price comes from is the products __master__ variant. This is the record that holds information on the default price and size. If all variants are the same price there is no need to set up any other pricing related to the product.

Next up you can set prices for specific variants. These prices will override the __master__ price. For example you have a `shirt` product with size option `small`, `medium` and `large`. Set the price for the product as `10.00` and both variations would come out as `10.00`. If you wanted to charge slightly more for the `large` shirt you could specify its price independent of the other variants.

Another factor that determines price is the price set on options. Taking the above example, if you had a number of products using the `size` option and did not want to set the price for every large variant in the store you could add a price to the `large` option directly that will be added to the price of all variants with the `large` option attached. This allows managing the price of similar things with less admin overhead.

If you are using the option price and have a product variant that does not match exactly you can specify that product variants price directly, which will overload the option price change.

#### Stock

When creating a product you are given the opportunity to enter the starting [stock](/infinitas\_docs/Shop/stock) for the product. Once it is created you `can not` edit the stock. Instead you are able to adjust stock values through the stock manager.

#### Options

#### Attributes

#### Specials

#### Featured
