<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Entrada;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index(Router $router) {
        $propiedades = Propiedad::get(3);
        $entradas= Entrada::get(2);
        $inicio = true;

        $router -> render('paginas/index' , [
            'propiedades' => $propiedades,
            'inicio' => $inicio,
            'entradas' => $entradas
            

        ]);
    }

    public static function nosotros(Router $router) {
        $router -> render('paginas/nosotros', []);
        
    }

    public static function propiedades (Router $router) {
        $propiedades = Propiedad::all();
        $router -> render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }

    public static function propiedad(Router $router) {

        $id = validarORedireccionar('/propiedades');

        // Buscar la propiedad por su id
        $propiedad = Propiedad::find($id);

        $router -> render('paginas/propiedad', [
            'propiedad' => $propiedad


        ]);
        
    }

    public static function blog(Router $router) {
        $entradas = Entrada::all();
        $router -> render('paginas/blog', [
            'entradas' => $entradas

        ]);
    }

    public static function entrada(Router $router) {
        $id = validarORedireccionar('/');

        // Buscar la propiedad por su id
        $entradas = Entrada::find($id);
        


        $router -> render('paginas/entrada', [
            'entrada' => $entradas


        ]);
        
    }

    public static function contacto(Router $router) {

        $mensaje = null;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $respuestas = $_POST['contacto'];

            // Crear una instancia de PHPMailer
            $mail = new PHPMailer();

            //Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = 'a8d133eb290107';
            $mail->Password = '27f86e242c6aba';
            $mail->SMTPSecure = 'tls';
            $mail->Port = '2525';

            // Configurar el contenido del mail
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $mail->Subject = 'Tienes un Nuevo Mensaje';

            // Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            // Definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . ' </p>';
            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . ' </p>';
            $contenido .= '<p>Vende o Compra: ' . $respuestas['tipo'] . ' </p>';
            $contenido .= '<p>Precio o Presupuesto: $' . $respuestas['precio'] . ' </p>';

            // Enviar de forma condicional algunos campos de email o telefono

            if($respuestas['contacto'] === 'telefono') {
                $contenido .= '<p>Eligio ser contactado por: ' . $respuestas['contacto'] . ' </p>';
                $contenido .= '<p>Telefono: ' . $respuestas['telefono'] . ' </p>';
                $contenido .= '<p>Fecha Contacto: ' . $respuestas['fecha'] . ' </p>';
                $contenido .= '<p>Hora: ' . $respuestas['hora'] . ' </p>';

            } else {
                // Es email, entonces agregamos el campo de email
                $contenido .= '<p>Eligio ser contactado por: ' . $respuestas['contacto'] . ' </p>';
                $contenido .= '<p>Email: ' . $respuestas['email'] . ' </p>';
            }
            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es texto alternativo sin HTML';

            // Enviar el email
            if($mail->send()) {
                $mensaje =  'Mensaje enviado correctamente';
            } else {
                $mensaje =  'El mensaje no se pudo enviar';
            }

        }

        $router -> render('paginas/contacto' , [
            'mensaje' => $mensaje
        ]);
    }

    public static function usuarios(Router $router) {
        $router -> render('paginas/usuarios', []);
        
    }
    

}