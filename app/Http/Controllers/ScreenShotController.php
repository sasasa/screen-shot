<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lib\LinkPreview\LinkPreviewInterface;
use App\Lib\LinkPreview\LinkPreviewRuntimeException;
use Dusterio\LinkPreview\Client;
class ScreenShotController extends Controller
{


    /**
     * Fibonacci sequence
     */
    private function fibonacciSequence(int $n): array {
        $sequence = [0, 1];
        for ($i = 2; $i < $n; $i++) {
            $sequence[$i] = $sequence[$i - 1] + $sequence[$i - 2];
        }
        return $sequence;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, string $url, LinkPreviewInterface $linkPreview)
    {
        try {
            // phpinfo();
            $options = stream_context_create(['ssl' => [
                'verify_peer'      => false,
                'verify_peer_name' => false
            ]]);
            dd(file_get_contents('https://www.akagi.com/products/index.html?tab01=garigari', false, $options));
            dd($this->fibonacciSequence(113));

            // $previewClient = new Client("https://www.google.com/maps/place/".urlencode("〒814-0001+福岡県福岡市早良区百道浜４丁目５−３"));
            // $previewClient = new Client($url);
            // $response = $previewClient->getPreview('general')->toArray();
            // dd(mb_convert_encoding($response["title"], "UTF-8", "auto"));

            // $response = $linkPreview->get("https://www.google.com/maps/place/".urlencode("〒814-0001+福岡県福岡市早良区百道浜４丁目５−３"));
            $response = $linkPreview->get($url);
            dd($response);
            $linkPreview->store();
            $modeColor = $linkPreview->getModeColor();
    
            return response($response->fileData)->withHeaders([
                'Content-Type' => 'image/jpeg',
            ]);
        } catch (LinkPreviewRuntimeException $e) {
            // dd($e);
            abort(404);
        }

    }
}


