<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInquiryRequest;
use App\Http\Requests\UpdateInquiryRequest;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use App\Models\Site;
use App\Usecases\InquiryCreate;

class InquiryController extends Controller
{
    public function phone(Request $request, InquiryCreate $usecase)
    {
        $site = $usecase($request->site_id, Inquiry::PHONE);
        return response()->json([
            'message' => 'success',
            'phone' => 'tel:'. $site->production->phone,
        ]);
    }

    public function mail(Request $request, InquiryCreate $usecase)
    {
        $site = $usecase($request->site_id, Inquiry::MAIL);
        return response()->json([
            'message' => 'success',
            'mail' => 'mailto:'. $site->production->inquiry_email. "?subject=". rawurlencode('Beautiful Site Listを見てメールしました。'),
        ]);
    }
}
