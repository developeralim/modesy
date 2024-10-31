<!DOCTYPE html>
<html lang="<?= $activeLang->short_form; ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title><?= escSls($title); ?> - <?= escSls($baseSettings->site_title); ?></title>
<meta name="description" content="<?= escSls($description); ?>"/>
<meta name="keywords" content="<?= escSls($keywords); ?>"/>
<meta name="author" content="<?= escSls($generalSettings->application_name); ?>"/>
<link rel="shortcut icon" type="image/png" href="<?= getFavicon(); ?>"/>
<meta property="og:locale" content="<?= escSls($activeLang->language_code); ?>"/>
<meta property="og:site_name" content="<?= escSls($generalSettings->application_name); ?>"/>
<?php if (isset($showOgTags)): ?>
<meta property="og:type" content="<?= !empty($ogType) ? escSls($ogType) : 'website'; ?>"/>
<meta property="og:title" content="<?= !empty($ogTitle) ? escSls($ogTitle) : 'index'; ?>"/>
<meta property="og:description" content="<?= escSls($ogDescription); ?>"/>
<meta property="og:url" content="<?= escSls($ogUrl); ?>"/>
<meta property="og:image" content="<?= escSls($ogImage); ?>"/>
<meta property="og:image:width" content="<?= !empty($ogWidth) ? $ogWidth : 250; ?>"/>
<meta property="og:image:height" content="<?= !empty($ogHeight) ? $ogHeight : 250; ?>"/>
<meta property="article:author" content="<?= !empty($ogAuthor) ? escSls($ogAuthor) : ''; ?>"/>
<meta property="fb:app_id" content="<?= escSls($generalSettings->facebook_app_id); ?>"/>
<?php if (!empty($ogTags)):foreach ($ogTags as $tag): ?>
<meta property="article:tag" content="<?= escSls($tag->tag); ?>"/>
<?php endforeach; endif; ?>
<meta property="article:published_time" content="<?= !empty($ogPublishedTime) ? $ogPublishedTime : ''; ?>"/>
<meta property="article:modified_time" content="<?= !empty($ogModifiedTime) ? $ogModifiedTime : ''; ?>"/>
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:site" content="@<?= escSls($generalSettings->application_name); ?>"/>
<meta name="twitter:creator" content="@<?= escSls($ogCreator); ?>"/>
<meta name="twitter:title" content="<?= escSls($ogTitle); ?>"/>
<meta name="twitter:description" content="<?= escSls($ogDescription); ?>"/>
<meta name="twitter:image" content="<?= escSls($ogImage); ?>"/>
<?php else: ?>
<meta property="og:image" content="<?= getLogo(); ?>"/>
<meta property="og:image:width" content="<?= $baseVars->logoWidth; ?>"/>
<meta property="og:image:height" content="<?= $baseVars->logoHeight; ?>"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="<?= escSls($title); ?> - <?= escSls($baseSettings->site_title); ?>"/>
<meta property="og:description" content="<?= escSls($description); ?>"/>
<meta property="og:url" content="<?= base_url(); ?>"/>
<meta property="fb:app_id" content="<?= escSls($generalSettings->facebook_app_id); ?>"/>
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:site" content="@<?= escSls($generalSettings->application_name); ?>"/>
<meta name="twitter:title" content="<?= escSls($title); ?> - <?= escSls($baseSettings->site_title); ?>"/>
<meta name="twitter:description" content="<?= escSls($description); ?>"/>
<?php endif;
if ($generalSettings->pwa_status == 1): ?>
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="<?= escSls($generalSettings->application_name); ?>">
<meta name="msapplication-TileImage" content="<?= base_url(getPwaLogo($generalSettings, 'sm')); ?>">
<meta name="msapplication-TileColor" content="#2F3BA2">
<link rel="manifest" href="<?= base_url('manifest.json'); ?>">
<link rel="apple-touch-icon" href="<?= base_url(getPwaLogo($generalSettings, 'sm')); ?>">
<?php endif; ?>
<link rel="canonical" href="<?= escSls(base_url(uri_string())); ?>"/>
<link rel="alternate" href="<?= getCurrentUrl(); ?>" hreflang="<?= $activeLang->language_code; ?>"/>
<?= csrf_meta(); ?>

<?= view('partials/_fonts'); ?>
<link rel="stylesheet" href="<?= base_url('assets/css/style-2.5.min.css'); ?>"/>
<link rel="stylesheet" href="<?= base_url('assets/css/plugins-2.5.css'); ?>"/>
<?= view('partials/_css_js_header');
if ($baseVars->rtl == true): ?>
<link rel="stylesheet" href="<?= base_url('assets/css/rtl-2.5.min.css'); ?>">
<?php endif; ?>
<?= $generalSettings->google_adsense_code; ?>
<?= $generalSettings->custom_header_codes; ?>
</head>
<body>
<header id="header">
<?= view('partials/_top_bar'); ?>
<div class="main-menu">
<div class="container-fluid">
<div class="row">
<div class="nav-top">
<div class="container">
<div class="row align-items-center">
<div class="col-md-7 nav-top-left">
<div class="row-align-items-center">
<div class="logo">
<a href="<?= langBaseUrl(); ?>"><img src="<?= getLogo(); ?>" alt="logo" width="<?= $baseVars->logoWidth; ?>" height="<?= $baseVars->logoHeight; ?>"></a>
</div>
<div class="top-search-bar">
<form action="<?= generateUrl('products'); ?>" method="get" id="form_validate_search" class="form_search_main">
<input type="text" name="search" maxlength="300" pattern=".*\S+.*" id="input_search_main" class="form-control input-search" placeholder="<?= trans("search_products_categories_brands"); ?>" required autocomplete="off">
<button class="btn btn-default btn-search" aria-label="search"><i class="icon-search"></i></button>
<div id="response_search_results" class="search-results-ajax mds-scrollbar"></div>
</form>
</div>
</div>
</div>
<div class="col-md-5 nav-top-right">
<ul class="nav align-items-center">
<?php if (isSaleActive()): ?>
<li class="nav-item nav-item-cart li-main-nav-right">
<a href="<?= generateUrl('cart'); ?>">
<i class="icon-cart"></i>
<span class="label-nav-icon"><?= trans("cart"); ?></span>
<?php $cartProductCount = getCartProductCount(); ?>
<span class="notification span_cart_product_count <?= $cartProductCount <= 0 ? 'visibility-hidden' : ''; ?>"><?= $cartProductCount; ?></span>
</a>
</li>
<?php endif; ?>
<li class="nav-item li-main-nav-right"><a href="<?= generateUrl('wishlist'); ?>"><i class="icon-heart-o"></i><span class="label-nav-icon"><?= trans("wishlist"); ?></span></a></li>
<?php if (authCheck()): ?>
<?php if ($generalSettings->multi_vendor_system == 1): ?>
<li class="nav-item m-r-0"><a href="<?= generateDashUrl("add_product"); ?>" class="btn btn-md btn-custom btn-sell-now m-r-0"><?= trans("sell_now"); ?></a></li>
<?php endif;
else: ?>
<?php if ($generalSettings->multi_vendor_system == 1): ?>
<li class="nav-item m-r-0">
<button type="button" class="btn btn-md btn-custom btn-sell-now m-r-0" data-toggle="modal" data-target="#loginModal" aria-label="sell-now"><?= trans("sell_now"); ?></button>
</li>
<?php endif;
endif; ?>
</ul>
</div>
</div>
</div>
</div>
<div class="nav-main">
<?= view("partials/_nav_main"); ?>
</div>
</div>
</div>
</div>
<div class="mobile-nav-container">
<div class="nav-mobile-header">
<div class="container-fluid">
<div class="row">
<div class="nav-mobile-header-container">
<div class="d-flex justify-content-between">
<div class="flex-item flex-item-left item-menu-icon justify-content-start">
<button type="button" class="btn-open-mobile-nav button-link" aria-label="open-mobile-menu"><i class="icon-menu"></i></button>
</div>
<div class="flex-item flex-item-mid justify-content-center">
<div class="mobile-logo">
<a href="<?= langBaseUrl(); ?>" class="logo"><img src="<?= getLogo(); ?>" alt="logo" width="<?= $baseVars->logoWidth; ?>" height="<?= $baseVars->logoHeight; ?>"></a>
</div>
</div>
<div class="flex-item flex-item-right justify-content-end">
<button type="button" class="button-link a-search-icon" aria-label="button-mobile-search-icon"><i id="searchIconMobile" class="icon-search"></i></button>
<?php if (isSaleActive()): ?>
<a href="<?= generateUrl('cart'); ?>" class="a-mobile-cart"><i class="icon-cart"></i><span class="notification span_cart_product_count"><?= getCartProductCount(); ?></span></a>
<?php endif; ?>
</div>
</div>
</div>
</div>
<div class="row">
<div class="top-search-bar mobile-search-form">
<form action="<?= generateUrl('products'); ?>" method="get">
<input type="text" id="input_search_mobile" name="search" maxlength="300" pattern=".*\S+.*" class="form-control input-search" placeholder="<?= trans("search_products_categories_brands"); ?>" required autocomplete="off">
<button class="btn btn-default btn-search"><i class="icon-search"></i></button>
<div id="response_search_results_mobile" class="search-results-ajax mds-scrollbar"></div>
</form>
</div>
</div>
</div>
</div>
</div>
</header>
<div id="overlay_bg" class="overlay-bg"></div>
<?= view("partials/_nav_mobile"); ?>
<input type="hidden" class="search_type_input" name="search_type" value="product">
<?php if (!authCheck()): ?>
<div class="modal fade" id="loginModal" role="dialog">
<div class="modal-dialog modal-dialog-centered login-modal" role="document">
<div class="modal-content">
<div class="auth-box">
<button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
<div class="title"><?= trans("login"); ?></div>
<form id="form_login" novalidate="novalidate">
<div class="social-login">
<?= view('auth/_social_login', ["orText" => trans("login_with_email")]); ?>
</div>
<div id="result-login" class="font-size-13"></div>
<div id="confirmation-result-login" class="font-size-13"></div>
<div class="form-group">
<input type="email" name="email" class="form-control auth-form-input" placeholder="<?= trans("email_address"); ?>" maxlength="255" required>
</div>
<div class="form-group">
<input type="password" name="password" class="form-control auth-form-input" placeholder="<?= trans("password"); ?>" minlength="4" maxlength="255" required>
</div>
<div class="form-group text-right">
<a href="<?= generateUrl("forgot_password"); ?>" class="link-forgot-password"><?= trans("forgot_password"); ?></a>
</div>
<div class="form-group">
<button type="submit" class="btn btn-md btn-custom btn-block"><?= trans("login"); ?></button>
</div>
<p class="p-social-media m-0 m-t-5"><?= trans("dont_have_account"); ?>&nbsp;<a href="<?= generateUrl("register"); ?>" class="link font-600"><?= trans("register"); ?></a></p>
</form>
</div>
</div>
</div>
</div>
<?php endif;
if ($generalSettings->location_search_header == 1): ?>
<div class="modal fade" id="locationModal" role="dialog">
<div class="modal-dialog modal-dialog-centered login-modal location-modal" role="document">
<div class="modal-content">
<div class="auth-box">
<button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
<div class="title"><?= trans("select_location"); ?></div>
<p class="location-modal-description"><?= trans("filter_products_location"); ?></p>
<form action="<?= base_url('Home/setDefaultLocationPost'); ?>" method="post">
<?= csrf_field(); ?>
<input type="hidden" name="form_type">
<div class="form-group m-b-20">
<?php $defaultCountryId = $generalSettings->single_country_mode == 1 ? $generalSettings->single_country_id : $baseVars->defaultLocation->country_id;
$filterStates = !empty($defaultCountryId) ? getStatesByCountry($defaultCountryId) : array();
$filterCities = !empty($baseVars->defaultLocation->state_id) ? getCitiesByState($baseVars->defaultLocation->state_id) : array(); ?>
<?php if ($generalSettings->single_country_mode != 1): ?>
<div class="m-b-5">
<select id="select_countries_filter" name="country_id" class="select2 form-control" onchange="getStates(this.value, 'filter');">
<option value=""><?= trans('country'); ?></option>
<?php if (!empty($activeCountries)):
foreach ($activeCountries as $item): ?>
<option value="<?= $item->id; ?>" <?= $item->id == $baseVars->defaultLocation->country_id ? 'selected' : ''; ?>><?= esc($item->name); ?></option>
<?php endforeach;
endif; ?>
</select>
</div>
<?php else: ?>
<input type="hidden" name="country_id" value="<?= $generalSettings->single_country_id; ?>">
<?php endif; ?>
<div id="get_states_container_filter" class="m-b-5 <?= !empty($filterStates) ? '' : 'display-none'; ?>">
<select id="select_states_filter" name="state_id" class="select2 form-control" onchange="getCities(this.value, 'filter');">
<option value=""><?= trans('state'); ?></option>
<?php if (!empty($filterStates)):
foreach ($filterStates as $item): ?>
<option value="<?= $item->id; ?>" <?= $item->id == $baseVars->defaultLocation->state_id ? 'selected' : ''; ?>><?= esc($item->name); ?></option>
<?php endforeach;
endif; ?>
</select>
</div>
<div id="get_cities_container_filter" class="m-b-5 <?= empty($filterCities) ? 'display-none' : ''; ?>">
<select id="select_cities_filter" name="city_id" class="select2 form-control">
<option value=""><?= trans('city'); ?></option>
<?php if (!empty($filterCities)):
foreach ($filterCities as $item):?>
<option value="<?= $item->id; ?>" <?= $item->id == $baseVars->defaultLocation->city_id ? 'selected' : ''; ?>><?= esc($item->name); ?></option>
<?php endforeach;
endif; ?>
</select>
</div>
</div>
<div class="form-group">
<button type="submit" name="submit" value="set" class="btn btn-md btn-custom btn-block"><?= trans("select_location"); ?></button>
</div>
</form>
</div>
</div>
</div>
</div>
<?php endif;
if ($generalSettings->newsletter_status == 1 && $generalSettings->newsletter_popup == 1): ?>
<div id="modal_newsletter" class="modal fade modal-center modal-newsletter" role="dialog">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-body">
<div class="row">
<div class="col-6 col-left">
<img src="<?= !empty($generalSettings->newsletter_image) ? base_url($generalSettings->newsletter_image) : base_url('assets/img/newsletter_bg.jpg'); ?>" alt="<?= trans("newsletter") ?>" class="newsletter-img" width="394" height="394">
</div>
<div class="col-6 col-right">
<div class="newsletter-form-container">
<button type="button" class="close modal-close-rounded" data-dismiss="modal"><i class="icon-close"></i></button>
<div class="newsletter-form">
<div class="modal-title"><?= trans("join_newsletter"); ?></div>
<p class="modal-desc"><?= trans("newsletter_desc"); ?></p>
<form id="form_newsletter_modal" class="form-newsletter" data-form-type="modal">
<div class="form-group">
<div class="modal-newsletter-inputs">
<input type="email" name="email" class="form-control form-input newsletter-input" placeholder="<?= trans('enter_email') ?>">
<button type="submit" class="btn"><?= trans("subscribe"); ?></button>
</div>
</div>
<input type="text" name="url">
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php endif; ?>
<div id="modalAddToCart" class="modal fade modal-product-cart" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<strong class="font-600 text-success" style="font-size: 16px;"> <i class="icon-check"></i>&nbsp;<?= trans("product_added_to_cart"); ?></strong>
<button type="button" class="close modal-close-rounded" data-dismiss="modal"><i class="icon-close"></i></button>
</div>
<div id="contentModalCartProduct" class="modal-body"></div>
</div>
</div>
</div>