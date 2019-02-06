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
                subject: '".ASUNTO."',
              },
            ],
            from: {email: '".EMAIL_SENDER."'},
            content: [
              {
                type: 'text/html',
                value:
                  '".MENSAJE."',
              },
            ],
          },
        });
        Sendgrid.API(request, function(error, response) {
          if (error) {
            console.log('Mail not sent; see error message below.');
          } else {
            console.log('Mail sent successfully!');
          }
          console.log(response);
        });
        ";
    fwrite($myfile, $txt);
    fclose($myfile);

    //Movemos el fichero al lugar adecuado para ejecutarlo
    //exec("mv ".JS_PATH.JS_NAME." ".EMAIL_MODULE_PATH);
    //Ejecutamos el archivo generado
    //exec("node ".EMAIL_MODULE_PATH.JS_NAME);
}

