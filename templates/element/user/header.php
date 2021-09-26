<?php
$this->disableAutoLayout();
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="https://www.energeticthemes.com/templates/sada/images/favicon.ico">

    <title>Sada - A HTML Template For Blog & Shop </title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700" rel="stylesheet">

    <!-- <link href="https://www.energeticthemes.com/templates/sada/css/all-fontawesome.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <link href="https://www.energeticthemes.com/templates/sada/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://www.energeticthemes.com/templates/sada/css/plugins/owl.carousel.min.css" rel="stylesheet">
    <link href="https://www.energeticthemes.com/templates/sada/css/plugins/magnific-popup.css" rel="stylesheet">
    <link href="https://www.energeticthemes.com/templates/sada/css/plugins/aos.css" rel="stylesheet">
    <link href="https://www.energeticthemes.com/templates/sada/css/plugins/spacing-and-height.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://www.energeticthemes.com/templates/sada/css/theme-modules.css" rel="stylesheet">
    <style>
        .dropdown-toggle::after {
            content: '' !important;
        }
    </style>
</head>

<body>
    <div id="main-content" class="bg-color-gray">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid mx-0 mx-md-20px mx-lg-60px">
                <a class="navbar-brand" href="/">
                    <img class="etcodes-normal-logo" src="https://www.energeticthemes.com/templates/sada/images/logo.png" width="84" height="22" alt="Logo">
                    <img class="etcodes-mobile-logo" src="https://www.energeticthemes.com/templates/sada/images/logo.png" width="84" height="22" alt="Logo">
                </a>
                <button class="navbar-toggler hamburger-menu-btn" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span>toggle menu</span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link" aria-haspopup="true" aria-expanded="false"><i style="font-size: 30px;" class="fa fa-user-circle"></i></a>
                            <div class="dropdown-menu float-left" aria-labelledby="navbarDropdownMenuLinkShop">
                                <?php if (isset($_SESSION['email'])) { ?>
                                    <a href="#" class="dropdown-item">Xin chào : <?php if (isset($_SESSION['email'])) {
                                                                                        echo $_SESSION['email'];
                                                                                    }; ?></a>
                                    <a href="/Auth/change" class="dropdown-item">Change Info</a>
                                    <a class="dropdown-item" href="/Auth/logout">Log out</a>
                                <?php } else { ?>
                                    <a href="/Auth/login" class="dropdown-item">Log In</a>
                                <?php } ?>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLinkHome" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Home</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLinkShop">
                                <a class="dropdown-item" href="index.html">1 - Home</a>
                                <a class="dropdown-item" href="home-2.html">2 - Home</a>
                            </div>
                        </li>

                        <!-- <li class="nav-item dropdown mega_menu_holder">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Blog</a>
                            <ul class="dropdown-menu mega_menu">
                                <li class="nav-item">
                                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">Blog Style Stander</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="blog-standard-right-sidebar.html">Standard
                                                Blog with Right Sidebar</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="blog-standard-left-sidebar.html">Standard
                                                Blog with Left Sidebar</a>
                                        </li>
                                        <li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">Blog Style</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="blog-card-right-sidebar.html">Card Blog with
                                                Right Sidebar</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="blog-card-left-sidebar.html">Card Blog with
                                                Left Sidebar</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="blog-card-three-col.html">Card Blog Three
                                                Col
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="blog-card-two-col-right-sidebar.html">Card
                                                Blog with two col Right Sidebar</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="blog-card-two-col-left-sidebar.html">Card
                                                Blog with two col Left Sidebar</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">Single Blog Style</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="blog-single-post.html">Single Blog</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="blog-post-single-gallery.html">Gallary Blog
                                                Post
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="blog-post-single-video.html">Video Blog Post</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="blog-post-single-audio.html">Audio Blog Post</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLinkShop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Shop</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLinkShop">
                                <a class="dropdown-item" href="shop-right-sidebar.html">Shop Right Sidebar</a>
                                <a class="dropdown-item" href="shop-left-sidebar.html">Shop Left Sidebar</a>
                                <a class="dropdown-item" href="shop-full-width.html">Shop Full Width</a>
                                <a class="dropdown-item" href="shop-single-product.html">Shop Single Product</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown mega_menu_holder">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Elements</a>
                            <ul class="dropdown-menu mega_menu">
                                <li class="nav-item">
                                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">Typography</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="elements-accordions.html">Accordions</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-banner.html">Banner</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-blockquote.html">Blockquote</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-call-to-action.html">Call To Action</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-typography.html">Typography</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-dropcaps.html">Dropcaps</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-highlights.html">Highlights</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">Basic Elements</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="elements-buttons.html">Buttons</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-columns.html">Columns</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-contact-form.html">Contact Form</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-google-maps.html">Google Maps</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-lists.html">Lists</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-tables.html">Tables</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-tabs.html">Tabs</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-galleries.html">Galleries</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">Content</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="elements-clients.html">Clients</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-icon-content-box.html">Icon Content
                                                Box
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-image-content-box.html">Image
                                                Content Box
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-numbered-process.html">Numbered
                                                Process</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-pricing-table.html">Pricing Table</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-slider.html">Slider</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-social-icons.html">Social Icons</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">Infographic</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="elements-counters.html">Counters</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-countdown.html">Countdown</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-progress-bar.html">Progress Bar</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-team.html">Team</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="elements-testimonials.html">Testimonials</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown mega_menu_holder">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Features</a> 
                            <ul class="dropdown-menu mega_menu">
                                <li class="nav-item">
                                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">Header Styles</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="feature-header-transparent.html">Transparent
                                                header
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-header-white.html">White header</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-header-dark.html">Dark header</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-header-with-top-bar.html">Header
                                                with top bar</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-header-with-push.html">Header with
                                                push
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-header-center-navigation.html">Center
                                                navigation
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-header-center-logo.html">Center logo</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-header-top-logo.html">Top logo</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-header-one-page-navigation.html">One
                                                page navigation</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-header-hamburger-menu.html">Hamburger
                                                menu
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-header-hamburger-menu-center-logo.html">Hamburger
                                                Center logo</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-header-sidebar-menu.html">Sidebar
                                                Menu
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">Footer</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="feature-footer-standard.html">Footer
                                                standard</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-footer-standard-dark.html">Footer
                                                standard dark</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-footer-standard-2.html">Footer
                                                standard 2
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-footer-strip.html">Footer strip</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-footer-strip-dark.html">Footer strip
                                                dark
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-footer-center.html">Footer center</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-footer-center-logo.html">Footer
                                                center logo
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-footer-center-logo-dark.html">Footer
                                                center logo dark</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-footer-modern.html">Footer modern
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-footer-modern-dark.html">Footer
                                                modern dark </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">Others</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="feature-page-title-left.html">Page Title
                                                Left alignment
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-page-title-right.html">Page Title
                                                Right alignment
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-page-title-center.html">Page Title
                                                Center alignment
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="feature-page-title-bg-img.html">Page Title
                                                BG Image</a>
                                        </li>
                                        <li class="dropdown-divider m-3"></li>
                                        <li>
                                            <a class="dropdown-item" href="elements-animation.html">Animation</a>
                                        </li>
                                    </ul>
                                </li> -->
                    </ul>
                    </li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="page-container scene-main scene-main--fade_In">

            <!-- <div class="fluid-container mx-15px mx-md-30px mx-lg-60px mb-30px mb-lg-60px">
                <div class="zero-one-carousel-container">
                    <div id="zero-one-carousel" class="owl-carousel default-owl-carousel">
                        <div class="owl-carousel-item" data-hash="zero">
                            <div class="bg-image">
                                <img src="https://www.energeticthemes.com/templates/sada/images/home1/s1.jpg" alt="Picture">
                            </div>
                            <div class="owl-carousel-item-content">
                                <div class="blog-carousel-content">
                                    <h4 class="blog-carousel-content-title"><a href="blog-single-post.html">Aenean
                                            mattis tortor ac sapien turpe congue molestie.</a></h4>
                                    <P>
                                        Oratio pertinax cu vix, id his aliquam habemus tractatos. Eu vis cursus modo
                                        officiis liberavisse, persequeris complectitur
                                        mei et. Id invidunt adipiscing cursus has.
                                    </P>
                                    <a href="blog-single-post.html" class="btn btn-dark-purple"> Read More
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="owl-carousel-item" data-hash="one">
                            <div class="bg-image">
                                <img src="https://www.energeticthemes.com/templates/sada/images/home1/s2.jpg" alt="Picture">
                            </div>
                            <div class="owl-carousel-item-content">
                                <div class="blog-carousel-content">
                                    <h4 class="blog-carousel-content-title"><a href="blog-single-post.html">Aenean
                                            mattis tortor ac sapien turpe congue molestie.</a></h4>
                                    <P>
                                        Oratio pertinax cu vix, id his aliquam habemus tractatos. Eu vis cursus modo
                                        officiis liberavisse, persequeris complectitur
                                        mei et. Id invidunt adipiscing cursus has.
                                    </P>
                                    <a href="blog-single-post.html" class="btn btn-dark-purple"> Read More
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="owl-carousel-item" data-hash="two">
                            <div class="bg-image">
                                <img src="https://www.energeticthemes.com/templates/sada/images/home2/4.jpg" alt="Picture">
                            </div>
                            <div class="owl-carousel-item-content">
                                <div class="blog-carousel-content">
                                    <h4 class="blog-carousel-content-title"><a href="blog-single-post.html">Aenean
                                            mattis tortor ac sapien turpe congue molestie.</a></h4>
                                    <P>
                                        Oratio pertinax cu vix, id his aliquam habemus tractatos. Eu vis cursus modo
                                        officiis liberavisse, persequeris complectitur
                                        mei et. Id invidunt adipiscing cursus has.
                                    </P>
                                    <a href="blog-single-post.html" class="btn btn-dark-purple"> Read More
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="owl-carousel-item" data-hash="three">
                            <div class="bg-image">
                                <img src="https://www.energeticthemes.com/templates/sada/images/home1/s3.jpg" alt="Picture">
                            </div>
                            <div class="owl-carousel-item-content">
                                <div class="blog-carousel-content">
                                    <h4 class="blog-carousel-content-title"><a href="blog-single-post.html">Aenean
                                            mattis tortor ac sapien turpe congue molestie.</a></h4>
                                    <P>
                                        Oratio pertinax cu vix, id his aliquam habemus tractatos. Eu vis cursus modo
                                        officiis liberavisse, persequeris complectitur
                                        mei et. Id invidunt adipiscing cursus has.
                                    </P>
                                    <a href="blog-single-post.html" class="btn btn-dark-purple"> Read More
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="owl-carousel-item" data-hash="four">
                            <div class="bg-image">
                                <img src="https://www.energeticthemes.com/templates/sada/images/home1/s4.jpg" alt="Picture">
                            </div>
                            <div class="owl-carousel-item-content">
                                <div class="blog-carousel-content">
                                    <h4 class="blog-carousel-content-title"><a href="blog-single-post.html">Aenean
                                            mattis tortor ac sapien turpe congue molestie.</a></h4>
                                    <P>
                                        Oratio pertinax cu vix, id his aliquam habemus tractatos. Eu vis cursus modo
                                        officiis liberavisse, persequeris complectitur
                                        mei et. Id invidunt adipiscing cursus has.
                                    </P>
                                    <a href="blog-single-post.html" class="btn btn-dark-purple"> Read More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="zero-one-carousel-nav">
                        <li>
                            <h4 class="carousel-nav-title"><a class="active" href="#zero">Aenean mattis tortor ac
                                    sapien turpe congue molestie.</a></h4>
                            <div class="post_meta_top">
                                <span class="post_meta_category">
                                    <a href="blog-standard-two-col-right-sidebar.html">TRAVEL</a>
                                </span>
                                <span class="post_meta_date">NOV 13, 2020</span>
                            </div>
                        </li>
                        <li>
                            <h4 class="carousel-nav-title"><a href="#one">Vestibulum ante ipsum primis in urna orci
                                    faucibus luctus. </a></h4>
                            <div class="post_meta_top">
                                <span class="post_meta_category">
                                    <a href="blog-standard-two-col-right-sidebar.html">PHOTOGRAPHY</a>
                                </span>
                                <span class="post_meta_date">NOV 13, 2020</span>
                            </div>
                        </li>
                        <li>
                            <h4 class="carousel-nav-title"><a class="carousel-nav-title" href="#two">Sapien etiam eu
                                    odio inposuere vite bibendum vitae lorem.</a></h4>
                            <div class="post_meta_top">
                                <span class="post_meta_category">
                                    <a href="blog-standard-two-col-right-sidebar.html">FOOD, TRAVEL</a>
                                </span>
                                <span class="post_meta_date">NOV 13, 2020</span>
                            </div>
                        </li>
                        <li>
                            <h4 class="carousel-nav-title"><a class="carousel-nav-title" href="#three">Etiam eu odio in
                                    sapien posuere dole vitae bibendum vitae lorem.</a></h4>
                            <div class="post_meta_top">
                                <span class="post_meta_category">
                                    <a href="blog-standard-two-col-right-sidebar.html">CULTURE, ART</a>
                                </span>
                                <span class="post_meta_date">NOV 13, 2020</span>
                            </div>
                        </li>
                        <li>
                            <h4 class="carousel-nav-title"><a class="carousel-nav-title" href="#four">Morbi eget leo a
                                    tellusv gravida ane sagittis nec nec felis.</a></h4>
                            <div class="post_meta_top">
                                <span class="post_meta_category">
                                    <a href="blog-standard-two-col-right-sidebar.html">TRAVEL</a>
                                </span>
                                <span class="post_meta_date">NOV 13, 2020</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div> -->