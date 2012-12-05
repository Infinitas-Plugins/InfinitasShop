Product options are used to build multiple similar products with a single physical product in the store. For example you my be selling t-shirts and instead of creating and maintaing many variations such as `small red` shirt, `large blue` shirt etc, you can create one `shirt` product and various options such as `size` and `colour`.

> Currently it is not possible to track stock for product options. This is planned for future versions but can be worked around by creating multiple products with less options.

[![](http://assets.infinitas-cms.org/docs/Plugins/Shop/products/product-options.png)](http://assets.infinitas-cms.org/docs/Plugins/Shop/products/product-options.png)

Products that have options attached will automatically add a tab to the product details at the bottom of the page. This will explain the options in more detail and hilight what has been selected by the customer. Customers are also able to click the options listed in the table to select what they require when purchasing.

[![](http://assets.infinitas-cms.org/docs/Plugins/Shop/products/product-option-details.png)](http://assets.infinitas-cms.org/docs/Plugins/Shop/products/product-option-details.png)

### Creating options

- Select options
- Text options
- Checkbox options
- File upload options

[![](http://assets.infinitas-cms.org/docs/Plugins/Shop/products/product-options-admin.png)](http://assets.infinitas-cms.org/docs/Plugins/Shop/products/product-options-admin.png)

#### Select options

There are a few different kinds of options a product can have, the most common is a selection such as the size or colour of the product. When creating options like this for your products you will be required to enter `option values`.

For an option like **colour** you might add `option values` like `red`, `green` and `blue`. These will be available as a selection to the customer when purchasing the product (if the option is active)

> Options can be set to required or optional. Optional products do not require the customer to select or enter a value.

#### Input options `planned`

Another type of option you may add to a product could be free text. This is great for products that require personalisation such as engraving on a trophee or other customisations.

From the backend you would be able to specify how this option affects the price, for example you might charge `per letter` or `per word` for the customisation. It could also be no charge.


#### Checkbox option `planned`

This option will create a checkbox that the user could select. For example if your product has an `up size` option, or something similar.


#### File upload `planned`

You can use this option if your product requires the customer to upload a file when purchasing. For example if you are selling business cards and need them to upload artwork with the purchase you can use this type of option.

> When building a product code it is not required to use all the options. This means you can have an input for free text that does not affect the final product code.

### Product codes

There are three different ways to handle product code for your products when dealing with options.

#### Fixed product code

The first, most simple way is to enter the product code in the product form. This will mean that all products, no matter the option will use the same code. EG: you have `shirts` with size and colour options, no matter which size or colour is purchased all products would have the original product code.

#### Variable based on option

The second way of dealing with product codes is to enter the code in the option. This is good for products that normally only have a single option to select from. Eg: you are selling shoes and the option is `size`. Each size would have the full product code while the code in the product is left blank.

[![](http://assets.infinitas-cms.org/docs/Plugins/Shop/products/product-code-option-admin.png)](http://assets.infinitas-cms.org/docs/Plugins/Shop/products/product-code-option-admin.png)

#### Dynamic

If you are making use of options and would like to differentiate products of the same type with different options you can use dynamic product codes. When creating a product you are able to insert **place holders** in the product code field that link back to product options.

[![](http://assets.infinitas-cms.org/docs/Plugins/Shop/products/product-code-admin.png)](http://assets.infinitas-cms.org/docs/Plugins/Shop/products/product-code-admin.png)

The place holders are the __product option__ alias prefixed with a `:`, such as `:size` or `:colour` depending on the alias given to the option. You can also mix in static text which allows having a **base** code which changes based on the options selected.

If you had the options `colour` and `size` with codes like `s`, `m` and `l` with `red` and `green` for colour you could build codes like the following:

- `:colour-:size` would output something like **red-m**
- `PROD123-:colour (:size)` would output **PROD123-green (s)**

[![](http://assets.infinitas-cms.org/docs/Plugins/Shop/products/product-code-calculated.png)](http://assets.infinitas-cms.org/docs/Plugins/Shop/products/product-code-calculated.png)

Here the product code has been defined as `TR-:mirror:size` with `:mirror` having the code as `BH` for the **both horizontal** option value and `125` for the **125mm** option value.