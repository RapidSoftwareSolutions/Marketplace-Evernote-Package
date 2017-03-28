<?php
$app->post('/api/Evernote/getUser', function ($request, $response, $args) {
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
    $client = new \Evernote\AdvancedClient($token, $sandbox, null, null, $china);

    try {
        $user = $client->getUserStore()->getUser();
        $responseBody['id'] = $user->id;
        $responseBody['username'] = $user->username;
        $responseBody['email'] = $user->email;
        $responseBody['name'] = $user->name;
        $responseBody['timezone'] = $user->timezone;
        $responseBody['privilege'] = $user->privilege;
        $responseBody['created'] = $user->created;
        $responseBody['updated'] = $user->updated;
        $responseBody['deleted'] = $user->deleted;
        $responseBody['attributes'] = $user->attributes;
        $responseBody['accounting'] = get_object_vars($user->accounting);

        $result['callback'] = 'success';
        $result['callback'] = 'success';
        $result['contextWrites']['to'] = json_encode($responseBody);


    } catch (\Exception $exception) {
        $responseBody = $exception->getMessage();
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $responseBody;

    }

    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);

});