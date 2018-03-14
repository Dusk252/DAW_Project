## Shopping cart website - college project for web application development

The relevant controllers, models, views, and scripts for a shopping cart CodeIgniter project. The sample website can be seen at https://test-pure-imagination.000webhostapp.com/index.php/
This website is simply a proof of concept. No business is being made through it and all information exists at title of example.

Playing around with the admin area can be done by logging in with the following credentials:
```email: admin@admin.com
password: admin```
User accounts can simply be created. No email confirmation so no valid addresses required.

###Known issues:
- Adding items to cart and then logging in works - the items will be added to cart upon log in. However, this featured was not implemented completely. There's no support to viewing the cart nor any indicator of the amount of items currently in the cart for non-logged in users.
- Quantity updating only checks for valid values (integers higher than zero (zero results in removal)) using javascript. If a browser is blocking scripts, quantity updating will not check for invalid values. Any non-integer character will turn into a zero, and zero will be added to the database. This is the only feature that breaks without javascript.
- The CSS-only front page products carroussel does not loop correctly.