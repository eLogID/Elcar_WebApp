
<!--<div class="blue_panel">
    <div class="row">
        <div class="col-md-6"><?php echo t("Agent")?></div>
        <div class="col-md-6 text-right">

            <a href="javascript:loadAgentDashboard();"><i class="ion-android-refresh"></i></a>

        </div>
    </div>
</div>


<ul id="tabs">
    <li class="active"><span class="agent-active-total" >0</span> <?php echo t("Active")?></li>
    <li><span class="agent-offline-total" >0</span> <?php echo t("Offline")?></li>
    <li><span class="agent-total-total">0</span> <?php echo t("Total")?></li>
</ul>

<ul id="tab" class="list_row">
    <li class="active agent-active">

    </li>
    <li class="agent-offline">

    </li>

    <li class="agent-total">

    </li>
</ul>-->

<div class="panel_active animated" id="panel_active">
    <div class="panel_active_box">
        <div class="panel_active_content">
            <div class="title">
                <?php echo t("Active")?> <br/>
            </div>
            <div class="panel_item">
                <div class="feed-activity-list agent_active"></div>
            </div>
        </div>
    </div>
</div>

<div class="panel_offline animated" id="panel_offline">
    <div class="panel_offline_box">
        <div class="panel_offline_content">
            <div class="title">
                <?php echo t("Offline")?> <br/>
            </div>
            <div class="panel_item">
                <div class="feed-activity-list agent_offline"></div>
            </div>
        </div>
    </div>
</div>