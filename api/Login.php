<?php
namespace app\api;
use Yii;
use yii\web\Session;
use app\modules\hr\models\RelationPosition;
use app\modules\hr\models\Empdata;
use app\modules\hr\models\Position;
use app\modules\hr\apihr\ApiHr;
use app\api\DBConnect;
use yii\bootstrap\Alert;
use yii\db\Command;
class Login
{
    public function checklogin($postValue)
    {
        $myusername = $postValue['myusername'];
        $mypassword = $postValue['mypassword'];
        $positioncode = $postValue['s_position_code'];
        
        $myusername = stripslashes($myusername);
        $mypassword = stripslashes($mypassword);
        // echo $myusername = mysql_real_escape_string($myusername);
        // echo $mypassword = mysql_real_escape_string($mypassword);
        
        // exit;;
        
        if ($myusername != "" && $mypassword != "") {
            if ($positioncode != "") {
                # ไม่เอาคนที่ลาออกไปแล้ว
                // $sqlx = "SELECT * FROM $config[DataBaseName].emp_data WHERE username ='$myusername' AND Prosonnal_Being !='3' AND username != 'admin' ";
                // $resultx = mysql_query($sqlx) or die(__FILE__.":".__LINE__.mysql_error());
                // $count1 = mysql_num_rows($resultx);
                $modelGetData = Empdata::find()
                ->where('username=:myusername')
                ->andWhere('username !=  "admin" ')
                ->andWhere('Prosonnal_Being != "3"')
                ->addParams([':myusername' => $myusername])
                ->asArray()
                ->one();
                if ($modelGetData > 0) {
                    
                    
                    // echo "<pre>";
                    // print_r($modelGetData);
                    // exit;
                    $pepperD = Pepper::pepper($mypassword, $modelGetData['password']);
                    //
                    //                            echo $pepperD;
                    //                            exit;
                    
                    
                    if ($modelGetData['username'] == "admin") {
                        $positioncode = "admin";
                    }
                    
                    if (($positioncode != "")) {
                        # ใส่รหัสผ่านถูกต้อง
                        if ($pepperD) {
                            $idcard = $modelGetData['ID_Card'];
                            $db['ou'] = DBConnect::getDBConn()['ou'];
                            $db['ct'] = DBConnect::getDBConn()['ct'];
                            $db['pl'] = DBConnect::getDBConn()['pl'];
                            
                            
                            # no use until Org Chart is finished
                            // last edit by ken 2012-11-08
                            //                                    $positionQuery = "SELECT id,PositionCode,WorkCompany,department,section,level, PositionCode
                            //                                    FROM $db[ou].position  WHERE PositionCode = '$positioncode' and status != 99";
                            $positionRS = Position::find()
                            ->select('id,PositionCode,WorkCompany,department,section,level, PositionCode')
                            ->where("PositionCode = '$positioncode'")
                            ->andWhere('status != "99"')
                            ->asArray()
                            ->one();
                            
                            //$positionRS = $db['ou']->createCommand($positionQuery)->queryOne();
                            
                            
                            //                                    $positionResult = mysql_query($positionQuery) or die(__FILE__.":".__LINE__.mysql_error());
                            //                                    $positionRS = mysql_fetch_array($positionResult);$positionResult
                            // end last edit by ken 2012-11-08
                            
                            
                            # == BEGIN login LOG
                            $ipAddress = Yii::$app->getRequest()->getUserIP();
                            $browser_version = $_SERVER['HTTP_USER_AGENT'];
                            $logText = "$modelGetData[Name] $modelGetData[Surname] ( $idcard )  รหัส $positionRS[PositionCode] Level $positionRS[level] บริษัท $positionRS[WorkCompany] แผนก $positionRS[department] ฝ่าย $positionRS[section]";
                            //                                    echo "=====>".$ipAddress."=====>";
                            //                                    echo $browser_version;
                            //                                    echo $logText;
                            //                                    exit;
                            
                            //                                    $loginsert = "INSERT INTO $config[DataBaseName].login_time(code,loginfo,ipaddress,browser)
                            //                                    values ('$positionRS[PositionCode]' ,'$logText' , '$ipAddress' , '$browser_version' )";
                            //
                            //                                    $loginsrtResult = mysql_query($loginsert) or die ( mysql_error());
                            # == END login LOG
                            
                            //Find Company Name
                            $arrCompany = ApiHr::getworkingcompanyByid($positionRS['WorkCompany']);
                            $company_name = $arrCompany[0]['name'];
                            
                            
                            //Yii2 create session
                            $session = Yii::$app->session;
                            $session->open();  //open session
                            
                            
                            $_fullname = $modelGetData['Name'] . ' ' . $modelGetData['Surname'];
                            $session->set('idcard', $idcard);   //set session idcard
                            $session->set('pwd', $mypassword);   //set session password
                            $session->set('fullname', $_fullname);   //set session fullname
                            $session->set('iplogin', $ipAddress);  //set ip address comming login
                            $session->set('longtext', $logText); //long text, personal detail
                            
                            $session->set('positioncode', $positioncode);
                            $session->set('positionid', $positionRS['id']);
                            $session->set('positionname', $modelGetData['Position']);
                            $session->set('datano', $modelGetData['DataNo']);
                            $session->set('numberid', $modelGetData['Code']);
                            $session->set('name', $modelGetData['Name']);
                            $session->set('surname', $modelGetData['Surname']);
                            $session->set('nickname', $modelGetData['Nickname']);
                            $session->set('sex', $modelGetData['Sex']);
                            $session->set('tel', $modelGetData['Mobile_Num']);
                            $session->set('companyid', $positionRS['WorkCompany']);
                            $session->set('companyname', $company_name);
                            $session->set('departmentname', $positionRS['department']);
                            $session->set('sectionname', $positionRS['section']);
                            $session->set('level', $positionRS['level']);
                            $session->set('codename', $positionRS['level']);
                            $session->set('bUserQC', 'Ok');
                            
                            $session->set('birthday', $modelGetData['Birthday']);
                            $session->set('address', $modelGetData['Address']);
                            $session->set('moo', $modelGetData['Moo']);
                            $session->set('road', $modelGetData['Road']);
                            $session->set('village', $modelGetData['Village']);
                            $session->set('subdistrict', $modelGetData['SubDistrict']);
                            $session->set('district', $modelGetData['District']);
                            $session->set('province', $modelGetData['Province']);
                            //.... and so on session here
                            
                            
                            $ipPic = 'http://10.0.0.248/ERP_easyhr/emp/';
                            $session->set('photopath',$ipPic);
                            $session->set('photo',$ipPic.$modelGetData['Pictures_HyperL']);
                            
                            
                            $_SESSION['positioncode'] = $positioncode;
                            $_SESSION['SESSION_DataNo'] = $modelGetData['DataNo'];
                            $_SESSION['SESSION_member_id'] = $modelGetData['Code'];# code
                            $_SESSION['SESSION_Name'] = $modelGetData['Name'];
                            $_SESSION['SESSION_Surname'] = $modelGetData['Surname'];
                            $_SESSION['SESSION_Nickname'] = $modelGetData['Nickname'];
                            $_SESSION['SESSION_username'] = $modelGetData['username'];
                            $_SESSION['SESSION_Sex'] = $modelGetData['Sex'];
                            $_SESSION['SESSION_ID_card'] = $modelGetData['ID_Card'];
                            $_SESSION['SESSION_Tel_Num'] = $modelGetData['Tel_Num'];
                            $_SESSION['SESSION_Working_Company'] = $positionRS['WorkCompany'];
                            $_SESSION['SESSION_Position'] = $positionRS['PositionCode'];
                            $_SESSION['SESSION_Position_id'] = $positionRS['id'];
                            $_SESSION['SESSION_Department'] = $positionRS['department'];
                            $_SESSION['SESSION_Section'] = $positionRS['section'];
                            $_SESSION['SESSION_Level'] = $positionRS['level'];
                            //$_SESSION['SESSION_Working_Company'] 	= 	$rx['Working_Company'];
                            
                            // last edit by ken 2012-11-08
                            $_SESSION['SESSION_CodeName '] = $positionRS['level'];
                            // end last edit by ken 2012-11-08
                            
                            $_SESSION['bUserQC'] = "Ok";
                            
                            
                            /*********************************************
                            *        jwt login
                            *
                            **********************************************/
                            // $jwt = new JWTAuth();
                            
                            // $data = array(
                            // 'name' => $rx['Name'],
                            // 'surname' => $rx['Surname'],
                            // 'idcard' => $rx['ID_Card'],
                            // 'position'=> $positionRS['PositionCode']
                            // );
                            
                            // $resSet = $jwt->registerServ($data);
                            // if(!$resSet['status']){
                            //     echo $resSet['msg'];
                            //     exit();
                            // }
                            
                            //--
                            
                            
                            //create_team();// ใช้ในหน้า ลูกค้ามุ้งหวัง
                            # เช็คสิทธิ์การใช้โปรแกรม
                            //$CheckUseProgram = ProgramPermission();
                            # มีการกำหนดสิทให้
                            //if($CheckUseProgram == true){
                            $MSG = "กำลังเข้าสู่ระบบกรุณารอสักครู่...........";
                            $link = "select_program.php";
                            //$link = "http://".$_SERVER['SERVER_NAME']."/easyloan";
                            return true;
                            //setcookie('token','xxxxxx');
                            
                            //}else{
                            # ไม่ได้รับสิทใช้โปรแกรม
                            //	$MSG = "คุณไม่ได้รับสิทใช้โปรแกรม";
                            //	$link = "index.php?p=logout";
                            //	echo $tpl->tbHtml('login.html','MSG_BLOCK');
                            //}
                        } else {
                            # กรอกรหัสผ่านไม่ถูก
                            $MSG = "กรอกรหัสผ่านไม่ถูกต้อง";
                            return $MSG;//echo $tpl->tbHtml('login.html','MSG_BLOCK');
                        }
                    }
                    
                } else {
                    # กรอก username ผิด
                    $MSG = "Username ผิด กรุณาพิมพ์ใหม่";
                    //                            $link = "index.php";
                    return $MSG;//echo $tpl->tbHtml('login.html','MSG_BLOCK');
                }
            } else {
                # ไม่ได้เลือกตำแหน่ง
                $MSG = "Username ผิด กรุณาพิมพ์ใหม่";
                // $link = "index.php";
                return $MSG;//echo $tpl->tbHtml('login.html','MSG_BLOCK');
            }
        } else {
            # ไม่ได้กรอกข้อมูล
            $MSG = "กรุณากรอกข้อมูลให้ครบด้วยครับ";
            $link = "index.php";
            return $MSG;//echo $tpl->tbHtml('login.html','MSG_BLOCK');
        }
    }
}
?>