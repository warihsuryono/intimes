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

$routes->get('/coa', 'Coa::index');
$routes->get('/coa/add', 'Coa::add');
$routes->get('/coa/edit/(:num)', 'Coa::edit/$1');
$routes->get('/coa/delete/(:num)', 'Coa::delete/$1');

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

$routes->get('/payment_types', 'Payment_type::index');
$routes->get('/payment_type/add', 'Payment_type::add');
$routes->get('/payment_type/edit/(:num)', 'Payment_type::edit/$1');
$routes->get('/payment_type/delete/(:num)', 'Payment_type::delete/$1');

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

$routes->get('/allowances', 'Allowance::index');
$routes->get('/allowance/add', 'Allowance::add');
$routes->get('/allowance/edit/(:num)', 'Allowance::edit/$1');
$routes->get('/allowance/delete/(:num)', 'Allowance::delete/$1');

$routes->get('/currencies', 'Currency::index');
$routes->get('/currency/add', 'Currency::add');
$routes->get('/currency/edit/(:num)', 'Currency::edit/$1');
$routes->get('/currency/delete/(:num)', 'Currency::delete/$1');

$routes->get('/units', 'Unit::index');
$routes->get('/unit/add', 'Unit::add');
$routes->get('/unit/edit/(:num)', 'Unit::edit/$1');
$routes->get('/unit/delete/(:num)', 'Unit::delete/$1');

$routes->get('/relations', 'Relation::index');
$routes->get('/relation/add', 'Relation::add');
$routes->get('/relation/edit/(:num)', 'Relation::edit/$1');
$routes->get('/relation/delete/(:num)', 'Relation::delete/$1');

$routes->get('/customer_levels', 'Customer_level::index');
$routes->get('/customer_level/add', 'Customer_level::add');
$routes->get('/customer_level/edit/(:num)', 'Customer_level::edit/$1');
$routes->get('/customer_level/delete/(:num)', 'Customer_level::delete/$1');

$routes->get('/benefits', 'Benefit::index');
$routes->get('/benefit/add', 'Benefit::add');
$routes->get('/benefit/edit/(:num)', 'Benefit::edit/$1');
$routes->get('/benefit/delete/(:num)', 'Benefit::delete/$1');

$routes->get('/divisions', 'Division::index');
$routes->get('/division/add', 'Division::add');
$routes->get('/division/edit/(:num)', 'Division::edit/$1');
$routes->get('/division/delete/(:num)', 'Division::delete/$1');

$routes->get('/degrees', 'Degree::index');
$routes->get('/degree/add', 'Degree::add');
$routes->get('/degree/edit/(:num)', 'Degree::edit/$1');
$routes->get('/degree/delete/(:num)', 'Degree::delete/$1');

$routes->get('/journals', 'Journal::index');
$routes->get('/journal/add', 'Journal::add');
$routes->get('/journal/edit/(:num)', 'Journal::edit/$1');
$routes->get('/journal/delete/(:num)', 'Journal::delete/$1');

$routes->get('/unbalance_journals', 'Unbalance_journal::index');
$routes->add('/unbalance_journal/edit/(:num)', 'Unbalance_journal::edit/$1');
$routes->add('/unbalance_journal/delete/(:num)', 'Unbalance_journal::delete/$1');

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

$routes->get('/instrument_acceptances', 'Instrument_acceptance::index');
$routes->get('/instrument_acceptance/add', 'Instrument_acceptance::add');
$routes->get('/instrument_acceptance/edit/(:num)', 'Instrument_acceptance::edit/$1');
$routes->get('/instrument_acceptance/view/(:num)', 'Instrument_acceptance::view/$1');
$routes->get('/instrument_acceptance/delete/(:num)', 'Instrument_acceptance::delete/$1');

$routes->get('/request_reviews', 'Request_review::index');
$routes->get('/request_review/add', 'Request_review::add');
$routes->get('/request_review/edit/(:num)', 'Request_review::edit/$1');
$routes->get('/request_review/view/(:num)', 'Request_review::view/$1');
$routes->get('/request_review/delete/(:num)', 'Request_review::delete/$1');

$routes->get('/instrument_processes', 'Instrument_process::index');
$routes->get('/instrument_process/add', 'Instrument_process::add');
$routes->get('/instrument_process/edit/(:num)', 'Instrument_process::edit/$1');
$routes->get('/instrument_process/view/(:num)', 'Instrument_process::view/$1');
$routes->get('/instrument_process/delete/(:num)', 'Instrument_process::delete/$1');

$routes->get('/calibration_forms', 'Calibration_form::index');
$routes->get('/calibration_form/add', 'Calibration_form::add');
$routes->get('/calibration_form/edit/(:num)', 'Calibration_form::edit/$1');
$routes->get('/calibration_form/view/(:num)', 'Calibration_form::view/$1');
$routes->get('/calibration_form/delete/(:num)', 'Calibration_form::delete/$1');

$routes->get('/calibration_verifications', 'Calibration_verification::index');
$routes->get('/calibration_verification/add', 'Calibration_verification::add');
$routes->get('/calibration_verification/edit/(:num)', 'Calibration_verification::edit/$1');
$routes->get('/calibration_verification/view/(:num)', 'Calibration_verification::view/$1');
$routes->get('/calibration_verification/delete/(:num)', 'Calibration_verification::delete/$1');

$routes->get('/calibration_certificates', 'Calibration_certificate::index');
$routes->get('/calibration_certificate/add', 'Calibration_certificate::add');
$routes->get('/calibration_certificate/edit/(:num)', 'Calibration_certificate::edit/$1');
$routes->get('/calibration_certificate/view/(:num)', 'Calibration_certificate::view/$1');
$routes->get('/calibration_certificate/delete/(:num)', 'Calibration_certificate::delete/$1');

$routes->get('/instrument_releases', 'Instrument_release::index');
$routes->get('/instrument_release/add', 'Instrument_release::add');
$routes->get('/instrument_release/edit/(:num)', 'Instrument_release::edit/$1');
$routes->get('/instrument_release/view/(:num)', 'Instrument_release::view/$1');
$routes->get('/instrument_release/delete/(:num)', 'Instrument_release::delete/$1');

$routes->get('/maintenance_items', 'Maintenance_item::index');
$routes->get('/maintenance_item/add', 'Maintenance_item::add');
$routes->get('/maintenance_item/edit/(:num)', 'Maintenance_item::edit/$1');
$routes->get('/maintenance_item/delete/(:num)', 'Maintenance_item::delete/$1');

$routes->get('/subwindow/suppliers', 'Supplier::subwindow');
$routes->get('/subwindow/customers', 'Customer::subwindow');
$routes->get('/subwindow/items', 'Item::subwindow');
$routes->get('/subwindow/instrument_acceptances', 'Instrument_acceptance::subwindow');
$routes->get('/subwindow/request_reviews', 'Request_review::subwindow');
$routes->get('/subwindow/instrument_processes', 'Instrument_process::subwindow');
$routes->get('/subwindow/calibration_forms', 'Calibration_form::subwindow');

// --------------------------------------------------------------------
$routes->get('/account_receivable', 'Account_receivable::index');
$routes->get('/item_histories', 'Item_history::index');
$routes->get('/sales_activities', 'Sales_activity::index');

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
