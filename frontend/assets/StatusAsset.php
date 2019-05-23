<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
 
namespace frontend\assets;
 
use yii\web\AssetBundle;
 
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class StatusAsset extends AssetBundle
{
    public $basePath = '@webroot/themes/eatwell/';
    public $baseUrl = '@web/themes/eatwell/';
    public $sourcePath = '@webroot/themes/eatwell/';
    public $css = [
        'css/bootstrap.min.css',
        'css/open-iconic-bootstrap.min.css',
        'css/animate.css',
        'css/owl.carousel.min.css',
        'css/owl.theme.default.min.css',
        'css/magnific-popup.css',
        'css/bootstrap-datepicker.css',
        'css/jquery.timepicker.css',
        'css/fontawesome_all.css',
        'css/icomoon.css',
        'css/style.css',
    ];
    public $js = [
      'js/jquery.min.js',
      'js/popper.min.js',
      'js/bootstrap.min.js',
      'js/jquery.easing.1.3.js',
      'js/jquery.waypoints.min.js',  
     // 'js/status-counter.js',
      'js/owl.carousel.min.js',  
      'js/jquery.magnific-popup.min.js',  
      'js/bootstrap-datepicker.js',  
      'js/jquery.timepicker.min.js',  
      'js/jquery.animateNumber.min.js',  
      'js/google-map.js',  
      //'js/https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"',  
      'js/main.js',  

    ];
    public $depends = [
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',
        ];
}