<?php
$db=new DbExt;

/*error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);*/

if(isset($_SESSION['kt_export_stmt'])){
	$stmt=$_SESSION['kt_export_stmt'];	
	
	$pos=strpos($stmt,"LIMIT");
	$stmt=substr($stmt,0,$pos);
		
	//dump($stmt);
	$feed_data='';
	$filename=isset($_GET['filename'])?$_GET['filename']:'';
	
	switch ($filename) {
		
		case "customer_signup":
			
			$header=array(
		     t("ID"),
		     t("Name"),
		     t("Mobile number"),
		     t("Email address"),	    			    
		     t("Plan"),
		     t("Status"),
		     t("Date"),
		    );
		    			
			if($res=$db->rst($stmt)){
				foreach ($res as $val) {
					$feed_data[]=array(
					  $val['customer_id'],
					  $val['first_name']." ".$val['last_name'],
					  $val['mobile_number'],
					  $val['email_address'],
					  $val['plan_name'],				  
					  $val['status'],
					  AdminFunctions::prettyDate($val['date_created'])				  
					);
				}								
			}
			$filename = $filename.'-'. date('Ymd') .'.csv';    	    
	    	$excel  = new ExcelFormat($filename);
	    	$excel->addHeaders($header);
            $excel->setData($feed_data);	  
            $excel->prepareExcel();	
            Yii::app()->end();                     
			break;
	
		case "sales_report":	
		
		    $header=array(
		     t("Date"),
		     t("Trans Type"),
		     t("Payment Provider"),
		     t("Memo"),	    			    
		     t("Total"),
		     t("Transaction Ref")		     
		    );
		    			
			if($res=$db->rst($stmt)){
				foreach ($res as $val) {
					$feed_data[]=array(
					   AdminFunctions::prettyDate($val['date_created']),
					  $val['transaction_type'],
					  AdminFunctions::prettyGateway($val['payment_provider']),
					  $val['memo'],
					  prettyPrice($val['total_paid']),
					  $val['transaction_ref'],
					);
				}								
			}
			$filename = $filename.'-'. date('Ymd') .'.csv';    	    
	    	$excel  = new ExcelFormat($filename);
	    	$excel->addHeaders($header);
            $excel->setData($feed_data);	  
            $excel->prepareExcel();	
            Yii::app()->end();                     
			break;
		   
		case "sms_logs":	
		
		   $header=array(
		     t("Date"),
		     t("Mobile number"),
		     t("SMS"),
		     t("Provider"),	    			    
		     t("Status"),		     
		    );
		    			
			if($res=$db->rst($stmt)){
				foreach ($res as $val) {
					$feed_data[]=array(
					   AdminFunctions::prettyDate($val['date_created']),
				       $val['to_number'],
				       $val['sms_text'],
				       $val['provider'],
				       $val['msg'],
					);
				}								
			}
			$filename = $filename.'-'. date('Ymd') .'.csv';    	    
	    	$excel  = new ExcelFormat($filename);
	    	$excel->addHeaders($header);
            $excel->setData($feed_data);	  
            $excel->prepareExcel();	
            Yii::app()->end();                     
			break;
			
		case "email_logs":	
		
		   $header=array(
		     t("Date"),
		     t("Email address"),
		     t("Subject"),
		     t("Content"),	    			    
		     t("Status"),		     
		    );
		    			
			if($res=$db->rst($stmt)){
				foreach ($res as $val) {
					$feed_data[]=array(
					      AdminFunctions::prettyDate($val['date_created']),
						  $val['email_address'],
						  $val['subject'],
						  $val['content'],
						  $val['status']
					);
				}								
			}
			$filename = $filename.'-'. date('Ymd') .'.csv';    	    
	    	$excel  = new ExcelFormat($filename);
	    	$excel->addHeaders($header);
            $excel->setData($feed_data);	  
            $excel->prepareExcel();	
            Yii::app()->end();                     
			break;
		
		case "push_logs":	
		
		   $header=array(
		     t("Date"),
		     t("Device"),
		     t("Device ID"),
		     t("Push Title"),	    			    
		     t("Content"),	    			    
		     t("Type"),	    			    
		     t("Status"),		     
		    );
		    			
			if($res=$db->rst($stmt)){
				foreach ($res as $val) {
					$feed_data[]=array(
					      AdminFunctions::prettyDate($val['date_created']),
						  $val['device_platform'],
						  $val['device_id'],
						  $val['push_title'],
						  $val['push_message'],
						  $val['push_type'],
						  $val['status']
					);
				}								
			}
			$filename = $filename.'-'. date('Ymd') .'.csv';    	    
	    	$excel  = new ExcelFormat($filename);
	    	$excel->addHeaders($header);
            $excel->setData($feed_data);	  
            $excel->prepareExcel();	
            Yii::app()->end();                     
			break;

        case "report":
            $header=array(
                t("Task ID"),
                t("Status"),
                t("Description"),
                t("Type"),
                t("Customer Name"),
                t("Contact Number"),
                t("Email Address"),
                t("Delivery Date"),
                t("Delivery Address"),
                t("Date Created"),
                t("Driver Name"),
                t("Accept"),
                t("Start"),
                t("Arrived"),
                t("Successful"),
                t("Duration"),
                t("Mileage")
            );

            $start_date = $_GET['start_date'];
            $end_date = $_GET['end_date'];
            $team = $_GET['team_selection'];
            $driver = $_GET['driver_selection'];
            $and='';
            $start='';
            $end='';
            $query='';

            switch ($_GET['time_selection'])
            {
                case 'week':
                    $start= date('Y-m-d', strtotime("-7 day") );
                    $end=date("Y-m-d", strtotime("+1 day"));
                    $and.= " AND delivery_date BETWEEN '$start' AND '$end' ";
                    break;

                case 'month':
                    $start= date('Y-m-d', strtotime("-30 day") );
                    $end=date("Y-m-d", strtotime("+1 day"));
                    $and.= " AND delivery_date BETWEEN '$start' AND '$end' ";
                    break;

                case 'custom':
                    $and.= " AND delivery_date BETWEEN '$start_date' AND '$end_date' ";
                    break;

                default:
                    break;
            }

            if ($team>0){
                $and.=" AND team_id=".Driver::q($team)." ";
            }
            if($driver>0){
                $and.=" AND driver_id=".Driver::q($driver)." ";
            }

            $and.=" AND driver_id <>'' ";

            $stmt="
			SELECT task_id,
			(
			  select concat(first_name,' ',last_name)
			  from
			  {{driver}}
			  where
			  driver_id=a.driver_id
			) as driver_name,task_description,
			trans_type,delivery_date,delivery_address
			FROM {{driver_task}} a
			WHERE customer_id=".Driver::q(Driver::getUserId())."
			$and
			ORDER BY delivery_date ASC
			";

            $totalWaktu='';

            if($result=$db->rst($stmt)){
                foreach ($result as $val) {
                    if ( $res=Driver::getTaskId($val['task_id'])){

                        $res['accept']='';
                        $res['start']='';
                        $res['arrived']='';
                        $res['successful']='';
                        $res['duration']='';
                        $res['mileage']='';

                        $history_details='';
                        if($history_details = Driver::getTaskHistory($res['task_id'])){
                            $datecreate = strtotime($res['date_created']);
                            $datetime = strtotime($res['date_created']);
                            $starttask='';

                            foreach ($history_details as $valh){
                                /* get diff time */
                                $betweentime='';

                                switch ($valh['status'])
                                {
                                    case "acknowledged":
                                        $starttask=strtotime($valh['date_created']);
                                        $res['accept']=Yii::app()->functions->FormatDateTime($valh['date_created']);
                                        break;

                                    case "started":
                                        $res['start']=Yii::app()->functions->FormatDateTime($valh['date_created']);
                                        break;

                                    case "inprogress":
                                        $res['arrived']=Yii::app()->functions->FormatDateTime($valh['date_created']);
                                        break;

                                    case "successful":
                                        $res['successful']=Yii::app()->functions->FormatDateTime($valh['date_created']);
                                        break;

                                    default:
                                        break;
                                }

                                if(!empty($datetime)){
                                    $create_history=strtotime($valh['date_created']);

                                    if($valh['status']=="successful"){
                                        if(!empty($starttask)){
                                            $betweentime=Driver::getBetweenTime($starttask,$create_history);
                                            $totalWaktu += Driver::getBetweenDate($starttask,$create_history);
                                        } else {
                                            $betweentime=Driver::getBetweenTime($datecreate,$create_history);
                                            $totalWaktu += Driver::getDay($starttask,$create_history);
                                        }

                                        $res['duration']=$betweentime;
                                    } else {
                                        $betweentime=Driver::getBetweenTime($datetime,$create_history);
                                    }
                                }

                                $datetime=strtotime($valh['date_created']);

                                $valh['between_time']=$betweentime;
                            }

                            $trip_details=''; $trip_data='';
                            $startlong = ''; $finishlong = '';
                            if($trip_details = Driver::getTaskTrip($res['task_id'])){
                                $totalMileage=0;
                                for($r = 0; $r < count($trip_details)-1; ++$r) {
                                    /*$totalMileage += Driver::get_distance();*/
                                    $totalMileage += (round(Driver::get_distance($trip_details[$r]['driver_location_lat'],$trip_details[$r+1]['driver_location_lat'],$trip_details[$r]['driver_location_lng'],$trip_details[$r+1]['driver_location_lng']),2));
                                }
                                $res['mileage']=$totalMileage.' Km';
                            }

                        }

                        $feed_data[]=array(
                            $res['task_id'],
                            $res['status'],
                            $res['task_description'],
                            $res['trans_type'],
                            $res['customer_name'],
                            $res['contact_number'],
                            $res['email_address'],
                            Yii::app()->functions->FormatDateTime($res['delivery_date']),
                            $res['delivery_address'],
                            Yii::app()->functions->FormatDateTime($res['date_created']),
                            $res['driver_name'],
                            $res['accept'],
                            $res['start'],
                            $res['arrived'],
                            $res['successful'],
                            $res['duration'],
                            $res['mileage']
                        );
                    }
                }

                $feed_data[]=array(
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    'Total',
                    Driver::getBetweenValue($totalWaktu),
                    ''
                );
            }

            $filename = $filename.'-'. date('YmdHis') .'.csv';
            $excel  = new ExcelFormat($filename);
            $excel->addHeaders($header);
            $excel->setData($feed_data);
            $excel->prepareExcel();
            Yii::app()->end();
            break;

		default:
			break;
	}
}