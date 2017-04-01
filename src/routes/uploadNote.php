<?php
$app->post('/api/Evernote/uploadNote', function ($request, $response, $args) {
    $settings = $this->settings;

    //checking properly formed json
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['accessToken', 'noteTitle']);
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
        $note = new \Evernote\Model\Note();
        $note->title = $post_data['args']['noteTitle'];
        if (isset($post_data['args']['noteContent']) && strlen($post_data['args']['noteContent']) > 0) {
            $note->content = new \Evernote\Model\PlainTextNoteContent($post_data['args']['noteContent']);
        }
        $note->content = new \Evernote\Model\PlainTextNoteContent($post_data['args']['noteContent']);

        if (isset($post_data['args']['noteTags']) && strlen($post_data['args']['noteTags']) > 0) {
            $note->tagNames = $post_data['args']['noteTags'];
        }
        if (isset($post_data['args']['notebookGuid']) && strlen($post_data['args']['notebookGuid']) > 0) {
            $notebook = $client->getNotebook($post_data['args']['notebookGuid']);

        }
        $guid = $client->uploadNote($note, $notebook)->getGuid();
        $responseBody['guid'] = $guid;
        $result['callback'] = 'success';
        $result['contextWrites']['to'] = $responseBody;


    } catch (\Exception $exception) {
        $responseBody = $exception->getMessage();
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $responseBody;

    }

    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);

});