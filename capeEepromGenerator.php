<style type="text/css">
  .dataRecordFileNameRow{
    display: none;
  }
  .dataRecordType-0-49 .dataRecordFileNameRow{
    display: block;
  }
  .dataRecordData{
    display: none;
  }
  .dataRecordInputType-textarea .dataRecordData{
    display: block;
  }
  .dataRecordInputType-textarea .dataRecordFile{
    display: none;
  }
  #addDataRecord{
    margin-top: 0.5em;
  }
  #generate{
    margin-top: 1em;
  }
</style>
<div id="global" class="settings">
<script src="/plugin.php?plugin=fpp-CapeEepromGenerator&page=capeEepromGenerator.js&nopage=1"></script>
<form id="capeEepromGeneratorForm"></form>
<div>
  <label for="eepromIdentifierFormat">
    EEPROM Identifier Format
  </label>
  <input type="text" id="eepromIdentifierFormat" maxlength=5 value="FPP02">
</div>
<div>
  <label for="capeName">Cape Name</label>
 <input type="text" id="capeName" maxlength=25 placeholder="My FPP Cape" value="PXLS-BBB-16"> 
</div>
<div>
  <label for="capeVersion">Cape Version</label>
 <input type="text" id="capeVersion" maxlength=9 value="1.0"> 
</div>
<div>
  <label for="capeSerialNumber">Cape Serial Number</label>
 <input type="text" id="capeSerialNumber" maxlength=14 value="123456789"> 
</div>
<template id="dataRecordTemplate">
  <div class="dataRecord backdrop mb-2">
    CODE (0-99 number representing the type of record)

    <input type="number" maxlength=2 class="dataRecordType" list="dataRecordTypes">
    <div class="dataRecordFields">
      <div class="dataRecordFileNameRow"><label for="dataRecordFileName">Target File Path:</label><input maxlength=62 class="dataRecordFileName" value="tmp/cape-info.json"></div>
      <div class="dataRecordDataFields" style="display:none;">
      <div>
        <label for="dataRecordData">Data:</label>
                <label for="">File</label><input type="radio" name="dataRecordInputType" value="file" checked/>
        <label for="">Text Input</label><input type="radio" name="dataRecordInputType" value="textarea"/>

      </div>
      <div>
        

        <textarea cols="30" rows="10" class="dataRecordData"></textarea>
      <input type="file" class="dataRecordFile"/>  
      </div>
      </div>
    </div>
    </input>
  </div>
</template>
<div id="dataRecords"></div>
<button class="buttons btn-outline-success btn-icon-add"id="addDataRecord"><i class="fas fa-plus"></i> Add Data Record</button>
<div><button id="generate" class="buttons btn-success btn-lg">Generate EEPROM bin</button></div>

    <datalist id="dataRecordTypes">
      <option value="0">File (Uncompressed)</option>
      <option value="1">ZIP Archive (unzip  called on the file)</option>
            <option value="2">TGZ Archive (tar -xzf is called on the file)</option>
    </datalist>
</div>