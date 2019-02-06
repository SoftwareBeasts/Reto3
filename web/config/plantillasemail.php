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
        defineEmail("Pedido confirmado", generateConfirmationEmail($datosEmail));
    break;
    case 4:
        defineEmail($datosEmail["asunto"], $datosEmail["mensaje"]);
    break;
}

function defineEmail($asunto, $mensaje)
{
    define("ASUNTO", $asunto);
    define("MENSAJE", $mensaje);
}

function generateCartEmail($datosEmail)
{
    return "<html><head></head><body style=\"font-family: Arial;\"><table width=\"35%\" style=\"border-collapse: collapse\"><tr rowspan=\"2\" style=\"boder: 1px sollid\"><td colspan=\"2\"><img src=\"http://sfescuelahosteleria.ml/web/view/media/logo-hosteleria.png\" alt=\"LogoEgibide\"></td><td style=\"display: flex;flex-flow: row nowrap;align-items: center;justify-content: center;min-height: 38px\"><p id=\"pedido\" style=\"color: #000;\"><strong>".$datosEmail["idPedido"]."</strong></p></td><td style=\"display: flex;flex-flow: row nowrap;align-items: center;justify-content: center;min-height: 38px\"><p id=\"fechaCorreo\" style=\"color: #000;\"><strong>".$datosEmail["fecha"]."</strong></p></td></tr><tr style=\"background-color: #f2f2f2;\"><td style=\"padding: 10px;\" ><strong>Nombre</strong></td><td><strong>Cantidad</strong></td><td><strong>Precio</strong></td></tr>".$datosEmail["cartHtml"]."<tr style=\"color: #000; \"><td colspan=\"2\" style=\"text-align: right;padding: 5px 0px\"></td><td style=\"padding:5px 0px\"><h2><span>".$datosEmail["precioTotal"]."€</span></h2></td></tr></table></body></html>";
}

function generateConfirmationEmail($datosEmail)
{
    return "<html><head></head><body style=\"font-family: Arial;\"><table width=\"35%\" style=\"border-collapse: collapse\"><tr rowspan=\"2\" style=\"boder: 1px sollid\"><td colspan=\"2\"><img src=\"http://sfescuelahosteleria.ml/web/view/media/logo-hosteleria.png\" alt=\"LogoEgibide\"></td><td style=\"display: flex;flex-flow: row nowrap;align-items: center;justify-content: center;min-height: 76px\"><p id=\"pedido\" style=\"color: #000;\"><strong>".$datosEmail["idPedido"]."</strong></p></td></tr><tr><td style=\"padding-top: 30px;\" colspan=\"3\"><p style=\"text-align: center;\">Hemos confirmado tu pedido, lo recibirá el día <strong>".$datosEmail["fecha"]."</strong></p></td></tr></table></body></html>";
}