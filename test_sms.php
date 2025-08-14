<?php

use App\Services\Sms\HubtelSmsSender;

$smsSender = new HubtelSmsSender();
$result = $smsSender->send('0504065214', 'Test SMS from TNFPortal');

dd($result);
