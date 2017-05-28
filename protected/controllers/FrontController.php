<?php
if (!isset($_SESSION)) { session_start(); }

class FrontController extends CController
{
	
	public $layout='front_layout';	
	public $body_class='';
	public $action_name='';
	public $data='';
	
	public function init()
	{
        $this->data=$_GET;

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
		$action_name=$action->id ;

		if($action_name=="index"){
            $this->body_class="";
        }else{
            $this->body_class="page-$action_name";
        }
		
		ScriptManageFront::scripts();
		
		$cs = Yii::app()->getClientScript();
		$jslang=json_encode(AdminFunctions::jsLang());
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
		
		$language=Yii::app()->language;
		$cs->registerScript(
		  'language',
		 "var language='$language';",
		  CClientScript::POS_HEAD
		);

		if($action_name=='track') $this->layout='';

		if(isset($_GET['id'])){
            if(is_numeric($_GET['task_id'])){

                if($res=FrontFunctions::getTaskView($_GET['id'],$_GET['task_id'])){

                    $default_country=Yii::app()->functions->getOption('drv_default_location' , $res['customer_id'] );
                    if(empty($default_country)){
                        $default_country='ID';
                    }
                    $cs->registerScript(
                        'default_country',
                        "var default_country='$default_country';",
                        CClientScript::POS_HEAD
                    );

                    $task_id=$_GET['id'];
                    $cs->registerScript(
                        'task_id',
                        "var task_id='$task_id';",
                        CClientScript::POS_HEAD
                    );

                    if(!empty($res['task_lat'])){
                        $task_lat=$res['task_lat'];
                    } else $task_lat=-0.789275;

                    $cs->registerScript(
                        'task_lat',
                        "var task_lat='$task_lat';",
                        CClientScript::POS_HEAD
                    );
                    if(!empty($res['task_lng'])){
                        $task_lng=$res['task_lng'];
                    } else $task_lng=113.921327;

                    $cs->registerScript(
                        'task_lng',
                        "var task_lng='$task_lng';",
                        CClientScript::POS_HEAD
                    );

                    if(!empty($res['delivery_address'])){
                        $delivery_address='<p>'.$res['delivery_address'].'</p><p class="text-muted">Delivery address</p>';
                    } else $delivery_address='<p class="text-muted">Delivery address</p>';

                    $cs->registerScript(
                        'delivery_address',
                        "var delivery_address='$delivery_address';",
                        CClientScript::POS_HEAD
                    );

                    $icon_driver=Yii::app()->baseUrl.'/assets/images/red.png';
                    $icon_finish=Yii::app()->baseUrl.'/assets/images/orange-dot.png';

                    $cs->registerScript(
                        'icon_driver',
                        "var icon_driver='$icon_driver';",
                        CClientScript::POS_HEAD
                    );

                    $cs->registerScript(
                        'icon_finish',
                        "var icon_finish='$icon_finish';",
                        CClientScript::POS_HEAD
                    );

                    if(!empty($res['trans_type'])){
                        $trans_type=$res['trans_type'];
                    } else $trans_type='';

                    $cs->registerScript(
                        'trans_type',
                        "var trans_type='$trans_type';",
                        CClientScript::POS_HEAD
                    );

                    if(!empty($res['driver_id'])){
                        $driver_id=$res['driver_id'];
                    } else $driver_id='';

                    $cs->registerScript(
                        'driver_id',
                        "var driver_id='$driver_id';",
                        CClientScript::POS_HEAD
                    );

                    if(!empty($res['driver_name'])){
                        $driver_name=$res['driver_name'];
                    } else $driver_name='';

                    $cs->registerScript(
                        'driver_name',
                        "var driver_name='$driver_name';",
                        CClientScript::POS_HEAD
                    );

                    if(!empty($res['driver_phone'])){
                        $driver_phone=$res['driver_phone'];
                    } else $driver_phone='';

                    $cs->registerScript(
                        'driver_phone',
                        "var driver_phone='$driver_phone';",
                        CClientScript::POS_HEAD
                    );

                    if(!empty($res['driver_email'])){
                        $driver_email=$res['driver_email'];
                    } else $driver_email='';

                    $cs->registerScript(
                        'driver_email',
                        "var driver_email='$driver_email';",
                        CClientScript::POS_HEAD
                    );

                    if(!empty($res['driver_location_lat'])){
                        $driver_location_lat=$res['driver_location_lat'];
                    } else $driver_location_lat='';

                    $cs->registerScript(
                        'driver_location_lat',
                        "var driver_location_lat='$driver_location_lat';",
                        CClientScript::POS_HEAD
                    );

                    if(!empty($res['driver_location_lng'])){
                        $driver_location_lng=$res['driver_location_lng'];
                    } else $driver_location_lng='';

                    $cs->registerScript(
                        'driver_location_lng',
                        "var driver_location_lng='$driver_location_lng';",
                        CClientScript::POS_HEAD
                    );

                    $driver_info_window='<p>'.$res['driver_name'].'</p><p>Your Agent</p>';
                    $cs->registerScript(
                        'driver_info_window',
                        "var driver_info_window='$driver_info_window';",
                        CClientScript::POS_HEAD
                    );

                    $travel_mode='driving';
                    $cs->registerScript(
                        'travel_mode',
                        "var travel_mode='$travel_mode';",
                        CClientScript::POS_HEAD
                    );

                    $find_driver_label='Find agent';
                    $cs->registerScript(
                        'find_driver_label',
                        "var find_driver_label='$find_driver_label';",
                        CClientScript::POS_HEAD
                    );

                    $id_task=$_GET['task_id'];
                    $cs->registerScript(
                        'id_task',
                        "var id_task='$id_task';",
                        CClientScript::POS_HEAD
                    );

                }

            }
        }

        $baseUrl = Yii::app()->baseUrl."";
        $cs = Yii::app()->getClientScript();
        if($action_name=='index'){
            $cs->registerCssFile($baseUrl."/assets/css/styles.css?ver=1.0");
        }else{
            $cs->registerCssFile($baseUrl."/assets/front.css?ver=1.0");
            $cs->registerCssFile($baseUrl."/assets/front-responsive.css?ver=1.0");
        }

		return true;
	}
		
	public function actionIndex()
	{				
		$this->render('index',array(
		  'pricing'=>FrontFunctions::getPlans()
		));
	}
	
	public function actionPricing()
	{
		$exlude_free=isset($_GET['hash'])?true:false;		
		$this->render('pricing',array(
		  'data'=>FrontFunctions::getPlans($exlude_free),
		  'email'=>isset($_GET['email'])?$_GET['email']:'',
		  'hash'=>isset($_GET['hash'])?$_GET['hash']:''
		));
	}
	
	private function includeMaterial()
	{
		$cs = Yii::app()->getClientScript();
		$baseUrl = Yii::app()->baseUrl.""; 
		Yii::app()->clientScript->registerScriptFile(
        "//cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js",
		CClientScript::POS_END
		);			
		$cs->registerCssFile("//cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css");
        $cs->registerCssFile("//fonts.googleapis.com/icon?family=Material+Icons");		 
	}
	
	public function actionSignup()
	{
		if ( isset($_GET['plan_id'])){
			if(is_numeric($_GET['plan_id'])){
				
				$this->body_class.=" page-material";
				$this->includeMaterial();
				
				$this->render('signup',array(
				  'plan_id'=>$_GET['plan_id'],
				  'email_address'=>isset($_GET['email'])?$_GET['email']:''
				));
			} else  $this->redirect(Yii::app()->createUrl('/front/pricing'));
		} else $this->redirect(Yii::app()->createUrl('/front/pricing'));
	}
	
	public function actionVerification()
	{		
		if($res=FrontFunctions::getCustomerByToken($_GET['hash'])){		   
			
		   $this->body_class.=" page-material";
		   $this->includeMaterial();
		   
		   $this->render('verification',array(
		     'data'=>$res,
		     'verification_type'=>isset($_GET['type'])?$_GET['type']:''
		   ));
		} else $this->render('error',array(
		  'msg'=>t("token is invalid")
		));		
	}
	
	public function actionSignupTy()
	{
		if($res=FrontFunctions::getCustomerByToken($_GET['hash'])){		  
		   if(isset($_GET['needs_approval'])){
		   	  if($_GET['needs_approval']==1){
		   	  	 $client_id=$res['customer_id'];
		   	  	 $db=new DbExt;
		   	  	 $db->updateData("{{customer}}",array(
		   	  	   'needs_approval'=>1,
		   	  	   'date_modified'=>AdminFunctions::dateNow()
		   	  	 ),'customer_id',$client_id);
		   	  }
		   }
		   $this->render('signupty',array(
		     'needs_approval'=>isset($_GET['needs_approval'])?$_GET['needs_approval']:'',
		     'renew'=>isset($_GET['renew'])?$_GET['renew']:''
		   ));
		} else $this->render('error',array(
		  'msg'=>t("token is invalid")
		));		
	}
	
	public function actionPayment()
	{
		if($res=FrontFunctions::getCustomerByToken($_GET['hash'])){
			
		   /*update plan_renew_id */
		   if(isset($_GET['plan_id'])){
		   	  if(is_numeric($_GET['plan_id'])){
			   	  $db=new DbExt;
			   	  $db->updateData("{{customer}}",array('renew_plan_id'=>$_GET['plan_id']),
			   	  'customer_id',$res['customer_id']);		   	  
			   	  $res['plan_id']=$_GET['plan_id'];
		   	  }
		   }
			
		   $plan_id=$res['plan_id'];
		   $plan_details=FrontFunctions::getPlansByID($plan_id);
		   $this->body_class.=" page-material";
		   $this->includeMaterial();
		   $this->render('payment-details',array(
		     'data'=>$res,
		     'plan_details'=>$plan_details,
		     //'payment_options'=>AdminFunctions::paymentGatewayList()
		     'payment_options'=>AdminFunctions::getEnabledPaymentList()
		   ));
		} else $this->render('error',array(
		  'msg'=>t("token is invalid")
		));		
	}
	
	public function actionpaymentPyp()
	{
		
		if(!isset($_GET['hash'])){
			 $this->render('error',array(
		      'msg'=>t("token is invalid")
		    ));		
			return ;
		}
		
		if($res=FrontFunctions::getCustomerByToken($_GET['hash'])){									
			
			/*check if transaction is renew*/
			if($res['renew_plan_id']>0){
			   $res['plan_id']=$res['renew_plan_id'];
			}
			
			if ($plan_details=FrontFunctions::getPlansByID($res['plan_id'])){
				
				$price=$plan_details['price'];
				if($plan_details['promo_price']>0.0001){
					$price=$plan_details['promo_price'];
				}
				
				$customer_token=$res['token'];
				$customer_id=$res['customer_id'];
				
				/*$db=new DbExt();
				$db->updateData("{{customer}}",array(
				  'plan_price'=>$price
				),'customer_id',$customer_id);*/
								
				if ( $con=FrontFunctions::getPaypalConnection()){
					
					if($currency=FrontFunctions::getCurrenyCode()){
						
																		
					    $params['CANCELURL']="http://".$_SERVER['HTTP_HOST'].Yii::app()->request->baseUrl."/front/payment/?hash=".urlencode($customer_token)."&lang=".Yii::app()->language;
					    $params['RETURNURL']="http://".$_SERVER['HTTP_HOST'].Yii::app()->request->baseUrl."/front/payment-pyp-confirm/?hash=".urlencode($customer_token)."&lang=".Yii::app()->language;
					    
				        $params['NOSHIPPING']='1';
			            $params['LANDINGPAGE']='Billing';
			            $params['SOLUTIONTYPE']='Sole';
			            $params['CURRENCYCODE']=$currency['currency_code'];
			            
			            $x=0;
			            $params['L_NAME'.$x]=$plan_details['plan_name'];
			            $params['L_NUMBER'.$x]=$plan_details['plan_name_description'];
			            $params['L_DESC'.$x]='';
			            $params['L_AMT'.$x]=AdminFunctions::normalPrettyPrice($price);
			            $params['L_QTY'.$x]=1;
			            $params['AMT']=AdminFunctions::normalPrettyPrice($price);
			            			            
			            $paypal=new Paypal($con);
			            $paypal->params=$params;
			            $paypal->debug=false;
			            if ($resp=$paypal->setExpressCheckout()){ 
			            	header('Location: '.$resp['url']);
			            	Yii::app()->end();
			            }  else  $this->render('error',array(
		                           'msg'=>$paypal->getError()
		                        ));					             
						
					} else $this->render('error',array(
		                'msg'=>t("Currency code not yet set")
		            ));		
					
				} else $this->render('error',array(
		            'msg'=>t("Paypal credentials not yet set")
		        ));		
				
			} else $this->render('error',array(
		        'msg'=>t("Total to pay is not valid")
		    ));		
		} else $this->render('error',array(
		  'msg'=>t("token is invalid")
		));		
	}
	
	public function actionpaymentPypConfirm()
	{
		$error='';
		if ( $con=FrontFunctions::getPaypalConnection()){
			if($res=FrontFunctions::getCustomerByToken($_GET['hash'])){									
				
			   /*check if transaction is renew*/
			   if($res['renew_plan_id']>0){
			      $res['plan_id']=$res['renew_plan_id'];
			   }
				
			   $plan_details=FrontFunctions::getPlansByID($res['plan_id']);
			   			  
			   $paypal=new Paypal($con);
			   if ($res_paypal=$paypal->getExpressDetail()){			   	   
			   } else $error=$paypal->getError();
			} else $error=t("Plan details not found");
		} else $error=t("Paypal credentials invalid");
		
		if(empty($error)){
			
			$this->body_class.=" page-material";
		    $this->includeMaterial();
			
			$this->render('pyp-confirm',array(
			  'plan_details'=>$plan_details,
			  'res_paypal'=>$res_paypal,
			  'hash'=>isset($_GET['hash'])?$_GET['hash']:''
			));
		} else $this->render('error',array(
		  'msg'=>$error
		));	
	}
	
	public function actionpaymentStp()
	{
		$error=''; $publish_key='';
		
		$stripe_enabled=trim(getOptionA('stripe_enabled'));
		if ($stripe_enabled==""){
			$error=t("Stripe is disabled");
		}
		
		$stripe_mode=trim(getOptionA('stripe_mode'));
		if ($stripe_mode=="sandbox"){
			$publish_key=trim(getOptionA('stripe_sandbox_publish_key'));
		} else if ($stripe_mode=="live") {
			$publish_key=trim(getOptionA('stripe_live_publish_key'));
		} else $error=t("Stripe mode is not defined");
							
		if($res=FrontFunctions::getCustomerByToken($_GET['hash'])){	
			
			/*check if transaction is renew*/
		    if($res['renew_plan_id']>0){
		       $res['plan_id']=$res['renew_plan_id'];
		    }		    		    
			
			$plan_details=FrontFunctions::getPlansByID($res['plan_id']);						
			$price=$res['plan_price'];
			
			/*check if transaction is renew*/
			if($res['renew_plan_id']>0){
				$price=$plan_details['price'];
				if($plan_details['promo_price']>0.0001){
					$price=$plan_details['promo_price'];
				}
			}
			
			$this->body_class.=" page-material";
		    $this->includeMaterial();
		    		   
		    Yii::app()->clientScript->registerScriptFile(
              "https://js.stripe.com/v2/",
		      CClientScript::POS_END
		    );			
		    			
		} else $error = t("Plan details not found");
		
		if(empty($error)){
			$this->render('stripe-init',array(
			  'plan_details'=>$plan_details,
			  'publish_key'=>$publish_key,
			  'hash'=>isset($_GET['hash'])?$_GET['hash']:'',
			  'price'=>$price
			)); 
		} else $this->render('error',array(
		      'msg'=>$error
		  ));		
			
	}
	
	public function actionPage()
	{				
		$url=isset($_SERVER['REQUEST_URI'])?explode("/",$_SERVER['REQUEST_URI']):false;
		if(is_array($url) && count($url)>=1){
			$page_slug=$url[count($url)-1];
			$page_slug=str_replace('page-','',$page_slug);			
			if(isset($_GET)){				
				$c=strpos($page_slug,'?');
				if(is_numeric($c)){
					$page_slug=substr($page_slug,0,$c);
				}
			}
			//dump($page_slug);
			if ( $res=AdminFunctions::getCustomPageByPageSlug($page_slug,'published')){
				$this->render('page',array(
				 'data'=>$res
				));
			} else $this->render('error',array(
		       'msg'=>t("Sorry but we cannot find what you are looking for")
		   ));
		} else $this->render('error',array(
		  'msg'=>t("Sorry but we cannot find what you are looking for")
		));
	}
	
	public function actionsetlang()
	{
		if(!empty($_GET['action'])){
			$url=Yii::app()->createUrl("front/".$_GET['action'],array(
			  'lang'=>$_GET['lang']
			));
		} else {
			$url=Yii::app()->createUrl("front/dashboard",array(
			  'lang'=>$_GET['lang']
			));
		}		
		$this->redirect($url);
	}
	
	public function xactionpaymentList()
	{
		
	}

	public function actiontrack(){
        if ( isset($_GET['id'])){
            if(is_numeric($_GET['task_id'])){

                $this->render('track',array(
                    'data'=>Driver::getTaskId($_GET['task_id']),
                    'id'=>$_GET['id'],
                    'task_id'=>$_GET['task_id']
                ));
            } else  $this->redirect(Yii::app()->createUrl('/front/index'));
        } else $this->redirect(Yii::app()->createUrl('/front/index'));
    }
} /*end class*/