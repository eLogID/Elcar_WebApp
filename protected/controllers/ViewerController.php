<?php
if (!isset($_SESSION)) { session_start(); }
/**
 * Created by IntelliJ IDEA.
 * User: isnaeni.hidayat
 * Date: 3/31/2017
 * Time: 4:25 PM
 */

class ViewerController extends CController
{
    public $layout='viewer_layout';
    public $body_class='';

    public function init()
    {
        // set website timezone
        $website_timezone=Yii::app()->functions->getOptionAdmin("website_timezone" );
        if (!empty($website_timezone)){
            Yii::app()->timeZone=$website_timezone;
        }

        if(isset($_GET['lang'])){
            Yii::app()->language=$_GET['lang'];
        }
    }

    public function beforeAction($action)
    {
        $action_name= $action->id ;
        $accept_controller=array('login','ajax','resetpassword');
        if(!ViewerFunctions::islogin()){
            if(!in_array($action_name,$accept_controller)){
                $this->redirect(Yii::app()->createUrl('/viewer/login'));
            }
        }

        /*check user status*/
        $status=Driver::getUserStatus();

        ScriptManagerViewer::scripts();

        $baseUrl = Yii::app()->baseUrl."";
        $cs = Yii::app()->getClientScript();
        $jslang=json_encode(Driver::jsLang());
        $cs->registerScript(
            'jslang',
            "var jslang=$jslang;",
            CClientScript::POS_HEAD
        );

        $js_lang_validator=Yii::app()->functions->jsLanguageValidator();
        $js_lang=Yii::app()->functions->jsLanguageAdmin();

        $cs->registerScript(
            'jsLanguageValidator',
            'var jsLanguageValidator = '.json_encode($js_lang_validator).'
		  ',
            CClientScript::POS_HEAD
        );

        $cs->registerScript(
            'js_lang',
            'var js_lang = '.json_encode($js_lang).';
		  ',
            CClientScript::POS_HEAD
        );

        $cs->registerScript(
            'account_status',
            "var account_status='$status';",
            CClientScript::POS_HEAD
        );

        $language=Yii::app()->language;
        $cs->registerScript(
            'language',
            "var language='$language';",
            CClientScript::POS_HEAD
        );

        if(in_array($action_name,$accept_controller)){
            $cs->registerCssFile($baseUrl."/assets/viewer/css/ui.css");
            $cs->registerCssFile($baseUrl."/assets/viewer/css/loginstyle.css");
        }

        return true;
    }

    public function actionLogin()
    {
        if (ViewerFunctions::islogin()){
            $this->redirect(Yii::app()->createUrl('/viewer/dashboard'));
            Yii::app()->end();
        }
        $this->body_class="account";
        $this->render('login');
    }

    public function actionLogout()
    {
        unset($_SESSION['elcar_viewer']);
        $this->redirect(Yii::app()->createUrl('/viewer/login'));
    }

    public function actionIndex(){
        $this->body_class="dashboard";
        $this->render('dashboard');
    }

    public function actionDashboard()
    {
        $this->body_class="dashboard";
        $this->render('dashboard');
    }

    public function actionAgents()
    {
        $this->body_class="agents";
        $this->render('agents');
    }

    public function actionTasks()
    {
        $this->body_class='task-list';
        $this->render('tasks');
    }
}