<?php

namespace StephaneCoinon\SendGridActivity;

use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\ErrorPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Message\Authentication\Bearer;

class HttpClientFactory
{
    /**
     * Build the HTTP client to talk with the API.
     *
     * @param string     $apiKey  API key
     * @param Plugin[]   $plugins List of additional plugins to use
     * @param HttpClient $client  Base HTTP client
     *
     * @return HttpClient
     */
    public static function create($apiKey, array $plugins = [], HttpClient $client = null): HttpClient
    {
        if (!$client) {
            $client = HttpClientDiscovery::find();
        }

        // $plugins[] = new ErrorPlugin();
        $plugins[] = new AuthenticationPlugin(
            new Bearer($apiKey ?? getenv('SENDGRID_API_TOKEN'))
        );

        return new PluginClient($client, $plugins);
    }
}
