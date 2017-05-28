<?php
class ApiController extends CController
{
    public $data;
    public $code=2;
    public $msg='';
    public $details='';

    public function __construct()
    {
        $this->data=$_GET;

        $website_timezone=Yii::app()->functions->getOptionAdmin("website_timezone");
        if (!empty($website_timezone)){
            Yii::app()->timeZone=$website_timezone;
        }

        if(isset($_GET['lang_id'])){
            Yii::app()->language=$_GET['lang_id'];
        }
    }

    public function beforeAction($action)
    {
        /*check if there is api has key*/
        $action=Yii::app()->controller->action->id;
        $continue=true;
        if($action=="getLanguageSettings" || $action=="GetAppSettings"){
            $continue=false;
        }
        if($continue){
            $key=getOptionA('mobile_api_key');
            if(!empty($key)){
                if(!isset($this->data['api_key'])){
                    $this->data['api_key']='';
                }
                if(trim($key)!=trim($this->data['api_key'])){
                    $this->msg=$this->t("api hash key is not valid");
                    $this->output();
                    Yii::app()->end();
                }
            }
        }
        return true;
    }

    public function actionIndex(){
        echo 'Api is working';
    }

    private function q($data='')
    {
        return Yii::app()->db->quoteValue($data);
    }

    private function t($message='')
    {
        return Yii::t("default",$message);
    }

    private function output()
    {
        $resp=array(
            'code'=>$this->code,
            'msg'=>$this->msg,
            'details'=>$this->details,
            'request'=>json_encode($this->data)
        );
        if (isset($this->data['debug'])){
            dump($resp);
        }

        if (!isset($_GET['callback'])){
            $_GET['callback']='';
        }

        if (isset($_GET['json']) && $_GET['json']==TRUE){
            echo CJSON::encode($resp);
        } else echo $_GET['callback'] . '('.CJSON::encode($resp).')';
        Yii::app()->end();
    }

    public function actionLogin()
    {
        if(!empty($this->data['username']) && !empty($this->data['password'])){
            if ( $res=Driver::driverAppLogin($this->data['username'],$this->data['password'])){
                $token=md5(Driver::generateRandomNumber(5) . $this->data['username']);
                $params=array(
                    'last_login'=>date('c'),
                    'last_online'=>strtotime("now"),
                    'ip_address'=>$_SERVER['REMOTE_ADDR'],
                    'token'=>$token,
                    'device_id'=>isset($this->data['device_id'])?$this->data['device_id']:'',
                    'device_platform'=>isset($this->data['device_platform'])?$this->data['device_platform']:'Android'
                );
                if(!empty($res['token'])){
                    unset($params['token']);
                    $token=$res['token'];
                }
                $db=new DbExt;
                if ( $db->updateData("{{driver}}",$params,'driver_id',$res['driver_id'])){
                    $this->code=1;
                    $this->msg=self::t("Login Successful");

                    //get location accuracy
                    $location_accuracy=2;
                    if ( $team=Driver::getTeam($res['team_id'])){
                        //dump($team);
                        if($team['location_accuracy']=="high"){
                            $location_accuracy=1;
                        }
                    }

                    $this->details=array(
                        'username'=>$this->data['username'],
                        'password'=>$this->data['password'],
                        'remember'=>isset($this->data['remember'])?$this->data['remember']:'',
                        'todays_date'=>Yii::app()->functions->translateDate(date("M, d")),
                        'todays_date_raw'=>date("Y-m-d"),
                        'on_duty'=>$res['on_duty'],
                        'token'=>$token,
                        'duty_status'=>$res['on_duty'],
                        'location_accuracy'=>$location_accuracy
                    );
                } else $this->msg=self::t("Login failed. please try again later");
            } else $this->msg=self::t("Login failed. either username or password is incorrect");
        } else $this->msg=self::t("Please fill in your username and password");
        $this->output();
    }

    public function actionForgotPassword()
    {
        if (empty($this->data['email'])){
            $this->msg=self::t("Email address is required");
            $this->output();
            Yii::app()->end();
        }
        $db=new DbExt;
        if ( $res=Driver::driverForgotPassword($this->data['email'])){
            $driver_id=$res['driver_id'];
            $code=Driver::generateRandomNumber(5);
            $params=array('forgot_pass_code'=>$code);
            if($db->updateData('{{driver}}',$params,'driver_id',$driver_id)){
                $this->code=1;
                $this->msg=self::t("We have send the a password change code to your email");

                $tpl=EmailTemplate::forgotPasswordRequest();
                $tpl=smarty('first_name',$res['first_name'],$tpl);
                $tpl=smarty('code',$code,$tpl);
                $subject='Forgot Password';
                if ( sendEmail($res['email'],'',$subject,$tpl)){
                    $this->details="send email ok";
                } else $this->msg="send email failed";

            } else $this->msg=self::t("Something went wrong please try again later");
        } else $this->msg=self::t("Email address not found");
        $this->output();
    }

    public function actionChangePassword()
    {
        $Validator=new Validator;
        $req=array(
            'email_address'=>self::t("Email address is required"),
            'code'=>self::t("Code is required"),
            'newpass'=>self::t("New Password is required")
        );
        $Validator->required($req,$this->data);
        if ( $Validator->validate()){
            if ( $res=Driver::driverForgotPassword($this->data['email_address'])){
                if ( $res['forgot_pass_code']==$this->data['code']){
                    $params=array(
                        'password'=>md5($this->data['newpass']),
                        'date_modified'=>date('c'),
                        'forgot_pass_code'=>Driver::generateRandomNumber(5)
                    );
                    $db=new DbExt;
                    if ( $db->updateData("{{driver}}",$params,'driver_id',$res['driver_id'])){
                        $this->code=1;
                        $this->msg=self::t("Password successfully changed");
                    } else $this->msg=self::t("Something went wrong please try again later");
                } else $this->msg=self::t("Invalid password code");
            } else $this->msg=self::t("Email address not found");
        } else $this->msg=Driver::parseValidatorError($Validator->getError());
        $this->output();
    }

    public function actionChangeDutyStatus()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }
        $driver_id=$token['driver_id'];
        $params=array(
            'on_duty'=>isset($this->data['onduty'])?$this->data['onduty']:2,
            'last_online'=>strtotime("now")
        );
        if ( $this->data['onduty']==2){
            $params['last_online']=time() - 300;
        }
        $db=new DbExt;
        if ( $db->updateData('{{driver}}',$params,'driver_id',$driver_id)){
            $this->code=1;
            $this->msg="OK";
            $this->details=$this->data['onduty'];
        } else $this->msg=self::t("Something went wrong please try again later");
        $this->output();
    }

    public function actionGetTaskByDate()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }
        $driver_id=$token['driver_id'];

        if (isset($this->data['onduty'])){
            if ($this->data['onduty']==1){
                Driver::updateLastOnline($driver_id);
            }
        }

        //if ( $res=Driver::getTaskByDriverID($driver_id,$this->data['date'])){
        if ( $res=Driver::getTaskByDriverIDWithAssigment($driver_id,$this->data['date'])){
            $this->code=1;
            $this->msg="OK";
            $data='';
            foreach ($res as $val) {
                $val['delivery_time']=Yii::app()->functions->timeFormat($val['delivery_date'],true);
                $val['status_raw']=$val['status'];
                $val['status']=self::t($val['status']);
                $val['trans_type_raw']=$val['trans_type'];
                $val['trans_type']=self::t($val['trans_type']);
                $data[]=$val;
            }
            $this->details=$data;
        } else $this->msg=self::t("No task for the day");
        $this->output();
    }

    public function actionviewTaskDescription()
    {
        $this->actionTaskDetails();
    }
    public function actionTaskDetails()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }

        if (isset($this->data['task_id'])){
            if ( $res=Driver::getTaskId($this->data['task_id']) ){

                //check task belong to current driver
                if ( $res['status']!="unassigned"){
                    $driver_id=$token['driver_id'];
                    if ($driver_id!=$res['driver_id']){
                        $this->msg=Driver::t("Sorry but this task is already been assigned to others");
                        $this->output();
                        Yii::app()->end();
                    }
                }

                $this->code=1;
                $this->msg=self::t("Task").":".$this->data['task_id'];

                $res['delivery_time']=Yii::app()->functions->timeFormat($res['delivery_date'],true);
                $res['status_raw']=$res['status'];
                $res['status']=self::t($res['status']);
                $res['trans_type_raw']=$res['trans_type'];
                $res['trans_type']=self::t($res['trans_type']);

                $res['history']=Driver::getDriverTaskHistory($this->data['task_id']);

                /*get signature if any*/
                $res['customer_signature_url']='';
                if (!empty($res['customer_signature'])){
                    $res['customer_signature_url']=Driver::uploadURL()."/".$res['customer_signature'];
                    if (!file_exists(Driver::uploadPath()."/".$res['customer_signature'])){
                        $res['customer_signature_url']='';
                    }
                }

                $res['driver_enabled_notes']=Yii::app()->functions->getOption("driver_enabled_notes",$res['customer_id']);
                $res['driver_enabled_signature']=Yii::app()->functions->getOption("driver_enabled_signature",$res['customer_id']);
                $res['driver_enabled_photo']=Yii::app()->functions->getOption("driver_enabled_photo",$res['customer_id']);

                $res['history_notes']=Driver::getDriverCountNote($this->data['task_id']);
                $res['task_photo']=Driver::getDriverCountPhoto($this->data['task_id']);
                $res['map_icons']=Driver::getDriverMapIcon($res['customer_id']);

                $this->details=$res;
            } else $this->msg=self::t("Task not found");
        } else $this->msg=self::t("Task id is missing");
        $this->output();
    }

    public function actionChangeTaskStatus()
    {

        if(isset($_GET['debug'])){
            dump($this->data);
        }

        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }
        $driver_id=$token['driver_id'];
        $team_id=$token['team_id'];
        $driver_name=$token['first_name'] ." " .$token['last_name'];

        $db=new DbExt;

        if (isset($this->data['status_raw']) && isset($this->data['task_id'])){

            $task_id=$this->data['task_id'];
            $task_info=Driver::getTaskId($task_id);
            if(!$task_info){
                $this->msg=self::t("Task not found");
                $this->output();
                Yii::app()->end();
            }

            $params_history='';
            $params_history['ip_address']=$_SERVER['REMOTE_ADDR'];
            $params_history['date_created']=date('c');
            $params_history['task_id']=$task_id;
            $params_history['driver_id']=$driver_id;
            $params_history['driver_location_lat']=isset($token['location_lat'])?$token['location_lat']:'';
            $params_history['driver_location_lng']=isset($token['location_lng'])?$token['location_lng']:'';

            switch ($this->data['status_raw']) {

                case "failed":
                case "cancelled":
                    $params=array('status'=>$this->data['status_raw']);
                    // update task id
                    $db->updateData("{{driver_task}}",$params,'task_id',$task_id);

                    $remarks=Driver::driverStatusPretty($driver_name,$this->data['status_raw']);
                    $params_history['status']=$this->data['status_raw'];
                    $params_history['remarks']=$remarks;
                    $params_history['reason']=isset($this->data['reason'])?$this->data['reason']:'' ;
                    // insert history
                    $db->insertData("{{task_history}}",$params_history);

                    $this->code=1;
                    $this->msg="OK";
                    $this->details=array(
                        'task_id'=>$this->data['task_id'],
                        'status_raw'=>$params['status'],
                        'type_trip'=>$this->data['type_trip'],
                        'reload_functions'=>'getTodayTask'
                    );

                    //send notification to customer
                    if ( $task_info['trans_type']=="delivery"){
                        Driver::sendNotificationCustomer('DELIVERY_FAILED',$task_info);
                    } else {
                        Driver::sendNotificationCustomer('PICKUP_FAILED',$task_info);
                    }

                    break;

                case "declined":

                    if ( $assigment_info=Driver::getAssignmentByDriverTaskID($driver_id,$task_id)){

                        $stmt_assign="UPDATE 
    					{{driver_assignment}}
    					SET task_status='declined',
    					date_process=".Driver::q(date('c')).",
    					ip_address=".Driver::q($_SERVER['REMOTE_ADDR'])."
    					WHERE
    					task_id=".Driver::q($task_id)."
    					AND
    					driver_id=".Driver::q($driver_id)."
    					";
                        //dump($stmt_assign);
                        $db->qry($stmt_assign);

                        $this->code=1;
                        $this->msg="OK";
                        $this->details=array(
                            'task_id'=>$this->data['task_id'],
                            'status_raw'=>'declined',
                            'type_trip'=>$this->data['type_trip'],
                            'reload_functions'=>'getTodayTask'
                        );

                    } else {
                        $params=array('status'=>"declined");
                        // update task id
                        $db->updateData("{{driver_task}}",$params,'task_id',$task_id);

                        $remarks=Driver::driverStatusPretty($driver_name,'declined');
                        $params_history['status']='declined';
                        $params_history['remarks']=$remarks;
                        // insert history
                        $db->insertData("{{task_history}}",$params_history);

                        $this->code=1;
                        $this->msg="OK";
                        $this->details=array(
                            'task_id'=>$this->data['task_id'],
                            'status_raw'=>$params['status'],
                            'reload_functions'=>'getTodayTask'
                        );

                        //send email to admin or merchant
                    }

                    break;

                case "acknowledged":

                    // double check if someone has already the accept task
                    if($task_info['status']!="unassigned"){
                        if ( $task_info['driver_id']!=$driver_id){
                            $this->msg=Driver::t("Sorry but this task is already been assigned to others");
                            $this->output();
                            Yii::app()->end();
                        }
                    }

                    $params=array(
                        'driver_id'=>$driver_id,
                        'status'=>"acknowledged",
                        'team_id'=>$team_id
                    );

                    // update task id
                    $db->updateData("{{driver_task}}",$params,'task_id',$task_id);

                    $remarks=Driver::driverStatusPretty($driver_name,'acknowledged');
                    $params_history['status']='acknowledged';
                    $params_history['remarks']=$remarks;
                    // insert history
                    $db->insertData("{{task_history}}",$params_history);

                    $this->code=1;
                    $this->msg="OK";
                    $this->details=array(
                        'task_id'=>$this->data['task_id'],
                        'status_raw'=>$params['status'],
                        'type_trip'=>$this->data['type_trip'],
                        'reload_functions'=>'TaskDetails'
                    );

                    //update driver_assignment
                    $stmt_assign="UPDATE
    				{{driver_assignment}}
    				SET task_status='acknowledged'
    				WHERE task_id=".Driver::q($task_id)."
    				";
                    $db->qry($stmt_assign);

                    //send notification to customer
                    if ( $task_info['trans_type']=="delivery"){
                        Driver::sendNotificationCustomer('DELIVERY_REQUEST_RECEIVED',$task_info);
                    } else {
                        Driver::sendNotificationCustomer('PICKUP_REQUEST_RECEIVED',$task_info);
                    }

                    break;

                case "started":
                    $params=array('status'=>"started");
                    $db->updateData("{{driver_task}}",$params,'task_id',$task_id);
                    // update task id

                    $remarks=Driver::driverStatusPretty($driver_name,'started');
                    $params_history['status']='started';
                    $params_history['remarks']=$remarks;
                    // insert history
                    $db->insertData("{{task_history}}",$params_history);

                    $this->code=1;
                    $this->msg="OK";
                    $this->details=array(
                        'task_id'=>$this->data['task_id'],
                        'status_raw'=>$params['status'],
                        'type_trip'=>$this->data['type_trip'],
                        'reload_functions'=>'TaskDetails'
                    );

                    //send notification to customer
                    if ( $task_info['trans_type']=="delivery"){
                        Driver::sendNotificationCustomer('DELIVERY_DRIVER_STARTED',$task_info);
                    } else {
                        Driver::sendNotificationCustomer('PICKUP_DRIVER_STARTED',$task_info);
                    }

                    break;

                case "inprogress":
                    $params=array('status'=>"inprogress");
                    $db->updateData("{{driver_task}}",$params,'task_id',$task_id);
                    // update task id

                    $remarks=Driver::driverStatusPretty($driver_name,'inprogress');
                    $params_history['status']='inprogress';
                    $params_history['remarks']=$remarks;
                    // insert history
                    $db->insertData("{{task_history}}",$params_history);

                    $this->code=1;
                    $this->msg="OK";
                    $this->details=array(
                        'task_id'=>$this->data['task_id'],
                        'status_raw'=>$params['status'],
                        'type_trip'=>$this->data['type_trip'],
                        'reload_functions'=>'TaskDetails'
                    );

                    //send notification to customer
                    if ( $task_info['trans_type']=="delivery"){
                        Driver::sendNotificationCustomer('DELIVERY_DRIVER_ARRIVED',$task_info);
                    } else {
                        Driver::sendNotificationCustomer('PICKUP_DRIVER_ARRIVED',$task_info);
                    }

                    break;

                case "successful":
                    if($task_info['task_lat']=='' && $task_info['task_lng']==''){
                        $params=array(
                            'status'=>"successful",
                            'task_lat'=>$token['location_lat'],
                            'task_lng'=>$token['location_lng'],
                            'delivery_address'=>Driver::LatLongToAddress($token['location_lat'],$token['location_lng']),
                            'delivery_date'=>date('c')
                        );
                    }else{
                        $params=array('status'=>"successful", 'delivery_date'=>date('c'));
                    }

                    $db->updateData("{{driver_task}}",$params,'task_id',$task_id);
                    // update task id

                    $remarks=Driver::driverStatusPretty($driver_name,'successful');
                    $params_history['status']='successful';
                    $params_history['remarks']=$remarks;
                    // insert history
                    $db->insertData("{{task_history}}",$params_history);

                    //check next action
                    if(isset($this->data['nextaction'])){
                        if($this->data['nextaction']=='nextdest'){
                            $result = Driver::createNewTask($this->data['token'],$_SERVER['REMOTE_ADDR']);
                        }
                    }

                    $this->code=1;
                    $this->msg="OK";
                    $this->details=array(
                        'task_id'=>$this->data['task_id'],
                        'status_raw'=>$params['status'],
                        'type_trip'=>$this->data['type_trip'],
                        'next_dest'=>$result,
                        'reload_functions'=>'getTodayTask'
                    );

                    //send notification to customer
                    if ( $task_info['trans_type']=="delivery"){
                        Driver::sendNotificationCustomer('DELIVERY_SUCCESSFUL',$task_info);
                    } else {
                        Driver::sendNotificationCustomer('PICKUP_SUCCESSFUL',$task_info);
                    }

                    break;

                default:
                    $this->msg=self::t("Missing status");
                    break;
            }
        } else $this->msg=self::t("Missing parameters");

        $this->output();
    }

    public function actionAddSignatureToTask()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }
        $driver_id=$token['driver_id'];

        if ( isset($this->data['image'])){
            $path_to_upload=Yii::getPathOfAlias('webroot')."/upload";
            if (!file_exists($path_to_upload)){
                if (!@mkdir($path_to_upload,0777)){
                    $this->msg=self::t("Failed cannot create folder"." ".$path_to_upload);
                    Yii::app()->end();
                }
            }

            $filename="signature_".$this->data['task_id'] . "-" . Driver::generateRandomNumber(10) .".png";
            //$filename="signature_".$this->data['task_id'] . "-.png";

            /*$img = $this->data['image'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            @file_put_contents($path_to_upload."/$filename", $data);*/


            $img = $this->data['image'];
            Driver::base30_to_jpeg($img, $path_to_upload."/$filename");

            $params=array(
                'customer_signature'=>$filename,
                'date_modified'=>date('c'),
                'ip_address'=>$_SERVER['REMOTE_ADDR']
            );

            $task_id=$this->data['task_id'];
            $driver_name=$token['first_name'] ." " .$token['last_name'];

            $db=new DbExt;

            $task_id=$this->data['task_id'];
            $task_info=Driver::getTaskId($task_id);
            if(!$task_info){
                $this->msg=self::t("Task not found");
                $this->output();
                Yii::app()->end();
            }

            if ( $db->updateData("{{driver_task}}",$params,'task_id',$task_id)){
                $this->code=1;
                $this->msg="Successful";
                $this->details=$this->data['task_id'];

                $remarks=Driver::driverStatusPretty($driver_name,'sign');
                $params_history=array(
                    'status'=>'sign',
                    'remarks'=>$remarks,
                    'date_created'=>date('c'),
                    'ip_address'=>$_SERVER['REMOTE_ADDR'],
                    'task_id'=>$task_id,
                    'customer_signature'=>$filename ,
                    'driver_id'=>$driver_id,
                    'driver_location_lat'=>isset($token['location_lat'])?$token['location_lat']:'',
                    'driver_location_lng'=>isset($token['location_lng'])?$token['location_lng']:'',
                    'signature_base30'=>$img,
                    'receive_by'=>$this->data['receive_by']
                );

                if(!empty($this->data['signature_id'])){
                    $db->updateData("{{task_history}}",$params_history,'id',$this->data['signature_id']);
                } else {
                    $db->insertData("{{task_history}}",$params_history);
                }

            } else $this->msg=self::t("Something went wrong please try again later");

        } else $this->msg=self::t("Signature is required");
        $this->output();
    }

    public function actionloadSignature()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }

        if (isset($this->data['task_id'])){
            if ( $res=Driver::getTaskId($this->data['task_id']) ){

                if($res2=Driver::getDriverTaskViewHistory($this->data['task_id'],'sign')){
                    $this->code=1;
                    $this->msg=self::t("OK");

                    $res2['customer_signature_url']='';
                    if (!empty($res2['customer_signature'])){
                        $res2['customer_signature_url']=Driver::uploadURL()."/".$res2['customer_signature'];
                        if (!file_exists(Driver::uploadPath()."/".$res2['customer_signature'])){
                            $res2['customer_signature_url']='';
                        }
                    }

                    $this->details=array(
                        'task_id'=>$this->data['task_id'],
                        'status'=>$res['status'],
                        'data'=>$res2
                    );

                }

            } else $this->msg=self::t("no signature found");
        } else $this->msg=self::t("Task id is missing");
        $this->output();
    }

    public function actionCalendarTask()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }
        $driver_id=$token['driver_id'];

        if (isset($this->data['start']) && isset($this->data['end'])){
            $start=$this->data['start'] ." 00:00:00";
            $end=$this->data['end'] ." 23:59:00";
            $data='';
            if ( $res=Driver::getDriverTaskCalendar($driver_id,$start,$end)){
                //dump($res);
                foreach ($res as $val) {
                    $data[]=array(
                        'title'=> Driver::getTotalTaskByDate($driver_id,$val['delivery_date']),
                        'id'=>$val['delivery_date'],
                        'year'=>date("Y",strtotime($val['delivery_date'])),
                        'month'=>date("m",strtotime($val['delivery_date'] ." -1 months" )),
                        'day'=>date("d",strtotime($val['delivery_date'])),
                    );
                }
                $this->code=1;
                $this->msg="OK";
                $this->details=$data;
            }
        } else $this->msg=self::t("Missing parameters");

        $this->output();
    }

    public function actionGetProfile()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }
        $driver_id=$token['driver_id'];
        $info=Driver::driverInfo($driver_id);
        $this->code=1;
        $this->msg="OK";
        $photo_url='';
        if (!empty($info['photo_profile'])){
            $photo_url=Driver::uploadURL()."/photo/".rawurldecode($info['photo_profile']);
            if (!file_exists(Driver::uploadPath()."/photo/".rawurldecode($info['photo_profile']))){
                $photo_url='';
            }
        }
        $driver_name=$info['first_name'].' '.$info['last_name'];
        $this->details=array(
            'team_name'=>$info['team_name'],
            'email'=>$info['email'],
            'phone'=>$info['phone'],
            'transport_type_id'=>$info['transport_type_id'],
            'transport_type_id2'=>ucwords(self::t($info['transport_type_id'])),
            'transport_description'=>$info['transport_description'],
            'licence_plate'=>$info['licence_plate'],
            'color'=>$info['color'],
            'profile_photo'=>$photo_url,
            'full_name'=>$driver_name,
        );
        $this->output();
    }

    public function actionGetTransport()
    {
        $this->code=1;
        $this->code=1;
        $this->details=Driver::transportType();
        $this->output();
    }

    public function actionUpdateProfile()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }
        $driver_id=$token['driver_id'];

        $Validator=new Validator;
        $req=array(
            'phone'=>self::t("Phone is required")
        );
        $Validator->required($req,$this->data);
        if ( $Validator->validate()){
            $params=array(
                'phone'=>$this->data['phone'],
                'date_modified'=>date('c'),
                'ip_address'=>$_SERVER['REMOTE_ADDR']
            );
            $db=new DbExt;
            if ( $db->updateData("{{driver}}",$params,'driver_id',$driver_id)){
                $this->code=1;
                $this->msg=self::t("Profile Successfully updated");
            } else $this->msg=self::t("Something went wrong please try again later");
        } else $this->msg=Driver::parseValidatorError($Validator->getError());
        $this->output();
    }

    public function actionUpdateVehicle()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }
        $driver_id=$token['driver_id'];

        $Validator=new Validator;
        $req=array(
            'transport_type_id'=>self::t("Transport Type is required"),
            'transport_description'=>self::t("Description is required"),
            /*'licence_plate'=>self::t("License Plate is required"),
            'color'=>self::t("Color is required"),*/
        );
        if ( $this->data['transport_type_id']=="truck"){
            unset($req);
            $req=array(
                'transport_type_id'=>self::t("Transport Type is required")
            );
        }
        $Validator->required($req,$this->data);
        if ( $Validator->validate()){
            $params=array(
                'transport_type_id'=>$this->data['transport_type_id'],
                'transport_description'=>$this->data['transport_description'],
                'licence_plate'=>isset($this->data['licence_plate'])?$this->data['licence_plate']:'',
                'color'=>isset($this->data['color'])?$this->data['color']:'',
                'date_modified'=>date('c'),
                'ip_address'=>$_SERVER['REMOTE_ADDR']
            );
            $db=new DbExt;
            if ( $db->updateData("{{driver}}",$params,'driver_id',$driver_id)){
                $this->code=1;
                $this->msg=self::t("Vehicle Info updated");
            } else $this->msg=self::t("Something went wrong please try again later");
        } else $this->msg=Driver::parseValidatorError($Validator->getError());
        $this->output();
    }

    public function actionProfileChangePassword()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }
        $driver_id=$token['driver_id'];

        $Validator=new Validator;
        $req=array(
            'current_pass'=>self::t("Current password is required"),
            'new_pass'=>self::t("New password is required"),
            'confirm_pass'=>self::t("Confirm password is required")
        );
        if ( $this->data['new_pass']!=$this->data['confirm_pass']){
            $Validator->msg[]=self::t("Confirm password does not macth with your new password");
        }

        $Validator->required($req,$this->data);
        if ( $Validator->validate()){

            if (!Driver::driverAppLogin($token['username'],$this->data['current_pass'])){
                $this->msg=self::t("Current password is invalid");
                $this->output();
                Yii::app()->end();
            }
            $params=array(
                'password'=>md5($this->data['new_pass']),
                'date_modified'=>date('c'),
                'ip_address'=>$_SERVER['REMOTE_ADDR']
            );
            $db=new DbExt;
            if ( $db->updateData("{{driver}}",$params,'driver_id',$driver_id)){
                $this->code=1;
                $this->msg=self::t("Password Successfully Changed");
                $this->details=$this->data['new_pass'];
            } else $this->msg=self::t("Something went wrong please try again later");
        } else $this->msg=Driver::parseValidatorError($Validator->getError());
        $this->output();
    }

    public function actionSettingPush()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }
        $driver_id=$token['driver_id'];

        $params=array(
            'enabled_push'=>$this->data['enabled_push'],
            'date_modified'=>date('c'),
            'ip_address'=>$_SERVER['REMOTE_ADDR']
        );
        $db=new DbExt;
        if ( $db->updateData("{{driver}}",$params,'driver_id',$driver_id)){
            $this->code=1;
            $this->msg=self::t("Setting Saved");
        } else $this->msg=self::t("Something went wrong please try again later");
        $this->output();
    }

    public function actionGetSettings()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }
        $driver_id=$token['driver_id'];

        $lang=Driver::availableLanguages();
        $lang='';

        $resp=array(
            'enabled_push'=>$token['enabled_push'],
            'language'=>$lang
        );
        $this->code=1;
        $this->msg="OK";
        $this->details=$resp;
        $this->output();
    }

    public function actionLanguageList()
    {
        $final_list='';
        $lang=getOptionA('language_list');
        if(!empty($lang)){
            $lang=json_decode($lang,true);
        }
        if(is_array($lang) && count($lang)>=1){
            foreach ($lang as $lng) {
                $final_list[$lng]=$lng;
            }
            $this->code=1; $this->msg="OK";
        } else $this->msg=t("No language");
        $this->details=$final_list;
        $this->output();
    }

    public function actionGetAppSettings()
    {

        $translation=Driver::getMobileTranslation();
        $GPSSetting=Driver::getGPSSetting();
        $this->code=1;
        $this->msg="OK";
        $this->details=array(
            'notification_sound_url'=>Driver::moduleUrl()."/sound/food_song.mp3",
            'translation'=>$translation,
            'gps_setting'=>$GPSSetting
        );
        $this->output();
    }

    public function actionViewOrderDetails()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }
        $driver_id=$token['driver_id'];
        $order_id= $this->data['order_id'];

        $_GET['backend']='true';
        if ( $data=Yii::app()->functions->getOrder2($order_id)){
            //dump($data);
            $json_details=!empty($data['json_details'])?json_decode($data['json_details'],true):false;
            if ( $json_details !=false){
                Yii::app()->functions->displayOrderHTML(array(
                    'merchant_id'=>$data['merchant_id'],
                    'order_id'=>$order_id,
                    'delivery_type'=>$data['trans_type'],
                    'delivery_charge'=>$data['delivery_charge'],
                    'packaging'=>$data['packaging'],
                    'cart_tip_value'=>$data['cart_tip_value'],
                    'cart_tip_percentage'=>$data['cart_tip_percentage'],
                    'card_fee'=>$data['card_fee'],
                    'donot_apply_tax_delivery'=>$data['donot_apply_tax_delivery'],
                    'points_discount'=>isset($data['points_discount'])?$data['points_discount']:'' /*POINTS PROGRAM*/
                ),$json_details,true);
                $data2=Yii::app()->functions->details;
                unset($data2['html']);
                $this->code=1;
                $this->msg="OK";

                $admin_decimal_separator=getOptionA('admin_decimal_separator');
                $admin_decimal_place=getOptionA('admin_decimal_place');
                $admin_currency_position=getOptionA('admin_currency_position');
                $admin_thousand_separator=getOptionA('admin_thousand_separator');

                $data2['raw']['settings']=Driver::priceSettings();
                $data2['raw']['order_info']=array(
                    'order_id'=>$data['order_id'],
                    'order_change'=>$data['order_change'],
                );

                $this->details=$data2['raw'];

            } else $this->msg = self::t("Record not found");
        } else $this->msg = self::t("Record not found");
        $this->output();
    }

    public function actionGetNotifications()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }
        $driver_id=$token['driver_id'];
        if ( $res=Driver::getDriverNotifications($driver_id)) {
            $data='';
            foreach ($res as $val) {
                $val['date_created']=Driver::prettyDate($val['date_created']);
                //$val['date_created']=date("h:i:s",strtotime($val['date_created']));
                $data[]=$val;
            }
            $this->code=1;
            $this->msg="OK";
            $this->details=$data;
        } else $this->msg=self::t("No notifications");
        $this->output();
    }

    public function actionlocations()
    {

    }

    public function actionUpdateDriverLocation()
    {
        //demo
        //die();
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }

        $driver_id=$token['driver_id'];
        if (isset($this->data['remaks'])){
            $params=array(
                'location_lat'=>$this->data['lat'],
                'location_lng'=>$this->data['lng'],
                'remaks'=>$this->data['remaks'],
                'last_login'=>date('c'),
                'last_online'=>strtotime("now")
            );
        }else{
            $params=array(
                'location_lat'=>$this->data['lat'],
                'location_lng'=>$this->data['lng'],
                'last_login'=>date('c'),
                'last_online'=>strtotime("now")
            );
        }

        $db=new DbExt;
        if ( $db->updateData("{{driver}}",$params,'driver_id',$driver_id)){
            $this->code=1;
            $this->msg="Location set";
            $this->details=date("m/d/Y h:i:s",strtotime("now"));

            if (isset($this->data['task_id'])){
                $task_id=$this->data['task_id'];
                $task_info=Driver::getTaskId($task_id);
                if(!$task_info){
                    Yii::app()->end();
                }

                $params_history='';
                $params_history['ip_address']=$_SERVER['REMOTE_ADDR'];
                $params_history['date_created']=date('c');
                $params_history['task_id']=$task_id;
                $params_history['driver_id']=$driver_id;
                $params_history['driver_location_lat']=isset($token['location_lat'])?$token['location_lat']:'';
                $params_history['driver_location_lng']=isset($token['location_lng'])?$token['location_lng']:'';

                // insert history
                $db->insertData("{{driver_log}}",$params_history);

            }

        } else $this->msg="Failed";
        $this->output();
    }

    public function actionAPIUpdateLocation()
    {
        if ( !$token=Driver::getDriverByToken($_POST['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }
        $driver_id=$token['driver_id'];

        $DSpeed = "0";
        if(isset($_POST['speed'])){
            $DSpeed = $_POST['speed'];
        }
        $params=array(
            'location_lat'=>$_POST['lat'],
            'location_lng'=>$_POST['lng'],
            'last_login'=>date('c'),
            'last_online'=>strtotime("now"),
            'speed'=>$DSpeed
        );

        $db=new DbExt;
        if ( $db->updateData("{{driver}}",$params,'driver_id',$driver_id)){
            $this->code=1;
            $this->msg="Location set";
            $this->details=date("m/d/Y h:i:s",strtotime("now"));

            if (isset($_POST['task_id'])){
                $task_id=$_POST['task_id'];
                $task_info=Driver::getTaskId($task_id);
                if(!$task_info){
                    Yii::app()->end();
                }

                $params_history='';
                $params_history['ip_address']=$_SERVER['REMOTE_ADDR'];
                $params_history['date_created']=date('c');
                $params_history['task_id']=$task_id;
                $params_history['driver_id']=$driver_id;
                $params_history['driver_location_lat']=isset($token['location_lat'])?$token['location_lat']:'';
                $params_history['driver_location_lng']=isset($token['location_lng'])?$token['location_lng']:'';
                $params_history['speed']=$DSpeed;

                // insert history
                $db->insertData("{{driver_log}}",$params_history);

            }
        } else $this->msg="Failed";
        $this->output();
    }

    public function actionClearNofications()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }
        $driver_id=$token['driver_id'];
        $stmt="UPDATE 
    	{{driver_pushlog}}
    	SET
    	is_read='1'
    	WHERE
    	driver_id=".self::q($driver_id)."
    	AND
    	is_read='2'
    	";
        $this->code=1;
        $this->msg="OK";
        $db=new DbExt;
        $db->qry($stmt);
        $this->output();
    }

    public function actionLogout()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }
        $driver_id=$token['driver_id'];
        $params=array(
            'last_online'=>time() - 300,
            'ip_address'=>$_SERVER['REMOTE_ADDR']
        );

        $db=new DbExt;
        $db->updateData('{{driver}}',$params,'driver_id',$driver_id);
        $this->code=1;
        $this->msg="OK";
        $this->output();
    }

    public function actionUploadProfile()
    {
        if ( !$token=Driver::getDriverByToken($_REQUEST['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }
        $driver_id=$token['driver_id'];

        if ($_FILES["file"]["error"] > 0) {

            $this->msg=self::t("Failed cannot upload files with errors more than ". $_FILES["file"]["error"] . ".");

        } else {

            $path_to_upload=Yii::getPathOfAlias('webroot')."/upload/photo";
            if (!file_exists($path_to_upload)){
                if (!@mkdir($path_to_upload,0777)){
                    $this->msg=self::t("Failed cannot create folder"." ".$path_to_upload);
                    Yii::app()->end();
                }
            }

            $allowed_exts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);

            if (in_array($extension, $allowed_exts)){
                $filename=$_FILES["file"]["name"];
            }else{
                $filename=$_FILES["file"]["name"].".jpg";
            }

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $path_to_upload."/".rawurldecode($filename))){

                $params=array(
                    'photo_profile'=>rawurldecode($filename),
                    'date_modified'=>date('c'),
                    'ip_address'=>$_SERVER['REMOTE_ADDR']
                );

                $db=new DbExt;
                if ($db->updateData("{{driver}}",$params,'driver_id',$driver_id)){
                    $this->code=1;
                    $this->msg="Successful";
                    $this->details=Driver::uploadURL()."/photo/".rawurldecode($filename);;
                } else $this->msg=self::t("Something went wrong please try again later");
            }
            else{
                $this->msg=self::t("Failed cannot upload file"." ".$filename);
                Yii::app()->end();
            }
        }
        $this->output();

    }

    public function actionUploadTaskPhoto()
    {
        if ( !$token=Driver::getDriverByToken($_REQUEST['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }
        $driver_id=$token['driver_id'];

        if ($_FILES["file"]["error"] > 0) {

            $this->msg=self::t("Failed cannot upload files with errors more than ". $_FILES["file"]["error"] . ".");

        } else {

            $path_to_upload=Yii::getPathOfAlias('webroot')."/upload/photo";
            if (!file_exists($path_to_upload)){
                if (!@mkdir($path_to_upload,0777)){
                    $this->msg=self::t("Failed cannot create folder"." ".$path_to_upload);
                    Yii::app()->end();
                }
            }

            $allowed_exts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);

            if (in_array($extension, $allowed_exts)){
                $filename=$_REQUEST['task_id']."_".$_FILES["file"]["name"];
            }else{
                $filename=$_REQUEST['task_id']."_".$_FILES["file"]["name"].".jpg";
            }

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $path_to_upload."/".rawurldecode($filename))){

                $params=array(
                    'date_modified'=>date('c'),
                    'ip_address'=>$_SERVER['REMOTE_ADDR']
                );

                $task_id=$_REQUEST['task_id'];
                $driver_name=$token['first_name'] ." " .$token['last_name'];

                $db=new DbExt;

                $task_info=Driver::getTaskId($task_id);
                if(!$task_info){
                    $this->msg=self::t("Task not found");
                    $this->output();
                    Yii::app()->end();
                }

                if ( $db->updateData("{{driver_task}}",$params,'task_id',$task_id)){
                    $this->code=1;
                    $this->msg="Successful";
                    $this->details=$_REQUEST['task_id'];

                    $remarks=Driver::driverStatusPretty($driver_name,'photo');
                    $params_history=array(
                        'status'=>'photo',
                        'remarks'=>$remarks,
                        'date_created'=>date('c'),
                        'ip_address'=>$_SERVER['REMOTE_ADDR'],
                        'task_id'=>$task_id,
                        'photo_name'=>rawurldecode($filename) ,
                        'driver_id'=>$driver_id,
                        'driver_location_lat'=>isset($token['location_lat'])?$token['location_lat']:'',
                        'driver_location_lng'=>isset($token['location_lng'])?$token['location_lng']:''
                    );
                    $db->insertData("{{task_history}}",$params_history);

                } else $this->msg=self::t("Something went wrong please try again later");
            }
            else{
                $this->msg=self::t("Failed cannot upload file"." ".$filename);
                Yii::app()->end();
            }

        }

        $this->output();

    }

    public function actiongetTaskPhoto()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }

        if (isset($this->data['task_id'])){
            if ( $res=Driver::getDriverTaskViewHistory($this->data['task_id'],'photo') ){

                $this->code=1;
                $this->msg=self::t("Successful");

                $data='';
                foreach ($res as $val) {

                    $val['photo_url']='';
                    if (!empty($val['photo_name'])){
                        $val['photo_url']=Driver::uploadURL()."/photo/".$val['photo_name'];
                        if (!file_exists(Driver::uploadPath()."/photo/".$val['photo_name'])){
                            $val['photo_url']='';
                        }
                    }

                    $data[]=$val;
                }

                $this->details=$data;
            } else $this->msg=self::t("Task not found");
        } else $this->msg=self::t("Task id is missing");
        $this->output();

    }

    public function actiondeletePhoto()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }

        if (isset($this->data['task_id'])){
            if (isset($this->data['id'])){
                if ( $res=Driver::getDriverTaskViewHistory($this->data['task_id'],'photo',$this->data['id']) ){

                    $this->code=1;
                    $this->msg="OK";

                    if (!empty($res['photo_name'])){
                        if (file_exists(Driver::uploadPath()."/photo/".$res['photo_name'])){
                            /* Now process delete data */
                            if(unlink(Driver::uploadPath()."/photo/".$res['photo_name'])){
                                $this->msg="success delete file..";
                            } else {
                                $this->msg="failed delete file..";
                            }
                        }
                    }

                    $stmt="DELETE FROM {{task_history}} WHERE task_id=".self::q($this->data['task_id'])." AND id=".self::q($this->data['id'])."";

                    $db=new DbExt;
                    $db->qry($stmt);

                } else $this->msg=self::t("Task not found");
            } else $this->msg=self::t("ID is missing");
        } else $this->msg=self::t("Task id is missing");
        $this->output();
    }

    public function actionloadNotes()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }

        if (isset($this->data['task_id'])){
            if ( $res=Driver::getDriverTaskViewHistory($this->data['task_id'],'notes') ){
                $this->code=1;
                $this->msg=self::t("Successful");

                $data='';
                foreach ($res as $val) {

                    $val['status_raw']=$val['status'];

                    $data[]=$val;
                }

                $this->details=$data;
            } else $this->msg=self::t("Notes not found");
        } else $this->msg=self::t("Task id is missing");
        $this->output();
    }

    public function actiondeleteNotes()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }

        if (isset($this->data['task_id'])){
            if (isset($this->data['id'])){
                if ( $res=Driver::getDriverTaskViewHistory($this->data['task_id'],'notes',$this->data['id']) ){

                    $this->code=1;
                    $this->msg="OK";

                    $stmt="DELETE FROM {{task_history}} WHERE task_id=".self::q($this->data['task_id'])." AND id=".self::q($this->data['id'])."";

                    $db=new DbExt;
                    $db->qry($stmt);

                } else $this->msg=self::t("Task not found");
            } else $this->msg=self::t("ID is missing");
        } else $this->msg=self::t("Task id is missing");
        $this->output();
    }

    public function actionaddNotes()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }
        $driver_id=$token['driver_id'];

        if (isset($this->data['task_id'])){
            if ( $res=Driver::getTaskId($this->data['task_id']) ){
                //check task belong to insert Notes
                if($res['status']=='successful'){
                    $this->msg=Driver::t("Sorry but this task is already been successful..");
                    $this->output();
                    Yii::app()->end();
                }

                $params=array(
                    'date_modified'=>date('c'),
                    'ip_address'=>$_SERVER['REMOTE_ADDR']
                );

                $driver_name=$token['first_name'] ." " .$token['last_name'];

                $db=new DbExt;

                $task_id=$this->data['task_id'];

                if ( $db->updateData("{{driver_task}}",$params,'task_id',$task_id)){

                    $this->code=1;
                    $this->msg="Successful";
                    $this->details=array(
                        'task_id'=>$this->data['task_id'],
                        'driver_id'=>$driver_id
                    );

                    $remarks=Driver::driverStatusPretty($driver_name,'notes');
                    $params_history=array(
                        'status'=>'notes',
                        'remarks'=>$remarks,
                        'date_created'=>date('c'),
                        'ip_address'=>$_SERVER['REMOTE_ADDR'],
                        'task_id'=>$task_id,
                        'notes'=>$this->data['notes'],
                        'driver_id'=>$driver_id,
                        'driver_location_lat'=>isset($token['location_lat'])?$token['location_lat']:'',
                        'driver_location_lng'=>isset($token['location_lng'])?$token['location_lng']:''
                    );
                    $db->insertData("{{task_history}}",$params_history);

                } else $this->msg=self::t("Something went wrong please try again later");

            } else $this->msg=self::t("Task not found");
        } else $this->msg=self::t("Task id is missing");
        $this->output();
    }

    public function actionupdateNotes()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }

        if (isset($this->data['task_id'])){
            if (isset($this->data['id'])){
                if ( $res=Driver::getDriverTaskViewHistory($this->data['task_id'],'notes',$this->data['id']) ){

                    $params=array(
                        'notes'=>$this->data['notes']
                    );

                    $db=new DbExt;

                    if ( $db->updateData("{{task_history}}",$params,'id',$this->data['id'])){
                        $this->code=1;
                        $this->msg="Notes updated";
                        $this->details=array(
                            'task_id'=>$this->data['task_id'],
                            'driver_id'=>$token['driver_id']
                        );
                    } else $this->msg=self::t("Something went wrong please try again later");

                } else $this->msg=self::t("Task not found");
            } else $this->msg=self::t("ID is missing");
        } else $this->msg=self::t("Task id is missing");
        $this->output();
    }

    public function actioncreateTaskNew()
    {
        if ( !$token=Driver::getDriverByToken($this->data['token'])) {
            $this->msg=self::t("Token not valid");
            $this->output();
            Yii::app()->end();
        }
        $driver_id=$token['driver_id'];

        $DbExt=new DbExt;

        $params=array(
            'task_description'=>isset($this->data['task_description'])?$this->data['task_description']:'@Auto Generate Task',
            'trans_type'=>isset($this->data['trans_type'])?$this->data['trans_type']:'delivery',
            'contact_number'=>isset($this->data['contact_number'])?$this->data['contact_number']:'',
            'email_address'=>isset($this->data['email_address'])?$this->data['email_address']:'',
            'customer_name'=>isset($this->data['customer_name'])?$this->data['customer_name']:'',
            'delivery_date'=>date('c'),
            'delivery_address'=>isset($this->data['delivery_address'])?$this->data['delivery_address']:'',
            'team_id'=>$token['team_id'],
            'driver_id'=>$driver_id,
            'task_lat'=>isset($this->data['task_lat'])?$this->data['task_lat']:'',
            'task_lng'=>isset($this->data['task_lng'])?$this->data['task_lng']:'',
            'date_created'=>date('c'),
            'ip_address'=>$_SERVER['REMOTE_ADDR'],
            'customer_id'=>$token['customer_id'],
            'task_token'=>Driver::random_string(10)
        );

        if(!empty($params['delivery_date'])){
            $params['delivery_date']= date("Y-m-d G:i",strtotime($params['delivery_date']));
        }
        if($params['driver_id']>0){
            $params['status']='assigned';
        }

        if($DbExt->insertData("{{driver_task}}",$params)){
            $task_id=Yii::app()->db->getLastInsertID();
            $this->code=1;
            $this->msg=Driver::t("Successful");

            // send notification to driver
            if ($info=Driver::getTaskId($task_id)){
                Driver::sendDriverNotification('ASSIGN_TASK',$info);
            }

            $this->details='getTodayTask';

        } else $this->msg=Driver::t("failed cannot insert record");

        $this->output();
    }
} /*end class*/