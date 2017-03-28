<?php
$app->post('/api/Evernote/getNotebook', function ($request, $response, $args) {
    $settings = $this->settings;

    //checking properly formed json
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['accessToken', 'notebookGuid']);
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
        $notebook = $client->getNotebook($post_data['args']['notebookGuid']);

        $responseBody['guid'] = $notebook->getEdamNotebook()->guid;
        $responseBody['name'] = $notebook->getEdamNotebook()->name;
        $responseBody['updateSequenceNum'] = $notebook->getEdamNotebook()->updateSequenceNum;
        $responseBody['defaultNotebook'] = $notebook->getEdamNotebook()->defaultNotebook;
        $responseBody['created'] = $notebook->getEdamNotebook()->serviceCreated;
        $responseBody['updated'] = $notebook->getEdamNotebook()->serviceUpdated;

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