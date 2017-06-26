<?php

namespace App\Services;

use App\Strategies\Moodle\VersionStrategy;
use App\Escola;
use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleClient;
use App\Exceptions\MoodleErrorException;

class MoodleAuthService {

    private $guzzle;

    public function __construct(GuzzleClient $client) {
        $this->guzzle = $client;
    }

    public function autenticar(Escola $escola, Request $request) {
        $token = $this->authToken($escola, $request);
        $user = $this->getUser($escola, $token);
        return $user;
    }

    private function authToken(Escola $escola, Request $request) {
       
        $response = $this->guzzle->post($escola->moodle_link . '/login/token.php', [
            'form_params' => [
                'username' => $request->username,
                'password' => $request->password,
                'service' => 'moodle_mobile_app',
            ],
        ]);
  
        $data = json_decode((string) $response->getBody(), true);
     
        if (!isset($data['token'])) {
            throw new MoodleErrorException($data['error']);
        }

        return $data['token'];
    }

    private function getUser(Escola $escola, String $token, String $format = 'json') {
        $versionStrategy = new VersionStrategy($escola, $token, $format);
        
        $response = $this->guzzle->post($escola->moodle_link  . '/webservice/rest/server.php', [
            'form_params' => $versionStrategy->getParamsForUserId(),
        ]);

        $data = json_decode((string) $response->getBody(), true);

        $response = $this->guzzle->post($escola->moodle_link  . '/webservice/rest/server.php', [
            'form_params' => $versionStrategy->getParams($data),
        ]);

        $data = json_decode((string) $response->getBody(), true);

        return collect($data[0]);
    }

}
