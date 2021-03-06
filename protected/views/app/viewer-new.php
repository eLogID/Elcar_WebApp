
<div class="modal fade new-viewer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button aria-label="Close" data-dismiss="modal" class="close" type="button">
                    <span aria-hidden="true"><i class="ion-android-close"></i></span>
                </button>
                <h4 id="mySmallModalLabel" class="modal-title">
                    <?php echo t("Add Viewer")?>
                </h4>
            </div>

            <div class="modal-body">

                <form id="frm" class="frm" method="POST" onsubmit="return false;">
                    <?php echo CHtml::hiddenField('action','addViewer')?>
                    <?php echo CHtml::hiddenField('id','')?>
                    <div class="inner">

                        <div class="row">
                            <div class="col-md-6 ">
                                <?php echo CHtml::textField('first_name','',array(
                                    'placeholder'=>t("First Name"),
                                    'required'=>true
                                ))?>
                            </div>
                            <div class="col-md-6 ">
                                <?php echo CHtml::textField('last_name','',array(
                                    'placeholder'=>t("Last Name"),
                                    'required'=>true
                                ))?>
                            </div>
                        </div>

                        <div class="row top10">
                            <div class="col-md-6 ">
                                <?php echo CHtml::textField('email','',array(
                                    'placeholder'=>t("Email")
                                ))?>
                            </div>
                            <div class="col-md-6 ">
                                <?php echo CHtml::textField('phone','',array(
                                    'class'=>"mobile_inputs",
                                    'required'=>true,
                                    'maxlength'=>15
                                ))?>
                            </div>
                        </div>

                        <div class="row top10">
                            <div class="col-md-6 ">
                                <?php echo CHtml::textField('username','',array(
                                    'placeholder'=>t("Username"),
                                    'required'=>true
                                ))?>
                            </div>
                            <div class="col-md-6 ">
                                <?php echo CHtml::passwordField('password','',array(
                                    'placeholder'=>t("Password"),
                                    'required'=>true
                                ))?>
                            </div>
                        </div>

                        <div class="row top20">
                            <div class="col-md-12">
                                <p><?php echo t("Status")?></p>
                                <?php
                                echo CHtml::dropDownList('status','',Driver::driverStatus(),array(
                                    'required'=>true
                                ));
                                ?>
                            </div>
                        </div>


                        <div class="row top20">
                            <div class="col-md-5 col-md-offset-7">
                                <button type="submit" class="orange-button medium rounded"><?php echo t("Submit")?></button>
                                <button type="button" data-id=".new-viewer"
                                        class="close-modal green-button medium rounded"><?php echo t("Cancel")?></button>
                            </div>
                        </div>


                    </div>
                </form>

            </div>

        </div>
    </div>
</div>