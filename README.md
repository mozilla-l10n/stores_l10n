# Stores l10n

Web App providing the folllowing features:
* Monitor the state of content translation for products shipping in Google Play and Apple Appstore.
* Public JSON API allowing to extract formatted translations to feed the stores APIs to update published content.

## Installation
1. Clone the repository.
2. Install dependencies with `composer install --no-dev`.
3. Clone the translations repo in a `locales` folder at the root of the cloned repo (`git clone https://github.com/mozilla-l10n/appstores/ locales`).
4. Point a virtual host to the `web` directory.
5. Copy `app/config/config.inc.php.ini` to `config.inc.php` and adapt the `$webroot_folder` to your installation.
6. Set up a cron job to update the `locales` sub-repository.
