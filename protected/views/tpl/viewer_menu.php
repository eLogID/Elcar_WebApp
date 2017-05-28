<?php
/**
 * Created by IntelliJ IDEA.
 * User: isnaeni.hidayat
 * Date: 4/3/2017
 * Time: 9:54 AM
 */

$customer_id=ViewerFunctions::getUserId();
$user_id=$_SESSION['elcar_viewer']['viewer_id'];
$html='';

if(isset($user_id)){
    if($res=ViewerFunctions::getUserLogin($user_id, $customer_id)){
        $photo_url=Yii::app()->getBaseUrl(true).'/assets/images/no-avatar.jpg';
        if (!empty($res['photo_profile'])){
            $photo_url=Driver::uploadURL()."/photo/".rawurldecode($res['photo_profile']);
            if (!file_exists(Driver::uploadPath()."/photo/".rawurldecode($res['photo_profile']))){
                $photo_url=Yii::app()->getBaseUrl(true).'/assets/images/no-avatar.jpg';
            }
        }
        $html  = '<div class="dropdown profile-element">';
        $html .= '<span><img alt="profile" class="avatar-wrapper" src="'.$photo_url.'"/></span>';
        $html .= '<a data-toggle="dropdown" class="dropdown-toggle" href="#">';
        $html .= '<span class="clear">';
        $html .= '<span class="block m-t-xs"> <strong class="font-bold">'.$res["first_name"].' '.$res["last_name"] .'</strong></span>';
        $html .= '<span class="text-muted text-xs block">'.$res['email'].' <b class="caret"></b></span>';
        $html .= '</span></a>';
        $html .= '<ul class="dropdown-menu animated fadeInRight m-t-xs">';
        $html .= '<li><a href="'.Yii::app()->getBaseUrl(true).'/viewer/profile">Profile</a></li>';
        $html .= '<li><a href="'.Yii::app()->getBaseUrl(true).'/viewer/logout">Logout</a></li>';
        $html .= '</ul></div>';
    }
}

$menu = array(
    'activeCssClass'=>'active',
    'encodeLabel' => false,
    'id'=>'side-menu',
    'items'=>array(
        array(
            'label'=>'
            <div class="dropdown profile-element">'.$html.'</div>
            <div class="logo-element">
                eLog.id
            </div>
            ',
            'itemOptions'=>array('class'=>'nav-header')
        ),
        array(
            'visible'=>true,
            'label'=>'<i class="fa fa-th-large"></i><span class="nav-label">'.t('Dashboard').'</span>',
            'url'=>array('/viewer/dashboard')
        ),
        array(
            'visible'=>true,
            'label'=>'<i class="fa fa-tasks"></i><span class="nav-label">'.t('Tasks').'</span>',
            'url'=>array('/viewer/tasks')
        ),
        array(
            'visible'=>true,
            'label'=>'<i class="fa fa-users"></i><span class="nav-label">'.t('Drivers').'</span>',
            'url'=>array('/viewer/agents')
        ),
        array(
            'visible'=>true,
            'label'=>'<i class="fa fa-gears"></i><span class="nav-label">'.t('Settings').'</span>',
            'url'=>array('/viewer/settings')
        )
    ),
    'htmlOptions' => array(
        'class' => 'nav metismenu'
    )
);
?>

<div class="sidebar-collapse">
    <?php $this->widget('zii.widgets.CMenu',$menu); ?>
</div>
