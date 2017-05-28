<?php $this->renderPartial('/layouts/header');?>

<div class="track_map_wrapper">
    <div class="track-header">
        <div class="row">
            <div class="col-xs-6">
                <div class="row">
                    <div class="col-xs-4">
                        <b class="track_speed"></b>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 text-right">
                <a href="<?php echo FrontFunctions::websiteUrl() ?>" target="_blank">
                    <img class="logo" src="<?php echo FrontFunctions::getLogoURL() ?>">
                </a>
            </div>
        </div>
    </div>
    <!-- track-header -->
    <?php if($data['status']=='successful'){ ?>
        <div class="track-layer track-done">
            <h3 class="top30">This task is already completed.</h3>
        </div>
    <?php } else {?>
    <div class="track-center-map">
        <a href="javascript:;" class="track-center-map">
            <i class="ion-ios-navigate-outline"></i>
        </a>
    </div>
    <!-- track-center-map -->
    <div class="track-center-map call-wrap">
        <a href="tel:">
            <i class="ion-ios-telephone-outline"></i>
        </a>
    </div>
    <!-- track-center-map -->
    <div class="track_map" id="track_map"></div><!-- track_map -->

    <div class="track-arrived-wrap track-layer">
        <i class="ion-ios-bell-outline"></i>
        <h3>Hey i'm here!</h3>
        <p class="arrived-msg">
            <?php
            echo $data['driver_name'].'just arrived at '.$data['delivery_address'];
            ?>
        </p>
    </div> <!--track-arrived-wrap-->

    <div class="track-message track-layer"></div>

    <div class="track-layer track-rating-wrap">
        <h3>Rate Your Experience!</h3>

        <?php
        if($info=Driver::driverInfo($data['driver_id'])){
            $photo_url='';
            if (!empty($info['photo_profile'])){
                $photo_url=Driver::uploadURL()."/photo/".rawurldecode($info['photo_profile']);
                if (!file_exists(Driver::uploadPath()."/photo/".rawurldecode($info['photo_profile']))){
                    $photo_url='';
                }
            }
            ?>

            <div class="avatar-wrapper top20">
                <?php echo '<img src="'.$photo_url.'" class="avatar">' ?>
            </div> <!--avatar-wrapper-->
            <p><?php echo $info['first_name'].' '.$info['last_name'] ?></p>

            <form method="POST" class="frm top20" id="frm">

                <div class="raty-stars" data-score="0"></div>

                <input type="hidden" value="customerRating" name="action" id="action" />
                <?php echo '<input type="hidden" value="'.$task_id.'" name="task_id" id="task_id" />' ?>
                <p class="top20"><textarea placeholder="Leave your comment" name="rating_comment" id="rating_comment"></textarea></p>
                <p class="top30"><button class="rounded relative yellow-button large">Submit</button></p>
            </form>

        <?php
        }
        ?>

    </div> <!--track-rating-wrap-->

    <div class="track-details">
        <div class="spinner" style="display: block;">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>

        <div class="trackdetails-wrap"></div>
        <!--<p class="text-center no-agent-p">There is no assign agent for this task</p>-->
    </div>
    <!-- track-details -->
    <?php }?>
</div>