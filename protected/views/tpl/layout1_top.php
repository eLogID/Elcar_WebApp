
<nav class="navbar navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
            <i class="fa fa-reorder"></i>
        </button>
        <a href="<?php echo Yii::app()->createUrl('/app/index')?>" class="navbar-brand logo">
            <img src="<?php echo FrontFunctions::getLogoURL() ?>">
        </a>
    </div>

    <div class="navbar-collapse collapse" id="navbar">
        <ul class="nav navbar-nav navbar-top-links">
            <li class="active">
                <a aria-expanded="false" role="button" href="javascript:;" class="green-button add-new-task"><?php echo t("Add New Task")?></a>
            </li>
            <li class="dropdown">
                <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bars" aria-hidden="true"></i> Transaction
                    <span class="caret"></span>
                </a>
                <ul role="menu" class="dropdown-menu">
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/app/tasks')?>">
                            <i class="fa fa-tasks"></i> <?php echo Driver::t("Tasks")?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/app/teams')?>">
                            <i class="fa fa-users"></i> <?php echo Driver::t("Teams")?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/app/agents')?>">
                            <i class="fa fa-user"></i> <?php echo Driver::t("Drivers")?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/app/viewers')?>">
                            <i class="fa fa-eye"></i> <?php echo Driver::t("Viewers")?>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i> Reports
                    <span class="caret"></span>
                </a>
                <ul role="menu" class="dropdown-menu">
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/app/reports')?>">
                            <i class="fa fa-line-chart"></i> <?php echo Driver::t("Reports")?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/app/pushlogs')?>">
                            <i class="fa fa-send-o"></i> <?php echo Driver::t("Push")?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/app/tracks')?>">
                            <i class="fa fa-map-pin"></i> <?php echo Driver::t("Agen Tracks")?>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-gears" aria-hidden="true"></i> Configuration
                    <span class="caret"></span>
                </a>
                <ul role="menu" class="dropdown-menu">
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/app/notifications')?>">
                            <i class="fa fa-bell-o"></i> <?php echo Driver::t("Notifications")?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/app/assignment')?>">
                            <i class="fa fa-sign-language"></i> <?php echo Driver::t("Assignment")?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/app/profile')?>">
                            <i class="fa fa-user-circle"></i> <?php echo Driver::t("Profile")?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/app/settings')?>">
                            <i class="fa fa-gear"></i> <?php echo Driver::t("Settings")?>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown notification_panel">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" title="Notifications">
                    <i class="fa fa-bell"></i>  <span class="label label-primary notification_count">0</span>
                </a>
                <ul class="dropdown-menu dropdown-alerts" id="notification_list"></ul>
            </li>
        </ul>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <a href="<?php echo Yii::app()->createUrl('app/logout')?>">
                    <i class="fa fa-sign-out"></i> Log out
                </a>
            </li>
        </ul>
    </div>
</nav>