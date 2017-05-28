<?php

/**
 * Created by IntelliJ IDEA.
 * User: isnaeni.hidayat
 * Date: 4/1/2017
 * Time: 11:53 AM
 */
class ScriptManagerViewer
{
    public static function scripts()
    {
        $ajaxurl=Yii::app()->baseUrl.'/ajaxviewer';
        $site_url=Yii::app()->baseUrl.'/';
        $home_url=Yii::app()->baseUrl.'/viewer';

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

        /*MAP MARKER*/
        $delivery_icon=Yii::app()->baseUrl.'/assets/images/restaurant-pin-32.png';
        $delivery_icon_success=Yii::app()->baseUrl.'/assets/images/delivery-successful.png';
        $delivery_icon_failed=Yii::app()->baseUrl.'/assets/images/delivery-failed.png';

        $pickup_icon=Yii::app()->baseUrl.'/assets/images/pickup-icon-32.png';
        $pickup_icon_success=Yii::app()->baseUrl.'/assets/images/pickup-successful.png';
        $pickup_icon_failed=Yii::app()->baseUrl.'/assets/images/pickup-failed.png';

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
            $map_style='[{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#0f252e"},{"lightness":17}]}];';
            $cs->registerScript(
                'map_style',
                "var map_style=$map_style",
                CClientScript::POS_HEAD
            );
        }
        /** END Set general settings */

        /*Css File*/
        $baseUrl = Yii::app()->baseUrl."";
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($baseUrl."/assets/viewer/css/bootstrap.min.css");
        $cs->registerCssFile($baseUrl."/assets/viewer/font-awesome/css/font-awesome.css");
        $cs->registerCssFile($baseUrl."/assets/viewer/css/animate.css");
        $cs->registerCssFile($baseUrl."/assets/viewer/css/style.css");
        $cs->registerCssFile($baseUrl."/assets/viewer/css/plugins/ladda/ladda.min.css");
        $cs->registerCssFile($baseUrl."/assets/viewer/css/plugins/toastr/toastr.min.css");
        $cs->registerCssFile($baseUrl."/assets/viewer/css/plugins/footable/footable.core.css");

        /*Js File*/
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/jquery-3.1.1.min.js',
            CClientScript::POS_END
        );

        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/bootstrap.min.js',
            CClientScript::POS_END
        );

        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/ladda/ladda.min.js',
            CClientScript::POS_END
        );

        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/toastr/toastr.min.js',
            CClientScript::POS_END
        );

        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/backstretch/backstretch.min.js',
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

        /* Flot */
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/flot/jquery.flot.js',
            CClientScript::POS_END
        );

        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/flot/jquery.flot.tooltip.min.js',
            CClientScript::POS_END
        );

        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/flot/jquery.flot.spline.js',
            CClientScript::POS_END
        );

        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/flot/jquery.flot.resize.js',
            CClientScript::POS_END
        );

        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/flot/jquery.flot.pie.js',
            CClientScript::POS_END
        );

        /*Peity*/
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/peity/jquery.peity.min.js',
            CClientScript::POS_END
        );

        /*pace*/
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/pace/pace.min.js',
            CClientScript::POS_END
        );

        /*jQuery UI*/
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/jquery-ui/jquery-ui.min.js',
            CClientScript::POS_END
        );

        /*GITTER*/
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/gritter/jquery.gritter.min.js',
            CClientScript::POS_END
        );

        /*Sparkline*/
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/sparkline/jquery.sparkline.min.js',
            CClientScript::POS_END
        );

        /*ChartJS*/
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/chartJs/Chart.min.js',
            CClientScript::POS_END
        );

        /*FooTable*/
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/assets/viewer/js/plugins/footable/footable.all.min.js',
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
            Yii::app()->baseUrl . '/assets/viewer/viewer.js?ver=1.0',
            CClientScript::POS_END
        );

    }
}