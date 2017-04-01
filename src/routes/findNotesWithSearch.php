<?php
$app->post('/api/Evernote/findNotesWithSearch', function ($request, $response, $args) {
    $settings = $this->settings;

    //checking properly formed json
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['accessToken', 'notebookGuid', 'query']);
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
        $sortOrder = isset($post_data['args']['sortOrder']) ? $post_data['args']['sortOrder'] : 2;
    if(isset($post_data['args']['maxResults']) && strlen($post_data['args']['maxResults']) > 0) {
        $results = $client->findNotesWithSearch($post_data['args']['query'], $notebook, null, $sortOrder, $post_data['args']['maxResults']);
    } else {
        $results = $client->findNotesWithSearch($post_data['args']['query'], $notebook, null, $sortOrder);
    }
        foreach ($results as $note) {
            $responseBody[]['guid'] = $note->guid;
            $responseBody[]['title'] = $note->title;
            $responseBody[]['content'] = $note->content;
            $responseBody[]['created'] = $note->created;
            $responseBody[]['created'] = $note->created;
            $responseBody[]['updated'] = $note->updated;
            $responseBody[]['deleted'] = $note->deleted;
            $responseBody[]['active'] = $note->active;
            $responseBody[]['updateSequenceNum'] = $note->updateSequenceNum;
            $responseBody[]['notebookGuid'] = $note->notebookGuid;
            $responseBody[]['tagGuids'] = $note->tagGuids;
            $responseBody[]['resources'] = $note->resources;
        }

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