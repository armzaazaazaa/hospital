<?php
/**
 * Created by PhpStorm.
 * User: watcharaphan
 * Date: 5/9/2018 AD
 * Time: 15:34
 */
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/global/master-utility-function.js?t=' . time(), ['depends' => [\yii\web\JqueryAsset::className()]]); //java
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/global/validator.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); //java
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/hospital/jquery-ui.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/upload.js?t=' . time(), ['depends' => [\yii\web\JqueryAsset::className()]]);

?>

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

<style type="text/css">
    img.resize  {
        width: 180px;
        height: 200px;
        border: 0;
    }
    img:hover.resize  {
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

<div class="box box-danger col-lg-12"> <?

    foreach ($imgs as $value) {

        ?>
        <div class="col-md-3 box-body">
            <img  class="resize" src="<?php echo Yii::$app->request->baseUrl . '/upload/' . $value[0] ?>" height="180" width="200" alt="animate" >
        </div>
        <?php
    }


    ?>

<button class="btn-success">
    <p><a href="upload">Black</a></p>
</button>

    <button class="btn-success">
        <p><a href="symptom">symptom</a></p>
    </button>

</div>

