#! /usr/bin/env python
# -*- coding: utf-8 -*-

'''
This script can be used to generate the content of $supported_locales for the
Project class.

Output is saved as locales.php and can be manually copied and pasted.
'''

import json
import os
import urllib2

def main():
    update_sources = [
        {
            'product': 'fx_android',
            'channel': 'aurora',
            'source': 'http://hg.mozilla.org/releases/mozilla-aurora/raw-file/default/mobile/android/locales/maemo-locales',
            'format': 'txt',
        },
        {
            'product': 'fx_android',
            'channel': 'beta',
            'source': 'http://hg.mozilla.org/releases/mozilla-beta/raw-file/default/mobile/android/locales/maemo-locales',
            'format': 'txt',
        },
        {
            'product': 'fx_android',
            'channel': 'release',
            'source': 'http://hg.mozilla.org/releases/mozilla-release/raw-file/default/mobile/android/locales/maemo-locales',
            'format': 'txt',
        },
        {
            'product': 'fx_ios',
            'channel': 'release',
            'source': 'https://raw.githubusercontent.com/mozilla-mobile/firefox-ios/v7.x/shipping_locales.txt',
            'format': 'txt',
        },
        {
            'product': 'fx_ios',
            'channel': 'release',
            'source': 'https://raw.githubusercontent.com/mozilla-mobile/firefox-ios/v7.x/shipping_locales.txt',
            'format': 'txt',
        },
        {
            'product': 'focus_android',
            'channel': 'release',
            'source': 'https://l10n.mozilla-community.org/webstatus/api/?product=focus-android&txt',
            'format': 'txt',
        },
        {
            'product': 'focus_ios',
            'channel': 'release',
            'source': 'https://l10n.mozilla-community.org/webstatus/api/?product=focus-ios&txt',
            'format': 'txt',
        },
    ]

    supported_locales = {}
    supported_products = []

    for update_source in update_sources:
        product_name = update_source['product']
        product_channel = update_source['channel']
        product_url = update_source['source']

        if product_name not in supported_products:
            supported_products.append(product_name)

        product_locales = []
        print('Reading sources for {0}-{1} from {2}'.format(product_name, product_channel, product_url))
        response = urllib2.urlopen(product_url)
        for locale in response:
            if locale != '' and locale not in product_locales:
                product_locales.append(locale)
        # Sort locales
        product_locales.sort()
        if product_name not in supported_locales:
            supported_locales[product_name] = {}

        supported_locales[product_name][product_channel] = product_locales

    supported_products.sort()
    output_content = []
    for product in supported_products:
        output_content.append("\t\t'{0}' => [\n".format(product));

        channels = supported_locales[product].keys()
        channels.sort()

        for channel in channels:
            output_content.append("\t\t\t'{0}' => [\n".format(channel));

            line = '\t\t\t\t'
            for locale in supported_locales[product][channel]:
                locale = "'{0}', ".format(locale.replace('\n', ''))
                if len(line + locale) > 69:
                    # Start a new line
                    output_content.append(line + '\n')
                    line = '\t\t\t\t'
                line += locale
            output_content.append(line)

            output_content.append('\n\t\t\t],\n');
        output_content.append('\t\t],\n');

    # Write back txt file
    print 'Writing file...'
    output_file = open(os.path.join(os.path.dirname(os.path.abspath(__file__)), 'locales.php'), 'w')
    for line in output_content:
        output_file.write(line.replace('\t', '    '))
    output_file.close()

if __name__ == '__main__':
    main()
