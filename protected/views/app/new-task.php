<div class="modal new-task" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button aria-label="Close" data-dismiss="modal" class="close" type="button">
                    <span aria-hidden="true"><i class="ion-android-close"></i></span>
                </button>
                <h4 id="mySmallModalLabel" class="modal-title">
                    <?php echo t("New Task")?>
                </h4>
            </div>

            <div class="modal-body">

                <form id="frm_task" class="frm" method="POST" onsubmit="return false;">
                    <?php echo CHtml::hiddenField('action','addTask')?>
                    <?php echo CHtml::hiddenField('task_id','',array(
                        'class'=>"task_id"
                    ))?>
                    <?php echo CHtml::hiddenField('order_id','')?>

                    <?php echo CHtml::hiddenField('task_lat','')?>
                    <?php echo CHtml::hiddenField('task_lng','')?>

                    <div class="row">
                        <div class="col-md-6 ">

                            <h5><?php echo Driver::t("Task Description")?></h5>
                            <div class="top10">
                                <?php echo CHtml::textArea('task_description','',array('class'=>"")) ?>
                            </div>

                            <?php
                            $service_list=Driver::serviceList();
                            if($service_list){
                                $service_list=Driver::toList($service_list,'service_id','service_name',
                                    ''
                                );
                            }
                            ?>
                            <h5 class="top20"><?php echo Driver::t("Select Transaction")?></h5>
                            <div class="top10 row">
                                <div class="col-md-12 ">
                                    <?php
                                    echo CHtml::dropDownList('trans_type','', (array)$service_list, array(
                                        'class'=>"trans_type",
                                        'required'=>true
                                    ))
                                    ?>
                                </div>
                            </div>

                            <div class="delivery-info top20">
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php echo CHtml::textField('contact_number','',array(
                                            'class'=>"mobile_inputs",
                                            'placeholder'=>Driver::t("Contact number"),
                                            'maxlength'=>15
                                        ))?>
                                    </div>
                                    <div class="col-md-6 ">
                                        <?php
                                        echo CHtml::textField('email_address','',array(
                                            'placeholder'=>Driver::t("Email address")
                                        ))
                                        ?>
                                    </div>
                                </div>

                                <div class="row top10">
                                    <div class="col-md-6 ">
                                        <?php echo CHtml::textField('customer_name','',array(
                                            'placeholder'=>Driver::t("Name"),
                                            'required'=>true
                                        ))?>
                                    </div>
                                    <div class="col-md-6 ">
                                        <?php echo CHtml::textField('delivery_date','',array(
                                            'placeholder'=>Driver::t("Date time before"),
                                            'required'=>true,
                                            'class'=>"datetimepicker"
                                        ))?>
                                    </div>
                                </div>

                                <div class="row top10">
                                    <div class="col-md-12 ">
                                        <?php
                                        echo CHtml::textField('delivery_address','',array(
                                            'class'=>'delivery_address geocomplete delivery_address_task',
                                            'placeholder'=>Driver::t("Address"),
                                            'required'=>true
                                        ))
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <h5 class="top20"><?php echo Driver::t("Reference")?></h5>
                            <div class="top10">
                                <?php
                                echo CHtml::textField('reff','',array(
                                    'placeholder'=>Driver::t("Reference")
                                ))
                                ?>
                            </div>

                            <?php
                            $team_list=Driver::teamList( Driver::getUserId());
                            if($team_list){
                                $team_list=Driver::toList($team_list,'team_id','team_name',
                                    Driver::t("Select a team")
                                );
                            }
                            $all_driver=Driver::getAllDriver(Driver::getUserId());
                            ?>
                            <h5 class="top20"><?php echo Driver::t("Select Team")?></h5>
                            <div class="top10 row">
                                <div class="col-md-12 ">
                                    <?php
                                    echo CHtml::dropDownList('team_id', '', (array)$team_list, array(
                                        'class'=>"task_team_id"
                                    ))
                                    ?>
                                </div>
                            </div>

                            <div class="assign-agent-wrap">
                                <h5 class="top20"><?php echo Driver::t("Assign Agent")?></h5>
                                <div class="col-md-12 ">
                                    <div class="top10 row">
                                        <select name="driver_id" id="driver_id" class="driver_id">
                                            <?php if(is_array($all_driver) && count($all_driver)>=1):?>
                                                <option value=""><?php echo Driver::t("Select driver")?></option>
                                                <?php foreach ($all_driver as $val):?>
                                                    <option class="<?php echo "team_opion option_".$val['team_id']?>" value="<?php echo $val['driver_id']?>">
                                                        <?php echo $val['first_name']." ".$val['last_name']?>
                                                    </option>
                                                <?php endforeach;?>
                                            <?php endif;?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6 ">
                            <div class="map1" style="height: 250px;">
                                <div class="map_task_loader">
                                    <div class="inner">
                                        <div class="ploader"></div>
                                    </div>
                                </div>
                                <div class="map_task"></div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer top20">
                        <button type="submit" class="orange-button medium rounded new-task-submit">
                            <?php echo t("Submit")?>
                        </button>
                        <button type="button" data-id=".new-task" class="close-modal green-button medium rounded">
                            <?php echo t("Cancel")?>
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>
</div>