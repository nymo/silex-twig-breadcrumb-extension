# Twig breadcrumb extension for Silex
This is a breadcrumb extension for Twig which includes a breadcrumb service provider for silex for easy and simple use
of breadcrumbs in Silex.

## Features
- Create easily breadcrumbs in your Silex application
- i18n support
- Configurable separator
- Template override
- Named route support

## Requirements
- Silex
- Twig
- gettext must be activated in your PHP environment for i8n support since version 1.1.0


## Installation

### PHP Configuration
Please make sure that gettext functionality is activated in your PHP environment. For further assistance please refer
to the official PHP Manual http://www.php.net

### Via composer:
First add the following to your composer.json file:

```
"require":{
        "nymo/silex-twig-breadcrumb-extension":"~1.1"
    }
```

Then run composer update.

### Configure Silex
I assume you have already a running Silex application with Twig as a template engine.
First register the breadcrumb service provider:
```
$app->register(new \nymo\Silex\Provider\BreadCrumbServiceProvider());
```
Then register the Twig breadcrumb extension. You have to define this after your registered the Twig service provider
otherwise the application throws an error if you use $app['twig'].
```
$app['twig'] = $app->share(
    $app->extend(
        'twig',
        function ($twig, $app) {
            $twig->addExtension(new \nymo\Twig\Extension\BreadCrumbExtension($app));
            return $twig;
        }
    )
);
```

That's all. Now you ready to go.

## Usage
After your successfull installation you can add breadcrumb items wherever you want. All you need is to call the
breadcrumb service and add a item:

```
$app['breadcrumbs']->addItem('Silex rocks','http://silex.sensiolabs.org/');
$app['breadcrumbs']->addItem('PHP','http://www.php.net');
```
The last item in your container is always printed as plain text without an <a> tag.
You can also add an breadcrumb item without any url. Then this breadcrumb item will also be printed as plaint text.

```
$app['breadcrumbs']->addItem('Just some text');
```

### Named Routes
You can also use named routes. This extension supports two types of named routes a simple and a complex one with parameters.
Before you start to add a named route you will have to register (if not done already) the Silex UrlGeneratorServiceProvider.

```
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
```

Then add this url generator to the breadcrumbs collection.
```
$app['breadcrumbs']->setUrlGenerator($app['url_generator']);
```
Now you're ready to go.

#### Simple named route
If you got a simple route without any required parameters you can add this route to the breadcrumb collection as follows:

```
$app['breadcrumbs']->addItem('A simple route',array('route' => 'simple_named_route'));
```
#### Complex named route
A complex named route is being added the same way as a simple named route. What needs to be done additionally is to pass
an array with the required parameters as a second value to the array.

```
$app['breadcrumbs']->addItem('A complex route',array(
        'route' => 'complex_named_route',
        'params' => array(
            'name' => "John",
            'id' => 3
        )
    ));
```

#### Rendering breadcrumbs in twig

In your Twig template you can render your breadcrumbs with this function:
```
{{renderBreadCrumbs()}}
```
The default template renders an unordered list. The last item has a css class called lastItem. You can override this
template. Just copy the breadcrumbs.html.twig template from the vendor folder into your view path.

##i18n Support
Since version 1.1.0 this extension supports i18n. Each linkname uses the Twig trans filter.
For a detailed documentation about how to use translations in Silex please refer to http://silex.sensiolabs.org/doc/providers/translation.html

## Optional configuration
The extension comes with a small configuration option which can be used optional. The default separator used for
for the breadcrumbs is a > sign.
If you want to change it you can pass your own separator when registering the Twig extension:

```
$app['twig']->addExtension(new \nymo\Twig\Extension\BreadCrumbExtension($app),array("breadcrumbs.separator" => "::"));
```
