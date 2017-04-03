[![](https://scdn.rapidapi.com/RapidAPI_banner.png)](https://rapidapi.com/package/Evernote/functions?utm_source=RapidAPIGitHub_EvernoteFunctions&utm_medium=button&utm_content=RapidAPI_GitHub)

# Evernote Package
Evernote
* Domain: [Evernote](http://evernote.com)
* Credentials: accessToken

## How to get credentials: 
0. Go to [Evernote](http://evernote.com)
1. Request developer token using [This page](https://www.evernote.com/api/DeveloperToken.action) 

## Evernote.isBusinessUser
Returns a boolean indicating if the user has a business account

| Field      | Type       | Description
|------------|------------|----------
| accessToken| credentials| Access token received from Evernote

## Evernote.listNotebooks
Returns the list of notebooks

| Field      | Type       | Description
|------------|------------|----------
| accessToken| credentials| Access token received from Evernote

## Evernote.listPersonalNotebooks
Returns the list of personal notebooks

| Field      | Type       | Description
|------------|------------|----------
| accessToken| credentials| Access token received from Evernote

## Evernote.listSharedNotebooks
Returns the list of notebooks shared by the user

| Field      | Type       | Description
|------------|------------|----------
| accessToken| credentials| Access token received from Evernote

## Evernote.listLinkedNotebooks
Returns the list of notebooks shared to the user

| Field      | Type       | Description
|------------|------------|----------
| accessToken| credentials| Access token received from Evernote

## Evernote.getNote
Retrieves an existing note

| Field      | Type       | Description
|------------|------------|----------
| accessToken| credentials| Access token received from Evernote
| noteGuid   | String     | Guid of the note

## Evernote.uploadNote
Upload new Note to the API

| Field       | Type       | Description
|-------------|------------|----------
| accessToken | credentials| Access token received from Evernote
| noteTitle   | String     | Title of the note
| noteContent | String     | Content of the note
| noteTags    | Array      | Tags of the note
| notebookGuid| String     | Guid of the notebook to add to

## Evernote.replaceNote
Replaces an existing note by another one

| Field      | Type       | Description
|------------|------------|----------
| accessToken| credentials| Access token received from Evernote
| noteTitle  | String     | Title of the note
| noteContent| String     | Content of the note
| noteTags   | Array      | Tags of the note
| noteGuid   | String     | Guid of the note to replace

## Evernote.deleteNote
Delete an existing note

| Field      | Type       | Description
|------------|------------|----------
| accessToken| credentials| Access token received from Evernote
| noteGuid   | String     | Guid of the note

## Evernote.shareNote
Share an existing note

| Field      | Type       | Description
|------------|------------|----------
| accessToken| credentials| Access token received from Evernote
| noteGuid   | String     | Guid of the note

## Evernote.moveNote
Move an existing note

| Field       | Type       | Description
|-------------|------------|----------
| accessToken | credentials| Access token received from Evernote
| noteGuid    | String     | Guid of the note
| notebookGuid| String     | Guid of the notebook

## Evernote.isAppNotebookToken
Checks if the token is an "app notebook" one

| Field      | Type       | Description
|------------|------------|----------
| accessToken| credentials| Access token received from Evernote
| noteGuid   | String     | Guid of the note
| token      | String     | Token to check

## Evernote.getNotebook
Get an existing notebook info

| Field       | Type       | Description
|-------------|------------|----------
| accessToken | credentials| Access token received from Evernote
| notebookGuid| String     | Guid of the notebook

## Evernote.findNotesWithSearch
Searches for notes

| Field       | Type       | Description
|-------------|------------|----------
| accessToken | credentials| Access token received from Evernote
| notebookGuid| String     | Guid of the notebook
| query       | String     | String to find
| sortOrder   | Number     | Sort order: Normal=0(default), Recently Created = 2, Recently Updated = 4, Relevance = 8, Reverse = 65536, Title=1
| maxResults  | Number     | Max number of results

## Evernote.getUser
Returns the User corresponding to the provided authentication token

| Field      | Type       | Description
|------------|------------|----------
| accessToken| credentials| Access token received from Evernote

