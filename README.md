# Stores l10n

Web App providing the folllowing features:
* Monitor the state of content translation for products shipping in Google Play and Apple Appstore
* Public JSON API allowing to extract formatted translations to feed the stores APIs to update published content

## Installation
1. Clone the repo
2. Install dependencies with `composer install --no-dev`
3. Clone the translations repo in a `locales` folder at the root of the cloned repo (`git clone https://github.com/mozilla-l10n/appstores/ locales`)
4. Point a virtual host to the `web` directory
5. Copy `app/config/config.ini-dist` to `app/config/config.ini` and put the full URL for the app if installed in a subfolder
6. Set up a cron job to update the `locales` sub-repository
