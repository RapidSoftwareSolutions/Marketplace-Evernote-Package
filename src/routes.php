       <?php
       $routes = [
       'getToken',
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
       'isBusinessUser',
        'metadata'
       ];
       foreach ($routes as $file) {
           require __DIR__ . '/../src/routes/' . $file . '.php';
       }

