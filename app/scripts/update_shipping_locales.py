#! /usr/bin/env python
# -*- coding: utf-8 -*-

# This script can be used to generate app/config/shipping_locales.json

import json
import os
import urllib2


def main():
    config_folder = os.path.join(
        os.path.dirname(os.path.abspath(__file__)), os.pardir, 'config')

    # Read update sources
    print 'Reading product_sources.json ...'
    sources_file = open(os.path.join(config_folder, 'product_sources.json'))
    update_sources = json.load(sources_file)
    sources_file.close()

    shipping_locales = {}
    for product, product_data in update_sources.iteritems():
        for data in product_data:
            if data['format'] == 'array':
                # Hard-coded list of locales
                locales = data['source']
            else:
                # Get locales from a TXT source
                locales = []
                print('Reading sources for {0} ({1})'.format(product, data['channel']))
                response = urllib2.urlopen(data['source'])
                for locale in response:
                    if locale != '' and locale not in locales:
                        locales.append(locale.rstrip())

            # Make sure to add en-US
            if 'en-US' not in locales:
                locales.append('en-US')
            # Sort locales
            locales.sort()

            if product not in shipping_locales:
                shipping_locales[product] = {}
            shipping_locales[product][data['channel']] = locales

    # Write back JSON file
    print 'Writing shipping_locales.json ...'
    config_file = os.path.join(config_folder, 'shipping_locales.json')
    json_file = open(config_file, 'w')
    json_file.write(json.dumps(shipping_locales, sort_keys=True, indent=2))
    json_file.close()


if __name__ == '__main__':
    main()
