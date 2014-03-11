# Twig breadcrumb extension for Silex
This is a breadcrumb extension for Twig which includes a breadcrumb service provider for silex for easy and simple use
of breadcrumbs in Silex.

## Requirements
Silex and Twig.


## Installation

### Via composer:
First add the following to your composer.json file:

```
"require":{
        "nymo/silex-twig-breadcrumb-extension":"v1.0.*"
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
$app['twig']->addExtension(new \nymo\Twig\Extension\BreadCrumbExtension($app));
```

That's all. Now you ready to go.

## Usage
After your successfull installation you can add breadcrumb items wherever you want. All you need is to call the
breadcrumb service and add a item:

```
$app['breadcrumb']->addItem('Silex rocks','http://silex.sensiolabs.org/');
$app['breadcrumb']->addItem('PHP','http://www.php.net');
```
The last item in your container is always printed as plain text without an <a> tag.

In your Twig template you can render your breadcrumbs with this function:
```
{{renderBreadCrumbs()}}
```
The default template renders an unordered list. The last item has a css class called lastItem. You can override this
template. Just copy the breadcrumbs.html.twig template from the vendor folder into your view path.

## Optional configuration
The extension comes with a small configuration option which can be used optional. The default separator used for
for the breadcrumbs is a > sign.
If you want to change it you can pass your own separator when registering the Twig extension:

```
$app['twig']->addExtension(new \nymo\Twig\Extension\BreadCrumbExtension($app),array("breadcrumb.separator" => "::"));
```