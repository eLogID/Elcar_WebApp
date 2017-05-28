
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
                <div class="col-md-6 border">
                    <b><?php echo t("Viewer")?></b>
                </div>
                <div class="col-md-6 border text-right">

                    <a class="green-button left rounded" href="javascript:;"
                       data-toggle="modal" data-target=".new-viewer" >
                        <?php echo t("Add Viewer")?>
                    </a>
                    <a class="orange-button left rounded refresh-table" href="javascript:;"><?php echo t("Refresh")?></a>

                </div>
            </div>
        </div>

        <div class="inner">
            <form id="frm_table" class="frm_table">
                <?php echo CHtml::hiddenField('action','viewerList')?>
                <table id="table_list" class="table table-hover">
                    <thead>
                    <tr>
                        <th width="5%"><?php echo t("ID")?></th>
                        <th width="10%"><?php echo t("User Name")?></th>
                        <th width="10%"><?php echo t("Name")?></th>
                        <th width="10%"><?php echo t("Email")?></th>
                        <th width="10%"><?php echo t("Phone")?></th>
                        <th width="10%"><?php echo t("Status")?></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </form>
        </div>

    </div>

</div>

<?php $this->renderPartial('/app/viewer-new',array());