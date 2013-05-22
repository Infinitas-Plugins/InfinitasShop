### Order status

The status for orders is not stored directly within the order model in order to keep the history of the order in tact. This will allow for late functionality such as being able to calculate the average dispatch time or time to resolve issues.

### Statuses

There are a couple of core statusses which should cover all aspects of orders. Custom statuses can be created which are linked to the core statuses as aliasses. These should assist any store owner to manage their own work flow related to the order process from pending through to completed or canceled.


- Canceled: Order was canceled by either party, either before or after payment
- Pending: Order has been placed, but awaiting payment or other details
- Processing: Order is being processed, payment has been made but not yet sent
- Processed: The order has been processed, possibly shipped or awaiting signature
- Completed: Order is complete, customer has (or should have) had it already
- Reversed: Order is returned, refunded, replaced etc.

> Each core status could have any number of statuses attached to it.