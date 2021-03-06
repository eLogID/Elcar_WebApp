<?php
class ScriptManageFront
{
	
	public static function scripts()
	{
		$ajaxurl=Yii::app()->baseUrl.'/ajaxfront';
		$site_url=Yii::app()->baseUrl.'/';
		$home_url=Yii::app()->baseUrl.'/front';

        Yii::app()->clientScript->scriptMap=array(
            'jquery.js'=>false,
            'jquery.min.js'=>false
        );

        $cs = Yii::app()->getClientScript();
        $cs->registerScript(
            'ajaxurl',
            "var ajax_url='$ajaxurl';",
            CClientScript::POS_HEAD
        );
        $cs->registerScript(
            'site_url',
            "var site_url='$site_url';",
            CClientScript::POS_HEAD
        );
        $cs->registerScript(
            'home_url',
            "var home_url='$home_url';",
            CClientScript::POS_HEAD
        );

        $track_map_style=Yii::app()->functions->getOptionAdmin('track_map_style');
        $track_map_style_res = json_decode($track_map_style);

        if ( is_array($track_map_style_res) && !empty($track_map_style)){
            $cs->registerScript(
                'map_style',
                "var map_style=$track_map_style",
                CClientScript::POS_HEAD
            );
        } else {
            $map_style='[{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#0f252e"},{"lightness":17}]}];';
            $cs->registerScript(
                'map_style',
                "var map_style=$map_style",
                CClientScript::POS_HEAD
            );
        }
		
		/*JS FILE*/
		Yii::app()->clientScript->registerScriptFile(
        Yii::app()->baseUrl . '/assets/jquery-1.10.2.min.js',
		CClientScript::POS_END
		);
		
		Yii::app()->clientScript->registerScriptFile(
        Yii::app()->baseUrl . '/assets/bootstrap/js/bootstrap.min.js',
		CClientScript::POS_END
		);
		
		Yii::app()->clientScript->registerScriptFile(
        Yii::app()->baseUrl . '/assets/chosen/chosen.jquery.min.js',
		CClientScript::POS_END
		);
		
		Yii::app()->clientScript->registerScriptFile(
        Yii::app()->baseUrl . '/assets/noty-2.3.7/js/noty/packaged/jquery.noty.packaged.min.js',
		CClientScript::POS_END
		);						
				
		Yii::app()->clientScript->registerScriptFile(
        Yii::app()->baseUrl . '/assets/form-validator/jquery.form-validator.min.js',
		CClientScript::POS_END
		);		
		
		Yii::app()->clientScript->registerScriptFile(
        Yii::app()->baseUrl . '/assets/js.kookie.js',
		CClientScript::POS_END
		);								
		
		/*Yii::app()->clientScript->registerScriptFile(
        "//cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js",
		CClientScript::POS_END
		);			*/

		Yii::app()->clientScript->registerScriptFile(
        Yii::app()->baseUrl . '/assets/intel/build/js/intlTelInput.js?ver=2.1.5',
		CClientScript::POS_END
		);			
		
		Yii::app()->clientScript->registerScriptFile(
        Yii::app()->baseUrl . '/assets/readmore.min.js',
		CClientScript::POS_END
		);						
					
		Yii::app()->clientScript->registerScriptFile(
        Yii::app()->baseUrl . '/assets/front.js?ver=1.0',
		CClientScript::POS_END
		);

        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/markercluster.js?ver=1.0',
            CClientScript::POS_END
        );

        $google_key=getOptionA('google_api_key');
        if (!empty($google_key)){
            Yii::app()->clientScript->registerScriptFile(
                '//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key='.urlencode($google_key),
                CClientScript::POS_END
            );
        } else {
            Yii::app()->clientScript->registerScriptFile(
                '//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places',
                CClientScript::POS_END
            );
        }

        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/gmaps.js',
            CClientScript::POS_END
        );

        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/jquery.geocomplete.min.js',
            CClientScript::POS_END
        );

        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/jquery-scrollTo/jquery.scrollTo.min.js',
            CClientScript::POS_END
        );

		/*CSS FILE*/
		$baseUrl = Yii::app()->baseUrl.""; 
		$cs = Yii::app()->getClientScript();				
		$cs->registerCssFile($baseUrl."/assets/bootstrap/css/bootstrap.min.css");		
		
		$cs->registerCssFile($baseUrl."/assets/chosen/chosen.min.css");		
		$cs->registerCssFile($baseUrl."/assets/animate.css");	
		$cs->registerCssFile("//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css");
		$cs->registerCssFile("//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css");
		
		$cs->registerCssFile($baseUrl."/assets/intel/build/css/intlTelInput.css");								
		
		//$cs->registerCssFile("//cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css");
		$cs->registerCssFile("//fonts.googleapis.com/icon?family=Material+Icons");
		$cs->registerCssFile("//fonts.googleapis.com/css?family=Lato:400,100,100italic,300,400italic,700italic,900,900italic");
        $cs->registerCssFile("//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800");

		$cs->registerCssFile($baseUrl."/assets/raty/jquery.raty.css");
		
	}
	
} /*END CLASS*/