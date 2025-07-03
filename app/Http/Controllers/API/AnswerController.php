<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\CampaignDescription;
use App\CamQuestion;
use App\Answer;
use App\Referral;

class AnswerController extends Controller
{
    // public function getUserAnswers(Request $request)
    // {
    //     $referralCode = $request->input('referral_code');

    //     if (!$referralCode) {
    //         return response()->json(['error' => 'Referral code is required'], 422);
    //     }

    //     // Find referral and user
    //     $referral = Referral::with('user')->where('referral_code', $referralCode)->first();

    //     if (!$referral) {
    //         return response()->json(['error' => 'Referral not found'], 404);
    //     }

    //     // Get the campaign
    //     $campaign = CampaignDescription::find($referral->campaign_id);

    //     if (!$campaign) {
    //         return response()->json(['error' => 'Campaign not found'], 404);
    //     }

    //     // Get questions
    //     $questions = CamQuestion::where('campaign_id', $campaign->id)
    //         ->with('choices')
    //         ->get();

    //     // Get answers for this referral code
    //     $answers = Answer::where('referral_code', $referralCode)->get();

    //     // Format response
    //     return response()->json([
    //         'user' => [
    //             'id' => $referral->user_id,
    //             'name' => $referral->user ? $referral->user->name : 'Unknown',
    //         ],
    //         'campaign' => $campaign,
    //         'questions' => $questions,
    //         'answers' => $answers,
    //     ]);
    // }
public function getUserAnswers(Request $request)
{
    $referralCode = $request->input('referral_code');
    $campaignId = $request->input('campaign_id');

    // Validate presence of both inputs
    if (!$referralCode || !$campaignId) {
        return response()->json(['error' => 'Both referral_code and campaign_id are required'], 422);
    }

    // Validate referral with matching campaign
    $referral = Referral::where('referral_code', $referralCode)
        ->where('campaign_id', $campaignId)
        ->first();

    if (!$referral) {
        return response()->json(['error' => 'Referral not found for this campaign'], 404);
    }
    // Get campaign info
    $campaign = CampaignDescription::find($campaignId);
    if (!$campaign) {
        return response()->json(['error' => 'Campaign not found'], 404);
    }

    // Get related questions with choices
    $questions = CamQuestion::where('campaign_id', $campaignId)
        ->with('choices')
        ->get();

    // Get answers for this referral
 $answers = Answer::where('referral_code', $referralCode)->get()->map(function ($answer) {
    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    $response = $answer->response;

    // Check if response looks like an image filename
    if ($answer->file_path && in_array(strtolower(pathinfo($response, PATHINFO_EXTENSION)), $imageExtensions)) {
        $response = asset($answer->file_path);
    }

    return [
        'id' => $answer->id,
        'question_id' => $answer->question_id,
        'referral_code' => $answer->referral_code,
        'response' => $response, // updated response value
        'file_path' => $answer->file_path,
        'file_url' => $answer->file_path ? asset($answer->file_path) : null,
        'created_at' => $answer->created_at,
        'updated_at' => $answer->updated_at,
    ];
});



   return response()->json([
    'referral' => $referral,
    'campaign' => array_merge($campaign->toArray(), [
        'referral_code' => $referralCode,
        'form_url' => url('/form?ref=' . $referralCode),
    ]),
    'questions' => $questions,
    'answers' => $answers,
]);

}

public function getAllReferrals(Request $request)
{
    $query = Referral::with('campaign.employer');

    if ($request->has('user_id')) {
        $query->where('user_id', $request->input('user_id'));
    }

    if ($request->has('referral_code')) {
        $query->where('referral_code', $request->input('referral_code'));
    }
 
    if ($request->has('campaign_id')) {
        $query->where('campaign_id', $request->input('campaign_id'));
    }

    // Sort by campaign_id
    $referrals = $query->orderBy('campaign_id')->get();

    return response()->json(['referrals' => $referrals]);
}

}
