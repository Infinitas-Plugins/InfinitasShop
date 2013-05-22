### Notes

Notes can be attached to an order in many ways. The shop plugin uses notes to show users the status of their order and admins can manually add notes to update the user with any delays or changes to an order.

The main parts of a note include:

- internal: This makes the note only visible to admins. 
- notify\_user: This will send out an email once submitted so the user will know there has been an update
- status: This is the order status such as `pending` or `shipped`
- note: Free text field to give the user any update

> If a note is set to `notify\_user` then it can not be internal as the use will get an email with the contents of the note. The internal field will be forced to false.

The initial idea was to be able to track the status of the order while keeping the history in tact. This means that the `status\_id` field could not reside within the order table. The table grew a bit to include the other features listed above which allow admins to make private notes and update the user from directly within the application.