<?php
if (!isset($_SESSION)) { session_start(); }
/**
 * Created by IntelliJ IDEA.
 * User: isnaeni.hidayat
 * Date: 4/2/2017
 * Time: 5:05 PM
 */

class AjaxviewerController extends CController
{
    public $code=2;
    public $msg;
    public $details;
    public $data;

    public function __construct()
    {
        $this->data=$_POST;
    }

    public function init()
    {
        // set website timezone
        $website_timezone=Yii::app()->functions->getOptionAdmin("website_timezone" );
        if (!empty($website_timezone)){
            Yii::app()->timeZone=$website_timezone;
        }

        if(isset($this->data['language'])){
            Yii::app()->language=$this->data['language'];
        }
        if(isset($_GET['language'])){
            Yii::app()->language=$_GET['language'];
        }
        unset($this->data['language']);
    }

    private function jsonResponse()
    {
        $resp=array('code'=>$this->code,'msg'=>$this->msg,'details'=>$this->details);
        echo CJSON::encode($resp);
        Yii::app()->end();
    }

    public function actionLogin()
    {
        $req=array(
            'username'=>Driver::t("Username is required"),
            'password'=>Driver::t("password is required"),
        );

        $Validator=new Validator;
        $Validator->required($req,$this->data);
        if($Validator->validate()){

            AdminFunctions::CheckCustomerExpiry();

            if ($res = ViewerFunctions::Login(trim($this->data['username']), trim($this->data['password']) )){

                if($res['status']=="active"){
                    unset($res['username']);
                    unset($res['password']);
                    $_SESSION['elcar_viewer']=$res;
                    $this->code=1;
                    $this->msg=t("Login successful");
                    $this->details=Yii::app()->createUrl('/viewer/dashboard');
                } else $this->msg=t("Login failed. either username or password is incorrect");

            } else $this->msg=t("Login failed. either username and password is invalid");
        } else $this->msg=$Validator->getErrorAsHTML();
        $this->jsonResponse();
    }

    public function actiongetDashboardTask()
    {
        if (isset($this->data['status'])){
            $date='';
            if ( isset($this->data['date'])){
                $date=$this->data['date'];
            }

            $data=''; $coordinates='';
            $status_list=array('unassigned','assigned','completed');
            foreach ($status_list as $status) {
                if ($res = ViewerFunctions::getTaskByStatus(ViewerFunctions::getUserId(),$status,$date)){
                    $total=count($res);
                    $html='';
                    foreach ($res as $val) {
                        if(!empty($val['task_lat']) && !empty($val['task_lng']) ){
                            $coordinates[]=array(
                                'lat'=>$val['task_lat'],
                                'lng'=>$val['task_lng'],
                                'trans_type'=>$val['trans_type'],
                                'customer_name'=>$val['customer_name'],
                                'address'=>$val['delivery_address'],
                                'task_id'=>$val['task_id'],
                                'status'=>Driver::t($val['status']),
                                'status_raw'=>$val['status'],
                                'trans_type'=>Driver::t($val['trans_type']),
                                'map_type'=>'restaurant'
                            );
                        } else {
                            if ($res_location=Driver::addressToLatLong($val['delivery_address'])){
                                $val['task_lat']=$res_location['lat'];
                                $val['task_lng']=$res_location['long'];

                                $coordinates[]=array(
                                    'lat'=>$res_location['lat'],
                                    'lng'=>$res_location['long'],
                                    'trans_type'=>$val['trans_type'],
                                    'customer_name'=>$val['customer_name'],
                                    'address'=>$val['delivery_address'],
                                    'task_id'=>$val['task_id'],
                                    'status'=>Driver::t($val['status']),
                                    'status_raw'=>$val['status'],
                                    'trans_type'=>Driver::t($val['trans_type']),
                                    'map_type'=>'restaurant'
                                );
                            }
                        }
                        $html.=Driver::formatTask($val);
                    }

                    $data[$status]=array(
                        'total'=>$total,
                        'html'=>$html
                    );
                    $this->details=$data;
                } else {
                    $data[$status]='';
                    $this->details=$data;
                }
            }

            /*get the driver online coordinates*/
            $agent_stats=array('active');
            $customer_id=ViewerFunctions::getUserId();
            if($customer_id!='0' || $customer_id!=0){
                $include_offline=getOption(ViewerFunctions::getUserId(),'driver_include_offline_driver_map');
            } else {
                $include_offline=1;
            }

            if($include_offline==1){
                $agent_stats=array('active','offline');
            }

            $online_agent='';
            foreach ($agent_stats as $agent_stat) {
                $res_agent=ViewerFunctions::getDriverByStats(
                    ViewerFunctions::getUserId(),
                    $agent_stat,
                    isset($this->data['date'])?$this->data['date']:date("Y-m-d"),
                    'active'
                );
                if (is_array($res_agent) && count($res_agent)>=1){
                    foreach ($res_agent as $agent_val) {
                        $coordinates[]=array(
                            'driver_id'=>$agent_val['driver_id'],
                            'first_name'=>$agent_val['first_name'],
                            'last_name'=>$agent_val['last_name'],
                            'email'=>$agent_val['email'],
                            'phone'=>$agent_val['phone'],
                            'lat'=>$agent_val['location_lat'],
                            'lng'=>$agent_val['location_lng'],
                            'map_type'=>'driver',
                            'is_online'=>$agent_val['is_online']
                        );
                    }
                }
            }

            $this->code=1;
            $this->msg=$coordinates;

        } else $this->msg=Driver::t("parameter status is missing");
        $this->jsonResponse();
    }

    public function actiongetAgentlist()
    {
        if($res=ViewerFunctions::getDriverList(ViewerFunctions::getUserId())){
            $this->code=1;
            $this->msg='successful load data';

            if(is_array($res) && count($res)>=1){
                $html='';
                foreach ($res as $val) {
                    $html.=ViewerFunctions::formatTask($val);
                }
            }
            $this->details=$html;
        } else $this->msg=ViewerFunctions::t("parameter status is missing");
        $this->jsonResponse();
    }

    public function actiontaskList()
    {
        $customer_id = ViewerFunctions::getUserId();
        if($customer_id!='0' || $customer_id!=0){
            $and=" AND customer_id =".ViewerFunctions::q(ViewerFunctions::getUserId())."  ";
        }

        $stmt="SELECT SQL_CALC_FOUND_ROWS *
		FROM
		{{driver_task_view}}
		WHERE 1		
		$and
		";

        $DbExt=new DbExt;
        $DbExt->qry("SET SQL_BIG_SELECTS=1");
        if ($res=$DbExt->rst($stmt)){
            $total = count($res);
            $html = '';
            foreach ($res as $val){
                $valstat = '';
                switch ($val['status'])
                {
                    case "acknowledged":
                    case "successful":
                        $valstat='primary';
                        break;
                    case "started":
                        $valstat='info';
                        break;
                    case "assigned":
                        $valstat='warning';
                        break;
                    case "inprogress":
                        $valstat='success';
                        break;
                    case "failed":
                    case "canceled":
                    case "cancelled":
                    case "declined":
                    case "suspended":
                    case "blocked":
                        $valstat='danger';
                        break;
                }
                $status="<span class=\"label label-".$valstat." \">".Driver::t($val['status'])."</span>";

                $action="<a class=\"btn btn-primary task-details\"
			    	data-id=\"".$val['task_id']."\" href=\"javascript:;\">".t("Details")."</a>";

                if ($val['status']=="unassigned"){
                    $action="<a class=\"btn btn-default assign-agent\"
			    	data-id=\"".$val['task_id']."\" href=\"javascript:;\">".Driver::t("Assigned")."</a>";
                }

                $html .= "<tr>";
                $html .= "<td>".$val['task_id']."</td>";
                $html .= "<td>".$val['trans_type']."</td>";
                $html .= "<td>".$val['task_description']."</td>";
                $html .= "<td>".$val['driver_name']."</td>";
                $html .= "<td>".$val['customer_name']."</td>";
                $html .= "<td>".$val['delivery_address']."</td>";
                $html .= "<td>".$val['delivery_date']."</td>";
                $html .= "<td>".$status."</td>";
                $html .= "<td>".$action."</td>";
                $html .= "</tr>";
            }

            $this->code=1;
            $this->msg=$total;
            $this->details=$html;

        } else $this->msg=ViewerFunctions::t("parameter status is missing");
        $this->jsonResponse();
    }
}