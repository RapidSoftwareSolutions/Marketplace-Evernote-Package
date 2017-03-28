<?php
$app->post('/api/Evernote/listNotebooks', function ($request, $response, $args) {
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
        $notebooks = $client->listNotebooks();
        if (!empty($notebooks)) {
            foreach ($notebooks as $notebook) {
                $responseBody[]['name'] = $notebook->name;
                $responseBody[]['guid'] = $notebook->guid;
                $responseBody[]['isBusinessNotebook'] = $notebook->isBusinessNotebook;
                $responseBody[]['isDefaultNotebook'] = $notebook->isDefaultNotebook;
                $responseBody[]['isLinkedNotebook'] = $notebook->isLinkedNotebook;
            }
            $result['callback'] = 'success';
            $result['contextWrites']['to'] = json_encode($responseBody);
        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = 'API_ERROR';
            $result['contextWrites']['to']['status_msg'] = 'API request error';
        }

    } catch (\Exception $exception) {
        $responseBody = $exception->getMessage();
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $responseBody;

    }

    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);

});