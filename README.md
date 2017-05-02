SymfonyZero API
================

# What is?
 
SymfonyZero-API is a free fully functional kickstarter edition. You can use it as a base for your Symfony web projects with a Web API architecture. SymfonyZero-API helps you to build web projects more quickly, saving time in the early stages of the development. You can build the backend with Symfony offering an API Rest which you can use to connect the frontend made with another technology.

In this documentation you can learn about how to install, configure and how you can help to improve it. SymfonyZero-API is an alive project and we'll be adding new features and improvements, so stay tuned for new updates.

If you detect an error, you know how to improve it or you have an idea about this edition, please, fix it, do it or write us!

# Requirements

SymfonyZero-API uses the last LTS version: Symfony 2.8 (although you can change it easily), so you need to keep in your mind these requirements:

**Mandatory**
 ```
* PHP needs to be a minimum version of PHP 5.3.9 (recommended 5.5.9 or higher)
* JSON needs to be enabled
* ctype needs to be enabled
* Your php.ini needs to have the date.timezone setting
 ```
 
 **Optional**
  ```
*  You need to have the PHP-XML module installed
*  You need to have at least version 2.6.21 of libxml
*  PHP tokenizer needs to be enabled
*  mbstring functions need to be enabled
*  iconv needs to be enabled
POSIX needs to be enabled (only on *nix)
*  Intl needs to be installed with ICU 4+
*  APC 3.0.17+ (or another opcode cache needs to be installed)
*  php.ini recommended settings
        - short_open_tag = Off
        - magic_quotes_gpc = Off
        - register_globals = Off
        - session.auto_start = Off
 ```
 
 If you change the Symfony version, these requirements could change. In this case you must visit the [official site](http://symfony.com/doc/current/reference/requirements.html) to check them.
   
 Note: Doctrine Data Fixtures Extension needs PHP 5.6 or higher, so if you want to use it, you have to ensure at least that version of PHP is installed.
 
 Also, to install the bundle to integrate with ElasticSearch, you need to follow several steps. First, we have to activate the bundle. Open _app/AppKernel.php_ file and uncomment the line:
 
 ```sh
 new FOS\ElasticaBundle\FOSElasticaBundle()
 ```
 Then, we have to activate the listener for indexing users. Open _app/config/services.yml_ file and uncomment the lines:
 
 ```sh
     symfonyzero.elastica_listener_users:
        class: AppBundle\Listener\UsersListener
        #Object_persister: entity indexed at elasticsearch.yml config file 
        arguments:
            - @fos_elastica.object_persister.symfonyzero.user
            - @fos_elastica.indexable
        calls:
            - [ setContainer, ['@service_container'] ]
        tags:
            - { name: doctrine.event_listener, event: postPersist }
            - { name: doctrine.event_listener, event: postUpdate }
            - { name: kernel.event_listener, event: kernel.terminate, method: onKernelTerminate }
 ```
 Finally, we have to include the elasticsearch config file. Open _app/config/config.yml_ file and uncomment the line:
 
 ```sh
            - { resource: elasticsearch.yml }
 ```

# Setup
 
  Install SymfonyZero-API as base of your projects is very easy. You have two options, one using the automatic script for the installation (if you choose this option, please jump to the next section), or following the step by step tutorial. If you prefer to install it manually to know all the process, please read the following instructions.
  
First, you have to clone this repository in your web root directory:
 
```sh
$ git clone https://github.com/Emergya/SymfonyZero-API.git
```

To use Doctrine Data Fixtures you need PHP 5.6 or higher, so if you have previous version installed and you don't want to upgrade it, you have to remove this dependency in _composer.json_ deleting the line:

```json
"doctrine/doctrine-fixtures-bundle": "^2.3"
```


Then, you have to install vendors using Composer. If you don't have Composer installed, follow the instructions that you can find in [his web site](https://getcomposer.org/). Once you have Composer installed you'll can install vendors:

 ```sh
$ composer install
```

Make sure you set up right permission to run correctly the application. To do this, you can follow the instructions you can find in the [official book](http://symfony.com/doc/current/book/installation.html#book-installation-permissions).

By default, SymfonyZero-API uses MySQL database called _symfony_zeroApi_. You need also an user with permissions in that database, if you didn't set previously, you can set now in _app/config/parameters.yml_ . Then you can run this command to create de database and his schema:

 ```sh
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:create
```

If you change the model, remember you have to do this:

```sh
$ php bin/console doctrine:schema:update --force
```

To run the application you have to can use the []built-in server]((http://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html) or configure your web server (Apache, Nginx) correctly. 
For using built-in server, please visit: https://symfony.com/doc/2.8/cookbook/web_server/built_in.html 

When you have your server running and configured, you can check the installation in your browser:
```
http://localhost:8000/config.php
```

To check the swagger-like API, please go to:
```
http://localhost:8000/api/doc
```

Now you can build your own project using SymfonyZero-API by yourself.

# Deploy

You can avoid all the setup process using the _deploy script_. You can install SymfonyZero-API in a clean environment (with apt-get package manager available) and all the configuration and the actions will be done automatically.

You only need the _deploy_ folder you can find in the root of this repository. Then run:

```sh
$ sudo ./setup.sh
```

And you will have SymfonyZero-API running in your system (You can check it in _http://api.symfonyzero_). If you want to change anything of the process, you can edit _setup.sh_ file.

For example, by default SymfonyZero-API is installed in _/var/www/SymfonyZero-API/_ directory, but you can modify it changing in _setup.sh_ var _SYMFONYPATH_, and
 of course, changing that path in the virtual host (_symfonyzeroapi.conf_).

By default, script will install PHP 7 if doesn't found any PHP version installed or find a previous version of PHP 5.6. This deploy is prepared to install a previous version, so if you prefer to install PHP 5.6 you can edit _setup.sh_ and
follow the instructions you will find in it, you only have to comment one line and uncomment another one.

# How to update

If you update your repository with a new version of SymfonyZero-API of with your new changes, you don't need to do again all the commands includes in the previous section. To do it quicker we provides a console command which execute the needed commands for you. 

First you have to install new composer dependencies:

```sh
$ composer install
```

Then, to run the update command:

```sh
$ php bin/console zero:deploy
```

If you want to edit the command to suit your needs, you can find it in _src/ApiBundle/Command/DeployCommand.php_.
 
# Features
 
 SymfonyZero-API helps you to develop build your web applications quickly. It is made up of several bundles (Symfony Standard Edition bundles and Third party bundles) and usual features and sections which appears in a wide range of websites. In this section you can read what is included in each of these parts.
 
**Third Party Bundles**

SymfonyZero-API has available a pre-configured third party bundles to give a solution for the most common needs of the web projects. In this list you can discover what bundles are installed and the link to access to their official repositories.

*  [FOSRestBundle](https://github.com/FriendsOfSymfony/FOSRestBundle) - FOSRestBundle provides various tools to rapidly develop RESTful API's with Symfony
*  [JMSSerializerBundle](https://github.com/schmittjoh/JMSSerializerBundle) - JMSSerializerBundle serialize, and deserialize data of any complexity (supports XML, JSON, YAML)
*  [NelmioApiDocBundle](https://github.com/nelmio/NelmioApiDocBundle) - NelmioApiDocBundle generates documentation for your REST API from annotations
*  [NelmioCorsBundle](https://github.com/nelmio/NelmioCorsBundle) - NelmioCorsBundle allows you to send Cross-Origin Resource Sharing headers with ACL-style per-URL configuration.
*  [KnpPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle) - KnpPaginatorBundle is a friendly Symfony paginator to paginate everything.
*  [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle) - FOSUserBundle provides a flexible framework for user management that aims to handle common tasks such as user registration and password retrieval.
*  [FOSOAuthServerBundle](https://github.com/FriendsOfSymfony/FOSOAuthServerBundle) - FOSOAuthServerBundle provides a server side OAuth2 implementation.
*  [SwitchUserStatelessBundle](https://github.com/lafourchette/SwitchUserStatelessBundle) - SwitchUserStatelessBundle allows admins to impersonate other users.
*  [BazingaHateoasBundle](https://github.com/willdurand/BazingaHateoasBundle) - BazingaHateoasBundle provides support to build a 3rd level of API Rest.
*  [EasyAdminBundle](https://github.com/javiereguiluz/EasyAdminBundle) - EasyAdminBundle lets you create administration backends for Symfony applications with unprecedented simplicity.
*  [ElasticaSearchBundle](https://github.com/FriendsOfSymfony/FOSElasticaBundle) - FosElasticaBundle provides integration with ElasticSearch
 

**Common Sections and Functionality**
 
 * Landing page
 * Swagger interface with API Documentation
 * Comments Entity. CRUD for demonstration purposes
 * Data fixtures with example comments
 * Register system and OAuth 2.0 Authentication
  
**Symfony Standard Edition**
 
Extracted of the [official repository of Symfony](https://github.com/symfony/symfony-standard), here we have the pre-configured bundles we have available because they are in the Symfony Standard Edition:

*  FrameworkBundle - The core Symfony framework bundle
*  SensioFrameworkExtraBundle - Adds several enhancements, including template and routing annotation capability
*  DoctrineBundle - Adds support for the Doctrine ORM
*  TwigBundle - Adds support for the Twig templating engine
*  SecurityBundle - Adds security by integrating Symfony's security component
*  SwiftmailerBundle - Adds support for Swiftmailer, a library for sending emails
*  MonologBundle - Adds support for Monolog, a logging library
*  WebProfilerBundle (in dev/test env) - Adds profiling functionality and the web debug toolbar
*  SensioDistributionBundle (in dev/test env) - Adds functionality for configuring and working with Symfony distributions
*  SensioGeneratorBundle (in dev/test env) - Adds code generation capabilities
*  DebugBundle (in dev/test env) - Adds Debug and VarDumper component integration
 
# Config
 
 In this section you will learn how to configure all the possibilities of SymfonyZero-API. You can modify a lot of features, including versions.

If you want to change the *Symfony version* you must edit the file _composer.json_, specifically the line:

```
"symfony/symfony": "2.8.*",
```

Although we use Symfony 2.8, SymfonyZero-API has the new directory structure (Symfony 3.0 or higher) but if you want, you can [override this structure](http://symfony.com/doc/current/configuration/override_dir_structure.html).

Changing this for the version you prefer, when you running _composer install_, you will get that version of Symfony. Remember that some bundles could work differently for other versions of Symfony. Also, changing that file you can change the version of the bundle you prefer, for example, if you want to change the version of KnpPaginatorBundle, you have to change next line:
                                                                                                                                                                                                                                                                                    
```
"knplabs/knp-paginator-bundle": "^2.5",
```                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        

By the fault all the bundles are enabled, you can *disable any bundle* if you will not use. For this purpose, you must modify the _AppKernel.php_ file. You can find it in _app/_. In that file you will see all the bundles enabled for all environments. If you want to disable one bundle, just comment it. For example, to disable NelmioCorsBundle:

```php
//new Nelmio\CorsBundle\NelmioCorsBundle(),
```

Also, if you will never use this bundle, you can remove if from your _composer.json_ file.

Another modification you can do is the *database configuration*. By default SymfonyZero-API is prepared to use a database called _symfony_zeroApi_ with an user and password _symfonyApi_ you set in the firsts steps, but you can change it. To do this you have to edit the _parameters.yml_ file you can find in _app/config/_ route. Once time you create your new database and the user, you can edit this file. The parameters you must change are:

```yml
    database_host: 127.0.0.1
    database_port: null
    database_name: symfonyZeroApi
    database_user: userExample
    database_password: passwordExample
```

All the functions are used like an examples in ApiBundle:DefaultController only with the goal you know how can you use them. In a real application you must remove them and use only the functions you need. 

Of course, *each bundle* has a lot of different configuration you can change to adjust them to your needs. By default, SymfonyZero-API has the usual configuration for each bundle, but of course you can modify them. For this, you have to do these editions in _config.yml_ file which you can find in _app/config/_ route. For example, EasyAdminBundle is prepared for the User Entity, but if you want to add a new one, you only have to modify this:

```yml
easy_admin:
    entities:
        ...
        - AppBundle\Entity\YourNewEntity
```

SymfonyZero-API provides an example of data fixtures with some 'Comments'. You can use it to test the application.

You can find the fixtures already created in _src/ApiBundle/DataFixtures/ORM/CommentsFixtures.php_ and you can generate these dates using next console command (only if you didn't remove this dependency when you installed SymfonyZero-API):

```sh
$ php bin/console doctrine:fixtures:load
```

If you have activated ElasticaBundle, you'll have to configure Elastic Search. Open the _app/config/parameters.yml_ file and include this parameters:
```yml
elastic_host: 
elastic_port: 
```



In the previous section, you can find all the links for the official documentation for each bundle. Check it if you want to know all the possibilities to customize your application.

By default, SymfonyZero-API provides a base repository and base manager which the most used functions like create an entity, find by id, update an entity... And a repository and manager classes like an examples (for User and Comment entities). It's a good practice if you follow this structure when you create new entities. You can configure these files in src/ApiBundle/Resources/config.

The main idea is to store all the queries about a specific entity in the _repository_ and the _manager_ is the service in which you will delegate the responsibility of store usual methods you will need to use in different points of the applications.

With little knowledge of Symfony you will be able to use all the SymfonyZero-API possibilities and you will increase improve the development of your own applications.
 
# Registration and OAuth 2.0 Authentication

To register a new user in the application you need to send an POST request to _/v1/register_ which the next body (change the information for your user information) in JSON:

```json
{
	"email": "name@domain.com",
	"username": "username",
	"name": "name", 
	"plainPassword":{"first":"testPassword","second":"testPassword"}
}
```
You will need to add new fields if you modify the _user_ entity, and also remember to change the _UserType_ form in _/src/ApiBundle/Form/_.

To authenticate users using OAuth 2.0 you will need to do a previous task (only the first time). You need a _client_id_ and _secret_. Run this command:

```sh
php bin/console fos:oauth-server:client:create  --grant-type="password" --grant-type="refresh_token" --grant-type="token"
```

Then, you can set the _client_id_ and _secret_ you will get in your frontend application. To log in an user, you need to send a POST request in JSON to _/oauth/v2/token_ with this body:

```json
{
	"client_id": "client_id",
	"client_secret": "client_secret",
	"grant_type": "password", 
	"username": "username",
	"password": "password"
}
```

* _client_id_: Value get previously in the console OR concatenate id column of client table + '_' character + random_id column of client table. Example: "1_34354235kwokooos4k0soksockskk848ckoww04ok0sc8wsw"
* _client_secret_: Value get previously in the console.
* _grant_type_: Is the literal "password".
* _username_: Is the username of the user you want to authenticate.
* _password_: Is the password of the user you want to authenticate.

You will get a _access_token_ you need to use in all the request in which you have to be authenticated. To do this, send a header _Authorization_ with the value: "Bearer _access_token_" (with blank space between Bearer literal and access_token).

If you want to know more about the authentication process you can read the [bundle documentation](https://github.com/FriendsOfSymfony/FOSOAuthServerBundle/blob/master/Resources/doc/index.md).

# Improvements and contact
 
This is an open source project to contribute with the community and we are delighted to be helped by you, so if you have an idea to improve SymfonyZero-API or you find a bug, please create an issue and explain us clearly and with details your idea or the bug you have found.

In case you are able to patch any bug or add a new feature, don't hesitate and make a pull request. First, fork the repository and clone it locally. Then, create a branch for your edits. When you end your contribution, open a pull request and we'll discuss your changes.

If you have any doubt around how to contribute using GitHub, you can read the official guide [to contribute to open source project](https://guides.github.com/activities/contributing-to-open-source/).

Also, you can contact with developers in [symfony@emergya.com](symfony@emergya.com). We'll be glad to talk with you :)
