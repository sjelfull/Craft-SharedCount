<?php
namespace Craft;

use Guzzle\Http\Client as Guzzle;

class SharedcountService extends BaseApplicationComponent {

    protected $endpoint;
    protected $settings;
    protected $apiKey;
    protected $client;

    /**
     * Initalize service
     */
    public function init()
    {
        $plugin = craft()->plugins->getPlugin('sharedcount');
        $this->settings = $plugin->getSettings();

        // Parse environment variables
        $this->parseSettingsForEnvVariables();

        // Setup
        $this->apiKey = $this->settings['apiKey'];
        $this->client = new Guzzle();
        $this->endpoint = 'https://free.sharedcount.com/url';
    }

    /**
     * Fetches shares/likes for given url from SharedCount.com
     *
     * @param array $options
     * @return mixed
     */
    public function likes($options = [])
    {
        // Check if the url is set
        if (empty($options['url']))
        {
            throw new \InvalidArgumentException('(SharedCount) You didn\'t specify the url parameter');
        }

        // Get options
        $url = $options['url'];
        Craft::log('(SharedCount) Fetching statistics for ' . $url . '.');

        // Send off request
        $request = $this->client->get($this->endpoint, array(), array(
            'query' => array(
                'url'    => $url,
                'apikey' => $this->apiKey,
            )
        ));

        try
        {
            $response = $request->send();
        } catch (\Exception $e)
        {
            Craft::log('(SharedCount) Fetch error for ' . $url . ': ' . $e->getResponse()->getBody(true), LogLevel::Error);

            return false;
        }

        // Return result
        $result = $response->json();

        // Normalize service names as lowercase keys
        return $this->lowercaseKeys($result);
    }

    /**
     * Normalize array key capitalization
     *
     * @param array $result
     * @return array
     */
    private function lowercaseKeys($result = array())
    {
        $values = array();

        foreach ($result as $key => $value)
        {
            $values[ strtolower($key) ] = $value;
        }

        return $values;
    }

    /**
     * Parses settings for environment variables
     */
    private function parseSettingsForEnvVariables()
    {
        foreach ($this->settings as $key => $value)
        {
            $this->settings[ $key ] = craft()->config->parseEnvironmentString($value);
        }
    }
}