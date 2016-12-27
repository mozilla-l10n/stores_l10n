# Stores l10n

Web App providing the folllowing features:
* Monitor the state of content translation for products shipping in Google Play and Apple App store.
* Public JSON API allowing to extract formatted translations to feed the stores APIs and update published content.

## Installation
1. Clone the repository.
2. Install [Composer](https://getcomposer.org/) and its dependencies with `composer install --no-dev`.
3. Clone the translations repo in a `locales` folder in the root of the cloned repository: ```git clone https://github.com/mozilla-l10n/appstores/ locales```
4. Point a virtual host to the `web` directory.
5. Copy `app/config/config.inc.php.ini` to `config.inc.php` and adapt the `$webroot_folder` to your installation.
6. Make sure that the `logs` folder is writable by the user running the server (e.g. `www-data`).
7. Set up a cron job to update the `locales` sub-repository (production server is set to 15 minutes).

## Production instance
Production istance is hosted at https://l10n.mozilla-community.org/stores_l10n/ and updated automatically via GitHub webhooks.
