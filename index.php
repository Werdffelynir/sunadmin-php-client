<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/APIHelper.php';
require __DIR__ . '/src/APIHandler.php';


const SERVER_ADDRESS = 'http://sunadmin.loc/api';

$app = AppFactory::create();



$app->get('/', function (Request $request, Response $response, $args) {

    $response
        ->getBody()
        ->write('API');

    return $response;
});



$app->post('/mail', function (Request $request, Response $response, $args) {
    $params = $request->getParsedBody();

    $result = APIHandler:: httpResponse('GET', SERVER_ADDRESS . '/mail', [
        'file' => $params['file'],
        'subject' => $params['roll'],
        'message' => $params['message']
    ]);

    $response
        ->getBody()
        ->write(APIHelper::json($result));

    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});



$app->get('/chunks', function (Request $request, Response $response) {
    $params = $request->getQueryParams();
    $key = empty($params['key']) ? false : $params['key'];
    $result = null;

    if ($key) {
        $result = APIHandler:: httpResponse('GET', SERVER_ADDRESS . '/chunks?key=' . 'page');
    }

    $responseData = [
        'ok' => !!$key,
        'query' => $params,
        'result' => $result && $result['httpCode'] === 200 ? $result['data'] : array()
    ];

    $response
        ->getBody()
        ->write(APIHelper::json($responseData));

    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});



$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function(Request $request, Response $response) {
    return $response
        ->withStatus(404)
        ->withHeader('Content-Type', 'text/html');
});



$app->run();