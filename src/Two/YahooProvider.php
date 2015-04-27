<?php namespace Laravel\Socialite\Two;

use Symfony\Component\HttpFoundation\RedirectResponse;

class YahooProvider extends AbstractProvider implements ProviderInterface
{	
	/**
	 * Base YDN url
	 *
	 * @var string
	 */
	protected $ydnUrl = 'https://api.login.yahoo.com/oauth';

	 /**
     * The YDN API version for the request.
     *
     * @var string
     */
    protected $version = 'v2';

	 /**
     * {@inheritdoc}
     */
	protected function getAuthUrl($state)
	{
		return $this->buildAuthUrlFromBase($this->ydnUrl.'/'.$this->version.'/request_auth', $state);
	}

	/**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return $this->ydnUrl.'/'.$this->version.'/get_request_token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get($this->ydnUrl.'/'.$this->version.'/get_request_token?access_token='.$token, [
            'headers' => [
                'Content-Type: application/json', 
                'Accept: application/json'
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

        /**
     * Get the access token for the given code.
     *
     * @param  string  $code
     * @return string
     */
    public function getAccessToken($code)
    {
        $response = $this->getHttpClient()->get($this->getTokenUrl(), [
            'query' => $this->getTokenFields($code),
        ]);

        return $this->parseAccessToken($response->getBody());
    }

    /**
     * {@inheritdoc}
     */
    protected function parseAccessToken($body)
    {
        parse_str($body);

        return $access_token;
    }
}