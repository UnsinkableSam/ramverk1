# Stackoverflow-mod.

## How to install.

This is how we install the module. First off you go to packargist to download
the module via composer json.

[Packagist link](https://packagist.org/packages/samax/stackoverflow-mod)

#### composer.

Add this to you composer file. "composer require samax/stackoverflow-mod"

Example

```json
{
  "name": "anax/noname",
  "description": "A me page for the ramverk1 course.",
  "license": "MIT",
  "minimum-stability": "beta",
  "prefer-stable": true,
  "autoload": {
    "psr-4": {
      "Anax\\": "src/"
    }
  },
  "require": {
    "anax/anax-ramverk1-me": "^1.0.0"
  },
  "require-dev": {
    "phpunit/phpunit": "^7",
    "samax/stackoverflow-mod": "^v1.4",
    "anax/database-active-record": "^2.0.2",
    "anax/htmlform": "^2.0.0"
  }
}
```

Use the command composer update in your termninal to make the module download.
Make sure you got all the requirements by following what's being said on
packardgist.

# scaffold.

This is a one liner in the termnial that you might have to change depending
what ur folder and so on is called.

```code
bash vendor/samax/stackoverflow-mod/.anax/scaffold/postprocess.d/stackoverflow-mod.bash
```
