
<div id="layout_1">
    <?php $this->renderPartial('/tpl/layout1_top',array()); ?>
</div>

<div class="parent-wrapper">

    <div class="content_1 white">
        <?php $this->renderPartial('/tpl/menu',array()); ?>
    </div>

    <div class="content_main">
        <div class="nav_option">
            <div class="row">
                <div class="col-md-6 ">
                    <b><?php echo t("Agent Track")?></b>
                </div>
                <div class="col-md-6  text-right"></div>
            </div>
        </div>

        <div class="inner" style="padding-top:3px;">
            <div class="row">
                <div class="col-md-2">
                    <p><?php echo t("Time") ?></p>
                    <?php echo CHtml::dropDownList(
                        'time_track',
                        '',
                        array(
                            "day"=>t("Past Days"),
                            "week"=>t("Past Week"),
                            "month"=>t("Past Month"),
                            "custom"=>t("Custom Date")
                        ),
                        array('class'=>"form-control"))
                    ?>

                    <div class="custom_track top20">
                        <p><?php echo Driver::t("Start Date")?></p>
                        <?php echo CHtml::textField(
                            'start_date',
                            $start_date,
                            array('class'=>"form-control datetimepicker1"))
                        ?>
                        <p class="top20"><?php echo Driver::t("End Date")?></p>
                        <?php echo CHtml::textField(
                            'end_date',
                            $end_date,
                            array('class'=>"form-control datetimepicker1"))
                        ?>
                    </div>

                    <p class="top20"><?php echo t("Team") ?></p>
                    <?php echo CHtml::dropDownList(
                        'team_track','',
                        (array)$team_list,
                        array('class'=>"form-control"))
                    ?>

                    <p class="top20"><?php echo t("Driver") ?></p>
                    <select name="driver_track" id="driver_track" class="driver_track form-control">
                        <?php if(is_array($all_driver) && count($all_driver)>=1):?>
                            <option value="all"><?php echo Driver::t("All Driver")?></option>
                            <?php foreach ($all_driver as $val):?>
                                <option class="<?php echo "team_opion option_".$val['team_id']?>" value="<?php echo $val['driver_id']?>">
                                    <?php echo $val['first_name']." ".$val['last_name']?>
                                </option>
                            <?php endforeach;?>
                        <?php endif;?>
                    </select>
                </div>

                <div class="col-md-10">
                    <div class="map-track-wrap">
                        <div class="map-track" id="map-track"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>