<?= $this->element('user/header') ?>
<div class="container mb-30px">
    <div class="row">
        <div class="col-md-12 text-center">
            <?php foreach ($getCategoryForId as $item) { ?>
                <h5 class="widget-title text-uppercase"><?= $item->name ?></h5>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="row blog_posts cardPostStyle">
                    <?php foreach ($survies as $survy) {
                    ?>
                        <div class="col-md-6 col-lg-6">
                            <article>
                                <div class="post_img">
                                    <img src="https://www.energeticthemes.com/templates/sada/images/home1/1.jpg" alt="Card image cap">
                                </div>
                                <div class="post_text">
                                    <div class="post_meta_top">
                                        <span class="post_meta_category">
                                            <a href="blog-standard-two-col-right-sidebar.html">FOOD, TRAVEL</a>
                                        </span>
                                        <span class="post_meta_date"><?= date_format($survy->created, 'F d-y') ?></span>
                                    </div>
                                    <h5 class="post_title">
                                        <a href="blog-single-post.html"><?= $survy->question ?>
                                        </a>
                                    </h5>
                                    <div class="post_content">
                                        <p><?= $survy->description ?> </p>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php } ?>
                </div>
                <nav class="pagination_holder">
                    <!-- <ul class="pagination">
                    <li class="page-item active">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span>
                                >
                            </span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul> -->
                    <ul class="pagination">
                        <?= $this->Paginator->prev("<<") ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(">>") ?>
                    </ul>
                </nav>
            </div>

            <div class="col-lg-4 mt-30px mt-lg-0">
                <div class="widget">
                    <form role="search" class="search-form dark-outline-form">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="q">
                            <div class="input-group-btn">
                                <button class="btn" type="submit">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="bg-color-grayflame widget pt-30px pb-30px px-30px">
                    <h5 class="widget-title">Categories</h5>
                    <ul class="category-list list-unstyled mb-0">
                        <?php foreach ($categories as $category) { ?>
                            <li>
                                <a href="/category/<?= $category->id ?>">
                                    <?= $category->name ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="widget bg-color-grayflame pt-30px pb-30px px-30px">
                    <h5 class="widget-title">Top Posts</h5>
                    <ul class="list-unstyled post-simple-list mb-0">
                        <?php
                        $i = 1;
                        foreach ($topposts as $toppost) { ?>
                            <li class="media">
                                <span class="reveal-title mr-25px"><?= $i++ ?></span>
                                <div class="media-body">
                                    <a href="blog-single-post.html" class="media-title"><?= $toppost->question ?></a>
                                    <div class="post_meta_top">
                                        <span class="post_meta_category">
                                            <a href="blog-standard-two-col-right-sidebar.html">FOOD, TRAVEL</a>
                                        </span>
                                        <span class="post_meta_date">NOV 13, 2020</span>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="widget">
                    <h5 class="widget-title">Instagram</h5>
                    <ul class="row xs-gallery-gutters m-0 list-unstyled" id="instagramfeed"></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="container mb-30px">
                <div class="row">
                    <div class="col-12">
                        <h4 class="mb-30px">Most Selling Items </h4>
                    </div>
                </div>
                <div class="row products align-items-center">
                    <div class="product col-md-6 col-lg-3">
                        <div class="product-img-wrapper">
                            <a href="shop-single-product.html">
                                <img width="480" height="536" src="https://www.energeticthemes.com/templates/sada/images/products/1.jpg" alt="Product image">
                            </a>
                            <a rel="nofollow" href="shop-single-product.html" class="btn btn-dark rounded-0 btn-add-to-cart">Add
                                to cart</a>
                        </div>
                        <div class="product-white-wrapper align-items-center">
                            <h6 class="product-title">
                                <a href="shop-single-product.html"> Quisque dignissim</a>
                            </h6>
                            <span class="price">
                                <span class="amount">
                                    <span class="currencySymbol">$</span>69.00</span>
                            </span>
                        </div>
                    </div>
                    <div class="product col-md-6 col-lg-3">
                        <div class="product-img-wrapper">
                            <a href="shop-single-product.html">
                                <img width="480" height="536" src="https://www.energeticthemes.com/templates/sada/images/products/2.jpg" alt="Product image">
                            </a>
                            <a rel="nofollow" href="shop-single-product.html" class="btn btn-dark rounded-0 btn-add-to-cart">Add
                                to cart</a>
                        </div>
                        <div class="product-white-wrapper align-items-center">
                            <h6 class="product-title">
                                <a href="shop-single-product.html"> Quisque dignissim</a>
                            </h6>
                            <span class="price">
                                <span class="amount">
                                    <span class="currencySymbol">$</span>69.00</span>
                            </span>
                        </div>
                    </div>
                    <div class="product col-md-6 col-lg-3">
                        <div class="product-img-wrapper">
                            <a href="shop-single-product.html">
                                <img width="480" height="536" src="https://www.energeticthemes.com/templates/sada/images/products/3.jpg" alt="Product image">
                            </a>
                            <a rel="nofollow" href="shop-single-product.html" class="btn btn-dark rounded-0 btn-add-to-cart">Add
                                to cart</a>
                        </div>
                        <div class="product-white-wrapper align-items-center">
                            <h6 class="product-title">
                                <a href="shop-single-product.html"> Quisque dignissim</a>
                            </h6>
                            <span class="price">
                                <span class="amount">
                                    <span class="currencySymbol">$</span>69.00</span>
                            </span>
                        </div>
                    </div>
                    <div class="product col-md-6 col-lg-3">
                        <div class="product-img-wrapper">
                            <a href="shop-single-product.html">
                                <img width="480" height="536" src="https://www.energeticthemes.com/templates/sada/images/products/4.jpg" alt="Product image">
                            </a>
                            <a rel="nofollow" href="shop-single-product.html" class="btn btn-dark rounded-0 btn-add-to-cart">Add
                                to cart</a>
                        </div>
                        <div class="product-white-wrapper align-items-center">
                            <h6 class="product-title">
                                <a href="shop-single-product.html"> Quisque dignissim</a>
                            </h6>
                            <span class="price">
                                <span class="amount">
                                    <span class="currencySymbol">$</span>69.00</span>
                            </span>
                        </div>
                    </div>
                    <div class="product col-md-6 col-lg-3">
                        <div class="product-img-wrapper">
                            <a href="shop-single-product.html">
                                <img width="480" height="536" src="https://www.energeticthemes.com/templates/sada/images/products/5.jpg" alt="Product image">
                            </a>
                            <a rel="nofollow" href="shop-single-product.html" class="btn btn-dark rounded-0 btn-add-to-cart">Add
                                to cart</a>
                        </div>
                        <div class="product-white-wrapper align-items-center">
                            <h6 class="product-title">
                                <a href="shop-single-product.html"> Quisque dignissim</a>
                            </h6>
                            <span class="price">
                                <span class="amount">
                                    <span class="currencySymbol">$</span>69.00</span>
                            </span>
                        </div>
                    </div>
                    <div class="product col-md-6 col-lg-3">
                        <div class="product-img-wrapper">
                            <a href="shop-single-product.html">
                                <img width="480" height="536" src="https://www.energeticthemes.com/templates/sada/images/products/6.jpg" alt="Product image">
                            </a>
                            <a rel="nofollow" href="shop-single-product.html" class="btn btn-dark rounded-0 btn-add-to-cart">Add
                                to cart</a>
                        </div>
                        <div class="product-white-wrapper align-items-center">
                            <h6 class="product-title">
                                <a href="shop-single-product.html"> Quisque dignissim</a>
                            </h6>
                            <span class="price">
                                <span class="amount">
                                    <span class="currencySymbol">$</span>69.00</span>
                            </span>
                        </div>
                    </div>
                    <div class="product col-md-6 col-lg-3">
                        <div class="product-img-wrapper">
                            <a href="shop-single-product.html">
                                <img width="480" height="536" src="https://www.energeticthemes.com/templates/sada/images/products/12.jpg" alt="Product image">
                            </a>
                            <a rel="nofollow" href="shop-single-product.html" class="btn btn-dark rounded-0 btn-add-to-cart">Add
                                to cart</a>
                        </div>
                        <div class="product-white-wrapper align-items-center">
                            <h6 class="product-title">
                                <a href="shop-single-product.html"> Quisque dignissim</a>
                            </h6>
                            <span class="price">
                                <span class="amount">
                                    <span class="currencySymbol">$</span>69.00</span>
                            </span>
                        </div>
                    </div>
                    <div class="product col-md-6 col-lg-3">
                        <div class="product-img-wrapper">
                            <a href="shop-single-product.html">
                                <img width="480" height="536" src="https://www.energeticthemes.com/templates/sada/images/products/13.jpg" alt="Product image">
                            </a>
                            <a rel="nofollow" href="shop-single-product.html" class="btn btn-dark rounded-0 btn-add-to-cart">Add
                                to cart</a>
                        </div>
                        <div class="product-white-wrapper align-items-center">
                            <h6 class="product-title">
                                <a href="shop-single-product.html"> Quisque dignissim</a>
                            </h6>
                            <span class="price">
                                <span class="amount">
                                    <span class="currencySymbol">$</span>69.00</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div> -->

    <div class="container mb-30px">
        <div class="row">
            <div class="col-lg-6 mb-30px">
                <div class="bg-color-gray-shade-radius px-40px py-60px">
                    <h3>Subscribe and Stay
                        <br>Informed
                    </h3>
                    <p>Oratio pertinax cu vix, id his aliquam habemus tractatos. Eu vis cursus modo officiis
                        liberavisse,
                        persequeris complectitur mei et. Id invidunt adipiscing cursus has.</p>
                    <div class="form-group form-row  mb-0">
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control rounded-50 validate-required validate-email" placeholder="Your email">
                            <div class="input-group-append">
                                <button type="submit" class="btn rounded-50 form-custom-btn">Subscribe</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-30px">
                <div class="bg-img-3 px-40px py-35px">
                    <div class="white-box-square">
                        <div class="all-text-content-white text-center py-110px">
                            <h1>Oratio petinax cu vix</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->element('user/footer') ?>