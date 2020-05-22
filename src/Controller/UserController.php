<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController
{
    public function test()
    {
        return new Response(
            '<html><body>Hello world! Soy el primer usuario de Docker!</body></html>'
        );
    }

    public function getUsers(Connection $connection)
    {
        $result = $connection->fetchAll('SELECT * FROM users');

        return new JsonResponse($result);
    }

    public function createUser(Request $request, Connection $connection)
    {
        $name = $request->query->get('nombre');
        $lastname = $request->query->get('apellido');
        $email = $request->query->get('email');

        $count = $connection->executeUpdate("
            INSERT INTO `db`.`users` (`name`, `lastname`, `email`)
            VALUES ('".$name."', '".$lastname."', '".$email."');
        ");

        return new Response($count == 1 ? 'Usuario guardado' : 'No se ha podido guardar el usuario');
    }
}