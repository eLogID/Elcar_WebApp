
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
                    <b><?php echo t("Notifications")?></b>
                </div>
                <div class="col-md-6  text-right"></div>
            </div>
        </div>

        <div class="inner">

            <h4><?php echo t("Pickup Notifications")?></h4>

            <form id="frm" class="frm form-horizontal">
                <?php echo CHtml::hiddenField('action','SaveNotification')?>

                <?php $list=Driver::notificationListPickup(); ?>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?php echo t("Triggers")?></th>
                            <th><?php echo t("Mobile Push")?></th>
                            <th><?php echo t("SMS")?></th>
                            <th><?php echo t("Email")?></th>
                            <th><?php echo t("Actions")?></th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($list['PICKUP'] as $key=>$val):?>
                        <tr>
                            <td><?php echo t($key);?></td>
                            <td>
                                <?php
                                echo CHtml::checkBox(
                                        "PICKUP_".$val[0],
                                        getOption(Driver::getUserId(), "PICKUP_".$val[0])==1?true:false,
                                        array('class'=>"switch-boostrap"))
                                ?>
                            </td>
                            <td>
                                <?php
                                echo CHtml::checkBox(
                                        "PICKUP_".$val[1],
                                        getOption(Driver::getUserId(),"PICKUP_".$val[1])==1?true:false,
                                        array('class'=>"switch-boostrap"))
                                ?>
                            </td>
                            <td>
                                <?php
                                echo CHtml::checkBox(
                                        "PICKUP_".$val[2],
                                        getOption(Driver::getUserId(),"PICKUP_".$val[2])==1?true:false,
                                        array('class'=>"switch-boostrap"))
                                ?>
                            </td>
                            <td>
                                <a href="javascript:;" class="notification_tpl" data-id="<?php echo "PICKUP_".$key?>">
                                    <i class="ion-edit"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach;?>

                    </tbody>
                </table>

                <?php $list=Driver::notificationListDelivery(); ?>

                <div class="top20">&nbsp;</div>

                <h4><?php echo t("Delivery Notifications")?></h4>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?php echo t("Triggers")?></th>
                            <th><?php echo t("Mobile Push")?></th>
                            <th><?php echo t("SMS")?></th>
                            <th><?php echo t("Email")?></th>
                            <th><?php echo t("Actions")?></th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($list['DELIVERY'] as $key=>$val):?>
                        <tr>
                            <td><?php echo t($key);?></td>
                            <td>
                                <?php
                                echo CHtml::checkBox(
                                        "DELIVERY_".$val[0],
                                        getOption(Driver::getUserId(),"DELIVERY_".$val[0])==1?true:false,
                                        array('class'=>"switch-boostrap"))
                                ?>
                            </td>
                            <td>
                                <?php
                                echo CHtml::checkBox(
                                        "DELIVERY_".$val[1],
                                        getOption(Driver::getUserId(),"DELIVERY_".$val[1])==1?true:false,
                                        array('class'=>"switch-boostrap"))
                                ?>
                            </td>
                            <td>
                                <?php
                                echo CHtml::checkBox(
                                        "DELIVERY_".$val[2],
                                        getOption(Driver::getUserId(),"DELIVERY_".$val[2])==1?true:false,
                                        array('class'=>"switch-boostrap"))
                                ?>
                            </td>
                            <td>
                                <a href="javascript:;" class="notification_tpl" data-id="<?php echo "DELIVERY_".$key?>">
                                    <i class="ion-edit"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach;?>

                    </tbody>
                </table>

                <div class="top20">&nbsp;</div>

                <h4><?php echo t("Driver Notifications")?></h4>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?php echo t("Triggers")?></th>
                            <th><?php echo t("Mobile Push")?></th>
                            <th><?php echo t("SMS")?></th>
                            <th><?php echo t("Email")?></th>
                            <th><?php echo t("Actions")?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php echo t("ASSIGN_TASK")?></td>
                        <td>
                            <?php
                            echo CHtml::checkBox(
                                    'ASSIGN_TASK_PUSH',
                                    getOption(Driver::getUserId(),"ASSIGN_TASK_PUSH")==1?true:false,
                                    array('class'=>"switch-boostrap"))
                            ?>
                        </td>
                        <td>
                            <?php
                            echo CHtml::checkBox(
                                    'ASSIGN_TASK_SMS',
                                    getOption(Driver::getUserId(),"ASSIGN_TASK_SMS")==1?true:false,
                                    array('class'=>"switch-boostrap"))
                            ?>
                        </td>
                        <td>
                            <?php
                            echo CHtml::checkBox(
                                    'ASSIGN_TASK_EMAIL',
                                    getOption(Driver::getUserId(),"ASSIGN_TASK_EMAIL")==1?true:false,
                                    array('class'=>"switch-boostrap"))
                            ?>
                        </td>
                        <td>
                            <a href="javascript:;" class="notification_tpl" data-id="ASSIGN_TASK"><i class="ion-edit"></i></a>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo t("UPDATE_TASK")?></td>
                        <td>
                            <?php echo CHtml::checkBox(
                                    'UPDATE_TASK_PUSH',
                                    getOption(Driver::getUserId(),"UPDATE_TASK_PUSH")==1?true:false,
                                    array('class'=>"switch-boostrap"))
                            ?>
                        </td>
                        <td>
                            <?php echo CHtml::checkBox(
                                    'UPDATE_TASK_SMS',
                                    getOption(Driver::getUserId(),"UPDATE_TASK_SMS")==1?true:false,
                                    array('class'=>"switch-boostrap"))
                            ?>
                        </td>
                        <td>
                            <?php echo CHtml::checkBox(
                                    'UPDATE_TASK_EMAIL',
                                    getOption(Driver::getUserId(),"UPDATE_TASK_EMAIL")==1?true:false,
                                    array('class'=>"switch-boostrap"))
                            ?>
                        </td>
                        <td>
                            <a href="javascript:;" class="notification_tpl" data-id="UPDATE_TASK"><i class="ion-edit"></i></a>
                        </td>

                    </tr>

                    <tr>
                        <td><?php echo t("DELETED_TASK")?></td>
                        <td>
                            <?php echo CHtml::checkBox(
                                    'CANCEL_TASK_PUSH',
                                    getOption(Driver::getUserId(),"CANCEL_TASK_PUSH")==1?true:false,
                                    array('class'=>"switch-boostrap"))
                            ?>
                        </td>
                        <td>
                            <?php echo CHtml::checkBox(
                                    'CANCEL_TASK_SMS',
                                    getOption(Driver::getUserId(),"CANCEL_TASK_SMS")==1?true:false,
                                    array('class'=>"switch-boostrap"))
                            ?>
                        </td>
                        <td>
                            <?php echo CHtml::checkBox(
                                    'CANCEL_TASK_EMAIL',
                                    getOption(Driver::getUserId(),"CANCEL_TASK_EMAIL")==1?true:false,
                                    array('class'=>"switch-boostrap"))
                            ?>
                        </td>
                        <td>
                            <a href="javascript:;" class="notification_tpl" data-id="CANCEL_TASK"><i class="ion-edit"></i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div class="top20">&nbsp;</div>

                <h4><?php echo t("Auto assign Notifications")?></h4>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?php echo t("Triggers")?></th>
                            <th><?php echo t("Mobile Push")?></th>
                            <th><?php echo t("SMS")?></th>
                            <th><?php echo t("Email")?></th>
                            <th><?php echo t("Actions")?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php echo t("FAILED_AUTO_ASSIGN")?></td>
                        <td>
                            <?php echo CHtml::checkBox(
                                    'FAILED_AUTO_ASSIGN_PUSH',
                                    getOption(Driver::getUserId(),"FAILED_AUTO_ASSIGN_PUSH")==1?true:false,
                                    array('class'=>"switch-boostrap"))
                            ?>
                        </td>
                        <td>
                            <?php echo CHtml::checkBox(
                                    'FAILED_AUTO_ASSIGN_SMS',
                                    getOption(Driver::getUserId(),"FAILED_AUTO_ASSIGN_SMS")==1?true:false,
                                    array('class'=>"switch-boostrap"))
                            ?>
                        </td>
                        <td>
                            <?php echo CHtml::checkBox(
                                    'FAILED_AUTO_ASSIGN_EMAIL',
                                    getOption(Driver::getUserId(),"FAILED_AUTO_ASSIGN_EMAIL")==1?true:false,
                                    array('class'=>"switch-boostrap"))
                            ?>
                        </td>
                        <td>
                            <a href="javascript:;" class="notification_tpl" data-id="FAILED_AUTO_ASSIGN"><i class="ion-edit"></i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div class="top20">&nbsp;</div>

                <div class="form-group">
                    <div class="col-sm-6">
                        <button type="submit" class="orange-button medium rounded">
                            <?php echo Driver::t("Save")?>
                        </button>
                    </div>
                </div>

            </form>

        </div>

    </div>

</div>