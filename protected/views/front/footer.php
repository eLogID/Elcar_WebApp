<!--
<div class="sections section-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 border">

                <a href="<?php echo Yii::app()->createUrl('/')?>">
                    <img src="<?php echo FrontFunctions::getLogoURL();?>">
                </a>

                <?php if (!empty($custom_footer)):?>
                    <p class="top10">
                        <?php echo $custom_footer;?>
                    </p>
                <?php else :?>
                    <p class="top10">
                        <?php echo $company_address;?>
                    </p>

                    <?php if (!empty($website_default_country)):?>
                        <p>
                            <i class="ion-ios-flag"></i> <?php echo $website_default_country?>
                        </p>
                    <?php endif;?>

                    <?php if (!empty($contact_number)):?>
                        <p>
                            <i class="ion-android-call"></i> <?php echo $contact_number?>
                        </p>
                    <?php endif;?>

                    <?php if (!empty($email_address)):?>
                        <p>
                            <i class="ion-ios-email-outline"></i> <?php echo $email_address?>
                        </p>
                    <?php endif;?>
                <?php endif;?>

            </div>

            <div class="col-md-8 border">

                <div class="row">
                    <div class="col-md-4 border">
                        <h4><?php echo t("MENU")?></h4>
                        <?php $this->widget('zii.widgets.CMenu', FrontFunctions::getMenus('bottom-1'));?>
                    </div>

                    <div class="col-md-4 border">
                        <h4><?php echo t("OTHERS")?></h4>
                        <?php $this->widget('zii.widgets.CMenu', FrontFunctions::getMenus('bottom-2'));?>
                    </div>

                    <div class="col-md-4 border">
                        <h4><?php echo t("GET IN TOUCH")?></h4>
                        <ul class="social">
                            <?php if(!empty($follow_fb)):?>
                                <li>
                                    <a target="_blank" href="<?php echo FrontFunctions::urlFixed($follow_fb)?>"><div class="circle"><i class="ion-social-facebook"></i></div></a>
                                </li>
                            <?php endif;?>

                            <?php if(!empty($follow_twitter)):?>
                                <li>
                                    <a target="_blank" href="<?php echo FrontFunctions::urlFixed($follow_twitter)?>"><div class="circle"><i class="ion-social-twitter"></i></div></a>
                                </li>
                            <?php endif;?>

                            <?php if(!empty($follow_google)):?>
                                <li>
                                    <a target="_blank" href="<?php echo FrontFunctions::urlFixed($follow_google)?>"><div class="circle"><i class="ion-social-googleplus"></i></div></a>
                                </li>
                            <?php endif;?>

                        </ul>
                    </div>

                </div>

            </div>
        </div>

        <?php
        if(!empty($language_list)){
            $language_list=json_decode($language_list,true);
        }
        ?>

        <div class="sub-footer">
            <div class="row">
                <div class="col-md-6 border">
                    <span class="yellow">&copy; <?php echo date("Y")?> <?php echo strtoupper(FrontFunctions::getCompanyName())?></span>
                </div>
                <div class="col-md-6 border text-right">

                    <?php if(is_array($language_list) && count($language_list)>=1):?>
                        <div class="lang-selector-wrap">
                            <a href="javascript:;" class="language-selector">
                                <?php echo $language?>&nbsp;&nbsp;<i class="ion-ios-arrow-up"></i>
                            </a>


                            <ul id="lang-list">
                                <?php foreach ($language_list as $val_lang) :?>
                                    <li>
                                        <a href="<?php echo Yii::app()->getBaseUrl(true)."/setlang/?lang=$val_lang&action=$action_name"?>">
                                            <?php echo $val_lang?>
                                        </a>
                                    </li>
                                <?php endforeach;?>
                            </ul>

                        </div>
                    <?php endif;?>

                </div>
            </div>
        </div>

    </div>
</div>

<footer></footer>-->

<div id="contact" class="contact-section">
    <div class="container text-center">
        <h2 class="section-title">Contact Us</h2>
        <div class="contact-content">
            <p><?php echo t("PT eLogistik System Indonesia.");?></p>
            <p><?php echo $company_address;?></p>
            <?php if (!empty($contact_number)):?>
                <p>
                    <i class="ion-android-call"></i> <?php echo $contact_number?>
                </p>
            <?php endif;?>

            <?php if (!empty($email_address)):?>
                <p>
                    <i class="ion-ios-email-outline"></i> <?php echo $email_address?>
                </p>
            <?php endif;?>

        </div>
        <a class="btn btn-cta btn-primary" href="#">Get in Touch</a>

    </div><!--//container-->
</div><!--//contact-section-->

<footer class="footer text-center">
    <div class="container">
        <small class="copyright">&copy; <?php echo date("Y")?> <a href="http://elog.id/" target="_blank">eLogistik System Indonesia</a> | </small>
        <small class="copyright"><?php echo t("Created by Isnaeni Hidayat.")?> </small>
    </div>
</footer>