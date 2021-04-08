<?php

require_once('./vendor/autoload.php');
require_once('./se.php');
require_once('./orderfunction.php');

$sqsdb = new sqsorder;



use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\RedirectResponse;

$request = Request::createFromGlobals();
$response = new Response();
$session = new Session(new NativeSessionStorage(), new AttributeBag());

$response->headers->set('Content-Type', 'application/json');
$response->headers->set('Access-Control-Allow-Headers', 'origin, content-type, accept');
$response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
$response->headers->set('Access-Control-Allow-Origin', 'http://localhost/');
$response->headers->set('Access-Control-Allow-Credentials', 'true');

$session->start();

if(!$session->has('sessionObj')) {
    $session->set('sessionObj', new sqsSession);
}

if(empty($request->query->all())) {
    $response->setStatusCode(400);
} elseif($request->cookies->has('PHPSESSID')) {
    if($session->get('sessionObj')->is_rate_limited()) {
        $response->setStatusCode(429);
    }
    if($request->getMethod() == 'POST') {             // register
        if($request->query->getAlpha('action') == 'displayorderfood') {
                    $res = $session->get('sessionObj')->displayorder();
                   return $res;  
                   $response->setStatusCode(400);
            }
        elseif($request->query->getAlpha('action') == 'orderquantity') {    
                if($request->request->has('F_ID') and
                    $request->request->has('price')   and
                    $request->request->has('description') and
                    $request->request->has('image') and
                    $request->request->has('options')   ) {
                        $response->setStatusCode(201);
                   $res = $session->get('sessionObj')->orderquantity(
                        $request->request->get('foodname'),
                        $request->request->get('price'),    
                        $request->request->get('description'),
                        $request->request->get('options'),
                        $request->request->get('image')
                    );
                    if($res === true) {
                        $response->setStatusCode(201);
                    } elseif($res === false) {
                        $response->setStatusCode(403);
                    } elseif($res === 0) {
                        $response->setStatusCode(500);
                    }
                }
           else {
                $response->setStatusCode(400);
            }
        }
    if($request->getMethod() == 'DELETE') {           // delete queue, delete comment
        $response->setStatusCode(400);
    }
    if($request->getMethod() == 'PUT') {              // enqueue, add comment
        $response->setStatusCode(400);
    }
}
}
 else {
    $redirect = new RedirectResponse($_SERVER['REQUEST_URI']);
}

// Do logging just before sending response?

$response->send();

?>