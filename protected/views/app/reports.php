
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
                    <b><?php echo t("Reports")?></b>
                </div>
                <div class="col-md-6  text-right"></div>
            </div>
        </div>

        <div class="inner">

            <div class="row">
                <div class="col-md-3">

                    <?php echo CHtml::hiddenField('chart_type','task_completion')?>
                    <?php echo CHtml::hiddenField('chart_type_option','time')?>

                    <p><?php echo t("Time") ?></p>
                    <?php echo CHtml::dropDownList(
                            'time_selection',
                            '',
                            array(
                                "week"=>t("Past Week"),
                                "month"=>t("Past Month"),
                                "custom"=>t("Custom Date")
                            ),
                            array('class'=>"form-control"))
                    ?>

                    <div class="custom_selection top20">
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
                            'team_selection','',
                            (array)$team_list,
                            array('class'=>"form-control"))
                    ?>

                    <p class="top20"><?php echo t("Driver") ?></p>
                    <select name="driver_selection" id="driver_selection" class="driver_selection form-control">
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
                <div class="col-md-9">
                    <div class="report_div"></div>

                    <div class="row top30">
                        <div class="col-md-4 col-xs-offset-5">
                            <div class="btn-group">
                                <a href="javascript:;" data-id="time" class="btn btn-primary change_charts">
                                    <?php echo Driver::t("Time")?>
                                </a>
                                <a href="javascript:;" data-id="agent" class="btn btn-primary change_charts">
                                    <?php echo Driver::t("Driver")?>
                                </a>
                                <a href="javascript:;" data-id="all_report" class="btn btn-primary change_charts">
                                    <?php echo Driver::t("Export")?>
                                </a>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="table_charts"></div>

        </div>

    </div>

</div>