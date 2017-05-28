<?php
class ScriptManager
{
    public static function scripts()
    {
        $ajaxurl=Yii::app()->baseUrl.'/ajax';
        $site_url=Yii::app()->baseUrl.'/';
        $home_url=Yii::app()->baseUrl.'/app';

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

        $appname = FrontFunctions::getCompanyName();
        $cs->registerScript(
            'appname',
            "var appname='$appname';",
            CClientScript::POS_HEAD
        );

        /*MAP MARKER*/
        $delivery_icon=Yii::app()->baseUrl.'/assets/images/delivery_icon.png';
        $delivery_icon_success=Yii::app()->baseUrl.'/assets/images/delivery_success.png';
        $delivery_icon_failed=Yii::app()->baseUrl.'/assets/images/delivery_failed.png';

        $pickup_icon=Yii::app()->baseUrl.'/assets/images/pickup_icon.png';
        $pickup_icon_success=Yii::app()->baseUrl.'/assets/images/pickup_success.png';
        $pickup_icon_failed=Yii::app()->baseUrl.'/assets/images/pickup_failed.png';

        $driver_icon_online=Yii::app()->baseUrl.'/assets/images/driver_on.png';
        $driver_icon_offline=Yii::app()->baseUrl.'/assets/images/driver_off.png';

        $trip_start=Yii::app()->baseUrl.'/assets/images/start.png';
        $trip_finish=Yii::app()->baseUrl.'/assets/images/finish.png';


        $cs->registerScript(
            'map_marker_delivery',
            "var map_marker_delivery='$delivery_icon';",
            CClientScript::POS_HEAD
        );
        $cs->registerScript(
            'delivery_icon_success',
            "var delivery_icon_success='$delivery_icon_success';",
            CClientScript::POS_HEAD
        );
        $cs->registerScript(
            'delivery_icon_failed',
            "var delivery_icon_failed='$delivery_icon_failed';",
            CClientScript::POS_HEAD
        );

        $cs->registerScript(
            'pickup_icon',
            "var map_pickup_icon='$pickup_icon';",
            CClientScript::POS_HEAD
        );
        $cs->registerScript(
            'pickup_icon_success',
            "var pickup_icon_success='$pickup_icon_success';",
            CClientScript::POS_HEAD
        );
        $cs->registerScript(
            'pickup_icon_failed',
            "var pickup_icon_failed='$pickup_icon_failed';",
            CClientScript::POS_HEAD
        );

        $cs->registerScript(
            'driver_icon_online',
            "var driver_icon_online='$driver_icon_online';",
            CClientScript::POS_HEAD
        );
        $cs->registerScript(
            'driver_icon_offline',
            "var driver_icon_offline='$driver_icon_offline';",
            CClientScript::POS_HEAD
        );

        $cs->registerScript(
            'trip_start',
            "var trip_start='$trip_start';",
            CClientScript::POS_HEAD
        );
        $cs->registerScript(
            'trip_finish',
            "var trip_finish='$trip_finish';",
            CClientScript::POS_HEAD
        );

        $customer_id=Driver::getUserId();

        $default_country=Yii::app()->functions->getOption('drv_default_location' , $customer_id   );
        if(empty($default_country)){
            $default_country='ID';
        }
        $default_location_lat=Yii::app()->functions->getOption(  'drv_default_location_lat' , $customer_id );
        $default_location_lng=Yii::app()->functions->getOption( 'drv_default_location_lng' , $customer_id  );
        $drv_map_style=Yii::app()->functions->getOption(  'drv_map_style' , $customer_id);

        $default_location_lat=!empty($default_location_lat)?$default_location_lat:-0.789275;
        $default_location_lng=!empty($default_location_lng)?$default_location_lng:113.921327;

        $driver_include_offline_driver_map=Yii::app()->functions->getOption('driver_include_offline_driver_map', $customer_id);

        $driver_disabled_auto_refresh=Yii::app()->functions->getOption('driver_disabled_auto_refresh', $customer_id);
        /** START Set general settings */
        $cs->registerScript(
            'default_country',
            "var default_country='$default_country';",
            CClientScript::POS_HEAD
        );
        $cs->registerScript(
            'default_location_lat',
            "var default_location_lat='$default_location_lat';",
            CClientScript::POS_HEAD
        );
        $cs->registerScript(
            'default_location_lng',
            "var default_location_lng='$default_location_lng';",
            CClientScript::POS_HEAD
        );
        $cs->registerScript(
            'driver_include_offline_driver_map',
            "var driver_include_offline_driver_map='$driver_include_offline_driver_map';",
            CClientScript::POS_HEAD
        );
        $cs->registerScript(
            'disabled_auto_refresh',
            "var disabled_auto_refresh='$driver_disabled_auto_refresh';",
            CClientScript::POS_HEAD
        );

        $drv_map_style_res = json_decode($drv_map_style);

        if ( is_array($drv_map_style_res) && !empty($drv_map_style)){
            $cs->registerScript(
                'map_style',
                "var map_style=$drv_map_style",
                CClientScript::POS_HEAD
            );
        } else {
            $map_style='[{"featureType": "administrative.neighborhood","elementType": "labels.text.fill","stylers": [{"lightness": "-6"},{"invert_lightness": true},{"visibility": "on"},{"color": "#ff0000"}]}];';
            $cs->registerScript(
                'map_style',
                "var map_style=$map_style",
                CClientScript::POS_HEAD
            );
        }
        /** END Set general settings */

        /*JS FILE*/
        /*
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
            Yii::app()->baseUrl . '/assets/DataTables/jquery.dataTables.min.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/DataTables/fnReloadAjax.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/jquery.sticky2.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/SimpleAjaxUploader.min.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/summernote/summernote.min.js',
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
            Yii::app()->baseUrl . '/assets/form-validator/jquery.form-validator.min.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/intel/build/js/intlTelInput.js?ver=2.1.5',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/nprogress/nprogress.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/datetimepicker/jquery.datetimepicker.full.min.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/moment.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/js-date-format.min.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/switch/bootstrap-switch.min.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            "//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js",
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/jplayer/jquery.jplayer.min.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/js.kookie.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/app.js?ver=1.0',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/driver-js.js?ver=1.0',
            CClientScript::POS_END
        );
        */

        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/gmaps.js',
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
            Yii::app()->baseUrl . '/assets/viewer/js/jquery-3.1.1.min.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/bootstrap.min.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/backstretch/backstretch.min.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/form-validator/jquery.form-validator.min.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/toastr/toastr.min.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/metisMenu/jquery.metisMenu.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/slimscroll/jquery.slimscroll.min.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/pace/pace.min.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/datapicker/bootstrap-datepicker.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/jplayer/jquery.jplayer.min.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/js.kookie.js',
            CClientScript::POS_END
        );

        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/app.js?ver=1.0',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/driver-js.js?ver=1.0',
            CClientScript::POS_END
        );

        /*CSS FILE*/
        $baseUrl = Yii::app()->baseUrl."";
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($baseUrl."/assets/viewer/css/bootstrap.min.css");
        $cs->registerCssFile($baseUrl."/assets/viewer/font-awesome/css/font-awesome.css");
        $cs->registerCssFile($baseUrl."/assets/viewer/css/animate.css");
        $cs->registerCssFile($baseUrl."/assets/viewer/css/style.css");
        $cs->registerCssFile($baseUrl."/assets/viewer/css/plugins/ladda/ladda.min.css");
        $cs->registerCssFile($baseUrl."/assets/viewer/css/plugins/toastr/toastr.min.css");
        $cs->registerCssFile($baseUrl."/assets/viewer/css/plugins/footable/footable.core.css");
        $cs->registerCssFile($baseUrl."/assets/viewer/css/plugins/datapicker/datepicker3.css");
    }

    public static function scriptsOption(){

        $customer_id=Driver::getUserId();
        $map_style='[{"featureType": "administrative.neighborhood","elementType": "labels.text.fill","stylers": [{"lightness": "-6"},{"invert_lightness": true},{"visibility": "on"},{"color": "#ff0000"}]}];';

        $drv_default_location=Yii::app()->functions->getOption('drv_default_location', $customer_id);
        Yii::app()->functions->updateOption(
            'drv_default_location',
            !empty($drv_default_location)?$drv_default_location:'ID',
            Driver::getUserId()
        );

        $drv_map_style=Yii::app()->functions->getOption('drv_map_style', $customer_id);
        Yii::app()->functions->updateOption(
            'drv_map_style',
            !empty($drv_map_style)?$drv_map_style:$map_style,
            Driver::getUserId()
        );

        if(empty($drv_default_location)){
            $country_list=require_once('CountryCode.php');
            $country_name='';
            if (array_key_exists('ID',(array)$country_list)) {
                $country_name=$country_list['ID'];
            } else {
                $country_name='ID';
            }

            if ($res=Driver::addressToLatLong($country_name)) {
                Yii::app()->functions->updateOption("drv_default_location_lat", $res['lat'], Driver::getUserId());
                Yii::app()->functions->updateOption("drv_default_location_lng", $res['long'], Driver::getUserId());
            }
        }

        $driver_enabled_notes=Yii::app()->functions->getOption('driver_enabled_notes', $customer_id);
        Yii::app()->functions->updateOption(
            'driver_enabled_notes',
            !empty($driver_enabled_notes)?$driver_enabled_notes:'1',
            Driver::getUserId()
        );

        $driver_enabled_signature=Yii::app()->functions->getOption('driver_enabled_notes', $customer_id);
        Yii::app()->functions->updateOption(
            'driver_enabled_signature',
            !empty($driver_enabled_signature)?$driver_enabled_signature:'1',
            Driver::getUserId()
        );

        $driver_enabled_photo=Yii::app()->functions->getOption('driver_enabled_photo', $customer_id);
        Yii::app()->functions->updateOption(
            'driver_enabled_photo',
            !empty($driver_enabled_photo)?$driver_enabled_photo:'1',
            Driver::getUserId()
        );

    }
} /*END CLASS*/