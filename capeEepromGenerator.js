
$(()=>{
    $('#generate').click(()=>{
      var form_data = new FormData();      
        var dataFields = {
            eepromIdentifierFormat:$('#eepromIdentifierFormat').val(),
            capeName:$('#capeName').val(),
            capeVersion:$('#capeVersion').val(),
            capeSerialNumber:$('#capeSerialNumber').val(),
            dataRecords:[]
          };
        
        $('.dataRecord').each(function(i){
          var isFile = !$(this).hasClass('dataRecordInputType-textarea');
          var record = {};
          if(parseInt($('.dataRecordType',$(this)).val())<50){
            record.fileName = $('.dataRecordFileName',$(this)).val()
          }
          record.code=$('.dataRecordType',$(this)).val();
          if(isFile==true){
            record.type='file';
            record.fileId = i;
            var file_data = $('input[type=file]:eq(0)',$(this)).prop('files')[0];   
                        
            form_data.append('file_'+i, file_data);
          } else{
              record.type='textarea';
              record.data = $('.dataRecordData',$(this)).val();
          } 
          dataFields.dataRecords.push(record);
        })
        form_data.append('dataFields', JSON.stringify(dataFields))



        $.ajax({
            url: '/plugin.php?plugin=fpp-CapeEepromGenerator&page=renderBinary.php&nopage=1', 
            dataType: 'text', 
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(php_script_response){
                console.log(php_script_response); 
                $.jGrowl('Binary saved in /home/fpp/media/config',{themeState:'success'});
            }
         });
    });
  $('#addDataRecord').click(()=>{
    var $newDataRecord = $($('#dataRecordTemplate').html());
    $('#dataRecords').append($newDataRecord);
    function switchDataRecordInputType(dataRecordInputType){
      if(dataRecordInputType=='textarea'){
        $($newDataRecord).addClass('dataRecordInputType-textarea');
      }else{
        $($newDataRecord).removeClass('dataRecordInputType-textarea');
      }      
    }
    $('[name=dataRecordInputType]',$newDataRecord).on('change',function(){
      switchDataRecordInputType($(this).val());
    });
    $('.dataRecordFile',$newDataRecord).on('input', function() {

      var reader = new FileReader();
      reader.onload = function() {
        var arrayBuffer = this.result,
          array = new Uint8Array(arrayBuffer);
        
          $('.dataRecordFile',$newDataRecord).data('buffer',array);

      }
      reader.readAsArrayBuffer(this.files[0]);

    });
    $('.dataRecordType',$newDataRecord).on('input',function(){
      var dataRecordTypeInt = parseInt($(this).val());
      if($(this).val()!=''){
        $('.dataRecordDataFields',$newDataRecord).show();
      }else{
        $('.dataRecordDataFields',$newDataRecord).hide();
      }
      if(dataRecordTypeInt<50){
        $($newDataRecord).addClass('dataRecordType-0-49');
        $('input[value=file]',$newDataRecord).prop("checked", true);
        switchDataRecordInputType('file');
        if(dataRecordTypeInt==0){
          $(this).parent().find('.dataRecordFileName').val('tmp/cape-info.json');
        }else if(dataRecordTypeInt==1){
          $(this).parent().find('.dataRecordFileName').val('tmp/cape-info.zip');
        }else if(dataRecordTypeInt==2){
          $(this).parent().find('.dataRecordFileName').val('tmp/cape-info.tgz');
        }
      }else{
        $($newDataRecord).removeClass('dataRecordType-0-49')
        $('input[value=textarea]',$newDataRecord).prop("checked", true);
        switchDataRecordInputType('textarea');
      }
    })
  })
})


