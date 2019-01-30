<?php

require __DIR__ . "/../config/emailConf.php";

if(SEND_MAIL)
{
    //Generamos el fichero
    $myfile = fopen(JS_PATH.JS_NAME, "w") or die("Unable to open file!");
    $txt = "
        const sendgrid = require('@sendgrid/mail');
        sendgrid.setApiKey(process.env.SENDGRID_API_KEY || '".API_KEY."');
        
        async function sendgridExample() {
          await sendgrid.send({
            to: '".$userEmail."',
            from: '".EMAIL_SENDER."',
            subject: '".$subject."',
            text:
              '".$body."',
          });
        }
        sendgridExample().catch(console.error);
        ";
    fwrite($myfile, $txt);
    fclose($myfile);

    //Movemos el fichero al lugar adecuado para ejecutarlo
    exec("mv ".JS_PATH.JS_NAME." ".EMAIL_MODULE_PATH);
    //Ejecutamos el archivo generado
    exec("node ".EMAIL_MODULE_PATH.JS_NAME);
}

