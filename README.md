# Stores l10n

Web App providing the folllowing features:
* Monitor the state of content translation for products shipping in Google Play and App Store.
* Public [JSON API](https://l10n.mozilla-community.org/stores_l10n/documentation/) allowing to extract formatted translations to feed the stores APIs and update published content.

## Installation

1. Clone the repository.
2. Install [Composer](https://getcomposer.org/) and its dependencies with `composer install --no-dev`.
3. Point a virtual host to the `web` directory.
4. Copy `app/config/config.inc.php.ini` to `config.inc.php` and:
    * Point `$l10n_path` to a clone of the [localization repository](https://github.com/mozilla-l10n/appstores/).
    * Adapt the `$webroot_folder` to your installation.
5. Make sure that the `logs` folder is writable by the user running the server (e.g. `www-data`).

You will also need to set up a cron job to update the localization (production server is set to 15 minutes).

## Production instance

Production istance is hosted at https://l10n.mozilla-community.org/stores_l10n/ and updated automatically via GitHub webhooks.
