<?php
$app->post('/api/Evernote/getNote', function ($request, $response, $args) {
    $settings = $this->settings;

    //checking properly formed json
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['accessToken', 'noteGuid']);
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
        $note = $client->getNote($post_data['args']['noteGuid']);

        $responseBody['guid'] = $note->getEdamNote()->guid;
        $responseBody['title'] = $note->getEdamNote()->title;
        $responseBody['content'] = $note->getEdamNote()->content;
        $responseBody['created'] = $note->getEdamNote()->created;
        $responseBody['updated'] = $note->getEdamNote()->updated;
        $responseBody['deleted'] = $note->getEdamNote()->deleted;
        $responseBody['active'] = $note->getEdamNote()->active;
        $responseBody['updateSequenceNum'] = $note->getEdamNote()->updateSequenceNum;
        $responseBody['notebookGuid'] = $note->getEdamNote()->notebookGuid;
        $responseBody['tagGuids'] = $note->getEdamNote()->tagGuids;
        $responseBody['resources'] = $note->getEdamNote()->resources;

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