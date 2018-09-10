<?php
/**
 * Created by PhpStorm.
 * User: watcharaphan
 * Date: 5/9/2018 AD
 * Time: 15:26
 */

use yii\helpers\Url;
use yii\web\JsExpression;

$this->registerJsFile(Yii::$app->request->baseUrl . '/js/global/master-utility-function.js?t=' . time(), ['depends' => [\yii\web\JqueryAsset::className()]]); //java
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/global/validator.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); //java
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/hospital/jquery-ui.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile(Yii::$app->request->baseUrl . '/js/upload.js?t=' . time(), ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerCssFile(Yii::$app->request->baseUrl . '/css/upload.css', ['depends' => [\yii\bootstrap\BootstrapPluginAsset::className()]]);


?>


<form type="hidden" class="dropzone">


    <p><a href="viewupload">viewupload</a></p>

    <?= \kato\DropZone::widget([
        'options' => [
            'url' => Url::to(['teleecho/upload']),
            'autoDiscover' => false,
            'maxFilesize' => '50',
        ],
        'clientEvents' => [
            'complete' => "function(file){console.log(file)}",
            'removedfile' => "function(file){alert(file.name + ' is removed')}"
        ],
    ]);


    ?>
</form>
<!---->
<? //= \kato\DropZone::widget([
//    'autoDiscover' => false,
//    'options' => [
//        'init' => new JsExpression("function(file){alert( ' is removed')}"),
//        'url'=> 'index.php?r=branches/upload',
//        'maxFilesize' => '2',
//        'addRemoveLinks' =>true,
//        'acceptedFiles' =>'image/*',
//
//
//    ],
//    'clientEvents' => [
//        'complete' => "function(file){console.log(file)}",
//        // 'removedfile' => "function(file){alert(file.name + ' is removed')}"
//        'removedfile' => "function(file){
//             alert('Delete this file?');
//          $.ajax({
//               url: 'index.php?r=branches/rmf',
//               type: 'GET',
//               data: { 'filetodelete': file.name}
//          });
//
//           }"
//    ],    ]); ?>
<!---->
