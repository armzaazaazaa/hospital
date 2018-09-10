<?php
/**
 * Created by PhpStorm.
 * User: watcharaphan
 * Date: 6/9/2018 AD
 * Time: 17:11
 */

$this->title = '';

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\web\View;
use yii\widgets\Pjax;
use app\api\Utility;
use app\api\DateTime;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use kartik\select2\Select2;
use app\api\ApiHr;

use app\models\Province;

use kartik\widgets\FileInput;
use kartik\date\DatePicker;

$imghr = Yii::$app->request->baseUrl . '/images/wshr';
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/global/master-utility-function.js?t=' . time(), ['depends' => [\yii\web\JqueryAsset::className()]]); //java
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/global/validator.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); //java
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/hospital/jquery-ui.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/hospital/symptom.js?t=' . time(), ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/upload.js?t=' . time(), ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/upload.css', ['depends' => [\yii\bootstrap\BootstrapPluginAsset::className()]]);
?>
<style type="text/css">
    img.resize {
        width: 180px;
        height: 200px;
        border: 0;
    }

    img:hover.resize {
        transition: transform .1s;
        width: 500px;
        height: 500px;
        border: 0;
    }

    .zoom {
        padding: 1px;
        transition: transform .1s;
        width: 200px;
        height: 200px;
        margin: 0 auto;
    }

    .zoom:hover {
        -ms-transform: scale(1.5); /* IE 9 */
        -webkit-transform: scale(1.5); /* Safari 3-8 */
        transform: scale(1.5);
    }
</style>
<?php

$foled = Yii::$app->request->baseUrl . '/upload/';


?>

<?php


$objScan = scandir(\Yii::$app->basePath . '/upload/');
$arrFile = [];
foreach ($objScan as $a) {
    if ($a != '.' && $a != '..' && $a != '.DS_Store') {
        array_push($arrFile, $a);
    }

}

?>
<div class="box box-danger">
    <div class="breadcrumbs" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="/hospital/index.php/teleecho/symptom">กลับ</a>
            </li>
            <li class="active"><?php echo $patientname ?></li>
        </ul><!-- /.breadcrumb -->
        <!-- /section:basics/content.searchbox -->
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="tab-content">

                    <div class="col-lg-12">
                        <div class="tab-content col-lg-12 row">

                            <!-- /.tab-pane -->
                            <div class="tab-pane active" id="timeline">
                                <!-- The timeline -->
                                <ul class="timeline timeline-inverse">
                                    <!-- timeline time label -->
                                    <li class="time-label">
                        <span class="bg-red">
                          <?php echo DateTime::ThaiDateTime($date) ?>
                        </span>
                                    </li>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <li>
                                        <i class="fa fa-user bg-blue"></i>

                                        <div class="timeline-item col-lg-10">


                                            <h3 class="timeline-header"><a href="#">ผู้ป่วย</a> </h3>

                                            <div class="timeline-body">
                                                <p class="col-lg-12"><b> ชื่อผู้ป่วย</b> <?php echo $patientname ?> </p>
                                                <p class="col-lg-12"><b> เพศ </b> <?php echo $patientgender ?> </p>
                                                <p class="col-lg-12"><b> อายุ</b> <?php echo $patientage ?> </p>
                                                <p class="col-lg-12"><b> สวนสูง</b> <?php echo $patientheight ?> </p>
                                                <p class="col-lg-12"><b> น้ำหนัก</b> <?php echo $patientweight ?> </p>

                                            </div>

                                        </div>
                                    </li>
                                    <!-- END timeline item -->
                                    <!-- timeline item -->
                                    <li>
                                        <i class="fa fa-user bg-aqua"></i>

                                        <div class="timeline-item col-lg-10" >
                                            <span class="time"> </span>

                                            <h3 class="timeline-header no-border"><a href="#">ผุ้ทำรายการ <?php echo $doctorfirstname.' '.$doctorlastname ?></a>
                                            </h3>
                                             <p class="col-lg-12"><b> ประวัติเจ็บป่วยในอดีต</b> <?php echo $symtompasthistory ?> </p>
                                            <p class="col-lg-12"><b> ประวัติเจ็บป่วยในปัจจุบัน</b> <?php echo $symtompresentillness ?> </p>
                                            <p class="col-lg-12"><b> ผลทางห้องปฎิบัติการ</b> <?php echo $symtomlab ?> </p>
                                            <p class="col-lg-12"><b> ผลตรวจคลื่นไฟฟ้าหัวใจ</b> <?php echo $symtomekg ?> </p>
                                            <p class="col-lg-12"><b> ผลวินิฉัย</b> <?php echo $symtomdiagnosis ?> </p>
                                            <p class="col-lg-12"><b> แผนการรักษา</b> <?php echo $symtomplan ?> </p>
                                        </div>
                                    </li>
                                    <!-- END timeline item -->
                                    <!-- timeline item -->
                                    <li>
                                        <i class="fa fa-comments bg-yellow"></i>

                                        <div class="timeline-item col-lg-10">
                                            <span class="time"></span>

                                            <h3 class="timeline-header"><a href="#">ความเห็น</a> commented </h3>

                                            <div class="timeline-body">
                                                <p class="col-lg-12"><?php echo $symtomcomment ?> </p>
                                            </div>

                                        </div>
                                    </li>
                                    <!-- END timeline item -->
                                    <!-- timeline time label -->
                                    <li class="time-label">

                                    </li>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <li>
                                        <i class="fa fa-camera bg-purple"></i>

                                        <div class="timeline-item col-lg-12">
                                            <span class="time"></span>

                                            <h3 class="timeline-header"><a href="#">รูปภาพ x-Ray</a> </h3>

                                            <div class="timeline-body">

                                                 <?

                                                    foreach ($imgs as $value) {

                                                        ?>

                                                            <img class="resize margin"
                                                                 src="<?php echo Yii::$app->request->baseUrl . '/upload/' . $value[0] ?>"
                                                                 height="180" width="200" alt="animate">

                                                        <?php
                                                    }


                                                    ?>



                                            </div>
                                        </div>
                                    </li>
                                    <!-- END timeline item -->
                                    <li>
                                        <i class="fa fa-clock-o bg-gray"></i>
                                    </li>
                                </ul>
                            </div>
                            <!-- /.tab-pane -->


                            <!-- /.tab-pane -->
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

