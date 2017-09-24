# centralAuth

A centralised authentication system. Author : Pierre HUBERT

CentralAuth is an authentication system that enable you to centralize the authentication for all your applications. Users have just to remember one username and one password for all your services !

centralAuth is written in PHP, recommended version is PHP 7.0 or newer with MySQL.


## Concept

The concept of CentralAuth is quite easy. Signing in is done through the following steps:
- The client application request the creation of a new login ticket, specifying a redirect URL, where user will be redirected once login on CentralAuth will be done (or cancelled).
- CentralAuth respond with a login ticket and a login URL where user should be redirected.
- The client application temporarily stores login ticket and redirect user to the URL given by CentralAuth.
- User perform login on CentralAuth, or if he is new (and if it is possible) create a new account.
- If this is the first time the user sign in for the client app, centralAuth prompt user agreement for sharing personnal informations with the client application. 
- If the user cancelled the operation :
	- Login token is cancelled
	- The user is redirected to the application
	- The client application can decide to start over login operation. In any case, the client application can't access personnal user informations
- If the user accepted to share its personnal informations with the client application :
	- The user is redirected to the application, and an authorization token is included in the redirection
	- The client application perform a request on the server to retrieve user informations, login ticket and authorization token are included in the request
	- CentralAuth returns informations about the user.


## Installation

* Grab the source code of the software on your server
* Database installation : create a database then import `application/config/central_auth_3_sept_2017_db_struct.sql` in your newly created database.
* Edit the configurations files located under `application/config`, and have a special look at `database.php`, `config.php` and `application.php`.


## Add applications

In order to add authorized client to the system, open the table `auth_applications` and then create new entries :
- name : The name of the application
- description : A short description of the application that will be shown to the client when the app redirects it to the service.
- client_id : The ID of the client (should be a long random-generated string)
- client_secret : The secret token of the cleint (should be a long random-generated string)


## Connect to the application

The application offers an API in its first version with just two methods
- POST /api/v1/create_ticket : Allow an application to create a login tickets. The following parametres are required:
  - client_id : The ID of the client
  - client_secret : The secret token of the client
  - redirect_url : The URL where user will be redirected, once logged in (must include %AUTHORISATION% in the URL : it will be replaced by an authorization tokent)

- POST /api/v1/get_user_infos : Once an user logged in the centralAuth, the client app can retrieve basic user informations. The followinf parametres are required
  - client_id : The ID of the client
  - client_secret : The secret token of the client
  - login_ticket : Login ticket used by user to sign into the application
  - authorization_token : The Authorization token returned by the application.


## About the security

A system like CentralAuth must be secured the most possible. On the client, there is not any Javascript file executed, except the bootstrap default javascript file. All the project is protected against CRSF attacks. Furthermore, login tickets and authorization tickets have a limited lifetime. Clients of the applications get automatically disconnected from CentralAuth after 3 minutes of inactivity (the parametres can be changed in the configuration).