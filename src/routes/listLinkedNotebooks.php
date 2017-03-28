<?php
$app->post('/api/Evernote/listLinkedNotebooks', function ($request, $response, $args) {
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

        $notebooks = $client->listLinkedNotebooks();
        foreach ($notebooks as $notebook) {
            $responseBody[]['shareName'] = $notebook->shareName;
            $responseBody[]['username'] = $notebook->username;
            $responseBody[]['shardId'] = $notebook->shardId;
            $responseBody[]['shareKey'] = $notebook->shareKey;
            $responseBody[]['uri'] = $notebook->uri;
            $responseBody[]['guid'] = $notebook->guid;
            $responseBody[]['updateSequenceNum'] = $notebook->updateSequenceNum;
            $responseBody[]['noteStoreUrl'] = $notebook->noteStoreUrl;
            $responseBody[]['webApiUrlPrefix'] = $notebook->webApiUrlPrefix;
            $responseBody[]['stack'] = $notebook->stack;
            $responseBody[]['businessId'] = $notebook->businessId;
        }

        $result['callback'] = 'success';
        $result['contextWrites']['to'] = json_encode($responseBody);

    } catch (\Exception $exception) {
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = 'Api request exception';

    }

    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);

});