# WordPress Extension for Behat 3

Just a WordPress extension for Behat 3

## Install

Prepare your composer

```json
{
    "require-dev": {
        "tmf/wordpress-extension": "dev-master"
    }
}
```

## Configuration

```yml
# behat.yml
default:
  autoload:
    - %paths.base%/Features/Context
  suites:
    default:
      contexts:
        - Tmf\WordPressExtension\Context\WordPressContext
  extensions:
    Tmf\WordPressExtension:
      path: '%paths.base/vendor/wordpress'

    Behat\MinkExtension:
      base_url:    'http://localhost:8000'
      sessions:
        default:
          goutte: ~

```

## Tips

```
disable_functions=mail
```

Disable `mail()` function

