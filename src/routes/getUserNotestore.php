<?php
$app->post('/api/Evernote/getUserNotestore', function ($request, $response, $args) {
    $settings = $this->settings;

    //checking properly formed json
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['accessToken']);
    if (!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback'] == 'error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $post_data = $validateRes;
    }
    //forming request to vendor API

    $sandbox = $settings['sandbox'];
    $token = $post_data['args']['accessToken'];
    $china = $settings['china'];

    //requesting remote API
    $client = new \Evernote\Client($token, $sandbox, null, null, $china);
    try {
        $notestore = $client->getUserNotestore();
        $property = new \ReflectionProperty($notestore, 'url');
        $property->setAccessible(true);
        $value = $property->getValue($notestore);
        $result['callback'] = 'success';
        $result['contextWrites']['to'] = json_encode($value);

    } catch (\Exception $exception) {
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = 'Api request exception';

    }

    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);

});