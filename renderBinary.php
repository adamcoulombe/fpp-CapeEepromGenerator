<?php

function getNullPaddedByteArray($value,$byteLength){
    $byteArray=unpack("C*",$value);
    for($i=count($byteArray); $i<$byteLength; $i++){
        array_push($byteArray,0);
    }
    return $byteArray;
}
function pushToBufferArray($a,$b){
    foreach($b as $c){
        array_push($a,$c);
    }
    return $a;
}
    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    } else {
        
        // $filename = $_FILES['file']['tmp_name'];
        // $handle = fopen($filename, "rb");
        // $fsize = filesize($filename);
        // $contents = fread($handle, $fsize);
        // fclose($handle);
        $dataFields=json_decode($_POST['dataFields']);
        $bufferArray=array();
        //{"eepromIdentifierFormat":"FPP02","capeName":"test cape","capeVersion":"2","capeSerialNumber":"1234567","dataRecords":[{"fileName":"tmp/cape-info.tgz","type":"file","fileId":0}]}
        $bufferArray = pushToBufferArray($bufferArray,getNullPaddedByteArray($dataFields->eepromIdentifierFormat,6));
        $bufferArray = pushToBufferArray($bufferArray,getNullPaddedByteArray($dataFields->capeName,26));
        $bufferArray = pushToBufferArray($bufferArray,getNullPaddedByteArray($dataFields->capeVersion,10));
        $bufferArray = pushToBufferArray($bufferArray,getNullPaddedByteArray($dataFields->capeSerialNumber,16));
        print_r($dataFields);
        $dataRecord_i=0;
        foreach($dataFields->dataRecords as $dataRecord){
            $dataRecordData=array();
            if($dataRecord->type=="file"){
                $filename = $_FILES['file_'.$dataRecord_i]['tmp_name'];
                $handle = fopen($filename, "rb");
                $fsize = filesize($filename);
                $contents = fread($handle, $fsize);
                fclose($handle);
                $dataRecordData = unpack('C*',$contents);
            }else{
                $dataRecordData = $dataRecord->data;
            }
            $dataRecordDataLength = count($dataRecordData);
            $bufferArray = pushToBufferArray($bufferArray,getNullPaddedByteArray($dataRecordDataLength,6));
            $bufferArray = pushToBufferArray($bufferArray,getNullPaddedByteArray($dataRecord->code,2));
            if(property_exists($dataRecord, 'fileName')){
                $bufferArray = pushToBufferArray($bufferArray,getNullPaddedByteArray($dataRecord->fileName,64));
            }
            $bufferArray = pushToBufferArray($bufferArray,$dataRecordData);
            $dataRecord_i++;
        }

        //$buffer=unpack('C*',$bufferArray);
        // print_r(call_user_func_array("pack", array_merge(array("C*"), $unpacked)));
        //print_r(pack('C*', $unpacked));
       // $string_encoded = iconv( mb_detect_encoding( $buffer ), 'Windows-1252//TRANSLIT', $buffer );
       
       
       $file = fopen( "/home/fpp/media/config/cape-eeprom.bin", "w+");
       fwrite($file, call_user_func_array("pack", array_merge(array("C*"), $bufferArray)));
       fclose($file);
    }

?>