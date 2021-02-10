<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->add('/changepassword', 'Home::changepassword');

$routes->add('/login', 'A_login::index');
$routes->add('/logout', 'A_login::logout');

$routes->get('/users', 'A_user::index');
$routes->add('/user/add', 'A_user::add');
$routes->add('/user/edit/(:num)', 'A_user::edit/$1');
$routes->add('/user/delete/(:num)', 'A_user::delete/$1');

$routes->get('/groups', 'A_group::index');
$routes->add('/group/add', 'A_group::add');
$routes->add('/group/edit/(:num)', 'A_group::edit/$1');
$routes->add('/group/delete/(:num)', 'A_group::delete/$1');

$routes->get('/menu', 'A_menu::index');
$routes->add('/menu/add/', 'A_menu::add/$1');
$routes->add('/menu/edit/(:num)', 'A_menu::edit/$1');
$routes->add('/menu/delete/(:num)', 'A_menu::delete/$1');

$routes->get('/banks', 'Bank::index');
$routes->get('/bank/add', 'Bank::add');
$routes->get('/bank/edit/(:num)', 'Bank::edit/$1');
$routes->get('/bank/delete/(:num)', 'Bank::delete/$1');

$routes->get('/tire_positions', 'Tire_position::index');
$routes->get('/tire_position/add', 'Tire_position::add');
$routes->get('/tire_position/edit/(:num)', 'Tire_position::edit/$1');
$routes->get('/tire_position/delete/(:num)', 'Tire_position::delete/$1');

$routes->get('/tire_sizes', 'Tire_size::index');
$routes->get('/tire_size/add', 'Tire_size::add');
$routes->get('/tire_size/edit/(:num)', 'Tire_size::edit/$1');
$routes->get('/tire_size/delete/(:num)', 'Tire_size::delete/$1');

$routes->get('/tire_brands', 'Tire_brand::index');
$routes->get('/tire_brand/add', 'Tire_brand::add');
$routes->get('/tire_brand/edit/(:num)', 'Tire_brand::edit/$1');
$routes->get('/tire_brand/delete/(:num)', 'Tire_brand::delete/$1');

$routes->get('/tire_types', 'Tire_type::index');
$routes->get('/tire_type/add', 'Tire_type::add');
$routes->get('/tire_type/edit/(:num)', 'Tire_type::edit/$1');
$routes->get('/tire_type/delete/(:num)', 'Tire_type::delete/$1');

$routes->get('/tire_patterns', 'Tire_pattern::index');
$routes->get('/tire_pattern/add', 'Tire_pattern::add');
$routes->get('/tire_pattern/edit/(:num)', 'Tire_pattern::edit/$1');
$routes->get('/tire_pattern/delete/(:num)', 'Tire_pattern::delete/$1');

$routes->get('/tires', 'Tire::index');
$routes->get('/tire/add', 'Tire::add');
$routes->get('/tire/edit/(:num)', 'Tire::edit/$1');
$routes->get('/tire/delete/(:num)', 'Tire::delete/$1');

$routes->get('/vehicle_types', 'Vehicle_type::index');
$routes->get('/vehicle_type/add', 'Vehicle_type::add');
$routes->get('/vehicle_type/edit/(:num)', 'Vehicle_type::edit/$1');
$routes->get('/vehicle_type/delete/(:num)', 'Vehicle_type::delete/$1');

$routes->get('/vehicle_brands', 'Vehicle_brand::index');
$routes->get('/vehicle_brand/add', 'Vehicle_brand::add');
$routes->get('/vehicle_brand/edit/(:num)', 'Vehicle_brand::edit/$1');
$routes->get('/vehicle_brand/delete/(:num)', 'Vehicle_brand::delete/$1');

$routes->get('/vehicles', 'Vehicle::index');
$routes->get('/vehicle/add', 'Vehicle::add');
$routes->get('/vehicle/edit/(:num)', 'Vehicle::edit/$1');
$routes->get('/vehicle/delete/(:num)', 'Vehicle::delete/$1');

$routes->get('/customers', 'Customer::index');
$routes->get('/customer/add', 'Customer::add');
$routes->get('/customer/edit/(:num)', 'Customer::edit/$1');
$routes->get('/customer/delete/(:num)', 'Customer::delete/$1');

$routes->get('/suppliers', 'Supplier::index');
$routes->get('/supplier/add', 'Supplier::add');
$routes->get('/supplier/edit/(:num)', 'Supplier::edit/$1');
$routes->get('/supplier/delete/(:num)', 'Supplier::delete/$1');

$routes->get('/supplier_groups', 'Supplier_group::index');
$routes->get('/supplier_group/add', 'Supplier_group::add');
$routes->get('/supplier_group/edit/(:num)', 'Supplier_group::edit/$1');
$routes->get('/supplier_group/delete/(:num)', 'Supplier_group::delete/$1');

$routes->get('/items', 'Item::index');
$routes->get('/item/add', 'Item::add');
$routes->get('/item/edit/(:num)', 'Item::edit/$1');
$routes->get('/item/delete/(:num)', 'Item::delete/$1');

$routes->get('/item_prices', 'Item_price::index');
$routes->get('/item_price/edit/(:num)', 'Item_price::edit/$1');

$routes->get('/costings', 'Costing::index');
$routes->get('/costing/add', 'Costing::add');
$routes->get('/costing/edit/(:num)', 'Costing::edit/$1');
$routes->get('/costing/delete/(:num)', 'Costing::delete/$1');

$routes->get('/item_brands', 'Item_brand::index');
$routes->get('/item_brand/add', 'Item_brand::add');
$routes->get('/item_brand/edit/(:num)', 'Item_brand::edit/$1');
$routes->get('/item_brand/delete/(:num)', 'Item_brand::delete/$1');

$routes->get('/item_categories', 'Item_category::index');
$routes->get('/item_category/add', 'Item_category::add');
$routes->get('/item_category/edit/(:num)', 'Item_category::edit/$1');
$routes->get('/item_category/delete/(:num)', 'Item_category::delete/$1');

$routes->get('/item_scopes', 'Item_scope::index');
$routes->get('/item_scope/add', 'Item_scope::add');
$routes->get('/item_scope/edit/(:num)', 'Item_scope::edit/$1');
$routes->get('/item_scope/delete/(:num)', 'Item_scope::delete/$1');

$routes->get('/item_specifications', 'Item_specification::index');
$routes->get('/item_specification/add', 'Item_specification::add');
$routes->get('/item_specification/edit/(:num)', 'Item_specification::edit/$1');
$routes->get('/item_specification/delete/(:num)', 'Item_specification::delete/$1');

$routes->get('/item_sub_categories', 'Item_sub_category::index');
$routes->get('/item_sub_category/add', 'Item_sub_category::add');
$routes->get('/item_sub_category/edit/(:num)', 'Item_sub_category::edit/$1');
$routes->get('/item_sub_category/delete/(:num)', 'Item_sub_category::delete/$1');

$routes->get('/item_types', 'Item_type::index');
$routes->get('/item_type/add', 'Item_type::add');
$routes->get('/item_type/edit/(:num)', 'Item_type::edit/$1');
$routes->get('/item_type/delete/(:num)', 'Item_type::delete/$1');

$routes->get('/customers', 'Customer::index');
$routes->get('/customer/add', 'Customer::add');
$routes->get('/customer/edit/(:num)', 'Customer::edit/$1');
$routes->get('/customer/delete/(:num)', 'Customer::delete/$1');

$routes->get('/customer_calls', 'Customer_call::index');
$routes->get('/customer_call/add', 'Customer_call::add');
$routes->get('/customer_call/edit/(:num)', 'Customer_call::edit/$1');
$routes->get('/customer_call/delete/(:num)', 'Customer_call::delete/$1');
$routes->get('/customer_call/view', 'Customer_call::view');

$routes->get('/units', 'Unit::index');
$routes->get('/unit/add', 'Unit::add');
$routes->get('/unit/edit/(:num)', 'Unit::edit/$1');
$routes->get('/unit/delete/(:num)', 'Unit::delete/$1');

$routes->get('/customer_levels', 'Customer_level::index');
$routes->get('/customer_level/add', 'Customer_level::add');
$routes->get('/customer_level/edit/(:num)', 'Customer_level::edit/$1');
$routes->get('/customer_level/delete/(:num)', 'Customer_level::delete/$1');

$routes->get('/divisions', 'Division::index');
$routes->get('/division/add', 'Division::add');
$routes->get('/division/edit/(:num)', 'Division::edit/$1');
$routes->get('/division/delete/(:num)', 'Division::delete/$1');

$routes->get('/item_receives', 'Item_receive::index');
$routes->get('/item_receive/add', 'Item_receive::add');
$routes->get('/item_receive/edit/(:num)', 'Item_receive::edit/$1');
$routes->get('/item_receive/delete/(:num)', 'Item_receive::delete/$1');

$routes->get('/stock_controls', 'Stock_control::index');
$routes->get('/stock_control/add', 'Stock_control::add');
$routes->get('/stock_control/edit/(:num)', 'Stock_control::edit/$1');
$routes->get('/stock_control/delete/(:num)', 'Stock_control::delete/$1');

$routes->get('/po', 'Po::index');
$routes->get('/po/add', 'Po::add');
$routes->get('/po/edit/(:num)', 'Po::edit/$1');
$routes->get('/po/view/(:num)', 'Po::view/$1');
$routes->get('/po/revision/(:num)', 'Po::revision/$1');
$routes->get('/po/delete/(:num)', 'Po::delete/$1');

$routes->get('/pr', 'Pr::index');
$routes->get('/pr/add', 'Pr::add');
$routes->get('/pr/edit/(:num)', 'Pr::edit/$1');
$routes->get('/pr/view/(:num)', 'Pr::view/$1');
$routes->get('/pr/delete/(:num)', 'Pr::delete/$1');

$routes->get('/so', 'So::index');
$routes->get('/so/add', 'So::add');
$routes->get('/so/edit/(:num)', 'So::edit/$1');
$routes->get('/so/view/(:num)', 'So::view/$1');
$routes->get('/so/delete/(:num)', 'So::delete/$1');

$routes->get('/supplier_invoices', 'Supplier_invoice::index');
$routes->get('/supplier_invoice/add', 'Supplier_invoice::add');
$routes->get('/supplier_invoice/view/(:num)', 'Supplier_invoice::view/$1');
$routes->get('/supplier_invoice/edit/(:num)', 'Supplier_invoice::edit/$1');
$routes->get('/supplier_invoice/delete/(:num)', 'Supplier_invoice::delete/$1');

$routes->get('/invoices', 'Invoice::index');
$routes->get('/invoice/add', 'Invoice::add');
$routes->get('/invoice/view/(:num)', 'Invoice::view/$1');
$routes->get('/invoice/edit/(:num)', 'Invoice::edit/$1');
$routes->get('/invoice/delete/(:num)', 'Invoice::delete/$1');

$routes->get('/quotation', 'Quotation::index');
$routes->get('/quotation/add', 'Quotation::add');
$routes->get('/quotation/edit/(:num)', 'Quotation::edit/$1');
$routes->get('/quotation/view/(:num)', 'Quotation::view/$1');
$routes->get('/quotation/revision/(:num)', 'Quotation::revision/$1');
$routes->get('/quotation/delete/(:num)', 'Quotation::delete/$1');

$routes->get('/maintenance_items', 'Maintenance_item::index');
$routes->get('/maintenance_item/add', 'Maintenance_item::add');
$routes->get('/maintenance_item/edit/(:num)', 'Maintenance_item::edit/$1');
$routes->get('/maintenance_item/delete/(:num)', 'Maintenance_item::delete/$1');

$routes->get('/qrcode', 'Qr_reader::index');

$routes->get('/installations', 'Installation::index');
$routes->get('/installation/add', 'Installation::add');
$routes->get('/installation/view/(:num)', 'Installation::view/$1');
$routes->get('/installation/edit/(:num)', 'Installation::edit/$1');
$routes->get('/installation/delete/(:num)', 'Installation::delete/$1');

$routes->get('/checkings', 'Checking::index');

$routes->get('/subwindow/suppliers', 'Supplier::subwindow');
$routes->get('/subwindow/customers', 'Customer::subwindow');
$routes->get('/subwindow/items', 'Item::subwindow');
$routes->get('/subwindow/vehicles', 'Vehicle::subwindow');
$routes->get('/subwindow/tires', 'Tire::subwindow');

// --------------------------------------------------------------------
$routes->get('/item_histories', 'Item_history::index');

$routes->get('/downloads/(:any)', 'Home::downloads/$1');




/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
