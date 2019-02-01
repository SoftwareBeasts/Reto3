<?php

require __DIR__ . "/../config/emailConf.php";

if(SEND_MAIL)
{
    //Generamos el fichero
    $myfile = fopen(JS_PATH.JS_NAME, "w") or die("Unable to open file!");
    $txt = "
        var Sendgrid = require('sendgrid')(
          process.env.SENDGRID_API_KEY || '".API_KEY."'
        );
        
        var request = Sendgrid.emptyRequest({
          method: 'POST',
          path: '/v3/mail/send',
          body: {
            personalizations: [
              {
                to: [{email: '".$userEmail."'}],
                subject: '".$subject."',
              },
            ],
            from: {email: '".EMAIL_SENDER."'},
            content: [
              {
                type: 'text/html',
                value:
                  '".$body."',
              },
            ],
          },
        });
        ";
    fwrite($myfile, $txt);
    fclose($myfile);

    //Movemos el fichero al lugar adecuado para ejecutarlo
    exec("mv ".JS_PATH.JS_NAME." ".EMAIL_MODULE_PATH);
    //Ejecutamos el archivo generado
    exec("node ".EMAIL_MODULE_PATH.JS_NAME);
}

