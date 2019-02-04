<?php

switch ($type)
{
    case 1:
        defineEmail("Verificación de pedido", generateCartEmail($datosEmail));
    break;
    case 2:
        defineEmail("Nuevo pedido realizado", "Se ha realizado y confirmado un nuevo pedido con el identificador #"+$idPedido);
    break;
    case 3:
        defineEmail("Pedido confirmado", "Hemos confirmado tu pedido, lo recibirá en la fecha escogida");
    break;
}

function defineEmail($asunto, $mensaje)
{
    define("ASUNTO", $asunto);
    define("MENSAJE", $mensaje);
}

function generateCartEmail($datosEmail)
{
    $html = "<html><head></head><body><table width=\"100%\" style=\"border-collapse: collapse\"><tr rowspan=\"2\" style=\"background-color: #333;\"><td colspan=\"2\"><img src=\"http://sfescuelahosteleria.ml/web/view/media/logo-hosteleria.png\" alt=\"LogoEgibide\"></td><td style=\"display: flex;flex-flow: row nowrap;align-items: center;justify-content: center;min-height: 76px\"><h4 id=\"fechaCorreo\" style=\"color: #FFF;\">unafecha</h4></td></tr><tr style=\"background-color: #e1e1e1;\"><td><h4>Nombre</h4></td><td><h4>Cantidad</h4></td><td><h4>Precio</h4></td></tr><tr><td style=\"padding-bottom: 5px\">Producto</td><td style=\"padding-bottom: 5px\">Cantidad</td><td style=\"padding-bottom: 5px\">Precio</td></tr><tr style=\"color: #FFF; background-color: #333333\"><td colspan=\"2\" style=\"text-align: right;padding: 5px 0px\"><span>Precio Total:</span></td><td style=\"padding:5px 0px\"><span>presio</span></td></tr><tr style=\"background-color: #e1e1e1\"><td colspan=\"3\" style=\"text-align: center\"><a href=\"#\"><button style=\"background-color: #82005e;color: #FFF;padding: 10px;margin: 5px 0px;border: none\">Confirmar tu pedido</button></a></td></tr></table></body></html>";
}