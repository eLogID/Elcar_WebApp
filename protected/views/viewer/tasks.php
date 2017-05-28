<div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <?php $this->renderPartial('/tpl/viewer_menu',array()); ?>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <?php $this->renderPartial('/tpl/viewer_top',array()); ?>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Task</h2>
                <ol class="breadcrumb">
                    <li><a href="<?php echo Yii::app()->getBaseUrl(true)?>/viewer">Home</a></li>
                    <li class="active"><strong><a href="#">Task List</a></strong></li>
                </ol>
            </div>
            <div class="col-lg-2"></div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Task List</h5>
                        </div>
                        <div class="ibox-content">
                            <form id="frm_table" class="frm_table">
                                <?php echo CHtml::hiddenField('action','taskList')?>
                                <input type="text" class="form-control input-sm m-b-xs" id="filter"
                                       placeholder="Search in table">

                                <table class="footable table table-stripped" id="table_list" data-filter=#filter>
                                    <thead>
                                    <tr>
                                        <th width="10%"><?php echo t("Task ID")?></th>
                                        <th><?php echo t("Task Type")?></th>
                                        <th><?php echo t("Description")?></th>
                                        <th><?php echo t("Driver Name")?></th>
                                        <th><?php echo t("Name")?></th>
                                        <th><?php echo t("Address")?></th>
                                        <th><?php echo t("Delivery Date")?></th>
                                        <th><?php echo Driver::t("Status")?></th>
                                        <th><?php echo Driver::t("Action")?></th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="5">
                                            <ul class="pagination pull-right"></ul>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->renderPartial('/viewer/footer',array()); ?>
    </div>
</div>
