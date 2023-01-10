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
        $usecase($request->site_id, Inquiry::PHONE);
        return response()->json([
            'message' => 'success',
        ]);
    }

    public function mail(Request $request, InquiryCreate $usecase)
    {
        $usecase($request->site_id, Inquiry::MAIL);
        return response()->json([
            'message' => 'success',
        ]);
    }
}
