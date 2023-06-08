=== WooCommerce Multi Locations Inventory Management ===
Contributors: techspawn
Tags: woocommerce, warehouse, multi warehouse, multi locations, simple, variable, products, product
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html

This plugin will help you manage WooCommerce Products stocks through multiple locations.

== Description ==

This is the long description.  No limit, and you can use Markdown (as well as in the following sections).


= Features =

- New taxonomy for stock warehouses / locations
- Works on both, simple and variable products
- Easy management of stock with multiple Warehouses / locations
- Auto order allocation for warehouses / locations stock reduction
- Find your nearest Warehouse using Zipcode / Pincode
- Auto Warehouse assign to the product

= Compatibility =

- PHP 7+


== Installation ==

1. Upload "wcmlim" to the "/wp-content/plugins/" directory.
2. Check if you have WooCommerce 3.4+ plugin activated
3. Activate WooCommerce Multi Locations Inventory Management plugin through the "Plugins" menu in WordPress.

**Simple Products**

1. Enable Manage Stock in Inventory Tab > Update Post
2. Under Inventory Tab > Manage the stock for the Warehouse / Locations

**Variable Products**

1. Under Variations Tab > Create variations based on attributes
2. In each variation > Activate Manage Stock & Add Price > Update Post
3. In each variation > Manage the stock for the Warehouses / Locations for each variation

For documentation visit our [Website](https://techspawn.com/docs/woocommerce-multi-locations-inventory-management/).

== Frequently Asked Questions ==

== Screenshots ==
== Changelog ==


= Version 3.4.9 =
Fix: Product is adding, without selecting location.

= Version 3.4.9 =
Fix: Product is adding to the cart even if they are out of stock.

= Version 3.4.9 = 
Fix: Showing quantity of restricted location to user.

= Version 3.4.9 =
Fix: Restrict User for specific location, now user can see only location which is restricted for them if any.

= Version 3.4.8 =
Fix: Location Enable/Disable For Each Product (also added validation on shop page)

= Version 3.4.8 =
Fix: Tax Mapping Critical bug fixed

= Version 3.4.7 =
Fix: Stock status issue on Product listing page.


= Version 3.4.6 =
Fix: Back end only mode Closes Location PHP 8+ Fix.

= Version 3.4.5 =
Add: Added message for closest location.

= Version 3.4.1 =
Fix: Added code for allow Backorder for each location for Simple Product for list view

= Version 3.4.0 =
Fix: Sort Filter Issue
Fix: UI Issue.
Fix: Added allow Backorder for each location code for Simple Product

= Version 3.3.9 =
Fix: UI Issue.
Fix: Restock issue fix according to location

= Version 3.3.8 =
Fix: Update validation for Custom Location fee.

= Version 3.3.7 =
Fix: Flatsome Theme Issue.

= Version 3.3.5 =
Fix: Limit location per order Issue.

= Version 3.3.4 =
Fix: Order Filter Issues.

= Version 3.3.3 =
Add: Location open time and close time in advanced list view.

= Version 3.3.2 =
ADD- Custom Fee for each location
FIX- Shop Add to Cart instock  product product 

= Version 3.3.1 =
ADD- Given provision for location wise stock management on product level with manage stock disablement
Add: Code for assign only one Openpos outlet for one location
Fix: Improved code for Openpos outlet was auto assigned to every location.
Add: Code for restore location stock value for Failed /Refund order status

= Version 3.2.9 =
Fix: UI Fix
Fix: Improved code for BOM - Location as per shipping zone for simple and variable product.

= Version 3.2.8 =
Fix: location filter widget settings its refreshed and navigates to other page
Fix: Improved user specific location restriction for guest users.

= Version 3.2.7 =
Fix: validation on Location register

= Version 3.2.6 =
Fix: Location is not selected in location dropdown view for variable product
Fix: UI issue
Add: Code for set selected location from location switcher on location list view for variable product
Fix: Hide location to Guest User to choose


== Changelog ==
= Version 3.2.5 = 
Fix: Total stock is not updated on product central when order is placed from WCPOS frontend.[Git Issue]

== Changelog ==
= Version 3.2.4 =
Fix:Total stock is not reducing after deleting the location.

== Changelog ==
= Version 3.3.7= October 01, 2022
[Fix] Simplify backend-only mode settings.
[Fix] Backorder setting is not working for variable product
[Fix] The checkout page is always loading with Backend only modes 2nd rule 
[Fix] Show address details >It displays the street address twice on the product details page with list view.
[Fix] Hide the location dropdown on the product page if the stock status for a specific product variation is disabled.

== Changelog ==
= Version 3.2.1= September 24, 2022
[Fix] Facing error on checkout page "Error processing checkout. Please try again" Can't place an order.
[Fix] Local pickup location(Back end only mode) Issue for both simple and variable product
[Fix] Added validation > Multilocation > Local Pickup location when the product stock is 0


== Changelog ==
= Version 3.2.0 =
Fix: UI and UX fixes
Fix: Stock Notification[Total Stock == Location Stock]

== Changelog ==
= Version 3.1.10 =
Fix: Backend Only Mode select location as per priority fix

== Changelog ==
= Version 3.1.9 =
Fix: Local Pickup Location on checkout
Fix: UI and UX fixes

= Version 3.1.8 =
Fix: UI UX Improvements
Fix: Force user to select location popup fix


= Version 3.1.7 =
Fix: Detect location setting location selection
Fix: Select Closest location to Customers shipping address [Backend only mode]

= Version 3.1.6 =
Fix: Select Closest location to Customers shipping address [Backend only mode]

= Version 3.1.5 =
Add: Added locations for add to cart on shop page.

= Version 3.1.4 =
Add: Display locations on order edit page for Nearby Instock Location by Shipping Address

= Version 3.1.3 =
Fix: Minor Fixes

= Version 1.2.9 =
Add: Inline location stock and price edit on product listing page

= Version 1.1.5 =
Update: User interface design preview for stock information box
Add: Control options to updated for Front End Visual Display like color, border, text input
Add: Live Preview mode added on display setting tab

= Version 1.1.4 =
Add: Create Sub-location under locations
Add: Assign Payment Methods to locations
Add: Hide/show location on frontend 

= Version 1.1.3 =
Add: assign Shop Managers to locations
Fix: Enhanced way to store inventory in database

= Version 1.1.2 =
Add: Restrict customers to specific locations
Add: Compressed js files for better speed

= Version 1.1.1 =
Add: Locations Distance from the entered address 
Add: Option to add location-wise price

= Version 1.1.0 =
Note: If you are upgrading from 1.0.0, previously created locations will be deleted, and need to create those once again.
Add:  Assign Shipping zones to each location
Add:  Shortcode to select a sitewide location
Add:  Option to detect visitors location and set nearby location

= Version 1.0.0 =
- Initial Realase.
