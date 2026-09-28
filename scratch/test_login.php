<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$requestGet = Illuminate\Http\Request::create('/login', 'GET');
$responseGet = $kernel->handle($requestGet);

$session = $requestGet->hasSession() ? $requestGet->session() : null;
$token = csrf_token();

echo "CSRF Token: " . $token . "\n";

$requestPost = Illuminate\Http\Request::create('/login', 'POST', [
    '_token' => $token,
    'login' => 'admin',
    'password' => 'admin123',
    'remember' => 'on',
]);
if ($session) {
    $requestPost->setLaravelSession($session);
}

$responsePost = $kernel->handle($requestPost);

echo "POST Response Status: " . $responsePost->getStatusCode() . "\n";
if ($responsePost->isRedirect()) {
    echo "Redirect Target: " . $responsePost->getTargetUrl() . "\n";
} else {
    echo "Response Content Preview: " . substr($responsePost->getContent(), 0, 300) . "\n";
}
