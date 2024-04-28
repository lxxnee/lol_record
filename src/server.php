<?php
// summoner_name이 URL 파라미터로 전달되었는지 확인
if (isset($_GET['summoner_name'])) {
    // URL 파라미터에서 summoner_name 값을 가져옴
    $text = $_GET['summoner_name'];

    // summoner_name 값이 있을 때만 API 요청을 보냄
    if (!empty($text)) {
        // summoner_name을 URL에서 사용할 수 있도록 인코딩
        $summoner_name = urlencode($text);
        $api_key = "RGAPI-26ab054c-a852-4501-b04e-e542f8f0a626"; // Riot Games API 키를 입력하세요

        // 소환사 정보 요청
        $url = "https://kr.api.riotgames.com/lol/summoner/v3/summoners/by-name/" . $summoner_name . "?api_key=" . $api_key;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response, true);

        // 소환사 리그 정보 요청
        if (isset($result['id'])) {
            $url = "https://kr.api.riotgames.com/lol/league/v3/positions/by-summoner/" . $result['id'] . "?api_key=" . $api_key;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);
            $league = json_decode($response, true);
        }

        // 결과를 JSON 형식으로 출력
        echo json_encode(array('result' => $result, 'league' => $league));
    }
}
