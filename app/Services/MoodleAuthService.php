<?php

namespace App\Services;

class MoodleAuthService {

    static function authToken(String $moodleLink, String $username, String $password) {
        echo "Atenção: Paramêtro de Request será melhor para funcao authToken<br>";
        $client = new \GuzzleHttp\Client();

        $response = $client->post($moodleLink . '/login/token.php', [
            'form_params' => [
                'username' => $username,
                'password' => $password,
                'service' => 'moodle_mobile_app',
            ],
        ]);

        $data = json_decode((string) $response->getBody(), true);

        return $data['token'];
    }

    static function getUser(String $moodleLink, String $version, String $token, String $format = 'json') {
        echo "Atenção: Paramêtro de Request será melhor para funcao getUser";

        $client = new \GuzzleHttp\Client();

        $response = $client->post($moodleLink . '/webservice/rest/server.php', [
            'form_params' => [
                'wsfunction' => config('moodle.siteInfo.' . $version),
                'wstoken' => $token,
                'moodlewsrestformat' => $format,
            ],
        ]);


        $data = json_decode((string) $response->getBody(), true);

        $params = [
            'form_params' => [
                'wsfunction' => config('moodle.user.' . $version),
                'wstoken' => $token,
                'moodlewsrestformat' => $format,
            ],
        ];
        switch ($version) {
            case '2-6':
                $params['form_params']['userids'] = [$data['userid']];
                //$params['form_params']['userids'] = [666];
                break;
            case '3-2':
                $params['form_params']['field'] = 'id';
                $params['form_params']['values[0]'] = $data['userid'];
                //$params['form_params']['values[0]'] = '666';
                break;
        }
        
        $response = $client->post($moodleLink . '/webservice/rest/server.php', $params);

        $data = json_decode((string) $response->getBody(), true);

        return $data;
    }
}
