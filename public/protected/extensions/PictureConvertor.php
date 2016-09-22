<?php

class PictureConvertor
{
    public static function pictureTransfer ($pictJSON) {
        $picArr = (array)json_decode($pictJSON);
        if (!empty($picArr)) {
            $retArr = array();
            foreach ($picArr as $backup => $pic) {
                if ($backup == $pic) {
                    $picConfg = self::getPicInfo($pic);
                    if(file_exists(Yii::app()->request->baseUrl . $picConfg['pathToTemp'] . $picConfg['tempFile'])){
                        if ($picConfg['pathToTemp'] != $picConfg['pathToDir']) {
                            rename(Yii::app()->request->baseUrl . $picConfg['pathToTemp'] . $picConfg['tempFile'] , Yii::app()->request->baseUrl . $picConfg['pathToDir'] . $picConfg['newFile']);
                            $retArr[$pic] = '/' . $picConfg['pathToDir'] . $picConfg['newFile'];
                        } else {
                            //$retArr[$backup] = $pic;
                        }
                        //$retArr['backup'][] = $pic;
                    }
                } else {
                    $retArr[$backup] = $pic;
                }
            }
        } else {
            $file = 'images/storage/default.jpg';
            $newfile = '/images/storage/' . md5('default.jpg' . Yii::app()->user->name . time()) . '.jpg';

            if (!copy($file, substr($newfile,1))) {
                echo "failed to copy";
            }
            $retArr['/images/storage/default.jpg'] = Yii::app()->request->baseUrl . $newfile;
        }
        return $retArr;
    }
    
    public static function getPicInfo ($pic) {
        $tempArr = explode('/',$pic);
        $cnt = count($tempArr);
        $fileName = $tempArr[$cnt-1];
        $fileArr = explode('.',$fileName);
        $ext = $fileArr[1];
        $retArr['newFileName'] = md5($fileArr[0] . Yii::app()->user->name . time());
        $retArr['extension'] = $ext;
        $retArr['newFile'] = $retArr['newFileName'] . '.' . $ext;
        $retArr['tempFile'] = $fileName;
        $retArr['pathToDir'] = 'images/storage/';
        $retArr['pathToTemp'] = 'images/'.$tempArr[2].'/';
        return $retArr;
    }
    public static function trimFirstChar ($path) {
        $arr = json_decode($path);
        $retArr = array();
        foreach ($arr as $val) {
            $var = substr($val,1);
            $retArr[$var] = $var;
        }
        return json_encode($retArr);
    }
    public static function rollback ($rollbackArr) {
        foreach ($rollbackArr as $backup => $pic) {
            if (file_exists(Yii::app()->request->baseUrl . substr($pic,1))) {
                rename(Yii::app()->request->baseUrl . substr($pic,1) , Yii::app()->request->baseUrl . substr($backup,1));
            }
        }
    }
}
