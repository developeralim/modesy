<?php

use CodeIgniter\Router\RouteCollection;
use Config\Globals;

$languages = Globals::$languages;
$generalSettings = Globals::$generalSettings;
$csrt = Globals::$customRoutes;
$rtAdmin = $csrt->admin;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');
$routes->get('/' . $csrt->affiliate . '/(:any)', 'HomeController::affiliate/$1');
$routes->get('/mds/load-products', 'AjaxController::loadProducts');

/*
 * --------------------------------------------------------------------
 * Static Routes
 * --------------------------------------------------------------------
 */

include_once 'RoutesStatic.php';

/*
 * --------------------------------------------------------------------
 * Admin Routes
 * --------------------------------------------------------------------
 */

$routes->get($rtAdmin, 'AdminController::index');
$routes->get($rtAdmin . '/login', 'CommonController::adminLogin');
$routes->post($rtAdmin . '/login-post', 'CommonController::adminLoginpost');
$routes->get('confirm-account', 'AuthController::confirmAccount');
//navigation
$routes->get($rtAdmin . '/theme', 'AdminController::theme');
$routes->get($rtAdmin . '/homepage-manager', 'AdminController::homepageManager');
$routes->get($rtAdmin . '/edit-banner/(:num)', 'AdminController::editIndexBanner/$1');
//slider
$routes->get($rtAdmin . '/slider', 'AdminController::slider');
$routes->get($rtAdmin . '/edit-slider-item/(:num)', 'AdminController::editSliderItem/$1');
//page
$routes->get($rtAdmin . '/add-page', 'AdminController::addPage');
$routes->get($rtAdmin . '/edit-page/(:num)', 'AdminController::editPage/$1');
$routes->get($rtAdmin . '/pages', 'AdminController::pages');
//order
$routes->get($rtAdmin . '/orders', 'OrderAdminController::orders');
$routes->get($rtAdmin . '/order-details/(:num)', 'OrderAdminController::orderDetails/$1');
$routes->get($rtAdmin . '/transactions', 'OrderAdminController::transactions');
$routes->get($rtAdmin . '/digital-sales', 'OrderAdminController::digitalSales');
//product
$routes->get($rtAdmin . '/products', 'ProductController::products');
$routes->get($rtAdmin . '/product-details/(:num)', 'ProductController::productDetails/$1');
$routes->get($rtAdmin . '/featured-products', 'ProductController::featuredProducts');
$routes->get($rtAdmin . '/featured-products-pricing', 'ProductController::featuredProductsPricing');
//payments
$routes->get($rtAdmin . '/membership-payments', 'AdminController::membershipPayments');
$routes->get($rtAdmin . '/promotion-payments', 'AdminController::promotionPayments');
$routes->get($rtAdmin . '/wallet-deposits', 'AdminController::walletDeposits');
$routes->get($rtAdmin . '/bank-transfer-reports', 'AdminController::bankTransferReports');
//bidding
$routes->get($rtAdmin . '/quote-requests', 'ProductController::quoteRequests');
//category
$routes->get($rtAdmin . '/add-category', 'CategoryController::addCategory');
$routes->get($rtAdmin . '/categories', 'CategoryController::categories');
$routes->get($rtAdmin . '/edit-category/(:num)', 'CategoryController::editCategory/$1');
$routes->get($rtAdmin . '/bulk-category-upload', 'CategoryController::bulkCategoryUpload');
//brand
$routes->get($rtAdmin . '/brands', 'CategoryController::brands');
$routes->get($rtAdmin . '/add-brand', 'CategoryController::AddBrand');
$routes->get($rtAdmin . '/edit-brand/(:num)', 'CategoryController::editBrand/$1');
$routes->get($rtAdmin . '/edit-category/(:num)', 'CategoryController::editCategory/$1');
$routes->get($rtAdmin . '/bulk-category-upload', 'CategoryController::bulkCategoryUpload');
//custom fields
$routes->get($rtAdmin . '/add-custom-field', 'CategoryController::addCustomField');
$routes->get($rtAdmin . '/custom-fields', 'CategoryController::customFields');
$routes->get($rtAdmin . '/edit-custom-field/(:num)', 'CategoryController::editCustomField/$1');
$routes->get($rtAdmin . '/custom-field-options/(:num)', 'CategoryController::customFieldOptions/$1');
$routes->get($rtAdmin . '/bulk-custom-field-upload', 'CategoryController::bulkCustomFieldUpload');
//earnings
$routes->get($rtAdmin . '/earnings', 'EarningsController::earnings');
$routes->get($rtAdmin . '/payout-requests', 'EarningsController::payoutRequests');
$routes->get($rtAdmin . '/payout-settings', 'EarningsController::payoutSettings');
$routes->get($rtAdmin . '/add-payout', 'EarningsController::addPayout');
$routes->get($rtAdmin . '/seller-balances', 'EarningsController::sellerBalances');
//blog
$routes->get($rtAdmin . '/blog-add-post', 'BlogController::addPost');
$routes->get($rtAdmin . '/blog-posts', 'BlogController::posts');
$routes->get($rtAdmin . '/edit-blog-post/(:num)', 'BlogController::editPost/$1');
$routes->get($rtAdmin . '/blog-categories', 'BlogController::categories');
$routes->get($rtAdmin . '/edit-blog-category/(:num)', 'BlogController::editCategory/$1');
//comments & contant & reviews
$routes->get($rtAdmin . '/pending-product-comments', 'ProductController::pendingComments');
$routes->get($rtAdmin . '/product-comments', 'ProductController::comments');
$routes->get($rtAdmin . '/pending-blog-comments', 'BlogController::pendingComments');
$routes->get($rtAdmin . '/blog-comments', 'BlogController::comments');
$routes->get($rtAdmin . '/reviews', 'ProductController::reviews');
$routes->get($rtAdmin . '/contact-messages', 'AdminController::contactMessages');
$routes->get($rtAdmin . '/chat-messages', 'AdminController::chatMessages');
//abuse reports
$routes->get($rtAdmin . '/abuse-reports', 'AdminController::abuseReports');
//ad spaces
$routes->get($rtAdmin . '/ad-spaces', 'AdminController::adSpaces');
//seo tools
$routes->get($rtAdmin . '/seo-tools', 'AdminController::seoTools');
//location
$routes->get($rtAdmin . '/location-settings', 'AdminController::locationSettings');
$routes->get($rtAdmin . '/countries', 'AdminController::countries');
$routes->get($rtAdmin . '/states', 'AdminController::states');
$routes->get($rtAdmin . '/add-country', 'AdminController::addCountry');
$routes->get($rtAdmin . '/edit-country/(:num)', 'AdminController::editCountry/$1');
$routes->get($rtAdmin . '/add-state', 'AdminController::addState');
$routes->get($rtAdmin . '/edit-state/(:num)', 'AdminController::editState/$1');
$routes->get($rtAdmin . '/cities', 'AdminController::cities');
$routes->get($rtAdmin . '/add-city', 'AdminController::addCity');
$routes->get($rtAdmin . '/edit-city/(:num)', 'AdminController::editCity/$1');
//membership
$routes->get($rtAdmin . '/users', 'MembershipController::users');
$routes->get($rtAdmin . '/user-login-activities', 'MembershipController::userLoginActivities');
$routes->get($rtAdmin . '/account-deletion-requests', 'MembershipController::accountDeletionRequests');
$routes->get($rtAdmin . '/shop-opening-requests', 'MembershipController::shopOpeningRequests');
$routes->get($rtAdmin . '/add-user', 'MembershipController::addUser');
$routes->get($rtAdmin . '/edit-user/(:num)', 'MembershipController::editUser/$1');
$routes->get($rtAdmin . '/user-details/(:num)', 'MembershipController::userDetails/$1');
$routes->get($rtAdmin . '/membership-plans', 'MembershipController::membershipPlans');
$routes->get($rtAdmin . '/edit-plan/(:num)', 'MembershipController::editPlan/$1');
$routes->get($rtAdmin . '/roles-permissions', 'MembershipController::rolesPermissions');
$routes->get($rtAdmin . '/add-role', 'MembershipController::addRole');
$routes->get($rtAdmin . '/edit-role/(:num)', 'MembershipController::editRole/$1');
//support
$routes->get($rtAdmin . '/knowledge-base', 'SupportAdminController::knowledgeBase');
$routes->get($rtAdmin . '/knowledge-base/add-content', 'SupportAdminController::addContent');
$routes->get($rtAdmin . '/knowledge-base/edit-content/(:num)', 'SupportAdminController::editContent/$1');
$routes->get($rtAdmin . '/knowledge-base-categories', 'SupportAdminController::categories');
$routes->get($rtAdmin . '/knowledge-base/add-category', 'SupportAdminController::addCategory');
$routes->get($rtAdmin . '/knowledge-base/edit-category/(:num)', 'SupportAdminController::editCategory/$1');
$routes->get($rtAdmin . '/support-tickets', 'SupportAdminController::supportTickets');
$routes->get($rtAdmin . '/support-ticket/(:num)', 'SupportAdminController::supportTicket/$1');
//refund
$routes->get($rtAdmin . '/refund-requests', 'OrderAdminController::refundRequests');
$routes->get($rtAdmin . '/refund-requests/(:num)', 'OrderAdminController::refund/$1');
//languages
$routes->get($rtAdmin . '/language-settings', 'LanguageController::languageSettings');
$routes->get($rtAdmin . '/edit-language/(:num)', 'LanguageController::editLanguage/$1');
$routes->get($rtAdmin . '/edit-translations/(:num)', 'LanguageController::editTranslations/$1');
$routes->get($rtAdmin . '/search-phrases', 'LanguageController::searchPhrases');
//newsletter
$routes->get($rtAdmin . '/newsletter', 'AdminController::newsletter');
//affiliate program
$routes->get($rtAdmin . '/affiliate-program', 'AdminController::affiliateProgram');
//currency
$routes->get($rtAdmin . '/currency-settings', 'AdminController::currencySettings');
$routes->get($rtAdmin . '/add-currency', 'AdminController::addCurrency');
$routes->get($rtAdmin . '/edit-currency/(:num)', 'AdminController::editCurrency/$1');
//settings
$routes->get($rtAdmin . '/general-settings', 'AdminController::generalSettings');
$routes->get($rtAdmin . '/email-settings', 'AdminController::emailSettings');
$routes->get($rtAdmin . '/social-login', 'AdminController::socialLoginSettings');
$routes->get($rtAdmin . '/visual-settings', 'AdminController::visualSettings');
$routes->get($rtAdmin . '/preferences', 'AdminController::preferences');
$routes->get($rtAdmin . '/product-settings', 'AdminController::productSettings');
$routes->get($rtAdmin . '/font-settings', 'AdminController::fontSettings');
$routes->get($rtAdmin . '/edit-font/(:num)', 'AdminController::editFont/$1');
$routes->get($rtAdmin . '/route-settings', 'AdminController::routeSettings');
$routes->get($rtAdmin . '/cache-system', 'AdminController::cacheSystem');
$routes->get($rtAdmin . '/storage', 'AdminController::storage');
$routes->get($rtAdmin . '/payment-settings', 'AdminController::paymentSettings');
$routes->get($rtAdmin . '/add-tax', 'AdminController::addTax');
$routes->get($rtAdmin . '/edit-tax/(:num)', 'AdminController::editTax/$1');
/*
 * --------------------------------------------------------------------
 * Dynamic Routes
 * --------------------------------------------------------------------
 */

if (!empty($languages)) {
    foreach ($languages as $language) {
        $key = '';
        if ($generalSettings->site_lang != $language->id) {
            $key = $language->short_form . '/';
            $routes->get($language->short_form, 'HomeController::index');
        }
        //auth
        $routes->get($key . $csrt->register, 'AuthController::register');
        $routes->get($key . $csrt->register_success, 'AuthController::registerSuccess');
        $routes->get($key . $csrt->forgot_password, 'AuthController::forgotPassword');
        $routes->get($key . $csrt->reset_password, 'AuthController::resetPassword');
        //profile
        $routes->get($key . $csrt->profile . '/(:any)', 'ProfileController::profile/$1');
        $routes->get($key . $csrt->wishlist, 'HomeController::wishlist');
        $routes->get($key . $csrt->followers . '/(:any)', 'ProfileController::followers/$1');
        $routes->get($key . $csrt->following . '/(:any)', 'ProfileController::following/$1');
        $routes->get($key . $csrt->reviews . '/(:any)', 'ProfileController::reviews/$1');
        $routes->get($key . $csrt->my_reviews . '/(:any)', 'ProfileController::myReviews/$1');
        $routes->get($key . $csrt->shop_policies . '/(:any)', 'ProfileController::shopPolicies/$1');
        $routes->get($key . $csrt->my_coupons, 'ProfileController::myCoupons');
        //settings
        $routes->get($key . $csrt->settings, 'ProfileController::editProfile');
        $routes->get($key . $csrt->settings . '/' . $csrt->edit_profile, 'ProfileController::editProfile');
        $routes->get($key . $csrt->settings . '/' . $csrt->location, 'ProfileController::location');
        $routes->get($key . $csrt->settings . '/' . $csrt->shipping_address, 'ProfileController::shippingAddress');
        $routes->get($key . $csrt->settings . '/' . $csrt->affiliate_links, 'ProfileController::affiliateLinks');
        $routes->get($key . $csrt->settings . '/' . $csrt->social_media, 'ProfileController::socialMedia');
        $routes->get($key . $csrt->settings . '/' . $csrt->change_password, 'ProfileController::changePassword');
        $routes->get($key . $csrt->settings . '/' . $csrt->delete_account, 'ProfileController::deleteAccount');
        //wallet
        $routes->get($key . $csrt->wallet, 'ProfileController::wallet');
        //affiliate
        $routes->get($key . $csrt->affiliate_program, 'HomeController::affiliateProgram');
        //product
        $routes->get($key . $csrt->select_membership_plan, 'HomeController::selectMembershipPlan');
        $routes->get($key . $csrt->start_selling, 'HomeController::startSelling');
        $routes->get($key . $csrt->search, 'HomeController::search');
        $routes->get($key . $csrt->products, 'HomeController::products');
        $routes->get($key . $csrt->downloads, 'OrderController::downloads');
        //blog
        $routes->get($key . $csrt->blog, 'HomeController::blog');
        $routes->get($key . $csrt->blog . '/' . $csrt->tag . '/(:any)', 'HomeController::tag/$1');
        $routes->get($key . $csrt->blog . '/(:any)/(:any)', 'HomeController::post/$1/$2');
        $routes->get($key . $csrt->blog . '/(:any)', 'HomeController::blogCategory/$1');
        //shops
        $routes->get($key . $csrt->shops, 'HomeController::shops');
        //contact
        $routes->get($key . $csrt->contact, 'HomeController::contact');
        //chat
        $routes->get($key . $csrt->messages . '/(:any)', 'ChatController::chat/$1');
        $routes->get($key . $csrt->messages, 'ChatController::chats');
        //rss feeds
        $routes->get($key . $csrt->rss_feeds, 'RssController::rssFeeds');
        $routes->get($key . 'rss/' . $csrt->latest_products, 'RssController::latestProducts');
        $routes->get($key . 'rss/' . $csrt->featured_products, 'RssController::featuredProducts');
        $routes->get($key . 'rss/' . $csrt->category . '/(:any)', 'RssController::rssByCategory/$1');
        $routes->get($key . 'rss/' . $csrt->seller . '/(:any)', 'RssController::rssBySeller/$1');
        //cart
        $routes->get($key . $csrt->cart, 'CartController::cart');
        $routes->get($key . $csrt->cart . '/' . $csrt->shipping, 'CartController::shipping');
        $routes->get($key . $csrt->cart . '/' . $csrt->payment_method, 'CartController::paymentMethod');
        $routes->get($key . $csrt->cart . '/' . $csrt->payment, 'CartController::payment');
        //orders
        $routes->get($key . $csrt->orders, 'OrderController::orders');
        $routes->get($key . $csrt->order_details . '/(:num)', 'OrderController::order/$1');
        $routes->get($key . $csrt->order_completed . '/(:num)', 'CartController::orderCompleted/$1');
        $routes->get($key . $csrt->service_payment_completed, 'CartController::servicePaymentCompleted');
        $routes->get($key . 'invoice/(:num)', 'HomeController::invoice/$1');
        $routes->get($key . 'invoice-promotion/(:num)', 'HomeController::invoicePromotion/$1');
        $routes->get($key . 'invoice-membership/(:num)', 'HomeController::invoiceMembership/$1');
        $routes->get($key . 'invoice-wallet-deposit/(:num)', 'HomeController::invoiceWalletDeposit/$1');
        $routes->get($key . 'invoice-expense/(:num)', 'HomeController::invoiceExpense/$1');
        //refund
        $routes->get($key . $csrt->refund_requests, 'OrderController::refundRequests');
        $routes->get($key . $csrt->refund_requests . '/(:num)', 'OrderController::refund/$1');
        //bidding
        $routes->get($key . $csrt->quote_requests, 'OrderController::quoteRequests');
        //terms & conditions
        $routes->get($key . $csrt->terms_conditions, 'HomeController::termsConditions');
        //dashboard
        $routes->get($key . $csrt->dashboard, 'DashboardController::index');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->add_product, 'DashboardController::addProduct');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->product . '/' . $csrt->product_details . '/(:num)', 'DashboardController::editProductDetails/$1');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->edit_product . '/(:num)', 'DashboardController::editProduct/$1');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->products, 'DashboardController::products');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->bulk_product_upload, 'DashboardController::bulkProductUpload');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->sales, 'DashboardController::sales');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->sales . '/' . $csrt->shipment . '/(:any)', 'DashboardController::shipments/$1');
        $routes->post($key . $csrt->dashboard . '/' . $csrt->sales . '/' . $csrt->shipment . '/' . $csrt->generate_label, 'DashboardController::generateShippingLabel');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->sale . '/(:num)', 'DashboardController::sale/$1');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->quote_requests, 'DashboardController::quoteRequests');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->cash_on_delivery, 'DashboardController::cashOnDelivery');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->payments, 'DashboardController::payments');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->comments, 'DashboardController::comments');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->reviews, 'DashboardController::reviews');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->shop_settings, 'DashboardController::shopSettings');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->shop_policies, 'DashboardController::shopPolicies');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->shipping_settings, 'DashboardController::shippingSettings');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->add_shipping_zone, 'DashboardController::addShippingZone');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->edit_shipping_zone . '/(:num)', 'DashboardController::editShippingZone/$1');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->coupons, 'DashboardController::coupons');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->coupon_products . '/(:num)', 'DashboardController::couponProducts/$1');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->add_coupon, 'DashboardController::addCoupon');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->edit_coupon . '/(:num)', 'DashboardController::editCoupon/$1');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->refund_requests, 'DashboardController::refundRequests');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->refund_requests . '/(:num)', 'DashboardController::refund/$1');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->affiliate_program, 'DashboardController::affiliateProgram');
        //help center
        $routes->get($key . $csrt->help_center, 'SupportController::helpCenter');
        $routes->get($key . $csrt->help_center . '/' . $csrt->tickets, 'SupportController::tickets');
        $routes->get($key . $csrt->help_center . '/' . $csrt->submit_request, 'SupportController::submitRequest');
        $routes->get($key . $csrt->help_center . '/' . $csrt->ticket . '/(:num)', 'SupportController::ticket/$1');
        $routes->get($key . $csrt->help_center . '/' . $csrt->search, 'SupportController::search');
        $routes->get($key . $csrt->help_center . '/' . $csrt->ticket . '/(:num)', 'SupportController::ticket/$1');
        $routes->get($key . $csrt->help_center . '/(:any)/(:any)', 'SupportController::article/$1/$2');
        $routes->get($key . $csrt->help_center . '/(:any)', 'SupportController::category/$1');

        if ($generalSettings->site_lang != $language->id) {
            $routes->get($key . '(:any)/(:any)', 'HomeController::subCategory/$1/$2');
            $routes->get($key . '(:any)', 'HomeController::any/$1');
        }
    }
}

$routes->get('(:any)/(:any)', 'HomeController::subCategory/$1/$2');
$routes->get('(:any)', 'HomeController::any/$1');