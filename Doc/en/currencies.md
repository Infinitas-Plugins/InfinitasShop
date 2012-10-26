### Default currency

The default currency used in the store is the one that has a value equal to `1`. This is the currency that products will be displayed to when a new customer visits the store for the first time, and also the currency that is used throughout the admin [backend](/admin/shop/shop\_currencies).

> If by chance a currency conversion rate is exactly `1:1` the store owner will need to rather configure it as `1.00001` or `0.99999` so that the default will be correcly used.

### Currency configuration
You are able to configure any number of currencies through the backend. You are also able to select how that currency will be displayed to users. Some of the options available include:

- Code: The standard 3 char code for the currency such as `GBP` or `USD`
- Factor: This is the currency exchange rate
- Whole symbol: The major unit symbol such as `$` or `£`
- Fraction symbol: The minor unit symbol such as `c` or `p`
- Symbol position: Place the symbol in front of or behind the amount
- Decimal places: Specify the number of decimal places such as `$1.455` vs `$1.46`
- Zero value: What is shown when an amount is 0. eg: `Zero`, `0.00` or `-`
- Negative: How negative numbers are displayed. `-$5.99`

> A special case for negative values is using `()`. With this will get an output similar to `($4.99)` vs the usual `-$4.99`

### Currency updates

Currencies can be configured to update periodically using the built in [crons](/infinitas\_docs/Crons/crons) or [jobs](/infinitas\_docs/InfinitasJobs/jobs). Store owners are also able to update all currencies with a single click through the admin [backend](/admin/shop/shop\_currencies).

There is also the option of manually editing currencies one by one through the usual CRUD methods.

### Currencies in the frontend

Customers are able to select from the available currencies whilst shopping. The selecte currency is stored in the session and used until changed. In order to make the selected currency more permanet it is also saved to a cookie with a long life time.

Customers will only be able to select from currencies that are active. Store owners are able to disable any currency (besides the default) from the backed.

Currently currencies do not affect [payment methods](/infinitas\_docs/Shop/payment_methods). The currency a user selects is for display only and all sales will be proceced using the default currency.
