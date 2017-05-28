<div class="modal show-trip-map-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button aria-label="Close" data-dismiss="modal" class="close" type="button">
                    <span aria-hidden="true"><i class="ion-android-close"></i></span>
                </button>

                <div class="row">

                    <div class="col-md-6">
                        <h4 id="mySmallModalLabel" class="modal-title">
                            <?php echo t("Driver Trip")?> <span class="totalmileage"></span></span>
                        </h4>
                    </div> <!--col-->

                    <div class="col-md-5 text-right">
                        <a class="back-task-details-trip" href="javascript:;">
                            <i class="ion-ios-arrow-thin-left"></i> <?php echo t("Back")?>
                        </a>
                    </div>

                </div><!-- row-->

            </div>

            <div class="modal-body">

                <?php echo CHtml::hiddenField('map_origin_lat')?>
                <?php echo CHtml::hiddenField('map_origin_lng')?>
                <?php echo CHtml::hiddenField('map_destination_lat')?>
                <?php echo CHtml::hiddenField('map_destination_lng')?>
                <?php echo CHtml::hiddenField('map_task_id_ref')?>
                <?php echo CHtml::hiddenField('map_trip_count')?>

                <div class="map-trip-wrap">
                    <div class="map-trip" id="map-trip"></div>
                </div>


            </div> <!--body-->

        </div> <!--modal-content-->
    </div> <!--modal-dialog-->
</div> <!--modal-->