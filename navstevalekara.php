<?php

$allVolneTerminy = [];

for ($week = 0; $week <= 9; $week++) {
    $url = 'https://www.navstevalekara.sk/page/modules/doctors/order.php';

    $postData = [
        't' => 'w',
        'dc' => 0, // zadajte ID lekára podľa návodu
        'w' => $week,
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'User-Agent: Mozilla/5.0',
        'Content-Type: application/x-www-form-urlencoded',
        'Referer: https://www.navstevalekara.sk/',
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) {
        echo "Chyba pri načítaní týždňa $week.\n";
        continue;
    }

    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML($response);
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);
    $nodes = $xpath->query('//a[contains(@onclick, "get_order")]');

    foreach ($nodes as $node) {
        $onclick = $node->getAttribute('onclick');

        if (preg_match("/get_order\('([\d-]+)',\s*(\d+),\s*'([\d:]+)',\s*(\d+),\s*(true|false)\)/", $onclick, $matches)) {
            $allVolneTerminy[] = [
                'datum' => $matches[1],
                'den_v_tyzdni' => $matches[2],
                'cas' => $matches[3]
            ];
        }
    }

    usleep(200000);
}

if (!empty($allVolneTerminy)) {
    $to = 'vas@email.sk'; // zadajte váš e-mail
    $subject = 'Voľné termíny u lekára';
    
    $message = "Našli sa voľné termíny:\n\n";
    foreach ($allVolneTerminy as $termin) {
        $message .= "- " . $termin['datum'] . " o " . $termin['cas'] . "\n";
    }

    mail($to, $subject, $message);
}