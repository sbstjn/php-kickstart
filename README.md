I wanted to create a simple PHP framework with easy `Request` and `Response` access, automated [Jade](http://jade-lang.com) template parsing and [LESS](http://lesscss.com) stylesheet generating. I tried to adapt some of the routing syntax of [Express.js](http://expressjs.com) for [php-kickstart](http://semu.mp/php-kickstart.hmtl) route definition.

### Defining Routes
For handling new routes you need a `Router` with a new `Request` and `Response`, all access to needed functions is later handled through those response and request objects.
  
```php
<?php

$Router = new Router(new Request(), new Response());

$Router->get('/')->bind('General', 'home');
$Router->get('/download/:file/:type')->bind('General', 'download');
```
  
Create a custom handle in `handles/` with classname `General` and both methods `home` and `download` like  `handles/General.class.php`:

```php
<?php

class General {

  public function home(&$req, &$res) {
    $res->render('home');
  }
  
  public function download(&$req, &$res) {
    $res->assign('file', $req->param('file'));
    $res->assign('type', $req->param('type'));
  
    $res->render('download');
  }  

}
```
    
The response handler will search for templates in `views/` matching the name by adding `.jade`, `.mustache` or any other registered template engine as file extension.

```haml
!!! 5
html
  head
    meta(http-equiv='content-type', content='text/html; charset=utf-8')
    title php–kickstart
  body
    p Downloading #{file}
      | as #{type}
    p Downloading #{file} as #{type}      
```