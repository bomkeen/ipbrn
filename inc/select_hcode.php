<?php

$pro = isset($_POST['pro']) ? $_POST['pro'] : "";
 $p_name = \Yii::$app->db->createCommand("SELECT HOSPCODE,HOSPNAME FROM hospital WHERE PROVINCE=$pro")->queryAll();       

      foreach ($p_name as $p ) {
        echo "<option value=\"" . $p['HOSPCODE'] . "\">" . $p['HOSPNAME'] . "</option>";
    }
