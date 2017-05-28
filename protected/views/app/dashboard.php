
<div id="wrapper dashboard">
    <div id="map-wrapper" class="gray-bg">

        <div class="row border-bottom white-bg">
            <?php $this->renderPartial('/tpl/layout1_top',array()); ?>
        </div>

        <div class="wrapper wrapper-content dashboard-work-area">
            <div id="primary_map" class="primary_map"></div>
            <div id="floating-logo">
                <a href="http://elog.id/" target="_blank" title="eLogistik System Indonesia">
                    <img alt="image" id="logo" src="<?php echo Yii::app()->baseUrl."/assets/images/elog.png"?>" style="height:30px">
                </a>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">

                    </div>
                </div>
            </div>
        </div>

        <div class="footer fixed" id="footer">
            <div>
                <strong>Copyright</strong> <a href="http://elog.id/" target="_blank">eLogistik System Indonesia &copy; <?php echo date("Y")?></a>
            </div>
        </div>

    </div>

    <?php $this->renderPartial('/tpl/task_panel',array()); ?>
    <?php $this->renderPartial('/tpl/task_pane2',array()); ?>
</div>
