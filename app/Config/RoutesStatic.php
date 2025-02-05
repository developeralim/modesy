<?php
/*
 * --------------------------------------------------------------------
 * GET
 * --------------------------------------------------------------------
 */

$routes->post('login-post', 'AuthController::loginPost');
$routes->post('logout', 'CommonController::logout');
$routes->get('cron/update-sitemap', 'HomeController::cronUpdateSitemap');
$routes->get('unsubscribe', 'HomeController::unSubscribe');
$routes->get('connect-with-facebook', 'AuthController::connectWithFacebook');
$routes->get('facebook-callback', 'AuthController::facebookCallback');
$routes->get('connect-with-google', 'AuthController::connectWithGoogle');
$routes->get('connect-with-vk', 'AuthController::connectWithVk');

/*
 * --------------------------------------------------------------------
 * POST
 * --------------------------------------------------------------------
 */

//home
$routes->post('contact-post', 'HomeController::contactPost');
$routes->post('set-selected-currency-post', 'HomeController::setSelectedCurrency');
$routes->post('add-review-post', 'HomeController::addReviewPost');
$routes->post('submit-request-post', 'SupportController::submitRequestPost');
$routes->post('reply-ticket-post', 'SupportController::replyTicketPost');
$routes->post('close-ticket-post', 'SupportController::closeTicketPost');
$routes->post('download-attachment-post', 'SupportController::downloadAttachmentPost');
//auth
$routes->post('forgot-password-post', 'AuthController::forgotPasswordPost');
$routes->post('reset-password-post', 'AuthController::resetPasswordPost');
$routes->post('register-post', 'AuthController::registerPost');

//bidding
$routes->post('submit-quote-post', 'DashboardController::submitQuotePost');
$routes->post('request-quote-post', 'OrderController::requestQuotePost');
$routes->post('accept-quote-post', 'OrderController::acceptQuote');
$routes->post('reject-quote-post', 'OrderController::rejectQuote');
$routes->post('modify-quote-post', 'OrderController::modifyQuotePrice');

//cart
$routes->post('cart/add-to-cart', 'CartController::addToCart');
$routes->post('add-to-cart-quote', 'CartController::addToCartQuote');
$routes->post('update-cart-product-quantity', 'CartController::updateCartProductQuantity');
$routes->post('payment-method-post', 'CartController::paymentMethodPost');
$routes->post('shipping-post', 'CartController::shippingPost');
$routes->post('bank-transfer-payment-post', 'CartController::bankTransferPaymentPost');
$routes->post('cash-on-delivery-payment-post', 'CartController::cashOnDeliveryPaymentPost');
$routes->post('paypal-payment-post', 'CartController::paypalPaymentPost');
$routes->post('paystack-payment-post', 'CartController::paystackPaymentPost');
$routes->post('razorpay-payment-post', 'CartController::razorpayPaymentPost');
$routes->get('flutterwave-payment-post', 'CartController::flutterwavePaymentPost');
$routes->post('stripe-payment-post', 'CartController::stripePaymentPost');
$routes->get('iyzico-payment-post', 'CartController::iyzicoPaymentPost');
$routes->get('cart/paytabs-payment-post', 'CartController::paytabsPaymentPost');
$routes->post('midtrans-payment-post', 'CartController::midtransPaymentPost');
$routes->get('mercado-pago-payment-post', 'CartController::mercadoPagoPaymentPost');
$routes->post('cart/coupon-code-post', 'CartController::couponCodePost');
//order
$routes->post('submit-refund-request', 'OrderController::submitRefundRequest');
$routes->post('add-refund-message', 'OrderController::addRefundMessage');
//wallet
$routes->post('wallet/new-payout-request-post', 'ProfileController::newPayoutRequestPost');
$routes->post('wallet/set-payout-account-post', 'ProfileController::setPayoutAccountPost');

//message
$routes->post('send-message-post', 'HomeController::sendMessagePost');
$routes->post('chat/init','ChatController::initChat');

//file
$routes->post('upload-audio-post', 'FileController::uploadAudio');
$routes->post('load-audio-preview-post', 'FileController::loadAudioPreview');
$routes->post('upload-digital-file-post', 'FileController::uploadDigitalFile');
$routes->post('download-digital-file-post', 'FileController::downloadDigitalFile');
$routes->post('upload-file-manager-images-post', 'FileController::uploadFileManagerImagePost');
$routes->post('upload-image-post', 'FileController::uploadImage');
$routes->post('get-uploaded-image-post', 'FileController::getUploadedImage');
$routes->post('upload-image-session-post', 'FileController::uploadImageSession');
$routes->post('get-sess-uploaded-image-post', 'FileController::getSessUploadedImage');
$routes->post('upload-video-post', 'FileController::uploadVideo');
$routes->post('load-video-preview-post', 'FileController::loadVideoPreview');
$routes->post('download-purchased-digital-file-post', 'FileController::downloadPurchasedDigitalFile');
$routes->post('download-free-digital-file-post', 'FileController::downloadFreeDigitalFile');
//product
$routes->post('add-product-post', 'DashboardController::addProductPost');
$routes->post('edit-product-post', 'DashboardController::editProductPost');
$routes->post('edit-product-details-post', 'DashboardController::editProductDetailsPost');
$routes->post('start-selling-post', 'HomeController::startSellingPost');
$routes->post('add-remove-wishlist-post', 'AjaxController::addRemoveWishlist');
//variations
$routes->post('add-variation-post', 'VariationController::addVariationPost');
$routes->post('edit-variation', 'VariationController::editVariation');
$routes->post('edit-variation-post', 'VariationController::editVariationPost');
$routes->post('delete-variation-post', 'VariationController::deleteVariationPost');
$routes->post('add-variation-option', 'VariationController::addVariationOption');
$routes->post('add-variation-option-post', 'VariationController::addVariationOptionPost');
$routes->post('view-variation-options', 'VariationController::viewVariationOptions');
$routes->post('edit-variation-option', 'VariationController::editVariationOption');
$routes->post('edit-variation-option-post', 'VariationController::editVariationOptionPost');
$routes->post('delete-variation-option-post', 'VariationController::deleteVariationOptionPost');
$routes->post('select-variation-post', 'VariationController::selectVariationPost');
$routes->post('upload-variation-image-session', 'VariationController::uploadVariationImageSession');
$routes->post('get-uploaded-variation-image-session', 'VariationController::getSessUploadedVariationImage');
$routes->post('delete-variation-image-session-post', 'VariationController::deleteVariationImageSessionPost');
$routes->post('set-variation-image-main-session', 'VariationController::setVariationImageMainSession');
$routes->post('set-variation-image-main', 'VariationController::setVariationImageMain');
$routes->post('upload-variation-image', 'VariationController::uploadVariationImage');
$routes->post('get-uploaded-variation-image', 'VariationController::getUploadedVariationImage');
$routes->post('delete-variation-image-post', 'VariationController::deleteVariationImagePost');
$routes->post('select-variation-option-post', 'AjaxController::selectProductVariationOption');
$routes->post('get-sub-variation-options', 'AjaxController::getSubVariationOptions');
//profile
$routes->post('social-media-post', 'ProfileController::socialMediaPost');
$routes->post('edit-profile-post', 'ProfileController::editProfilePost');
$routes->post('cover-image-post', 'ProfileController::coverImagePost');
$routes->post('follow-unfollow-user-post', 'ProfileController::followUnfollowUser');
$routes->post('change-password-post', 'ProfileController::changePasswordPost');
$routes->post('delete-account-post', 'ProfileController::deleteAccountPost');
$routes->post('add-shipping-address-post', 'ProfileController::addShippingAddressPost');
$routes->post('edit-shipping-address-post', 'ProfileController::editShippingAddressPost');
$routes->post('edit-location-post', 'ProfileController::locationPost');
//shop & shipping settings
$routes->post('shop-settings-post', 'DashboardController::shopSettingsPost');
$routes->post('add-shipping-zone-post', 'DashboardController::addShippingZonePost');
$routes->post('edit-shipping-zone-post', 'DashboardController::editShippingZonePost');
$routes->post('add-shipping-class-post', 'DashboardController::addShippingClassPost');
$routes->post('edit-shipping-class-post', 'DashboardController::editShippingClassPost');
$routes->post('add-shipping-delivery-time-post', 'DashboardController::addShippingDeliveryTimePost');
$routes->post('edit-shipping-delivery-time-post', 'DashboardController::editShippingDeliveryTimePost');
//order dash
$routes->post('update-order-product-status-post', 'DashboardController::updateOrderProductStatusPost');
//promote
$routes->post('promote-product-post', 'DashboardController::promoteProductPost');
//coupon
$routes->post('add-coupon-post', 'DashboardController::addCouponPost');
$routes->post('edit-coupon-post', 'DashboardController::editCouponPost');

$routes->get('Ajax/updateChatGet', 'AjaxController::updateChatGet');
$routes->get('Ajax/getChats','ChatController::getChats');
$routes->get('Ajax/getMessages','ChatController::getMessages');

$postArray = [
    //Admin
    'Admin/editSliderSettingsPost',
    'Admin/deleteAbuseReportPost',
    'Admin/adSpacesPost',
    'Admin/googleAdsenseCodePost',
    'Admin/cacheSystemPost',
    'Admin/deleteContactMessagePost',
    'Admin/themePost',
    'Admin/generateSitemapPost',
    'Admin/downloadSitemapPost',
    'Admin/deleteSitemapPost',
    'Admin/seoToolsPost',
    'Admin/storagePost',
    'Admin/awsS3Post',
    'Admin/addCurrencyPost',
    'Admin/currencySettingsPost',
    'Admin/currencyConverterPost',
    'Admin/updateCurrencyRates',
    'Admin/deleteCurrencyPost',
    'Admin/editCurrencyPost',
    'Admin/editFontPost',
    'Admin/setSiteFontPost',
    'Admin/addFontPost',
    'Admin/deleteFontPost',
    'Admin/editIndexBannerPost',
    'Admin/homepageManagerPost',
    'Admin/deleteIndexBannerPost',
    'Admin/homepageManagerSettingsPost',
    'Admin/addIndexBannerPost',
    'Admin/setActiveLanguagePost',
    'Admin/downloadDatabaseBackup',
    'Admin/addCityPost',
    'Admin/addCountryPost',
    'Admin/addStatePost',
    'Admin/deleteCityPost',
    'Admin/deleteCountryPost',
    'Admin/locationSettingsPost',
    'Admin/editCityPost',
    'Admin/editCountryPost',
    'Admin/editStatePost',
    'Admin/deleteStatePost',
    'Admin/newsletterSendEmail',
    'Admin/deleteNewsletterPost',
    'Admin/newsletterSettingsPost',
    'Admin/newsletterSendEmailPost',
    'Admin/addPagePost',
    'Admin/editPagePost',
    'Admin/deletePagePost',
    'Admin/emailSettingsPost',
    'Admin/sendTestEmailPost',
    'Admin/emailOptionsPost',
    'Admin/generalSettingsPost',
    'Admin/recaptchaSettingsPost',
    'Admin/maintenanceModePost',
    'Admin/paymentGatewaySettingsPost',
    'Admin/commissionSettingsPost',
    'Admin/deleteTaxPost',
    'Admin/editTaxPost',
    'Admin/addTaxPost',
    'Admin/additionalInvoiceInfoPost',
    'Admin/preferencesPost',
    'Admin/productSettingsPost',
    'Admin/routeSettingsPost',
    'Admin/socialLoginSettingsPost',
    'Admin/visualSettingsPost',
    'Admin/updateWatermarkSettingsPost',
    'Admin/editSliderItemPost',
    'Admin/addSliderItemPost',
    'Admin/deleteSliderItemPost',
    'Admin/activateInactivateCountries',
    'Admin/homepageManagerPost',
    'Admin/updateCurrencyRate',
    'Admin/affiliateProgramPost',
    'Admin/deleteChatPost',
    'Admin/deleteChatMessagePost',
    'Admin/approveMembershipPaymentPost',
    'Admin/approvePromotionPaymentPost',
    'Admin/approveWalletDepositPaymentPost',
    'Admin/deleteMembershipPaymentPost',
    'Admin/deletePromotionPaymentsPost',
    'Admin/bankTransferOptionsPost',
    'Admin/deleteWalletDepositPost',
    'Admin/deleteBankTransferPost',
    'Admin/loadCountersPost',
    //Ajax
    'Ajax/getStates',
    'Ajax/getCities',
    'Ajax/getSubCategories',
    'Ajax/searchCategories',
    'Ajax/getSubCategories',
    'Ajax/runEmailQueue',
    'Ajax/getBlogCategoriesByLang',
    'Ajax/getCountriesByContinent',
    'Ajax/getStatesByCountry',
    'Ajax/addComment',
    'Ajax/loadMoreComments',
    'Ajax/loadMoreReviews',
    'Ajax/deleteComment',
    'Ajax/deleteReview',
    'Ajax/loadSubCommentForm',
    'Ajax/addBlogComment',
    'Ajax/loadMoreBlogComments',
    'Ajax/deleteBlogComment',
    'Ajax/addChatPost',
    'Ajax/loadChatPost',
    'Ajax/sendMessagePost',
    'Ajax/deleteChatPost',
    'Ajax/reportAbusePost',
    'Ajax/ajaxSearch',
    'Ajax/loadMorePromotedProducts',
    'Ajax/hideCookiesWarning',
    'Ajax/getProductShippingCost',
    'Ajax/addToNewsletter',
    'Ajax/createAffiliateLink',
    'Ajax/selectCouponCategoryPost',
    'Ajax/selectCouponProductPost',
    //Auth
    'Auth/sendActivationEmailPost',
    'Auth/joinAffiliateProgramPost',
    //Blog
    'Blog/addPostPost',
    'Blog/addCategoryPost',
    'Blog/deleteCategoryPost',
    'Blog/approveCommentPost',
    'Blog/deleteComment',
    'Blog/editCategoryPost',
    'Blog/editPostPost',
    'Blog/deletePostPost',
    'Blog/approveSelectedComments',
    'Blog/deleteSelectedComments',
    'Blog/deletePostImagePost',
    //Cart
    'Cart/removeCartDiscountCoupon',
    'Cart/removeFromCart',
    'Cart/getShippingMethodsByLocation',
    'Cart/walletBalancePaymentPost',
    //Category
    'Category/deleteBrandPost',
    'Category/editBrandPost',
    'Category/brandSettingsPost',
    'Category/addBrandPost',
    'Category/addCategoryPost',
    'Category/addCustomFieldPost',
    'Category/downloadCsvFilesPost',
    'Category/generateCsvObjectPost',
    'Category/importCsvItemPost',
    'Category/categorySettingsPost',
    'Category/deleteCategoryPost',
    'Category/loadCategories',
    'Category/editCustomFieldOptionPost',
    'Category/addCustomFieldOptionPost',
    'Category/addCategoryToCustomField',
    'Category/customFieldSettingsPost',
    'Category/addRemoveCustomFieldFiltersPost',
    'Category/deleteCustomFieldPost',
    'Category/editCategoryPost',
    'Category/editCustomFieldPost',
    'Category/deleteCustomFieldOption',
    'Category/deleteCategoryFromField',
    'Category/editFeaturedCategoriesOrderPost',
    'Category/editIndexCategoriesOrderPost',
    'Category/deleteCategoryImagePost',
    'Category/generateCsvObjectCustomFieldPost',
    'Category/importCsvCustomFieldPost',
    'Category/downloadCsvFilesCustomFieldPost',
    //Dashboard
    'Dashboard/deleteCouponPost',
    'Dashboard/downloadCsvFilePost',
    'Dashboard/generateCsvObjectPost',
    'Dashboard/importCsvItemPost',
    'Dashboard/deleteProduct',
    'Dashboard/approveDeclineRefund',
    'Dashboard/deleteShippingLocationPost',
    'Dashboard/selectShippingMethod',
    'Dashboard/deleteShippingMethodPost',
    'Dashboard/deleteShippingZonePost',
    'Dashboard/deleteShippingClassPost',
    'Dashboard/deleteShippingDeliveryTimePost',
    'Dashboard/addLicenseKeys',
    'Dashboard/deleteLicenseKey',
    'Dashboard/loadLicenseKeysList',
    'Dashboard/getSubCategories',
    'Dashboard/affiliateProgramPost',
    'Dashboard/addRemoveAffiliateProductPost',
    'Dashboard/exportTableDataPost',
    'Dashboard/cashOnDeliverySettingsPost',
    'Dashboard/shopPoliciesPost',
    'Dashboard/loadIndexData',
    //Earnings
    'Earnings/addPayoutPost',
    'Earnings/deleteEarningPost',
    'Earnings/completePayoutRequestPost',
    'Earnings/deletePayoutPost',
    'Earnings/payoutSettingsPost',
    'Earnings/editSellerBalancePost',
    //File
    'File/uploadBlogImage',
    'File/downloadDigitalFile',
    'File/setImageMainSession',
    'File/setImageMain',
    'File/deleteImageSession',
    'File/deleteImage',
    'File/deleteVideo',
    'File/deleteAudio',
    'File/deleteDigitalFile',
    'File/getBlogImages',
    'File/deleteBlogImage',
    'File/loadMoreBlogImages',
    'File/getFileManagerImages',
    'File/deleteFileManagerImage',
    'File/exportTableDataPost',
    //Home
    'Home/selectMembershipPlanPost',
    'Home/setDefaultLocationPost',
    'Home/bankTransferPaymentReportPost',
    //Language
    'Language/editLanguagePost',
    'Language/setDefaultLanguagePost',
    'Language/exportLanguagePost',
    'Language/deleteLanguagePost',
    'Language/addLanguagePost',
    'Language/importLanguagePost',
    'Language/editTranslationsPost',
    //Membership
    'Membership/addRolePost',
    'Membership/addUserPost',
    'Membership/editPlanPost',
    'Membership/editRolePost',
    'Membership/editUserPost',
    'Membership/addPlanPost',
    'Membership/settingsPost',
    'Membership/deletePlanPost',
    'Membership/deleteRolePost',
    'Membership/approveShopOpeningRequest',
    'Membership/deleteUserPost',
    'Membership/assignMembershipPlanPost',
    'Membership/changeUserRolePost',
    'Membership/confirmUserEmail',
    'Membership/banRemoveBanUser',
    'Membership/addDeleteUserAffiliateProgram',
    'Membership/loginToUserAccountPost',
    'Membership/rejectShopOpeningRequest',
    'Membership/cancelAccountDeleteRequestPost',
    //OrderAdmin
    'OrderAdmin/deleteDigitalSalePost',
    'OrderAdmin/approveGuestOrderProduct',
    'OrderAdmin/deleteOrderProductPost',
    'OrderAdmin/updateOrderProductStatusPost',
    'OrderAdmin/orderPaymentReceivedPost',
    'OrderAdmin/deleteOrderPost',
    'OrderAdmin/deleteTransactionPost',
    'OrderAdmin/approveRefundPost',
    //Order
    'Order/deleteQuoteRequest',
    'Order/addRefundMessage',
    'Order/cancelOrderPost',
    'Order/approveOrderProductPost',
    'Order/cancelOrderPost',
    'Order/deleteQuoteRequest',
    //Product
    'Product/deleteReviewPost',
    'Product/deleteCommentPost',
    'Product/deleteQuoteRequestPost',
    'Product/approveCommentPost',
    'Product/deleteCommentPost',
    'Product/deleteProductPermanently',
    'Product/deleteProduct',
    'Product/featuredProductsPricingPost',
    'Product/addRemoveFeaturedProduct',
    'Product/rejectProduct',
    'Product/approveProduct',
    'Product/deleteSelectedProducts',
    'Product/deleteSelectedProductsPermanently',
    'Product/addRemoveSpecialOffer',
    'Product/restoreProduct',
    'Product/deleteSelectedReviews',
    'Product/approveSelectedComments',
    'Product/deleteSelectedComments',
    'Product/approveSelectedEditedProducts',
    //Profile
    'Profile/deleteCoverImagePost',
    'Profile/deleteShippingAddressPost',
    'Profile/addFundsPost',
    'Profile/deleteAffiliateLinkPost',
    //SupportAdmin
    'SupportAdmin/addCategoryPost',
    'SupportAdmin/addContentPost',
    'SupportAdmin/editCategoryPost',
    'SupportAdmin/editContentPost',
    'SupportAdmin/deleteContentPost',
    'SupportAdmin/deleteCategoryPost',
    'SupportAdmin/sendMessagePost',
    'SupportAdmin/deleteTicketPost',
    'SupportAdmin/changeTicketStatusPost',
    'SupportAdmin/getCategoriesByLang',
    //Support
    'Support/downloadAttachmentPost',
    'Support/uploadSupportAttachment',
    'Support/deleteSupportAttachmentPost',
];

foreach ($postArray as $item) {
    $array = explode('/', $item);
    $routes->post($item, $array[0] . 'Controller::' . $array[1]);
}


