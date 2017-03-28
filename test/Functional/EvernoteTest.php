<?php

namespace Test\Functional;

require_once(__DIR__ . '/../../src/Models/checkRequest.php');

class DiscordBotTest extends BaseTestCase
{

    public function testListMetrics()
    {

        $routes = [
            'getUser',
            'findNotesWithSearch',
            'getNotebook',
            'isAppNotebookToken',
            'moveNote',
            'shareNote',
            'deleteNote',
            'replaceNote',
            'uploadNote',
            'getNote',
            'getUserNotestore',
            'listLinkedNotebooks',
            'listSharedNotebooks',
            'listPersonalNotebooks',
            'listNotebooks',
            'isBusinessUser'
        ];

        foreach ($routes as $file) {
            $var = '{  
                    }';
            $post_data = json_decode($var, true);

            $response = $this->runApp('POST', '/api/Evernote/' . $file, $post_data);

            $this->assertEquals(200, $response->getStatusCode(), 'Error in ' . $file . ' method');
        }
    }

}
