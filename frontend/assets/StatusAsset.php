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
    public $basePath = '@webroot/themes/chiefsrs/';
    public $baseUrl = '@web/themes/chiefsrs/';
    public $sourcePath = '@webroot/themes/chiefsrs/';
    public $css = [
        'css/bootstrap.min.css',
        'css/open-iconic-bootstrap.min.css',
        'css/animate.css',
        'css/owl.carousel.min.css',
        'css/owl.theme.default.min.css',
        'css/magnific-popup.css',
       // 'css/bootstrap-datepicker.css',
        'css/jquery.timepicker.css',
      //  'css/fontawesome_all.css',
        'css/icomoon.css',
        'css/style.css',
        'css/googlefonts.css'
        //'../../../../common/web/css/bootstrap-clockpicker.min.css',
    ];
    public $js = [
      //'js/jquery.min.js',
      'js/popper.min.js',
      'js/bootstrap.min.js',
      'js/jquery.easing.1.3.js',
      'js/jquery.waypoints.min.js',  
     // 'js/status-counter.js',
      'js/owl.carousel.min.js',  
      'js/jquery.magnific-popup.min.js',  
    //  'js/bootstrap-datepicker.js',  
      'js/jquery.timepicker.min.js',  
      'js/jquery.animateNumber.min.js',  
      'js/main.js', 
      //'../../../../common/web/js/bootstrap-clockpicker.min.js',

    ];
    public $depends = [
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',
        ];

        ///////////////////////////////////////chiefsrs theme by Krutin///////////////////////

/*    public $basePath = '@webroot/themes/chiefsrs/';
    public $baseUrl = '@web/themes/chiefsrs/';
    public $sourcePath = '@webroot/themes/chiefsrs/';
    public $css = [
        'css/bootstrap.min.css',
        'css/open-iconic-bootstrap.min.css',
        'css/animate.css',
        'css/owl.carousel.min.css',
        'css/owl.theme.default.min.css',
        'css/icomoon.css',
        'css/style.css',
    ];
    public $js = [
      //'js/jquery.min.js',
      'javascript/popper.min.js',
      'javascript/bootstrap.min.js',
      'javascript/jquery.easing.1.3.js',
      'javascript/jquery.waypoints.min.js',  
      'javascript/owl.carousel.min.js',  
      'javascript/jquery.animateNumber.min.js',  
     // 'javascript/google-map.js', 
      'javascript/main_1.js',
      'javascript/main.js',  

    ];
    public $depends = [
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',
        ];*/
}