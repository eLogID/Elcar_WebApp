<?php
/**
 * Created by IntelliJ IDEA.
 * User: isnaeni.hidayat
 * Date: 4/1/2017
 * Time: 11:05 AM
 */
Class ViewerFunctions
{
    public static function t($message='')
    {
        return Yii::t("default",$message);
    }

    public static function assetsUrl()
    {
        return Yii::app()->baseUrl.'/assets';
    }

    public static function q($data)
    {
        return Yii::app()->db->quoteValue($data);
    }

    public static function getUserId()
    {
        if (self::islogin()){
            return $_SESSION['elcar_viewer']['customer_id'];
        }
        return false;
    }

    public static function islogin()
    {
        if(isset($_SESSION['elcar_viewer'])){
            if(is_numeric($_SESSION['elcar_viewer']['viewer_id'])){
                return true;
            }
        }
        return false;
    }

    public static function Login($username='', $password='')
    {
        $db=new DbExt;

        $stmt="SELECT * FROM
		{{viewer}}
		WHERE
		username=".self::q($username)."
		AND
		password=".self::q(md5($password))."
		LIMIT 0,1
		";

        if ( $res=$db->rst($stmt)){
            return $res[0];
        }
        return false;
    }

    public static function getUserLogin($user_id='', $customer_id='')
    {
        $db=new DbExt;

        $and='';
        if($customer_id!='0' || $customer_id != 0){
            $and=" AND customer_id=".self::q($customer_id)." ";
        }

        $stmt="SELECT * FROM
		{{viewer}}
		WHERE
		viewer_id=".self::q($user_id)."
		$and
		LIMIT 0,1
		";

        if ( $res=$db->rst($stmt)){
            return $res[0];
        }
        return false;
    }

    public static function getTaskByStatus($customer_id='',$status='',$date='')
    {
        $where='';
        if($customer_id!='0' || $customer_id!=0){
            $where =" WHERE customer_id =".self::q($customer_id)." ";
        }

        $and_date='';
        if (!empty($date)){
            if(empty($where)){
                $and_date=" WHERE delivery_date LIKE '".$date."%' ";
            }else{
                $and_date=" AND delivery_date LIKE '".$date."%' ";
            }
        }

        switch ($status) {
            case "unassigned":
                $where_status="AND status IN ('declined','unassigned')";
                break;

            case "assigned":
                $where_status="AND status IN ('assigned','started','inprogress','acknowledged')";
                break;

            case "completed":
                $where_status="AND status IN ('successful','failed','cancelled','canceled')";
                break;

            default:
                $where_status="AND status =".self::q($status)."";
                break;
        }

        $db=new DbExt;
        $db->qry("SET SQL_BIG_SELECTS=1");
        $stmt="
		SELECT * FROM
		{{driver_task_view}}		
		$where		
		$and_date
		$where_status
		ORDER BY task_id DESC
		";

        if($res=$db->rst($stmt)){
            //dump($res);
            return $res;
        }
        return false;
    }

    public static function getDriverByStats($customer_id='',$stats='',$transaction_date='',
                                            $driver_status='active' , $team_id='')
    {

        $db=new DbExt;
        $todays_date=date('Y-m-d');
        $time_now = time() - 200;
        $and='';

        if($customer_id!='0' || $customer_id!=0){
            $and =" WHERE customer_id =".self::q($customer_id)." ";
        }

        if(empty($and)){
            $and .=" WHERE status=".self::q($driver_status)." ";
        }else{
            $and .=" AND status=".self::q($driver_status)." ";
        }

        switch ($stats) {
            case "active":
                $and.=" AND on_duty ='1' ";
                $and.=" AND last_online >='$time_now' ";
                $and.=" AND last_login like '".$todays_date."%'";
                break;

            case "offline":
                $date_now=date("now",strtotime('-6 minutes'));
                $and.=" AND last_online <='$time_now' ";
            default:

                break;
        }

        if ($team_id>0){
            $and.=" AND team_id=".self::q($team_id)." ";
        }

        $stmt="
		SELECT a.*,
		(
		  select count(*)
		  from
		  {{driver_task}}
		  where
		  driver_id=a.driver_id
		  and 
		  delivery_date like '".$transaction_date."%'
		) as total_task
		FROM
		{{driver}} a
		$and
		ORDER BY first_name ASC
		";

        //dump($stmt);

        if ( $res = $db->rst($stmt)){
            $data='';
            foreach ($res as $val) {
                $val['is_online']=2;
                $last_login=date('Y-m-d',strtotime($val['last_login']));
                if ( $last_login==$todays_date && $val['on_duty']==1){
                    if ( $val['last_online']>=$time_now){
                        $val['is_online']=1;
                    }
                }
                $data[]=$val;
            }
            return $data;
        }
        return false;
    }

    public static function getDriverList($customer_id='', $driver_status='active')
    {

        $db=new DbExt;
        $todays_date=date('Y-m-d');
        $time_now = time() - 200;
        $and='';

        if($customer_id!='0' || $customer_id!=0){
            $and =" WHERE customer_id =".self::q($customer_id)." ";
        }

        if(empty($and)){
            $and .=" WHERE status=".self::q($driver_status)."";
        }else{
            $and .=" AND status=".self::q($driver_status)."";
        }

        $stmt="
		SELECT a.*,
		(
		  select count(*)
		  from
		  {{driver_task}}
		  where
		  driver_id=a.driver_id
		) as total_task
		FROM
		{{driver}} a
		$and
		ORDER BY first_name ASC
		";

        if ($res = $db->rst($stmt)){
            $data='';
            foreach ($res as $val) {
                $val['is_online']=2;
                $last_login=date('Y-m-d',strtotime($val['last_login']));
                if ($last_login==$todays_date && $val['on_duty']==1){
                    if ($val['last_online']>=$time_now){
                        $val['is_online']=1;
                    }
                }
                $data[]=$val;
            }
            return $data;
        }
        return false;
    }

    public static function formatTask($data='')
    {
        if (is_array($data) && count($data)>=1){
            ob_start();

            $photo_url=Yii::app()->getBaseUrl(true).'/assets/images/no-avatar.jpg';
            if (!empty($data['photo_profile'])){
                $photo_url=Driver::uploadURL()."/photo/".rawurldecode($data['photo_profile']);
                if (!file_exists(Driver::uploadPath()."/photo/".rawurldecode($data['photo_profile']))){
                    $photo_url=Yii::app()->getBaseUrl(true).'/assets/images/no-avatar.jpg';
                }
            }
            ?>
            <div class="col-lg-3">
                <div class="contact-box center-version">

                    <a href="#">
                        <img alt="image" class="img-circle" src="<?php echo $photo_url?>">

                        <h3 class="m-b-xs"><strong><?php echo $data['first_name'].' '.$data['last_name']?></strong></h3>
                        <div class="font-bold"><?php echo $data['total_task'].' Task'?></div>
                        <address class="m-t-md">
                            Device: <strong><?php echo $data['device_platform']?></strong><br>
                            <?php echo $data['transport_description']?><br>
                            License Plat: <?php echo $data['licence_plat']?><br>
                            <abbr title="Phone">P:</abbr> <?php echo $data['phone']?>
                        </address>

                    </a>
                    <div class="contact-box-footer">
                        <div class="m-t-xs btn-group">
                            <a class="btn btn-xs btn-white" href="tel:<?php echo $data['phone']?>"><i class="fa fa-phone"></i> Call </a>
                            <a class="btn btn-xs btn-white" href="mailto:<?php echo $data['email']?>"><i class="fa fa-envelope"></i> Email</a>
                        </div>
                    </div>

                </div>
            </div>
            <?php
            $forms = ob_get_contents();
            ob_end_clean();
            return $forms;
        }
    }
}