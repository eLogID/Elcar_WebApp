<div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <?php $this->renderPartial('/tpl/viewer_menu',array()); ?>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <?php $this->renderPartial('/tpl/viewer_top',array()); ?>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Drivers</h2>
                <ol class="breadcrumb">
                    <li><a href="<?php echo Yii::app()->getBaseUrl(true)?>/viewer">Home</a></li>
                    <li class="active"><strong><a href="#">Drivers</a></strong></li>
                </ol>
            </div>
            <div class="col-lg-2"></div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div id="agent-list"></div>
            </div>
        </div>

        <?php $this->renderPartial('/viewer/footer',array()); ?>
    </div>
</div>