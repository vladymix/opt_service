<?php


class HttpStatus{
    const OK = 200; //   Úsalo para especificar que un recurso o colección existe
    const Created = 201;  //Puedes usarlo para especificar que se creó un recurso. Se puede complementar con el header Location para especificar la URI hacia el nuevo recurso.
    const NoContent= 204;   //Representa un resultado exitoso pero sin retorno de algún dato (viene muy bien en DELETE).
    const NoModified  = 304;//Indica que un recurso o colección no ha cambiado.
    const Unauthorized= 401; //Indica que el cliente debe estar autorizado primero antes de realizar operaciones con los recursos
    const NotFound =404;   // Ideal para especificar que el recurso buscado no existe
    const MethodNotAllowed = 405; // Nos permite expresar que el método relacionado a la url no es permitido en la api
    const NotAcceptable=406;    //Para indicar que el server no puede generar una respuesta a un aconsulta SQL mal planteada
    const UnprocessableEntity=422;//    Va muy bien cuando los parámetros que se necesitaban en la petición no están completos o su sintaxis es la incorrecta para procesar la petición.
    const TooManyRequests = 429; //   Se usa para expresarle al usuario que ha excedido su número de peticiones si es que existe una política de límites.
    const InternalServerError = 500; //  Te permite expresar que existe un error interno del servidor.
    const ServiceUnavailable=503; // Este código se usa cuando el servidor esta temporalmente fuera de servicio.
    const Conflict=409;// duplicados
    const BadRequest=400; //
    const ErrorExecute =420; 
}