<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST["btnUpdate"])) {
    $data = [
        'db_host' => $_POST['db_host'],
        'db_user' => $_POST['db_user'],
        'db_password' => $_POST['db_password'],
        'db_name' => $_POST['db_name']
    ];
    try {
        $connection = new mysqli($data['db_host'], $data['db_user'], $data['db_password'], $data['db_name']);
        if ($connection->connect_error) {
            $error = "Failed to connect to database, please check your database credentials!";
        } else {
            $connection->query("SET CHARACTER SET utf8mb4");
            $connection->query("SET NAMES utf8mb4");

            update($connection);
            $success = 'The update has been successfully completed! Please delete the "update_database.php" file.';
            $connection->close();
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

function runQuery($sql)
{
    global $connection;
    return mysqli_query($connection, $sql);
}

if (isset($_POST["btn_submit"])) {
    update($connection);
    $success = 'The update has been successfully completed! Please delete the "update_database.php" file.';
}

function update()
{
    updateFrom24To25();
}

function updateFrom24To25()
{
    global $connection;

    $tblAffiliateEarnings = "CREATE TABLE `affiliate_earnings` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `referrer_id` int(11) DEFAULT NULL,
        `order_id` int(11) DEFAULT NULL,
        `product_id` int(11) DEFAULT NULL,
        `seller_id` int(11) DEFAULT NULL,
        `commission_rate` tinyint(4) DEFAULT NULL,
        `earned_amount` bigint(20) DEFAULT NULL,
        `currency` varchar(20) DEFAULT 'USD',
        `exchange_rate` double DEFAULT 1,
        `created_at` timestamp NULL DEFAULT current_timestamp()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $tblAffiliateLinks = "CREATE TABLE `affiliate_links` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `referrer_id` int(11) DEFAULT NULL,
        `product_id` int(11) DEFAULT NULL,
        `seller_id` int(11) DEFAULT NULL,
        `lang_id` int(11) DEFAULT NULL,
        `link_short` varchar(100) DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT current_timestamp()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $tblPagesVendor = "CREATE TABLE `pages_vendor` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `user_id` int(11) DEFAULT NULL,
        `content_shop_policies` text DEFAULT NULL,
        `status_shop_policies` tinyint(1) DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $tblProductSearchIndexes = "CREATE TABLE `product_search_indexes` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `product_id` int(11) DEFAULT NULL,
        `lang_id` int(11) DEFAULT NULL,
        `search_index` varchar(1000) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $tblProductTags = "CREATE TABLE `product_tags` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `tag` varchar(255) DEFAULT NULL,
        `product_id` int(11) DEFAULT NULL,
        `lang_id` int(11) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $tblTaxes = "CREATE TABLE `taxes` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name_data` text DEFAULT NULL,
        `tax_rate` double NOT NULL,
        `is_all_countries` tinyint(1) DEFAULT 0,
        `country_ids` text DEFAULT NULL,
        `state_ids` text DEFAULT NULL,
        `product_sales` tinyint(1) DEFAULT 1,
        `service_payments` tinyint(1) DEFAULT 1,
        `status` tinyint(1) DEFAULT 1,
        `created_at` timestamp NULL DEFAULT current_timestamp()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $tblUserLoginActivities = "CREATE TABLE `user_login_activities` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `user_id` int(11) DEFAULT NULL,
        `ip_address` varchar(100) DEFAULT NULL,
        `user_agent` text DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT current_timestamp()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $tblWalletDeposits = "CREATE TABLE `wallet_deposits` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `user_id` int(11) DEFAULT NULL,
        `payment_method` varchar(50) DEFAULT NULL,
        `payment_id` varchar(100) DEFAULT NULL,
        `deposit_amount` varchar(30) DEFAULT NULL,
        `currency` varchar(20) DEFAULT 'USD',
        `payment_status` tinyint(1) DEFAULT 0,
        `ip_address` varchar(100) DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT current_timestamp()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $tblWalletExpenses = "CREATE TABLE `wallet_expenses` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `user_id` int(11) DEFAULT NULL,
        `payment_id` varchar(100) DEFAULT NULL,
        `expense_item_id` varchar(30) DEFAULT NULL,
        `expense_type` varchar(255) DEFAULT NULL,
        `expense_amount` bigint(20) DEFAULT NULL,
        `expense_detail` varchar(255) DEFAULT NULL,
        `currency` varchar(20) DEFAULT 'USD',
        `created_at` timestamp NULL DEFAULT current_timestamp()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    runQuery($tblAffiliateEarnings);
    runQuery($tblAffiliateLinks);
    runQuery($tblPagesVendor);
    runQuery($tblProductSearchIndexes);
    runQuery($tblProductTags);
    runQuery($tblTaxes);
    runQuery($tblUserLoginActivities);
    runQuery($tblWalletDeposits);
    runQuery($tblWalletExpenses);

    runQuery("ALTER TABLE bank_transfers ADD COLUMN `report_type` varchar(30) DEFAULT 'order'");
    runQuery("ALTER TABLE bank_transfers ADD COLUMN `report_item_id` INT");
    runQuery("ALTER TABLE brands ADD COLUMN `category_data` TEXT");
    runQuery("ALTER TABLE brands ADD COLUMN `show_on_slider` TINYINT(1) DEFAULT 0");
    runQuery("ALTER TABLE categories ADD COLUMN `show_description` TINYINT(1) DEFAULT 0");
    runQuery("ALTER TABLE coupons ADD COLUMN `is_public` TINYINT(1) DEFAULT 1");
    runQuery("ALTER TABLE custom_fields_options ADD COLUMN `name_data` TEXT");
    runQuery("ALTER TABLE earnings ADD COLUMN `affiliate_commission` bigint(20) DEFAULT 0;");
    runQuery("ALTER TABLE earnings ADD COLUMN `affiliate_commission_rate` DOUBLE DEFAULT 0;");
    runQuery("ALTER TABLE earnings ADD COLUMN `affiliate_discount` bigint(20) DEFAULT 0;");
    runQuery("ALTER TABLE earnings ADD COLUMN `affiliate_discount_rate` DOUBLE DEFAULT 0;");
    runQuery('ALTER TABLE general_settings ADD COLUMN `fea_categories_design` varchar(30) DEFAULT "round_boxes"');
    runQuery("ALTER TABLE general_settings ADD COLUMN `cache_static_system` TINYINT(1) DEFAULT 0");
    runQuery("ALTER TABLE general_settings ADD COLUMN `approve_after_editing` TINYINT(1) DEFAULT 0");
    runQuery("ALTER TABLE general_settings ADD COLUMN `email_options` TEXT");
    runQuery("ALTER TABLE general_settings ADD COLUMN `pwa_logo` TEXT");
    runQuery("ALTER TABLE general_settings ADD COLUMN `allow_free_plan_multiple_times` TINYINT(1) DEFAULT 0");
    runQuery("ALTER TABLE general_settings ADD COLUMN `single_country_mode` TINYINT(1) DEFAULT 0");
    runQuery("ALTER TABLE general_settings ADD COLUMN `single_country_id` INT");
    runQuery("ALTER TABLE general_settings ADD COLUMN `refund_system` TINYINT(1) DEFAULT 1");
    runQuery("ALTER TABLE general_settings ADD COLUMN `affiliate_status` TINYINT(1) DEFAULT 0");
    runQuery('ALTER TABLE general_settings ADD COLUMN `affiliate_type` varchar(30) DEFAULT "site_based"');
    runQuery("ALTER TABLE general_settings ADD COLUMN `affiliate_image` varchar(255)");
    runQuery("ALTER TABLE general_settings ADD COLUMN `affiliate_commission_rate` DOUBLE DEFAULT 0;");
    runQuery("ALTER TABLE general_settings ADD COLUMN `affiliate_discount_rate` DOUBLE DEFAULT 0;");
    runQuery("ALTER TABLE general_settings ADD COLUMN `auto_approve_orders` TINYINT(1) DEFAULT 0");
    runQuery("ALTER TABLE general_settings ADD COLUMN `auto_approve_orders_days` smallint(6) DEFAULT 10;");
    runQuery('ALTER TABLE general_settings ADD COLUMN `logo_size` varchar(30) DEFAULT "160x60"');
    runQuery("ALTER TABLE general_settings ADD COLUMN `profile_number_of_sales` TINYINT(1) DEFAULT 1");
    runQuery("ALTER TABLE homepage_banners ADD COLUMN `lang_id` INT DEFAULT 1");
    runQuery("ALTER TABLE invoices ADD COLUMN `client_tax_number` varchar(255)");
    runQuery("ALTER TABLE membership_transactions ADD COLUMN `global_taxes_data` TEXT");
    runQuery("ALTER TABLE orders ADD COLUMN `affiliate_data` TEXT");
    runQuery("ALTER TABLE payment_settings ADD COLUMN `cash_on_delivery_debt_limit` bigint(20) DEFAULT 1000;");
    runQuery("ALTER TABLE payment_settings ADD COLUMN `wallet_deposit` TINYINT(1) DEFAULT 1");
    runQuery("ALTER TABLE payment_settings ADD COLUMN `pay_with_wallet_balance` TINYINT(1) DEFAULT 1");
    runQuery("ALTER TABLE payment_settings ADD COLUMN `additional_invoice_info` TEXT");
    runQuery("ALTER TABLE products ADD COLUMN `is_edited` TINYINT(1) DEFAULT 0");
    runQuery("ALTER TABLE products ADD COLUMN `is_active` TINYINT(1) DEFAULT 1");
    runQuery("ALTER TABLE products ADD COLUMN `is_affiliate` TINYINT(1) DEFAULT 0");
    runQuery("ALTER TABLE products ADD COLUMN `updated_at` timestamp NULL DEFAULT NULL");
    runQuery("ALTER TABLE product_settings ADD COLUMN `pagination_per_page` smallint(6) DEFAULT 60");
    runQuery("ALTER TABLE product_settings ADD COLUMN `sort_by_featured_products` TINYINT(1) DEFAULT 1");
    runQuery("ALTER TABLE promoted_transactions ADD COLUMN `global_taxes_data` TEXT");
    runQuery("ALTER TABLE quote_requests ADD COLUMN `variation_option_ids` varchar(255)");
    runQuery("ALTER TABLE settings ADD COLUMN `social_media_data` TEXT");
    runQuery("ALTER TABLE settings ADD COLUMN `affiliate_description` TEXT");
    runQuery("ALTER TABLE settings ADD COLUMN `affiliate_content` longtext");
    runQuery("ALTER TABLE settings ADD COLUMN `affiliate_faq` mediumtext");
    runQuery("ALTER TABLE settings ADD COLUMN `affiliate_works` mediumtext");
    runQuery("ALTER TABLE settings ADD COLUMN `bulk_upload_documentation` TEXT");
    runQuery("ALTER TABLE shipping_zones ADD COLUMN `estimated_delivery` TEXT");
    runQuery("ALTER TABLE users ADD COLUMN `social_media_data` TEXT");
    runQuery("ALTER TABLE users ADD COLUMN `shop_request_reject_reason` TEXT");
    runQuery("ALTER TABLE users ADD COLUMN `shop_request_date` timestamp NULL DEFAULT NULL");
    runQuery("ALTER TABLE users ADD COLUMN `vat_rates_data_state` TEXT");
    runQuery("ALTER TABLE users ADD COLUMN `is_affiliate` TINYINT(1) DEFAULT 0");
    runQuery("ALTER TABLE users ADD COLUMN `vendor_affiliate_status` TINYINT(1) DEFAULT 0");
    runQuery("ALTER TABLE users ADD COLUMN `affiliate_commission_rate` DOUBLE DEFAULT 0;");
    runQuery("ALTER TABLE users ADD COLUMN `affiliate_discount_rate` DOUBLE DEFAULT 0;");
    runQuery("ALTER TABLE users ADD COLUMN `tax_registration_number` varchar(255)");
    runQuery("ALTER TABLE users ADD COLUMN `vacation_mode` TINYINT(1) DEFAULT 0");
    runQuery("ALTER TABLE users ADD COLUMN `vacation_message` TEXT");
    runQuery("ALTER TABLE users ADD COLUMN `commission_debt` bigint(20);");
    runQuery("ALTER TABLE users ADD COLUMN `account_delete_req` TINYINT(1) DEFAULT 0");
    runQuery("ALTER TABLE users ADD COLUMN `account_delete_req_date` timestamp NULL DEFAULT NULL");

    //add indexes
    runQuery("ALTER TABLE product_search_indexes ADD FULLTEXT(search_index);");
    runQuery("ALTER TABLE product_search_indexes ADD INDEX idx_product_id (product_id);");
    runQuery("ALTER TABLE product_search_indexes ADD INDEX idx_lang_id (lang_id);");
    runQuery("ALTER TABLE categories ADD INDEX idx_parent_tree (parent_tree);");
    runQuery("ALTER TABLE categories ADD INDEX idx_slug (slug);");
    runQuery("ALTER TABLE custom_fields ADD INDEX idx_field_order (field_order);");
    runQuery("ALTER TABLE custom_fields ADD INDEX idx_is_product_filter (is_product_filter);");
    runQuery("ALTER TABLE location_countries ADD INDEX idx_status (status);");
    runQuery("ALTER TABLE pages_vendor ADD INDEX idx_user_id (user_id);");
    runQuery("ALTER TABLE products ADD INDEX idx_slug (slug);");
    runQuery("ALTER TABLE products ADD INDEX idx_sku (sku);");
    runQuery("ALTER TABLE products ADD INDEX idx_is_edited (is_edited);");
    runQuery("ALTER TABLE products ADD INDEX idx_is_active (is_active);");
    runQuery("ALTER TABLE product_tags ADD INDEX idx_tag (tag);");
    runQuery("ALTER TABLE product_tags ADD INDEX idx_product_id (product_id);");
    runQuery("ALTER TABLE product_tags ADD INDEX idx_lang_id (lang_id);");
    runQuery("ALTER TABLE users ADD INDEX idx_country_id (country_id);");
    runQuery("ALTER TABLE users ADD INDEX idx_state_id (state_id);");
    runQuery("ALTER TABLE users ADD INDEX idx_city_id (city_id);");
    runQuery("ALTER TABLE users ADD INDEX idx_vacation_mode (vacation_mode);");
    runQuery("ALTER TABLE users ADD INDEX idx_is_membership_plan_expired (is_membership_plan_expired);");
    runQuery("ALTER TABLE user_login_activities ADD INDEX idx_user_id (user_id);");

    //add new routes
    $sql = "INSERT INTO `routes` (`route_key`, `route`) VALUES
    ('service_payment_completed', 'service-payment-completed'),
    ('wallet', 'wallet'),
    ('affiliate_program', 'affiliate-program'),
    ('payments', 'payments'),
    ('cash_on_delivery', 'cash-on-delivery'),
    ('shop_policies', 'shop-policies'),
    ('affiliate', 'affiliate'),
    ('coupon_products', 'coupon-products'),
    ('delete_account', 'delete-account'),
    ('my_reviews', 'my-reviews'),
    ('affiliate_links', 'affiliate-links');";
    runQuery($sql);

    //delete old routes
    $sql = "DELETE FROM routes WHERE `route_key` IN ('membership_payment_completed', 'payment_history', 'payouts', 'promote_payment_completed', 'set_payout_account', 'withdraw_money');";
    runQuery($sql);

    //delete old translations
    $sql = "DELETE FROM language_translations WHERE `label` IN (
        'add_a_comment',
        'approve_before_publishing',
        'bank_transfer_notifications',
        'bulk_category_upload_exp',
        'define_new_tax',
        'download_license_key',
        'enter_location',
        'featured_products_transactions',
        'keywords_exp',
        'location_explanation',
        'membership_transactions',
        'msg_accept_bank_transfer',
        'msg_error_cart_unapproved_products',
        'msg_shop_request_declined',
        'no_thanks',
        'payment_history',
        'search_products',
        'select_your_country',
        'send_email_shop_opening_request',
        'sort_by',
        'update_location',
        'x_url');";
    runQuery($sql);

    //add new translations
    $p["view_cart"] = "View Cart";
    $p["product_cart_summary"] = "Product cart summary";
    $p["product_added_to_cart"] = "Product successfully added to your cart!";
    $p["profile_settings"] = "Profile Settings";
    $p["wallet"] = "Wallet";
    $p["wallet_balance"] = "Wallet Balance";
    $p["new_payout_request"] = "New Payout Request";
    $p["referral_earnings"] = "Referral Earnings";
    $p["reference_code"] = "Reference Code";
    $p["create_affiliate_link"] = "Create affiliate link";
    $p["affiliate_link"] = "Affiliate Link";
    $p["copy"] = "Copy";
    $p["copy_link"] = "Copy Link";
    $p["affiliate_program"] = "Affiliate Program";
    $p["frequently_asked_questions"] = "Frequently Asked Questions";
    $p["question"] = "Question";
    $p["answer"] = "Answer";
    $p["add_question"] = "Add Question";
    $p["how_it_works"] = "How It Works";
    $p["join_program"] = "Join Program";
    $p["joined_affiliate_program"] = "You joined the affiliate program";
    $p["affiliate_link_exp"] = "To maximize your affiliate earnings, share this link in blog posts, on social media, and in email campaigns. Include it in YouTube video descriptions, on your website, and in online forums.";
    $p["program_type"] = "Program Type";
    $p["affiliate_site_based"] = "Site-based (for all products, site pays the commission)";
    $p["affiliate_seller_based"] = "Seller-based (for products selected by the seller, seller pays the commission)";
    $p["enable_for_all_products"] = "Enable For All Products";
    $p["enable_only_for_selected_products"] = "Enable Only for Selected Products (products can be selected from the products page)";
    $p["affiliate_program_vendor_exp"] = "The affiliate program allows you, as a seller, to pay external partners a commission for promoting your products and driving sales through their unique links, helping you reach a wider audience and increase revenue. When you activate this system, there will be an option to create an affiliate link on your product page. All users can participate in this program by creating their own links for your products.";
    $p["referrer_commission_rate"] = "Referrer Commission Rate";
    $p["buyer_discount_rate"] = "Buyer Discount Rate";
    $p["referral_discount"] = "Referral Discount";
    $p["referrer_commission"] = "Referrer Commission";
    $p["commissions_discounts"] = "Commissions & Discounts";
    $p["pay_wallet_balance_exp"] = "Pay with your wallet balance";
    $p["pay_wallet_balance_warning"] = "The order amount will be deducted from your wallet balance. If you approve, please click the button below to complete the purchase.";
    $p["expense"] = "Expense";
    $p["expenses"] = "Expenses";
    $p["expense_amount"] = "Expense Amount";
    $p["purchase"] = "Purchase";
    $p["affiliate"] = "Affiliate";
    $p["delete_from_affiliate_program"] = "Delete from Affiliate Program";
    $p["add_to_affiliate_program"] = "Add to Affiliate Program";
    $p["removed_from_affiliate_program"] = "You have been removed from the affiliate program.";
    $p["wrong_password"] = "Wrong password!";
    $p["enter_your_password"] = "Enter your password";
    $p["login_to_user_account_exp"] = "Your current session will be terminated and a new session will be created for the account of the user you selected.";
    $p["auto_approve_orders"] = "Auto-Approve Unapproved Orders (after x days)";
    $p["excel"] = "Excel";
    $p["chat_messages"] = "Chat Messages";
    $p["sender"] = "Sender";
    $p["receiver"] = "Receiver";
    $p["reject_permanently"] = "Reject Permanently";
    $p["mgs_reject_open_shop"] = "Your request to open a store has been rejected!";
    $p["mgs_reject_open_shop_permanently"] = "Your request to open a store has been permanently rejected!";
    $p["permanently_rejected"] = "Permanently Rejected";
    $p["shop_opening_request_emails"] = "Shop opening request emails";
    $p["allow_free_plan_multiple_times"] = "Allow Free Plan to be Used Multiple Times";
    $p["msg_membership_activated"] = "Your membership plan has been successfully activated!";
    $p["filter_products_location"] = "Filter products by location";
    $p["add_comment"] = "Add Comment";
    $p["show_description_category_page"] = "Show Description on Category Page";
    $p["add_products"] = "Add Products";
    $p["edit_products"] = "Edit Products";
    $p["product_id_not_defined"] = "Product ID is not defined.";
    $p["bulk_upload_documentation"] = "Bulk Upload Documentation";
    $p["edit_brand"] = "Edit Brand";
    $p["user_details"] = "User Details";
    $p["twitter_url"] = "X (Twitter) URL";
    $p["twitch_url"] = "Twitch Url";
    $p["discord_url"] = "Discord Url";
    $p["user_login_activities"] = "User Login Activities";
    $p["user_agent"] = "User Agent";
    $p["number_short_thousand"] = "k";
    $p["number_short_million"] = "m";
    $p["number_short_billion"] = "b";
    $p["pwa_logo"] = "PWA Logo";
    $p["show_on_slider"] = "Show on Slider";
    $p["tags_product_exp"] = "Add relevant keywords for your product to increase visibility in search results";
    $p["edited_products"] = "Edited Products";
    $p["product_approval_new_products"] = "Product Approval for New Products";
    $p["product_approval_edited_products"] = "Product Approval for Edited Products";
    $p["enable_dont_hide_products"] = "Enable, Do Not Hide Products";
    $p["enable_hide_products"] = "Enable, Hide Products Until Approved";
    $p["logo_size"] = "Logo Size";
    $p["theme"] = "Theme";
    $p["grid_layout"] = "Grid Layout";
    $p["round_boxes"] = "Round Boxes";
    $p["shop_by_category"] = "Shop By Category";
    $p["filter_by_keyword"] = "Filter by keyword";
    $p["keyword"] = "Keyword";
    $p["search_products_categories_brands"] = "Search for products, categories or brands";
    $p["bulk_custom_field_upload"] = "Bulk Custom Field Upload";
    $p["post_comment"] = "Post Comment";
    $p["load_more_reviews"] = "Load more reviews";
    $p["load_more_comments"] = "Load more comments";
    $p["additional_invoice_information"] = "Additional Invoice Information";
    $p["support_system_emails"] = "Support system emails";
    $p["additional_invoice_information_exp"] = "VAT Number, Company No etc.";
    $p["tax_registration_number"] = "Tax Registration Number";
    $p["msg_support_new_message"] = "New Support Message";
    $p["msg_support_message_received"] = "Your Support Message has been Received";
    $p["msg_support_message_received_exp"] = "Thank you for reaching out to us. We have received your support message and will get back to you shortly.";
    $p["msg_support_message_replied"] = "Your Support Ticket Has Been Replied";
    $p["msg_support_message_replied_exp"] = "Please click the button below to view the ticket details.";
    $p["support_ticket"] = "Ticket";
    $p["single_country_mode"] = "Single Country Mode";
    $p["vacation_mode"] = "Vacation Mode";
    $p["vacation_message"] = "Vacation Message";
    $p["vendor_on_vacation"] = "Vendor on Vacation";
    $p["vendor_on_vacation_exp"] = "This vendor is currently on vacation and is not available to process orders or respond to messages.";
    $p["refund_system"] = "Refund System";
    $p["public_coupon"] = "Public Coupon";
    $p["public_coupon_exp"] = "Public coupons are visible to all users";
    $p["my_reviews"] = "My Reviews";
    $p["vendor_on_vacation_vendor_exp"] = "Vacation mode allows you to pause your store for a certain period of time";
    $p["view_pdf_file"] = "View PDF File";
    $p["add_funds"] = "Add Funds";
    $p["enter_amount"] = "Enter Amount";
    $p["deposit_amount"] = "Deposit Amount";
    $p["wallet_deposits"] = "Wallet Deposits";
    $p["wallet_deposit"] = "Wallet Deposit";
    $p["deposits"] = "Deposits";
    $p["bank_transfer_reports"] = "Bank Transfer Reports";
    $p["report_type"] = "Report Type";
    $p["commission_debt"] = "Commission Debt";
    $p["commission_debt_limit_exp"] = "Cash on Delivery commissions will be automatically deducted from your wallet balance. If your wallet has insufficient funds, the commission will be added as a debt. When these debts exceed the specified debt limit, this payment option will be automatically disabled for your store.";
    $p["commission_debt_limit"] = "Commission Debt Limit";
    $p["add_funds_pay_debt"] = "Add funds to your wallet to pay your debt. The debt will be automatically deducted.";
    $p["you_have_no_debt"] = "You have no debt.";
    $p["cod_option_disabled"] = "Cash on Delivery payment option has been disabled until your commission debt is paid.";
    $p["sales_number"] = "Sales";
    $p["show_number_sales_profile"] = "Show Number of Sales on Profile";
    $p["paying_wallet_balance"] = "Paying with Wallet Balance";
    $p["footer_bottom"] = "Footer Bottom";
    $p["edit_tax"] = "Edit Tax";
    $p["add_tax"] = "Add Tax";
    $p["msg_cart_select_location"] = "Please select your location to proceed with your purchase.";
    $p["apply_for_product_sales"] = "Apply for Product Sales";
    $p["apply_for_service_payments"] = "Apply for Service Payments";
    $p["all_locations"] = "All Locations";
    $p["shop_policies"] = "Shop Policies";
    $p["vendor_vat_rates_exp"] = "The VAT rate you set for a country will apply to all states within that country. However, if you want a state to have its own unique tax rate, you can specify a different VAT rate for that state.";
    $p["pagination_product"] = "Pagination (Number of products on each page)";
    $p["show_previous_products"] = "Show Previous Products";
    $p["select_products"] = "Select Products";
    $p["select_for_coupon"] = "Select for Coupon";
    $p["static_cache_system"] = "Static Cache System";
    $p["static_cache_system_exp"] = "While the cache system is used for products that are updated more frequently, static cache is applied to records that do not change often (such as categories, custom fields, settings, etc.). If any changes occur in these records, the cache files are automatically refreshed.";
    $p["delete_account"] = "Delete Account";
    $p["delete_account_exp"] = "Deleting your account is permanent and cannot be reversed. All data, including preferences and subscriptions, will be lost. The process requires admin approval, which may take some time. Please enter your password and confirm to proceed.";
    $p["delete_account_submit_exp"] = "Your account deletion request has been submitted and is awaiting admin approval. If you wish to cancel this request, please contact site administration through the Help Center.";
    $p["msg_request_received"] = "Your request has been received!";
    $p["account_deletion_requests"] = "Account Deletion Requests";
    $p["product_search_listing"] = "Product Search & Listing";
    $p["show_featured_products_first_search"] = "Show Featured Products First in Search Results";
    $p["estimated_delivery"] = "Estimated Delivery";
    $p["no_delivery_this_location"] = "No delivery to this location";
    $p["msg_vendor_membership_plan_expired"] = "Your membership plan has expired, so your products will no longer be published on the site. If you would like your products to continue being published on the site, please renew your membership plan.";
    $p["affiliate_links"] = "Affiliate Links";
    addTranslations($p);

    //add update records
    runQuery("UPDATE products SET is_active = 0 WHERE status = 0 OR visibility = 0 OR is_sold = 1 OR is_deleted = 1 OR is_draft = 1");

    //set email options
    $result = runQuery("SELECT * FROM general_settings WHERE id = 1");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $dataOptions = [
            'new_product' => !empty($row['send_email_new_product']) ? 1 : 0,
            'new_order' => !empty($row['send_email_buyer_purchase']) ? 1 : 0,
            'order_shipped' => !empty($row['send_email_order_shipped']) ? 1 : 0,
            'contact_messages' => !empty($row['send_email_contact_messages']) ? 1 : 0,
            'shop_opening_request' => !empty($row['send_email_shop_opening_request']) ? 1 : 0,
            'bidding_system' => !empty($row['send_email_bidding_system']) ? 1 : 0,
            'support_system' => 0,
        ];
        $dataOptions = serialize($dataOptions);
        $stmt = $connection->prepare("UPDATE general_settings SET email_options = ?");
        $stmt->bind_param("s", $dataOptions);
        $stmt->execute();
    }

    //set settings
    $result = runQuery("SELECT * FROM settings ORDER BY id;");
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data = [
                'facebook_url' => !empty($row['facebook_url']) ? $row['facebook_url'] : '',
                'twitter_url' => !empty($row['twitter_url']) ? $row['twitter_url'] : '',
                'instagram_url' => !empty($row['instagram_url']) ? $row['instagram_url'] : '',
                'tiktok_url' => !empty($row['tiktok_url']) ? $row['tiktok_url'] : '',
                'whatsapp_url' => !empty($row['whatsapp_url']) ? $row['whatsapp_url'] : '',
                'youtube_url' => !empty($row['youtube_url']) ? $row['youtube_url'] : '',
                'discord_url' => '',
                'telegram_url' => !empty($row['telegram_url']) ? $row['telegram_url'] : '',
                'pinterest_url' => !empty($row['pinterest_url']) ? $row['pinterest_url'] : '',
                'linkedin_url' => !empty($row['linkedin_url']) ? $row['linkedin_url'] : '',
                'twitch_url' => '',
                'vk_url' => !empty($row['vk_url']) ? $row['vk_url'] : '',
            ];
            $socialMediaData = serialize($data);
            $affiliateDescription = 'a:2:{s:5:"title";s:53:"Boost Your Earnings with the Modesy Affiliate Program";s:11:"description";s:196:"Are you a content creator, blogger, influencer, or simply someone with a strong online presence? If so, Modesy has an exciting opportunity for you to turn your online influence into real earnings.";}';
            $affiliateContent = 'a:2:{s:5:"title";s:38:"Why Join the Modesy Affiliate Program?";s:7:"content";s:1745:"<p>Modesy, a leading e-commerce platform known for its diverse range of products and exceptional customer service, is thrilled to introduce its Affiliate Program. This program offers you a chance to earn lucrative commissions by promoting Modesy\'s products. Here is everything you need to know about why the Modesy Affiliate Program is perfect for you.<br><br><strong>1. Attractive Commission Rates</strong><br>Modesy offers competitive commission rates that ensure you are rewarded generously for your efforts. Every time someone makes a purchase through your referral link, you earn a commission. The more you promote, the more you earn.</p>
    <p><strong>2. Wide Range of Products</strong><br>With Modesy’s extensive catalog, you have endless opportunities to promote products that resonate with your audience. Whether your niche is tech gadgets, fashion, beauty products, or home decor, Modesy has something for everyone.</p>
    <p><strong>3. Easy-to-Use Tools</strong><br>The Modesy Affiliate Program provides you with a suite of tools to make your promotional efforts seamless. From custom referral links to detailed performance reports, you’ll have everything you need to track your success and optimize your strategies.</p>
    <p><strong>4. Reliable Support</strong><br>Modesy values its affiliates and offers dedicated support to help you succeed. Whether you have questions about the program or need tips on how to maximize your earnings, the Modesy support team is always ready to assist you.</p>
    <p><strong>5. Timely Payments</strong><br>Modesy ensures that your hard-earned commissions are paid out on time. With a straightforward payout process, you can focus on what you do best – promoting great products and earning money.</p>";}';
            $affiliateFaq = 'a:8:{i:0;a:3:{s:1:"o";s:1:"1";s:1:"q";s:36:"How do I join the Affiliate program?";s:1:"a";s:110:"Simply click the "Join Now" button and fill out the registration form. Once approved, you can start promoting!";}i:1;a:3:{s:1:"o";s:1:"2";s:1:"q";s:45:"Who can participate in the Affiliate Program?";s:1:"a";s:215:"Anyone with an online presence, including bloggers, social media influencers, website owners, and content creators, can join the affiliate program. As long as you can promote our products, you’re welcome to apply!";}i:2;a:3:{s:1:"o";s:1:"3";s:1:"q";s:40:"Where can I generate my Affiliate links?";s:1:"a";s:222:"You can generate your affiliate links directly from any product detail page on our website. Once logged in, visit the product page you want to promote, and you’ll find an option to create your affiliate link right there.";}i:3;a:3:{s:1:"o";s:1:"4";s:1:"q";s:28:"What products can I promote?";s:1:"a";s:162:"You can promote any product from our store that is included in the affiliate program and earn commission on any qualifying sales made through your affiliate link.";}i:4;a:3:{s:1:"o";s:1:"5";s:1:"q";s:46:"How long is the validity of an Affiliate link?";s:1:"a";s:211:"An affiliate link is valid for 30 days from the moment a person clicks on it and opens the product page. If the product is purchased during this period, the affiliate commission will be applied for that product.";}i:5;a:3:{s:1:"o";s:1:"6";s:1:"q";s:20:"How much can I earn?";s:1:"a";s:120:"There is no limit to how much you can earn. Your earnings depend on the sales you generate through your affiliate links.";}i:6;a:3:{s:1:"o";s:1:"7";s:1:"q";s:37:"How do I track my Affiliate earnings?";s:1:"a";s:96:"You can track your affiliate program earnings in the "Referral Earnings" section of your wallet.";}i:7;a:3:{s:1:"o";s:1:"8";s:1:"q";s:35:"How do I get my Affiliate earnings?";s:1:"a";s:188:"Once your earnings exceed the minimum payout limit, you can request a payment from the "Payouts" section of your wallet. Simply submit a payout request, and your payment will be processed.";}}';
            $affiliateWorks = 'a:3:{i:0;a:2:{s:5:"title";s:23:"Sign up for the program";s:11:"description";s:77:"Join the Modesy affiliate program by completing a simple registration process";}i:1;a:2:{s:5:"title";s:34:"Create and share your referral URL";s:11:"description";s:77:"Generate a referral URL and share it on your website, email, or social media.";}i:2;a:2:{s:5:"title";s:15:"Earn commission";s:11:"description";s:64:"Earn commissions on every sale made through your affiliate links";}}';
            $bulkUploadDocumentation = '<p>With the bulk product upload feature, you can upload your products in bulk with the help of a CSV file.<br><br>Bulk upload has options to add new products and edit existing products:<br><br><strong>Add Products: </strong>To add new products, download the CSV template, add your products to this CSV file and upload it from this section. You can see detailed explanations of all required or optional columns in the table below. When adding your data, you need to pay attention to the data type of these columns.<br><br><strong>Edit Products: </strong>To edit products, you need to add an "id" column to the CSV template. You can see the ID numbers of your products on the "products" page. After adding the "id" column, you need to add the column names you want to edit. <br>For example, if you want to update the stock and prices of your products, your CSV template should be like this:<br><span style="color: rgb(35, 111, 161);">"id","price","price_discounted","stock"</span><br><br>Example:<br><span style="color: rgb(35, 111, 161);">"id","price","price_discounted","stock"</span><br><span style="color: rgb(132, 63, 161);">"1","30","20","1000"</span><br><span style="color: rgb(132, 63, 161);">"5","40","40","500"</span><br><br><span style="color: rgb(186, 55, 42);">* To update the product price, you need to add both "price" and "price_discounted" columns to your CSV file.<br><br><br></span></p>
    <p><span style="font-size: 12pt;"><strong>CSV Columns</strong></span></p><table style="width: 100%;" class="table table-bordered"><tbody><tr><th>Column</th><th>Description</th></tr><tr><td style="width: 180px;">title</td>
    <td>Data Type: Text <br><strong>Required</strong><br>Example: Modern grey couch and pillows</td></tr><tr><td style="width: 180px;">slug</td><td>Data Type: Text <br><strong>Optional</strong> <small>(If you leave it empty, it will be generated automatically.)</small> <br>Example: modern-grey-couch-and-pillows</td>
    </tr><tr><td style="width: 180px;">sku</td><td>Data Type: Text <br><strong>Optional</strong><br>Example: MD-GR-6898</td></tr><tr><td style="width: 180px;">category_id</td><td>Data Type: Number <br><strong>Required</strong><br>Example: 1</td></tr><tr><td style="width: 180px;">price</td>
    <td>Data Type: Decimal/Number <br><strong>Required</strong><br>Example 1: 50<br>Example 2: 45.90<br>Example 3: 3456.25</td></tr><tr><td style="width: 180px;">price_discounted</td><td>Data Type: Decimal/Number <br><strong>Optional</strong><br>Example 1: 40<br>Example 2: 35.90<br>Example 3: 2456.25</td>
    </tr><tr><td style="width: 180px;">vat_rate</td><td>Data Type: Number <br><strong>Optional</strong><br>Example: 8</td></tr><tr><td style="width: 180px;">stock</td><td>Data Type: Number <br><strong>Required</strong><br>Example: 100</td></tr><tr><td style="width: 180px;">short_description</td>
    <td>Data Type: Text <br><strong>Optional</strong><br>Example: It is a nice and comfortable couch</td></tr><tr><td style="width: 180px;">description</td><td>Data Type: Text <br><strong>Optional</strong><br>Example: It is a nice and comfortable couch...</td></tr><tr><td style="width: 180px;">tags</td>
    <td>Data Type: Text <br><strong>Optional</strong><br>Example: nice, comfortable, couch</td></tr><tr><td style="width: 180px;">image_url</td><td>Data Type: Text <br><strong>Optional</strong><br>Example 1:<br>https://upload.wikimedia.org/wikipedia/commons/7/70/Labrador-sea-paamiut.jpg<br><br>Example 2:<br>https://upload.wikimedia.org/wikipedia/commons/7/70/Labrador-sea-paamiut.jpg,<br>https://upload.wikimedia.org/wikipedia/commons/thumb/4/42/Shaqi_jrvej.jpg/1600px-Shaqi_jrvej.jpg<br><br><span style="color: rgb(186, 55, 42);">*You can add multiple image links by placing commas between them.</span></td>
    </tr><tr><td style="width: 180px;">external_link</td><td>Data Type: Text <br><strong>Optional</strong><br>Example: https://domain.com/product_url</td></tr><tr><td style="width: 180px;">updated_at</td><td>Data Type: Timestamp <br><strong>Optional</strong><br>Example: 2024-06-30 10:27:00 <br><br><span style="color: rgb(186, 55, 42);">*If you leave it blank, the system will not assign an update date.</span></td></tr><tr>
    <td style="width: 180px;">created_at</td><td>Data Type: Timestamp <br><strong>Optional</strong><br>Example: 2024-06-30 10:27:00 <br><br><span style="color: rgb(186, 55, 42);">*If you leave it blank, the system will automatically assign the current date.</span></td></tr></tbody></table><p><br><br><br><br><br></p>';
            $stmt = $connection->prepare("UPDATE settings SET social_media_data = ?, affiliate_description = ?, affiliate_content = ?, affiliate_faq = ?, affiliate_works = ?, bulk_upload_documentation = ? WHERE id = ?");
            $stmt->bind_param("ssssssi", $socialMediaData, $affiliateDescription, $affiliateContent, $affiliateFaq, $affiliateWorks, $bulkUploadDocumentation, $row['id']);
            $stmt->execute();
        }
    }

    //set users
    $result = runQuery("SELECT * FROM users;");
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data = [
                'facebook_url' => !empty($row['facebook_url']) ? $row['facebook_url'] : '',
                'twitter_url' => !empty($row['twitter_url']) ? $row['twitter_url'] : '',
                'instagram_url' => !empty($row['instagram_url']) ? $row['instagram_url'] : '',
                'tiktok_url' => !empty($row['tiktok_url']) ? $row['tiktok_url'] : '',
                'whatsapp_url' => !empty($row['whatsapp_url']) ? $row['whatsapp_url'] : '',
                'youtube_url' => !empty($row['youtube_url']) ? $row['youtube_url'] : '',
                'discord_url' => '',
                'telegram_url' => !empty($row['telegram_url']) ? $row['telegram_url'] : '',
                'pinterest_url' => !empty($row['pinterest_url']) ? $row['pinterest_url'] : '',
                'linkedin_url' => !empty($row['linkedin_url']) ? $row['linkedin_url'] : '',
                'twitch_url' => '',
                'vk_url' => !empty($row['vk_url']) ? $row['vk_url'] : '',
                'personal_website_url' => !empty($row['personal_website_url']) ? $row['personal_website_url'] : ''
            ];
            $socialMediaData = serialize($data);
            $stmt = $connection->prepare("UPDATE users SET social_media_data = ? WHERE id = ?");
            $stmt->bind_param("si", $socialMediaData, $row['id']);
            $stmt->execute();
        }
    }

    //update custom field options
    $options = runQuery("SELECT * FROM custom_fields_options;");
    if (!empty($options->num_rows)) {
        while ($option = mysqli_fetch_array($options)) {
            $optionsLang = runQuery("SELECT * FROM custom_fields_options_lang WHERE `option_id` =" . $option['id'] . "   ORDER BY id;");
            $data = array();
            if (!empty($optionsLang->num_rows)) {
                while ($optionLang = mysqli_fetch_array($optionsLang)) {
                    $item = [
                        'lang_id' => $optionLang['lang_id'],
                        'name' => $optionLang['option_name']
                    ];
                    array_push($data, $item);
                }
            }
            if (!empty($data)) {
                $data = serialize($data);
                $stmt = $connection->prepare("UPDATE custom_fields_options SET `name_data` = ? WHERE `id` = ?");
                $stmt->bind_param("si", $data, $option['id']);
                $stmt->execute();
            }
        }
    }

    runQuery("UPDATE general_settings SET version='2.5' WHERE id='1'");
    runQuery("ALTER TABLE bank_transfers DROP COLUMN `user_type`;");
    runQuery("ALTER TABLE general_settings DROP COLUMN `send_email_new_product`;");
    runQuery("ALTER TABLE general_settings DROP COLUMN `send_email_buyer_purchase`;");
    runQuery("ALTER TABLE general_settings DROP COLUMN `send_email_contact_messages`;");
    runQuery("ALTER TABLE general_settings DROP COLUMN `send_email_order_shipped`;");
    runQuery("ALTER TABLE general_settings DROP COLUMN `send_email_shop_opening_request`;");
    runQuery("ALTER TABLE general_settings DROP COLUMN `send_email_bidding_system`;");
    runQuery("ALTER TABLE payment_settings DROP COLUMN `global_taxes_data`;");
    runQuery("ALTER TABLE settings DROP COLUMN `facebook_url`;");
    runQuery("ALTER TABLE settings DROP COLUMN `twitter_url`;");
    runQuery("ALTER TABLE settings DROP COLUMN `instagram_url`;");
    runQuery("ALTER TABLE settings DROP COLUMN `pinterest_url`;");
    runQuery("ALTER TABLE settings DROP COLUMN `linkedin_url`;");
    runQuery("ALTER TABLE settings DROP COLUMN `vk_url`;");
    runQuery("ALTER TABLE settings DROP COLUMN `whatsapp_url`;");
    runQuery("ALTER TABLE settings DROP COLUMN `telegram_url`;");
    runQuery("ALTER TABLE settings DROP COLUMN `youtube_url`;");
    runQuery("ALTER TABLE settings DROP COLUMN `tiktok_url`;");
    runQuery("ALTER TABLE users DROP COLUMN `facebook_url`;");
    runQuery("ALTER TABLE users DROP COLUMN `twitter_url`;");
    runQuery("ALTER TABLE users DROP COLUMN `instagram_url`;");
    runQuery("ALTER TABLE users DROP COLUMN `pinterest_url`;");
    runQuery("ALTER TABLE users DROP COLUMN `linkedin_url`;");
    runQuery("ALTER TABLE users DROP COLUMN `vk_url`;");
    runQuery("ALTER TABLE users DROP COLUMN `whatsapp_url`;");
    runQuery("ALTER TABLE users DROP COLUMN `telegram_url`;");
    runQuery("ALTER TABLE users DROP COLUMN `youtube_url`;");
    runQuery("ALTER TABLE users DROP COLUMN `tiktok_url`;");
    runQuery("ALTER TABLE users DROP COLUMN `personal_website_url`;");
    runQuery("ALTER TABLE users DROP COLUMN `cash_on_delivery_fee`;");
    runQuery("DROP TABLE custom_fields_options_lang;");

    //add product tags
    $rows = runQuery("SELECT pd.id AS id, pd.product_id AS product_id, pd.title AS title, pd.lang_id AS lang_id, pd.keywords AS keywords, 
       (SELECT sku FROM products WHERE products.id = pd.product_id LIMIT 1) AS sku FROM product_details pd");
    if (!empty($rows->num_rows)) {
        while ($row = mysqli_fetch_array($rows)) {

            try {
                $searchIndex = $row['title'];
                if (!empty($searchIndex)) {
                    $searchIndex = @mb_strtolower($searchIndex, 'UTF-8');
                }
                $searchIndex .= ' ' . $row['sku'];
                $arrayKeywords = !empty($row['keywords']) ? explode(',', $row['keywords']) : array();
                if (!empty($arrayKeywords) && count($arrayKeywords) > 0) {
                    $strKeywords = implode(' ', $arrayKeywords);
                    $strKeywords = mb_strtolower($strKeywords, 'UTF-8');
                    $searchIndex .= ' ' . $strKeywords;
                }
                $searchIndex = str_replace(['&', '#', '-', '_', ',', '"', "'"], '', $searchIndex ?? '');
                $stmt = $connection->prepare("INSERT INTO product_search_indexes (`product_id`, `lang_id`, `search_index`) VALUES (?, ?, ?)");
                $stmt->bind_param("iis", $row['product_id'], $row['lang_id'], $searchIndex);
                $stmt->execute();
                if (!empty($arrayKeywords) && count($arrayKeywords) > 0) {
                    $stmt = $connection->prepare("INSERT INTO product_tags (`product_id`, `lang_id`, `tag`) VALUES (?, ?, ?)");
                    foreach ($arrayKeywords as $item) {
                        $item = trim($item);
                        if (!empty($item)) {
                            $item = @mb_strtolower($item, 'UTF-8');
                            $stmt->bind_param("iis", $row['product_id'], $row['lang_id'], $item);
                            $stmt->execute();
                        }
                    }
                }
            } catch (Exception $e) {
            }

        }
    }

    runQuery("ALTER TABLE product_details DROP COLUMN `keywords`;");
    $stmt->close();
}

function addTranslations($translations)
{
    global $connection;

    $languages = runQuery("SELECT * FROM languages;");
    if (!empty($languages->num_rows)) {
        while ($language = mysqli_fetch_array($languages)) {
            foreach ($translations as $key => $value) {
                $trans = runQuery("SELECT * FROM language_translations WHERE label ='" . $key . "' AND lang_id = " . $language['id']);
                if (empty($trans->num_rows)) {
                    $stmt = $connection->prepare("INSERT INTO language_translations (`lang_id`, `label`, `translation`) VALUES (?, ?, ?)");
                    $stmt->bind_param("iss", $language['id'], $key, $value);
                    $stmt->execute();
                }
            }
        }
    }
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modesy - Update Wizard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #444 !important;
            font-size: 14px;
            background: #007991;
            background: -webkit-linear-gradient(to left, #007991, #6fe7c2);
            background: linear-gradient(to left, #007991, #6fe7c2);
        }

        .logo-cnt {
            text-align: center;
            color: #fff;
            padding: 60px 0 60px 0;
        }

        .logo-cnt .logo {
            font-size: 42px;
            line-height: 42px;
        }

        .logo-cnt p {
            font-size: 22px;
        }

        .install-box {
            width: 100%;
            padding: 30px;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin: auto;
            background-color: #fff;
            border-radius: 4px;
            display: block;
            float: left;
            margin-bottom: 100px;
        }

        .form-input {
            box-shadow: none !important;
            border: 1px solid #ddd;
            height: 44px;
            line-height: 44px;
            padding: 0 20px;
        }

        .form-input:focus {
            border-color: #239CA1 !important;
        }

        .btn-custom {
            background-color: #239CA1 !important;
            border-color: #239CA1 !important;
            border: 0 none;
            border-radius: 4px;
            box-shadow: none;
            color: #fff !important;
            font-size: 16px;
            font-weight: 300;
            height: 40px;
            line-height: 40px;
            margin: 0;
            min-width: 105px;
            padding: 0 20px;
            text-shadow: none;
            vertical-align: middle;
        }

        .btn-custom:hover, .btn-custom:active, .btn-custom:focus {
            background-color: #239CA1;
            border-color: #239CA1;
            opacity: .8;
        }

        .tab-content {
            width: 100%;
            float: left;
            display: block;
        }

        .tab-footer {
            width: 100%;
            float: left;
            display: block;
        }

        .buttons {
            display: block;
            float: left;
            width: 100%;
            margin-top: 30px;
        }

        .title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
            margin-top: 0;
            text-align: center;
        }

        .sub-title {
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 30px;
            margin-top: 0;
            text-align: center;
        }

        .alert {
            text-align: center;
        }

        .alert strong {
            font-weight: 500 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-sm-12 col-md-offset-2">
            <div class="row">
                <div class="col-sm-12 logo-cnt">
                    <h1>Modesy</h1>
                    <p>Welcome to the Update Wizard</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="install-box">
                        <h2 class="title">Update from v2.4.x to v2.5</h2>
                        <br><br>
                        <div class="messages">
                            <?php if (!empty($error)) { ?>
                                <div class="alert alert-danger">
                                    <strong><?= $error; ?></strong>
                                </div>
                            <?php } ?>
                            <?php if (!empty($success)) { ?>
                                <div class="alert alert-success">
                                    <strong><?= $success; ?></strong>
                                    <style>.alert-info {
                                            display: none;
                                        }</style>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="step-contents">
                            <div class="tab-1">
                                <?php if (empty($success)): ?>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <input type="hidden" name="license_code" value="<?= !empty($license_code) ? $license_code : ''; ?>">
                                        <input type="hidden" name="purchase_code" value="<?= !empty($purchase_code) ? $purchase_code : ''; ?>">
                                        <div class="tab-content">
                                            <div class="tab_1">
                                                <p class="text-danger" style="font-weight: 500;">** Please take a backup of your database before you start. You can export this backup in .sql format using the "export" option in phpMyAdmin.</p>
                                                <p class="text-danger" style="font-weight: 500;">** Updating may take some time depending on the number of records in your database. If you have many products (example: 10,000), you may need to increase
                                                    the "max_execution_time" value in your PHP settings. Otherwise, your server may stop working before the update process is completed.</p>
                                                <p class="text-danger" style="font-weight: 500;">** If there is an error during the update or if it is interrupted, you will need to delete the database, restore your database backup (with the "import" option in phpMyAdmin), and try again.</p>
                                                <hr>
                                                <p class="text-success text-center" style="font-weight: 500;">Enter your database credentials and click the button to update the database.</p>
                                                <div class="form-group">
                                                    <label for="email">Host</label>
                                                    <input type="text" class="form-control form-input" name="db_host" placeholder="Host" value="<?= !empty($data['db_host']) ? $data['db_host'] : 'localhost'; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Database Name</label>
                                                    <input type="text" class="form-control form-input" name="db_name" placeholder="Database Name" value="<?= !empty($data['db_name']) ? $data['db_name'] : ''; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Username</label>
                                                    <input type="text" class="form-control form-input" name="db_user" placeholder="Username" value="<?= !empty($data['db_user']) ? $data['db_user'] : ''; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Password</label>
                                                    <input type="text" class="form-control form-input" name="db_password" placeholder="Password" value="<?= !empty($data['db_password']) ? $data['db_password'] : ''; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="buttons text-center">
                                            <button type="submit" name="btnUpdate" class="btn btn-success btn-custom" style="width: 100%; height: 50px;">Update My Database</button>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>