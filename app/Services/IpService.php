<?php
namespace App\Services;

use Illuminate\Http\Request;

final class IpService
{
    public static function getIp(Request $request): string
    {
      $xForwardedFor = $request->header('X-Forwarded-For');
      $ips = explode(',', $xForwardedFor);
      $clientIp = $ips[0];
      return empty($clientIp) ? $request->ip() : $clientIp;
    }
}