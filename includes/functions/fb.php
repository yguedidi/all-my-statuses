<?php
    use Facebook\Facebook;
    use Facebook\HttpClients\FacebookCurl;
    use Facebook\HttpClients\FacebookCurlHttpClient;

    $fbOptions = [
        'app_id' => FB_APIKEY,
        'app_secret' => FB_SECRET,
        'default_graph_version' => 'v3.0',
    ];

    if(isLocal()) {
        $fbCurl = new FacebookCurl();
        $fbCurl->init();
        $fbCurl->setopt(CURLOPT_SSL_VERIFYPEER, false);
        $fbCurl->setopt(CURLOPT_SSL_VERIFYHOST, 2);

        $fbOptions['http_client_handler'] = new FacebookCurlHttpClient($fbCurl);
    }


    $fb = new Facebook($fbOptions);
