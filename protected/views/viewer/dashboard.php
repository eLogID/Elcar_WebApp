
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <?php $this->renderPartial('/tpl/viewer_menu',array()); ?>
    </nav>

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <?php $this->renderPartial('/tpl/viewer_top',array()); ?>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Dashbooard</h2>
                <ol class="breadcrumb">
                    <li class="active"><strong><a href="#">Dashbooard</a></strong></li>
                </ol>
            </div>
            <div class="col-lg-2"></div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight dashboard-work-area">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $date_now=date('Y-m-d');
                    echo CHtml::hiddenField('calendar_formated',$date_now,array(
                        'class'=>'calendar_formated'
                    ))
                    ?>
                    <div class="google-map" id="primary_map" style="height: 450px"></div>
                </div>
            </div>
        </div>

        <?php $this->renderPartial('/viewer/footer',array()); ?>
    </div>
</div>