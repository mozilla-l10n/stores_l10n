<?php
namespace Stores;

use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * API class
 *
 * This class manages all of our calls to the API.
 *
 *
 *
 * List of services:
 *
 * @package Stores
 */
class API
{
    public $url;

    public $parameters;
    public $extra_parameters;

    public $channels = [
        'apple'  => ['release'],
        'google' => ['release', 'beta', 'next'],
    ];

    public $services = [
        'storelocales', 'firefoxlocales',
        'localesmapping', 'translation', 'done',
    ];

    public $error;
    public $logging = true;
    public $logger;
    public $query = [];
    private $project;

    /**
     * The constructor analyzes the URL to extract its parameters
     *
     * @param array $url parsed url
     */
    public function __construct($url)
    {
        $this->url = $url;

        // We use the Monolog library to log our events
        $this->logger = new Logger('API');

        if ($this->logging) {
            $this->logger->pushHandler(new StreamHandler(INSTALL . 'logs/api-errors.log'));
        }

        // Also log to error console in Debug mode
        if (DEBUG) {
            $this->logger->pushHandler(new ErrorLogHandler());
        }

        $this->parameters = $this->getParameters($url['path']);

        $this->extra_parameters = isset($url['query'])
            ? $this->getExtraParameters($url['query'])
            : [];

        if (isset($this->parameters[0])) {
            $this->query['store'] = $this->parameters[0];
        }

        if (isset($this->parameters[1])) {
            $this->query['service'] = $this->parameters[1];
        }

        if (isset($this->parameters[2])) {
            $this->query['channel'] = $this->parameters[2];
        }

        if (isset($this->parameters[1])
            && $this->parameters[1] == 'translation'
            && isset($this->parameters[3])) {
            $this->query['locale'] = $this->parameters[3];
        }

        // Get all the apps locales
        $this->project = new Project;
    }

    /**
     * Get the name of the service queried
     *
     * @return string Name of the service
     */
    public function getService()
    {
        return $this->isValidService() ? $this->parameters[1] : 'Invalid service';
    }

    /**
     * Check if an API request is syntactically valid
     *
     * @return boolean True if valid request, False if invalid request
     */
    public function isValidRequest()
    {
        // No parameters passed
        if (! count($this->parameters)) {
            $this->log('No service requested');

            return false;
        }

        // Check that we have enough parameters for a query
        if (! $this->verifyEnoughParameters(1)) {
            return false;
        }

        // Check that the store is supported
        if (! $this->isValidStore()) {
            return false;
        }

        // Check if the service requested exists
        if (! $this->isValidService()) {
            return false;
        }

        // Check if the call to the service is technically valid
        if (! $this->isValidServiceCall($this->query['service'])) {
            return false;
        }

        return true;
    }

    /**
     * Check if we call a service that we do support and check that
     * the request is technically correct for that service
     *
     * @param  string  $service The name of the service
     * @return boolean Returns True if we have a valid service call, False otherwise
     */
    private function isValidServiceCall($service)
    {
        switch ($service) {
            case 'firefoxlocales':
            // ex: {store}/firefoxlocales/{channel}/
                if (! $this->verifyEnoughParameters(3)) {
                    return false;
                }

                if (! in_array($this->query['channel'], $this->channels[$this->query['store']])) {
                    $this->log("'{$this->query['channel']}' is not a supported channel for {$this->query['store']}.");

                    return false;
                }
                break;
            case 'localesmapping':
            // ex: {store}/localesmapping/{channel}/
                if (! $this->verifyEnoughParameters(2)) {
                    return false;
                }
                break;
            case 'translation':
            // ex: {store}/translation/{channel}/{locale}
                if (! $this->verifyEnoughParameters(4)) {
                    return false;
                }

                if (! in_array($this->query['channel'], $this->channels[$this->query['store']])) {
                    $this->log("'{$this->query['channel']}' is not a supported channel for {$this->query['store']}.");

                    return false;
                }

                if (! in_array($this->query['locale'], $this->project->getStoreLocales($this->query['store'], true))) {
                    $this->log("'{$this->query['locale']}' is not a supported locale for {$this->query['store']}.");

                    return false;
                }
                break;
            case 'storelocales':
            // ex: api/apple/storelocales/
            // We don't have anything specific to check as there is no parameter for this service call
                break;
            case 'done':
            // ex: /api/google/done/beta/
                if (! $this->verifyEnoughParameters(3)) {
                    return false;
                }

                if (! in_array($this->query['channel'], $this->channels[$this->query['store']])) {
                    $this->log("'{$this->query['channel']}' is not a supported channel for {$this->query['store']}.");

                    return false;
                }
                break;
            default:
                return false;
        }

        return true;
    }

    /**
     * Return the error message and an http 400 header
     * @return array Error message for an Invalid API call
     */
    public function invalidAPICall()
    {
        http_response_code(400);

        return ['error' => $this->error];
    }

    /**
     * Check that we have enough parameters in the URL to satisfy the request
     *
     * @param  int     $number number of compulsory parameters
     * @return boolean True if we can satisfy the request, False if we can't
     */
    private function verifyEnoughParameters($number)
    {
        if (count($this->parameters) < $number) {
            $this->log('Not enough parameters for this query.');

            return false;
        }

        return true;
    }

    /**
     * Check if the store queried is supported
     *
     * @return boolean True if the store is valid, False otherwise
     */
    private function isValidStore()
    {
        if (! in_array($this->parameters[0], array_keys($this->channels))) {
            $this->log("The store ({$this->parameters[0]}) is invalid.");

            return false;
        }

        return true;
    }

    /**
     * Check if the service called is valid
     *
     * @return boolean True if the service called is valid, False otherwise
     */
    private function isValidService()
    {
        if (! $this->verifyEnoughParameters(2)) {
            return false;
        }

        if (! in_array($this->parameters[1], $this->services)) {
            $this->log("The service requested ({$this->parameters[1]}) doesn't exist");

            return false;
        }

        return true;
    }

    /**
     * Utility function to log API call errors.
     *
     * @param  string  $message
     * @return boolean True if we logged, False if we didn't log
     */
    private function log($message)
    {
        $this->error = $message;

        return $this->logging
            ? $this->logger->addWarning($message, [$this->url['path']])
            : false;
    }

    /**
     * Get the list of parameters for an API call.
     *
     * @param  string $parameters The list of parameters from the URI
     * @return array  All the main parameters for the query
     */
    private function getParameters($parameters)
    {
        $parameters = explode('/', $parameters);
        // Remove empty values
        $parameters = array_filter($parameters);
        // Remove 'api' as all API calls start with it
        array_shift($parameters);
        // Reorder keys
        $parameters = array_values($parameters);

        return array_map(
            function ($item) {
                return trim(urldecode($item));
            },
            $parameters
        );
    }

    /**
     * Get the list of extra parameters for an API call.
     *
     * @param  string $parameters The $_GET list of parameters
     * @return array  All the extra parameters as [key => value]
     */
    private function getExtraParameters($parameters)
    {
        foreach (explode('&', $parameters) as $item) {
            if (strstr($item, '=')) {
                list($key, $value) = explode('=', $item);
                $extra[$key] = $value;
            } else {
                /* Deal with empty queries such as:
                 query/?foo=
                 query/?foo
                 query/?foo&bar=toto
                */
                $extra[$item] = '';
            }
        }

        return $extra;
    }
}
