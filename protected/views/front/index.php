
<!--
<div class="banner">
    <div class="col-md-8 border col">
        <div class="inner border">

            <h1><?php echo t("Simple, Powerful & Highly Flexible way to")?> <span><?php echo t("manage your company")?>.</span></h1>

            <p><?php echo t("Ditch the lengthy message threads, disruptive calls, out of place spreadsheets and clunky software to run your operations")?>. <?php echo FrontFunctions::getCompanyName()?> <?php echo t("lets you take back the control and allows you to focus on growing your business")?>.</p>

            <div class="line margin"></div>

            <h3><b><?php echo t("Only now")?>!</b> <?php echo t("Try")?> <?php echo FrontFunctions::getCompanyName()?> <?php echo t("free")?>:</h3>

            <form id="frm-trytrial" method="POST" onsubmit="return false;">
                <div class="row">
                    <div class="col-md-5 border">
                        <?php echo CHtml::textField('email_address','',array(
    'class'=>"rounded3",
    'placeholder'=>t("Your email address"),
    'required'=>true
));?>
                    </div>
                    <div class="col-md-5 border">
                        <button type="submit" class="rounded relative yellow-button large">
                            <?php echo t("SIGN UP FOR FREE")?>
                            <i class="ion-ios-arrow-thin-right"></i>
                        </button>
                    </div>
                </div>
            </form>

            <div class="line margin"></div>

            <h3><?php echo t("Available on")?>:</h3>

            <div class="available-wrap">
                <a href="#"><i class="ion-social-apple"></i></a>
                <a href="#"><i class="ion-social-android"></i></a>
            </div>


        </div>
    </div>
    <div class="col-md-4 border yellow-col col">
        <img class="phone" src="<?php echo Yii::app()->getBaseUrl(true)."/assets/images-front/phone.png";?>">
    </div>
</div>

<div class="sections section-1">

    <div class="container border">
        <div class="row">
            <div class="col-md-3 border">

                <div class="yellow-col relative">
                    <h2><?php echo t("What")?> <?php echo FrontFunctions::getCompanyName()?> <?php echo t("help you do")?>?</h2>
                    <div class="line margin dim"></div>
                </div>

            </div>
            <div class="col-md-9 border">

                <div class="row top150">
                    <div class="col-sm-4 border">
                        <img src="<?php echo Yii::app()->getBaseUrl(true)."/assets/images-front/logistic.png";?>">
                        <h4><?php echo t("Streamline the logistics")?></h4>
                        <div class="line margin"></div>
                        <p><?php echo t("An interactive map based interface lets you streamline your entire process from allocation you dispatch and from scheduling to tracking a delivery. It enables you locate your workforce on the map in real time")?>.</p>
                    </div>
                    <div class="col-sm-4 border">

                        <img src="<?php echo Yii::app()->getBaseUrl(true)."/assets/images-front/communicate.png";?>">
                        <h4><?php echo t("Communicate seamlessly")?></h4>
                        <div class="line margin"></div>
                        <p><?php echo FrontFunctions::getCompanyName()?> <?php echo t("comes with an integrated 2-way notification which can be used to serve and update your customers about their delivery at regular intervals and manage your mobileworkforce efficiently with instant updates")?>.</p>

                    </div>
                    <div class="col-sm-4 border">

                        <img src="<?php echo Yii::app()->getBaseUrl(true)."/assets/images-front/driven-decision.png";?>">
                        <h4><?php echo t("Take data driven decisions")?></h4>
                        <div class="line margin"></div>
                        <p><?php echo t("Analytics and graphical report feature available within the dashboard helps you monitor performance of the workforce. Data can be used for decision making to increase customer satisfaction and loyalty")?></p>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="sections section-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 border relative">

                <div class="inner border">
                    <h2><?php echo t("Watch")?> <?php echo FrontFunctions::getCompanyName()?> <?php echo t("in Action")?>!</h2>
                    <div class="line margin dim"></div>

                    <h1><?php echo t("Discover what");?><br/>
                        <?php echo FrontFunctions::getCompanyName()?> <?php echo t("can")?> <br/>
                        <?php echo t("do for your")?> <br/>
                        <?php echo t("business")?></h1>

                    <a href="<?php echo Yii::app()->createUrl('front/pricing')?>" class="brown-button large relative top30 rounded">
                        <?php echo t("SIGN UP FOR FREE")?>
                        <i class="ion-ios-arrow-thin-right"></i>
                    </a>

                    <div class="video-wrapper">
                        <img src="<?php echo Yii::app()->getBaseUrl(true)."/assets/images-front/macbook.png";?>">
                    </div>


                </div>


            </div>
            <div class="col-md-4 border brown-col relative">
                <img class="layer" src="<?php echo Yii::app()->getBaseUrl(true)."/assets/images-front/layer.png";?>">
            </div>
        </div>
    </div>
</div>

<div class="sections section-3">
    <div class="container border">
        <div class="row">
            <div class="col-md-4 border">
                <h2><?php echo t("Professionals & Businesses of All Types Use")?> <?php echo FrontFunctions::getCompanyName()?></h2>
                <div class="line margin white"></div>
            </div>
            <div class="col-md-8 border">
                <div class="row">
                    <div class="col-sm-4 border">
                        <h4><?php echo t("Pickup & Delivery")?></h4>
                        <div class="line margin"></div>

                        <ul>
                            <li>- <?php echo t("Courier Service")?></li>
                            <li>- <?php echo t("Laundry Service")?></li>
                            <li>- <?php echo t("Field Service")?></li>
                            <li>- <?php echo t("Grocery Delivery")?></li>
                            <li>- <?php echo t("Food Delivery")?></li>
                        </ul>

                    </div>
                    <div class="col-sm-4 border">

                        <h4><?php echo t("Beauty Services")?></h4>
                        <div class="line margin"></div>

                        <ul>
                            <li>- <?php echo t("Make Up Artist")?></li>
                            <li>- <?php echo t("Wedding Stylist")?></li>
                            <li>- <?php echo t("Manicurist")?></li>
                            <li>- <?php echo t("Hair Stylist")?></li>
                            <li>- <?php echo t("Aesthetician")?></li>
                        </ul>

                    </div>
                    <div class="col-sm-4 border">

                        <h4><?php echo t("Repair Services")?></h4>
                        <div class="line margin"></div>
                        <ul>
                            <li>- <?php echo t("Electrical Works")?></li>
                            <li>- <?php echo t("Computer Repair")?></li>
                            <li>- <?php echo t("Appliances Repair")?></li>
                            <li>- <?php echo t("Plumbing Repair")?></li>
                            <li>- <?php echo t("Auto Repair")?></li>
                        </ul>

                    </div>
                </div>

                <div class="row top20">
                    <div class="col-sm-4 border">
                        <h4><?php echo t("Home Services")?></h4>
                        <div class="line margin"></div>

                        <ul>
                            <li>- <?php echo t("Home Cleaning")?></li>
                            <li>- <?php echo t("Landscaping")?></li>
                            <li>- <?php echo t("Maid Service")?></li>
                            <li>- <?php echo t("Alarm & Security")?></li>
                            <li>- <?php echo t("Personal Organizer")?></li>
                        </ul>

                    </div>
                    <div class="col-sm-4 border">
                        <h4><?php echo t("Health and Well Being")?></h4>
                        <div class="line margin"></div>

                        <ul>
                            <li>- <?php echo t("Yoga Instructor")?></li>
                            <li>- <?php echo t("Personal Trainer")?></li>
                            <li>- <?php echo t("Family Physician")?></li>
                            <li>- <?php echo t("Alternative Healing")?></li>
                            <li>- <?php echo t("Massage Therapist")?></li>
                        </ul>

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<div class="sections section-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4 border">
                <h2><?php echo FrontFunctions::getCompanyName()?> <?php echo t("pricing")?></h2>
                <div class="line margin dim"></div>
            </div>
            <div class="col-md-8 border">
                <p class="top20"><?php echo t("No commitment, no hidden charges and no complications;")?> <?php echo t("simple and transparent pricing. Your business is")?>
                    <?php echo t("unique and our pricing structure is flexible. Let's get started")?></p>
            </div>
        </div>

        <div class="rowx pricing top20">


            <?php if (is_array($pricing) && count($pricing)>=1):?>
                <div class="row pricing top20">

                    <?php foreach ($pricing as $val):?>
                        <?php
    $price=$val['price']; $promo_price=0;
    if($val['promo_price']>0.0001){
        $price=$val['promo_price'];
        $promo_price=$val['promo_price'];
    }
    ?>
                        <div class="col-md-4 border">
                            <div class="box">
                                <h5><?php echo $val['plan_name']?></h5>

                                <div class="section">
                                    <?php if($final_price=FrontFunctions::formatPricing($price)):?>
                                        <?php echo $final_price?>
                                        <?php if ($promo_price>0):?>
                                            <p><?php echo t("Before")?> <span class="promo-price"><?php echo prettyPrice($val['price'])?></span></p>
                                        <?php endif;?>
                                    <?php else :?>
                                        <price>-</price>
                                    <?php endif;?>
                                    <p class="uppercase"><?php echo t("Membership Limit")?> <?php echo $val['expiration']?> <?php echo t($val['plan_type'])?> </p>

                                    <?php if(!empty($val['plan_name_description'])):?>
                                        <p class="plan_description readmore"><?php echo $val['plan_name_description']?></p>
                                    <?php endif;?>

                                </div>

                                <div class="section text-left">
                                    <ul>
                                        <li>- <?php echo t("Allowed")." ".t($val['allowed_driver'])." ".t("driver")?>.</li>
                                        <li>- <?php echo t("Allowed")." ".t($val['allowed_task'])." ".t("Task")?>.</li>
                                        <?php if ( $val['with_sms']==1):?>
                                            <li>- <?php echo t("With SMS Features")?></li>
                                        <?php else :?>
                                            <li>- <?php echo t("NO SMS Features")?></li>
                                        <?php endif;?>
                                    </ul>
                                </div>

                                <div class="action">
                                    <a href="<?php echo Yii::app()->createUrl('front/signup',array(
        'plan_id'=>$val['plan_id']
    ))?>" class="brown-button large relative top30 rounded">
                                        <?php echo t("START FREE TRIAL")?>
                                        <i class="ion-ios-arrow-thin-right"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    <?php endforeach;?>

                </div>
            <?php endif;?>


        </div>
    </div>

    <img src="<?php echo Yii::app()->getBaseUrl(true)."/assets/images-front/headphone.png";?>">

</div>
</div>

<div class="sections section-5">
</div>
-->
<!-- ******HEADER****** -->
<header id="header" class="header">
    <div class="container">
        <h1 class="logo">
            <a class="scrollto" href="<?php echo Yii::app()->createUrl('/front/index')?>#hero">
                <span class="logo-icon-wrapper"><img src="<?php echo FrontFunctions::getLogoURL();?>" alt="icon"></span>
            </a>
        </h1>
        <nav class="main-nav navbar-right" role="navigation">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="navbar-collapse" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active nav-item"><a class="scrollto" href="#about">About</a></li>
                    <li class="nav-item"><a class="scrollto" href="#testimonials">Testimonials</a></li>
                    <li class="nav-item"><a class="scrollto" href="#features">Features</a></li>
                    <li class="nav-item"><a class="scrollto" href="#team">Team</a></li>
                    <li class="nav-item"><a class="scrollto" href="#pricing">Pricing</a></li>
                    <li class="nav-item"><a class="scrollto" href="#contact">Contact</a></li>
                    <li class="nav-item"><a class="login" href="<?php echo Yii::app()->createUrl('/app')?>"><i class="ion-android-lock"></i> Log in</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<div id="hero" class="hero-section">

    <div id="hero-carousel" class="hero-carousel carousel carousel-fade slide" data-ride="carousel" data-interval="10000">

        <div class="figure-holder-wrapper">
            <div class="container">
                <div class="row">
                    <div class="figure-holder">
                        <img class="figure-image img-responsive" src="assets/images-front/macbook.png" alt="image" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li class="active" data-slide-to="0" data-target="#hero-carousel"></li>
            <li data-slide-to="1" data-target="#hero-carousel"></li>
            <li data-slide-to="2" data-target="#hero-carousel"></li>
            <li data-slide-to="3" data-target="#hero-carousel"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">

            <div class="item item-1 active">
                <div class="item-content container">
                    <div class="item-content-inner">

                        <h2 class="heading"><?php echo t("Simple, powerful & highly flexible way to manage")?><br class="hidden-xs"><?php echo t("your company")?>.</h2>
                        <p class="intro"><?php echo t("Ditch the lengthy message threads, disruptive calls, out of place spreadsheets and clunky software to run your operations")?>. <?php echo FrontFunctions::getCompanyName()?> <?php echo t("lets you take back the control and allows you to focus on growing your business")?>.</p>
                        <!--<a class="btn btn-primary btn-cta" href="https://wrapbootstrap.com/theme/admin-appkit-admin-theme-angularjs-WB051SCJ1?ref=3wm" target="_blank">Get Started</a>-->

                    </div>
                </div>
            </div>

            <div class="item item-2">
                <div class="item-content container">
                    <div class="item-content-inner">

                        <h2 class="heading"><?php echo t("What")?> <?php echo FrontFunctions::getCompanyName()?> <?php echo t("help you do")?>?</h2>
                        <p class="intro"><?php echo t("Streamline the logistics, communicate seamlessly and take data driven decisions.")?></p>

                    </div>
                </div>
            </div>

            <div class="item item-3">
                <div class="item-content container">
                    <div class="item-content-inner">

                        <h2 class="heading"><?php echo t("Watch")?> <?php echo FrontFunctions::getCompanyName()?> <?php echo t("in action")?>!</h2>
                        <p class="intro"><?php echo t("Discover what")?> <?php echo FrontFunctions::getCompanyName()?> <?php echo t("can do for your business")?>.</p>

                    </div>
                </div>
            </div>

            <div class="item item-4">
                <div class="item-content container">
                    <div class="item-content-inner">

                        <h2 class="heading"><?php echo t("Professionals & businesses of all types use ")?> <?php echo FrontFunctions::getCompanyName()?>.</h2>
                        <p class="intro"><?php echo t("Pickup & delivery, home services, repair services and another services.")?></p>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="about" class="about-section">
    <div class="container text-center">
        <h2 class="section-title"><?php echo t("Why Use")?> <?php echo FrontFunctions::getCompanyName()?>?</h2>
        <p class="intro"><?php echo FrontFunctions::getCompanyName()?> <?php echo t("uses modern front-end technologies and is packed with useful components to speed up your company") ?>.</p>
        <ul class="technologies list-inline">
            <li><img src="assets/images/logo-bootstrap.svg" alt="Bootstrap"></li>
            <li><img src="assets/images/logo-angular.svg" alt="Angular"></li>
            <li><img src="assets/images/logo-html5.svg" alt="HTML5"></li>
            <li><img src="assets/images/logo-css3.svg" alt="CSS3"></li>
            <li><img src="assets/images/logo-less.svg" alt="Less"></li>
            <li><img src="assets/images/logo-jquery.svg" alt="jQuery"></li>
        </ul>

        <div class="items-wrapper row">
            <div class="item col-sm-4 col-xs-12">
                <div class="item-inner">
                    <div class="figure-holder">
                        <img class="figure-image" src="assets/images/figure-1.png" alt="image">
                    </div>
                    <h3 class="item-title"><?php echo t("Increase utilization of the fleet.") ?></h3>
                    <div class="item-desc">
                        <?php echo t("With")?> <?php echo FrontFunctions::getCompanyName()?> <?php echo t("technology, logistics companies can control and monitor the performance and productivity of every courier.")?>
                    </div>
                </div>
            </div>
            <div class="item col-sm-4 col-xs-12">
                <div class="item-inner">
                    <div class="figure-holder">
                        <img class="figure-image" src="assets/images/figure-2.png" alt="image">
                    </div>
                    <h3 class="item-title"><?php echo t("Live tracking.") ?></h3>
                    <div class="item-desc">
                        <?php echo t("With")?> <?php echo FrontFunctions::getCompanyName()?> <?php echo t(", technology you can monitor the position, performance and productivity of your fleet.")?>
                    </div>
                </div>
            </div>
            <div class="item col-sm-4 col-xs-12">
                <div class="item-inner">
                    <div class="figure-holder">
                        <img class="figure-image" src="assets/images/figure-3.png" alt="image">
                    </div>
                    <h3 class="item-title"><?php echo t("Smart, simple & beautiful")?></h3>
                    <div class="item-desc">
                        <?php echo FrontFunctions::getCompanyName()?> <?php echo t("app for Android made simple yet practical, to perform tasks be easily and supports many devices.")?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="testimonials" class="testimonials-section">
    <div class="container">
        <h2 class="section-title text-center">Many Happy Customers</h2>
        <div class="item center-block">
            <div class="profile-holder">
                <img class="profile-image" src="assets/images/profile-1.png" alt="profile">
            </div>
            <div class="quote-holder">
                <blockquote class="quote">
                    <p>Testimonial goes here bla..bla...bla...</p>
                    <div class="quote-source">
                        <span class="name">@Richer,</span>
                        <span class="meta">San Francisco</span>
                    </div>
                </blockquote>
            </div>
        </div>
        <div class="item item-reversed center-block">
            <div class="profile-holder">
                <img class="profile-image" src="assets/images/profile-2.png" alt="profile">
            </div>
            <div class="quote-holder">
                <blockquote class="quote">
                    <p>Testimonial goes here bla..bla...bla...</p>
                    <div class="quote-source">
                        <span class="name">@LisaWhite,</span>
                        <span class="meta">London</span>
                    </div>
                </blockquote>
            </div>
        </div>
    </div>
</div>

<div id="features" class="features-section">
    <div class="container text-center">
        <h2 class="section-title"><?php echo t("Discover Features")?></h2>
        <p class="intro"><?php echo FrontFunctions::getCompanyName()?> <?php echo t("comes with an any features.")?></p>

        <div class="tabbed-area row">

            <!-- Nav tabs -->
            <ul class="feature-nav nav nav-pill nav-stacked text-left col-md-4 col-sm-6 col-xs-12 col-md-push-8 col-sm-push-6 col-xs-push-0" role="tablist">
                <li role="presentation" class="active"><a href="#feature-1" aria-controls="feature-1" role="tab" data-toggle="tab"><i class="fa fa-magic"></i>20+ Use Case-based App Pages</a></li>
                <li role="presentation"><a href="#feature-2" aria-controls="feature-2" role="tab" data-toggle="tab"><i class="fa fa-cubes"></i>100+ Components and Widgets</a></li>
                <li role="presentation"><a href="#feature-3" aria-controls="feature-3" role="tab" data-toggle="tab"><i class="fa fa-bar-chart"></i>Useful Chart Libraries</a></li>
                <li role="presentation"><a href="#feature-4" aria-controls="feature-4" role="tab" data-toggle="tab"><i class="fa fa-star"></i>AngularJS Version Included</a></li>
                <li role="presentation"><a href="#feature-5" aria-controls="feature-5" role="tab" data-toggle="tab"><i class="fa fa-rocket"></i>Built on Bootstrap 3</a></li>
                <li role="presentation"><a href="#feature-6" aria-controls="feature-6" role="tab" data-toggle="tab"><i class="fa fa-tablet"></i>Fully Responsive</a></li>
                <li role="presentation"><a href="#feature-7" aria-controls="feature-7" role="tab" data-toggle="tab"><i class="fa fa-file-code-o"></i>Valid HTML5 + CSS3</a></li>
                <li role="presentation"><a href="#feature-8" aria-controls="feature-8" role="tab" data-toggle="tab"><i class="fa fa-heart"></i>Free Updates &amp; Support + Documentation</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="feature-content tab-content col-md-8 col-sm-6 col-xs-12 col-md-pull-4 col-sm-pull-6 col-xs-pull-0">
                <div role="tabpanel" class="tab-pane fade in active" id="feature-1">
                    <a href="#" target="_blank">
                        <img class="img-responsive" src="assets/images/feature-1.png" alt="screenshot" >
                    </a>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="feature-2">
                    <a href="#" target="_blank">
                        <img class="img-responsive" src="assets/images/feature-2.png" alt="screenshot" >
                    </a>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="feature-3">
                    <a href="#" target="_blank">
                        <img class="img-responsive" src="assets/images/feature-3.png" alt="screenshot" >
                    </a>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="feature-4">
                    <a href="#" target="_blank">
                        <img class="img-responsive" src="assets/images/feature-4.png" alt="screenshot" >
                    </a>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="feature-5">
                    <a href="#" target="_blank">
                        <img class="img-responsive" src="assets/images/feature-5.png" alt="screenshot" >
                    </a>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="feature-6">
                    <a href="#" target="_blank">
                        <img class="img-responsive" src="assets/images/feature-6.png" alt="screenshot" >
                    </a>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="feature-7">
                    <a href="#" target="_blank">
                        <img class="img-responsive" src="assets/images/feature-7.png" alt="screenshot" >
                    </a>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="feature-8">
                    <a href="#" target="_blank">
                        <img class="img-responsive" src="assets/images/feature-8.png" alt="screenshot" >
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>

<div id="team" class="team-section">
    <div class="container text-center">
        <h2 class="section-title"><?php echo t("Our Team")?></h2>
        <p class="intro"><?php echo t("See who are behind")?> <?php echo FrontFunctions::getCompanyName()?></p>
        <div class="story">
            <p><?php echo FrontFunctions::getCompanyName()?>
                <?php echo t("is created by eLogistik System Indonesia. eLog team got to know each other while working projects and became good friends. They firmly believe with the right resource, small teams can execute beautiful products too. Thus they made")?>
                <?php echo FrontFunctions::getCompanyName()?>
                <?php echo t("to help your company make outstanding products - the internet has made it possible for the  \"small guys\" to compete directly with the \"big guys\".") ?>
            </p>
        </div>
        <div class="members-wrapper row">
            <div class="item col-md-4 col-sm-4 col-xs-12">
                <div class="item-inner">
                    <div class="profile">
                        <img class="profile-image" src="assets/images/team-1.png" alt="Pipin Maryono" />
                    </div>

                    <div class="member-content">
                        <h3 class="member-name">Pipin Maryono</h3>
                        <div class="member-title">Business Development & Technology</div>
                        <ul class="social list-inline">
                            <li><a class="twitter" href="https://twitter.com/pipin1313" target="_blank"><i class="fa fa-twitter"></i></a></li>
                            <li><a class="facebook" href="https://www.facebook.com/pipin13" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li><a class="linkedin" href="https://www.linkedin.com/in/pipin-maryono-05479165/" target="_blank"><i class="fa fa-linkedin"></i></a></li>

                        </ul>
                        <div class="member-desc">
                            <p>Experienced in support for IT related services, network and infra structure engineering</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item col-md-4 col-sm-4 col-xs-12">
                <div class="item-inner">
                    <div class="profile">
                        <img class="profile-image" src="assets/images/team-2.png" alt="Isnaeni Hidayat" />
                    </div>

                    <div class="member-content">
                        <h3 class="member-name">Isnaeni Hidayat</h3>
                        <div class="member-title">Full-Stack Developer</div>
                        <ul class="social list-inline">
                            <li><a class="twitter" href="https://twitter.com/IsnaeniH" target="_blank"><i class="fa fa-twitter"></i></a></li>
                            <li><a class="facebook" href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li><a class="linkedin" href="https://www.linkedin.com/in/isnaeni-hidayat-821037129/" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                        <div class="member-desc">
                            <p>
                                I am a full-stack web developer with a focus on front-end. </br>
                                I've worked both as a solo developer and as a lead developer, scaling up a team as needed. </br>
                                My recent projects have been built in Cordova and Angular but I'm always open to new frameworks and believe that the technology should suit the project. </br>
                                I enjoy learning new languages, frameworks and technologies.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item col-md-4 col-sm-4 col-xs-12">
                <div class="item-inner">
                    <div class="profile">
                        <img class="profile-image" src="assets/images/team-3.png" alt="Imam Malik" />
                    </div>

                    <div class="member-content">
                        <h3 class="member-name">Imam Malik</h3>
                        <div class="member-title">System Delivery & Operation</div>
                        <ul class="social list-inline">
                            <li><a class="twitter" href="https://twitter.com/m4s1m4m" target="_blank"><i class="fa fa-twitter"></i></a></li>
                            <li><a class="facebook" href="https://www.facebook.com/1m4m.m4l1k" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li><a class="linkedin" href="https://www.linkedin.com/in/imam-malik-6748b313b/" target="_blank"><i class="fa fa-linkedin"></i></a></li>

                        </ul>
                        <!--<div class="member-desc">
                            <p></p>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="pricing" class="pricing-section">
    <div class="container text-center">
        <h2 class="section-title">Pricing</h2>
        <div class="intro"><?php echo FrontFunctions::getCompanyName()?> future updates are 100% FREE for existing customers</div>
        <div class="pricing-wrapper">
            <?php if (is_array($pricing) && count($pricing)>=1):?>
                <?php
                $inumber = 1;
                ?>
                <?php foreach ($pricing as $val):?>
                    <?php
                    if($inumber > 3){
                        $inumber = 1;
                    }
                    ?>
                    <div class="item item-<?php echo $inumber?> col-md-4 col-sm-4 col-xs-12">
                        <div class="item-inner">
                            <?php
                            $price=$val['price']; $promo_price=0;
                            if($val['promo_price']>0.0001){
                                $price=$val['promo_price'];
                                $promo_price=$val['promo_price'];
                            }
                            $curr='';
                            $curr_id=getOptionA('website_currency');
                            if ( $res_cur=AdminFunctions::getCurrencyByID($curr_id)){
                                $curr=$res_cur['currency_symbol'];
                            }
                            ?>

                            <h3 class="item-heading"><?php echo $val['plan_name']?></h3>
                            <div class="price-figure">
                                <?php if($val['remaks']=='Call'):?>
                                    <span class="number"><?php echo $val['remaks']?></span>
                                <?php else :?>
                                    <?php if($final_price=FrontFunctions::formatPrice($price)):?>
                                        <span class="currency"><?php echo $curr?></span><span class="number"><?php echo $final_price?></span>
                                        <?php if ($promo_price>0):?>
                                            <p><?php echo t("Before")?> <span class="number"><?php echo FrontFunctions::formatPrice($val['price'])?></span></p>
                                        <?php endif;?>
                                    <?php else :?>
                                        <price>-</price>
                                    <?php endif;?>
                                <?php endif;?>
                            </div>

                            <div class="price-desc">
                                <p><?php echo t("Membership Limit")?> <?php echo $val['expiration']?> <?php echo t($val['plan_type'])?></p>

                                <?php if(!empty($val['plan_name_description'])):?>
                                    <p class="plan_description readmore"><?php echo $val['plan_name_description']?></p>
                                <?php endif;?>

                                <div class="section text-left">
                                    <ul>
                                        <li> <?php echo t("Allowed")." ".t($val['allowed_driver'])." ".t("driver")?>.</li>
                                        <li> <?php echo t("Allowed")." ".t($val['allowed_task'])." ".t("Task")?>.</li>
                                        <!--<?php if ( $val['with_sms']==1):?>
                                                <li> <?php echo t("With SMS Features")?></li>
                                            <?php else :?>
                                                <li> <?php echo t("NO SMS Features")?></li>
                                            <?php endif;?>-->
                                    </ul>
                                </div>
                            </div>

                            <a class="btn btn-cta" href="<?php echo Yii::app()->createUrl('front/signup',array(
                                'plan_id'=>$val['plan_id']
                            ))?>"><?php echo t("START FREE TRIAL")?></a>

                        </div>
                    </div>
                    <?php
                    $inumber++;
                endforeach;
                ?>
            <?php endif;?>

        </div>

    </div>
</div>