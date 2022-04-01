# FPP Cape EEPROM Generator

This plugin is a utility for generating an EEPROM binary for configuring a custom BBB Cape for FPP. This is only for cape designers or developers and is not intended to be used by most FPP users.

 Configurable fields are based on [FPP's eeprom format](https://github.com/FalconChristmas/fpp/blob/master/docs/EEPROM.txt)

## How to use

You can install that plugin by following the method "[Retrieve Plugin Info](https://falconchristmas.github.io/FPP_Manual%285.0%29.pdf#page=101)" in the FPP manual . (You need to be on the latest 5.5 since there was a bug in earlier versions of 5.x that were problematic for this install method)

In a nutshell, enter the following url into the input field at the top of the plugins page:

`https://raw.githubusercontent.com/adamcoulombe/fpp-CapeEepromGenerator/master/pluginInfo.json`

Then you can click the "Get Plugin Info" button and you should see a new available plugin appear, and you can click install:

![FPP Get Plugin Info](https://i.ibb.co/9n3XHW8/image-1.png)  

Once the plugin is installed, you can access it under the "Input/Output" menu, the page allows you to configure various fields for your eeprom. With eeproms, you can add multiple "data records". This can be basically a zip package containing files like string configuration and presumably other things (take a look at the cape-info.tgz used by computergeek1507's BBB16-Flex for reference). The zip or tgz package basically gets unzipped into /home/fpp/media/tmp which in effect allow you to load in your own config files. I don't know a lot about all the files you can put in this zip package to configure things, but at a minimum you'll probably want to have a cape-info.json and probably a strings/YOUR_CAPE.json .

![fpp cape eeprom generator screenshot](https://i.ibb.co/r2p8gBP/image.png)

When you click "Generate EEPROM bin" it will generate an eeprom file and save it into /home/fpp/media/config . This way, when you reboot the device, it will automatically load that binary as a "virtual eeprom", this way you can test out the eeprom binary you just made.

Once you are happy with the binary, you will need to get the cape-eeprom.bin from the /home/fpp/media/config folder on the device and ultimately you can burn this file to an eeprom.