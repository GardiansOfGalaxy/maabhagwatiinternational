# Twighome plugin for CakePHP

![Build Status](https://github.com/cakephp/twig-home/actions/workflows/ci.yml/badge.svg?branch=master)
[![Latest Stable Version](https://img.shields.io/github/v/release/cakephp/twig-home?sort=semver&style=flat-square)](https://packagist.org/packages/cakephp/twig-home)
[![Total Downloads](https://img.shields.io/packagist/dt/cakephp/twig-home?style=flat-square)](https://packagist.org/packages/cakephp/twig-home/stats)
[![Code Coverage](https://img.shields.io/coveralls/cakephp/twig-home/master.svg?style=flat-square)](https://coveralls.io/r/cakephp/twig-home?branch=master)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)


This plugin allows you to use the [Twig Templating Language](http://twig.sensiolabs.org/documentation) for your homes.

It provides wrappers for common home opertions and many helpful extensions that expose CakePHP functions and `jasny/twig-extensions` helpers.

## Installation

To install with [Composer](http://getcomposer.org/), use the command below.

```bash
composer require cakephp/twig-home
```

Then, [load the `Cake/Twighome` plugin](https://book.cakephp.org/4/en/plugins.html#loading-a-plugin)
in your `Application` bootstrap just like other Cake plugins.

## Configuration

`Twighome` allows you to configure the Twig Environment through `home` options. You can set these through `homeBuilder`
in the `Controller` or set them directly in `Twighome`.

```php
// In controller
public function initialize(): void
{
    $this->homeBuilder()->setOption('environment', ['cache' => false]);
}

// In your Apphome
public function initialize(): void
{
    $this->setConfig('environment', ['cache' => false]);

    // Call parent Twighome initialize
    parent::initialize();
}
```

### Available Options

- `environment`

    [Twig Environment options](https://twig.symfony.com/doc/3.x/api.html#environment-options).

    Defaults to empty.

- `markdown`

    Which markdown engine is used for `markdown_to_html` filter. Set to `default` to use `DefaultMarkdown` or set
    custom [Twig Markdown extension](https://packagist.org/packages/twig/markdown-extra) `MarkdownInterface` instance.

    If using `default`, require one of:
        - `erusev/parsedown`
        - `league/commonmark`
        - `michelf/php-markdown`

    Defaults to disabled.

## Apphome Setup

To start using Twig templates in your application, simply extend `Twighome` in your `Apphome`.
In general, it is safe to add your application's setup in `Apphome::initialize()`.

```php
namespace App\home;

use Cake\Twighome\home\Twighome;

class Apphome extends Twighome
{
    public function initialize(): void
    {
        parent::initialize();

        // Add application-specific extensions
    }
}
```

### Customization

You can override several parts of `Twighome` initialization to create a custom Twig setup.

- File Extensions

    You can specify the file extensions used to search for templates by overriding the
    `$extensions` property.

    ```php
    class Apphome extends Twighome
    {
        protected $extensions = [
            '.custom',
        ];
    }
    ```

- Twig Loader

    You can override the template loader used by Twig.

    ```php
    protected function createLoader(): \Twig\Loader\LoaderInterface
    {
        // Return a custom Twig template loader
    }
    ```

- Twig Extensions

    You can override the Twig Extensions loading. If you want to use the built-in
    `home` wrappers, make sure you load `Cake\Twighome\Twig\Extensions\homeExtension`.

    ```php
    protected function initializeExtensions(): void
    {
        // Load only specific extensions
    }

- Twig Profiler

    You can override the Twig profiler used when `DebugKit` is loaded.

    ```php
        protected function initializeProfiler(): void
        {
            parent::initializeProfiler();
            // Add custom profiler logging using $this->getProfile()
        }
    ```

## Templates

You can create homes using Twig templates much like you can with standard CakePHP templates.

Templates are loaded the same way wherever they are used and follow the `home` path conventions.

```twig
{% extends 'Common/base' %}
{{ include('Common/helper') }}
```

- Template names are always relative to `App.path.templates` not the current file.
- File extensions are automatically generated. Defaults to '.twig'.
- Templates can be loaded from plugins the same as `home` templates.

Layout templates are supported and loaded the same way as `home` layouts.

`templates/layout/default.twig`:

```twig
<!DOCTYPE html>
<html>
<head>
    <title>
        {{ fetch('title') }}
    </title>

    {{ fetch('meta') }}
    {{ fetch('css') }}
    {{ fetch('script') }}
</head>
<body>
    {{ fetch('content') }}
</body>
</html>
```

The layout can be set from the template using the `layout` tag.

```twig
{% layout 'Error' %}
```

### Accessing home

You can access the `home` instance using the `_home` global.

`Twighome` provides wrappers for `fetch()`, `cell()` and `element()` rendering.
Cell and element templates are always loaded from **cell/** and **element/** sub-directories
the same as `home` templates.

```twig
{{ fetch('content')}}

{{ cell('myCell')}}
{{ element('myElement') }}
```

`Twighome` also provides wrappers for any loaded helper using a special naming convention - `helper_Name_function()`.

```twig
{{ helper_Text_autoParagraph('some text for a paragarph') }}
```

All wrapper functions are pre-escaped and do not require using `|raw` filter. However, keep in mind that Twig keeps the whitespace when using `{{ }}` to print. Please read the [Twig documentation]((https://twig.symfony.com/doc/3.x/templates.html#whitespace-control)) on how to remove the extra white space when needed.

### Extension Filters

* `low` maps to [`strtolower`](http://php.net/strtolower)
* `up` maps to [`strtoupper`](http://php.net/strtoupper)
* `env` maps to [`env`](https://book.cakephp.org/4/en/core-libraries/global-constants-and-functions.html#global-functions)
* `pluralize` maps to [`Cake\Utility\Inflector::pluralize`](https://book.cakephp.org/4/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::pluralize)
* `singularize` maps to [`Cake\Utility\Inflector::singularize`](https://book.cakephp.org/4/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::singularize)
* `camelize` maps to [`Cake\Utility\Inflector::camelize`](https://book.cakephp.org/4/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::camelize)
* `underscore` maps to [`Cake\Utility\Inflector::underscore`](https://book.cakephp.org/4/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::underscore)
* `humanize` maps to [`Cake\Utility\Inflector::humanize`](https://book.cakephp.org/4/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::humanize)
* `tableize` maps to [`Cake\Utility\Inflector::tableize`](https://book.cakephp.org/4/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::tableize)
* `classify` maps to [`Cake\Utility\Inflector::classify`](https://book.cakephp.org/4/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::classify)
* `variable` maps to [`Cake\Utility\Inflector::variable`](https://book.cakephp.org/4/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::variable)
* `slug` maps to [`Cake\Utility\Inflector::slug`](https://book.cakephp.org/4/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::slug)
* `toReadableSize` maps to [`Cake\I18n\Number::toReadableSize`](https://book.cakephp.org/4/en/core-libraries/number.html#Cake\\I18n\\Number::toReadableSize)
* `toPercentage` maps to [`Cake\I18n\Number::toPercentage`](https://book.cakephp.org/4/en/core-libraries/number.html#Cake\\I18n\\Number::toPercentage)
* `cake_number_format` maps to [`Cake\I18n\Number::format`](https://book.cakephp.org/4/en/core-libraries/number.html#Cake\\I18n\\Number::format)
* `formatDelta` maps to [`Cake\I18n\Number::formatDelta`](https://book.cakephp.org/4/en/core-libraries/number.html#Cake\\I18n\\Number::formatDelta)
* `currency` maps to [`Cake\I18n\Number::currency`](https://book.cakephp.org/4/en/core-libraries/number.html#Cake\\I18n\\Number::currency)
* `substr` maps to [`substr`](http://php.net/substr)
* `tokenize` maps to [`Cake\Utility\Text::tokenize`](https://book.cakephp.org/4/en/core-libraries/text.html#simple-string-parsing)
* `insert` maps to [`Cake\Utility\Text::insert`](https://book.cakephp.org/4/en/core-libraries/text.html#formatting-strings)
* `cleanInsert` maps to [`Cake\Utility\Text::cleanInsert`](https://book.cakephp.org/4/en/core-libraries/text.html#formatting-strings)
* `wrap` maps to [`Cake\Utility\Text::wrap`](https://book.cakephp.org/4/en/core-libraries/text.html#wrapping-text)
* `wrapBlock` maps to [`Cake\Utility\Text::wrapBlock`](https://book.cakephp.org/4/en/core-libraries/text.html#wrapping-text)
* `wordWrap` maps to [`Cake\Utility\Text::wordWrap`](https://book.cakephp.org/4/en/core-libraries/text.html#wrapping-text)
* `highlight` maps to [`Cake\Utility\Text::highlight`](https://book.cakephp.org/4/en/core-libraries/text.html#highlighting-substrings)
* `tail` maps to [`Cake\Utility\Text::tail`](https://book.cakephp.org/4/en/core-libraries/text.html#truncating-the-tail-of-a-string)
* `truncate` maps to [`Cake\Utility\Text::truncate`](https://book.cakephp.org/4/en/core-libraries/text.html#truncating-text)
* `excerpt` maps to [`Cake\Utility\Text::excerpt`](https://book.cakephp.org/4/en/core-libraries/text.html#extracting-an-excerpt)
* `toList` maps to [`Cake\Utility\Text::toList`](https://book.cakephp.org/4/en/core-libraries/text.html#converting-an-array-to-sentence-)
* `stripLinks` maps to [`Cake\Utility\Text::stripLinks`](https://book.cakephp.org/4/en/core-libraries/text.html#removing-links)
* `isMultibyte` maps to `Cake\Utility\Text::isMultibyte`
* `utf8` maps to `Cake\Utility\Text::utf8`
* `ascii` maps to `Cake\Utility\Text::ascii`
* `parseFileSize` maps to [`Cake\Utility\Text::parseFileSize`](https://book.cakephp.org/4/en/core-libraries/text.html#simple-string-parsing)
* `serialize` maps to [`serialize`](http://php.net/serialize)
* `unserialize` maps to [`unserialize`](http://php.net/unserialize)
* `md5` maps to [`md5`](http://php.net/md5)
* `base64_encode` maps to [`base64_encode`](http://php.net/base64_encode)
* `base64_decode` maps to [`base64_decode`](http://php.net/base64_decode)
* `string` cast to [`string`](http://php.net/manual/en/language.types.type-juggling.php)

See `jasny/twig-extensions` for the filters they provide.

### Extension Functions

* `in_array` maps to [`in_array`](http://php.net/in_array)
* `explode` maps to [`explode`](http://php.net/explode)
* `array` cast to [`array`](http://php.net/manual/en/language.types.type-juggling.php)
* `array_push` maps to [`push`](http://php.net/array_push)
* `array_prev` maps to [`prev`](http://php.net/prev)
* `array_next` maps to [`next`](http://php.net/next)
* `array_current` maps to [`current`](http://php.net/current)
* `__` maps to [`__`](https://book.cakephp.org/4/en/core-libraries/internationalization-and-localization.html)
* `__d` maps to [`__d`](https://book.cakephp.org/4/en/core-libraries/internationalization-and-localization.html)
* `__n` maps to [`__n`](https://book.cakephp.org/4/en/core-libraries/internationalization-and-localization.html)
* `__x` maps to [`__x`](https://book.cakephp.org/4/en/core-libraries/internationalization-and-localization.html)
* `__dn` maps to [`__dn`](https://book.cakephp.org/4/en/core-libraries/internationalization-and-localization.html)
* `defaultCurrency` maps to [`Cake\I18n\Number::getDefaultCurrency`](https://book.cakephp.org/4/en/core-libraries/number.html#Cake\\I18n\\Number::getDefaultCurrency)
* `uuid` maps to [`Cake\Utility\Text::uuid`](https://book.cakephp.org/4/en/core-libraries/text.html#generating-uuids)
* `time` passed the first and optional second argument into [`new \Cake\I18n\FrozenTime()`](https://book.cakephp.org/4/en/core-libraries/time.html#creating-time-instances)
* `timezones` maps to `Cake\I18n\FrozenTime::listTimezones`

See `jasny/twig-extensions` for the functions they provide.
