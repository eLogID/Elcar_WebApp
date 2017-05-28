
<div class="modal inmodal driver-details-moda" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title"><?php echo t("Driver Details")?></h4>
            </div>

            <div class="modal-body">
                <?php
                echo CHtml::hiddenField('driver_id_details','',array(
                    'class'=>"driver_id_details"
                ))
                ?>

                <div class="grey-box rounded">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group left-form-group">
                                <label class="font-medium"><?php echo Driver::t("Name")?> :</label>
                                <span class="v driver_name"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group left-form-group">
                                <label class="font-medium"><?php echo Driver::t("Phone")?> :</label>
                                <span class="v phone"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group left-form-group">
                                <label class="font-medium"><?php echo Driver::t("Email address")?> :</label>
                                <span class="v email"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group left-form-group">
                                <label class="font-medium"><?php echo Driver::t("Team")?> :</label>
                                <span class="v team_name"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group left-form-group">
                                <label class="font-medium"><?php echo Driver::t("Transport Type")?> :</label>
                                <span class="v transport_type_id"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group left-form-group">
                                <label class="font-medium"><?php echo Driver::t("License Plate")?> :</label>
                                <span class="v licence_plate"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <h4><?php echo Driver::t("Task")?></h4>
                <div class="grey-box rounded top10">
                    <table class="table driver-task-list">
                        <thead>
                        <tr>
                            <th><?php echo Driver::t("Task ID")?></th>
                            <th><?php echo Driver::t("Name")?></th>
                            <th><?php echo Driver::t("Type")?></th>
                            <th><?php echo Driver::t("Address")?></th>
                            <th><?php echo Driver::t("Status")?></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer"></div>

        </div>
    </div>
</div>