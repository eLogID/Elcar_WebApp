
<!--<div class="container">
    <div class="login-wrap rounded">
        <img src="<?php echo Yii::app()->baseUrl.'/assets/images/logo@2x.png'; ?>">

        <form id="frm" class="frm rounded3" method="POST" onsubmit="return false;">
            <div class="inner">
                <?php echo CHtml::hiddenField('action','login')?>
                <?php echo CHtml::hiddenField('old_password',$old_password)?>
                <div>
                    <?php
                    echo CHtml::textField('email_address',
                        $email_address
                        ,array(
                            'placeholder'=>Driver::t("Enter email"),
                            'class'=>"lightblue-fields rounded",
                            'required'=>true
                        ));
                    ?>
                </div>

                <div class="top20">
                    <?php
                    echo CHtml::passwordField('password',
                        $password
                        ,array(
                            'placeholder'=>Driver::t("Password"),
                            'class'=>"lightblue-fields rounded",
                            'required'=>true
                        ));
                    ?>
                </div>

                <div class="top20">
                    <button class="yellow-button large rounded3 relative">
                        <?php echo Driver::t("LOG IN")?> <i class="ion-ios-arrow-thin-right"></i>
                    </button>
                </div>

            </div>

            <div class="sub-section">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo CHtml::checkBox('remember',true,array('value'=>1))?>
                        <?php echo t("Remember me")?>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="javascript:;" class="show-forgot-pass"><?php echo t("Forgot password")?>?</a>
                    </div>
                </div>
            </div>

        </form>

        <form id="frm-forgotpass" class="frm rounded3" method="POST" onsubmit="return false;">
            <?php echo CHtml::hiddenField('action','forgotPassword')?>
            <div class="inner">

                <p class="center">
                    <?php echo t("Enter your email address and we'll send you a link to reset your password")?>
                </p>

                <div class="top20">
                    <?php
                    echo CHtml::textField('email_address','',array(
                        'placeholder'=>Driver::t("Enter email"),
                        'class'=>"lightblue-fields rounded",
                        'required'=>true
                    ));
                    ?>
                </div>

                <div class="top20">
                    <button class="yellow-button large rounded3 relative">
                        <?php echo Driver::t("SUBMIT")?> <i class="ion-ios-arrow-thin-right"></i>
                    </button>
                </div>
            </div>

            <div class="sub-section">
                <a href="javascript:;" class="show-login"><?php echo t("Back")?></a>
            </div>

        </form>

        <hr/>
        <p class="center white"><?php echo t("You don't have account")?>?</p>

        <a href="<?php echo Yii::app()->createUrl('front/signup')?>" class="yellow-button large rounded3 relative">
            <?php echo Driver::t("SIGNUP FOR FREE")?> <i class="ion-ios-arrow-thin-right"></i>
        </a>

    </div>
</div>-->

<div class="container" id="login-block">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="account-wall text-center animated fadeInDown" style="margin-top: 0px;">
                <h1 class="logo-name" style="font-size: 80px;">
                    <img alt="image" src="<?php echo Yii::app()->baseUrl.'/assets/images/logo@2x.png'; ?>" />
                </h1>
                <h3 class="system-name">Welcome to <?php echo FrontFunctions::getCompanyName()?>.</h3>

                <div id="error"></div>

                <form id="frm" class="form-signin" method="POST" onsubmit="return false;">
                    <?php echo CHtml::hiddenField('action','login')?>
                    <?php echo CHtml::hiddenField('old_password',$old_password)?>
                    <div class="append-icon m-b-10">
                        <?php
                        echo CHtml::textField('email_address',
                            $email_address
                            ,array(
                                'placeholder'=>Driver::t("Enter email"),
                                'class'=>"form-control form-white username",
                                'required'=>true
                            ));
                        ?>
                        <i class="icon-user"></i>
                    </div>
                    <div class="append-icon m-b-0">
                        <?php
                        echo CHtml::passwordField('password',
                            $password
                            ,array(
                                'placeholder'=>Driver::t("Password"),
                                'class'=>"form-control form-white password",
                                'required'=>true
                            ));
                        ?>
                        <i class="icon-lock"></i>
                    </div>
                    <div class="append-icon m-b-20">
                        <p class="pull-left" style="color: white">
                            <?php echo CHtml::checkBox('remember',true,array('value'=>1))?>
                            <?php echo t("Remember me")?>
                        </p>
                    </div>

                    <button class="btn btn-lg btn-primary btn-block" data-style="expand-left">
                        <?php echo Driver::t("LOG IN")?>
                    </button>

                    <div class="clearfix">
                        <p class="pull-left m-t-20"><a id="formpassword" href="javascript:;"><?php echo t("Forgot password")?>?</a></p>
                    </div>

                    <p class="text-muted text-center"><small style="color: white;"><?php echo t("You don't have account")?>?</small></p>
                    <a class="btn btn-lg btn-warning btn-block" data-style="expand-left" href="<?php echo Yii::app()->createUrl('front/signup')?>">
                        <?php echo Driver::t("SIGNUP FOR FREE")?>
                    </a>
                </form>

                <!--form reset-->
                <form id="frm-forgotpass" class="form-password" role="form">
                    <?php echo CHtml::hiddenField('action','forgotPassword')?>
                    <p class="text-muted text-center" style="color: white;">
                        <?php echo t("Enter your email address and we'll send you a link to reset your password")?>
                    </p>
                    <div class="append-icon m-b-20">
                        <?php
                        echo CHtml::textField('email_address','',array(
                            'placeholder'=>Driver::t("Enter email"),
                            'class'=>"form-control form-white email",
                            'required'=>true
                        ));
                        ?>
                        <i class="icon-lock"></i>
                    </div>
                    <button type="submit" id="submit-password" class="btn btn-lg btn-danger btn-block" data-style="expand-left"><?php echo t("SUBMIT")?></button>
                    <div class="clearfix">
                        <p class="pull-left m-t-20"><a id="login" href="javascript:;"><?php echo t("Already got an account? Sign In")?></a></p>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <p class="account-copyright">
        <span class="system-name">&copy; 2017 <a href="http://elog.id">PT eLogistik System Indonesia.</a></span> <br />
        <span class="system-name"><strong>Created By</strong> Isnaeni Hidayat.</span>
    </p>
</div>