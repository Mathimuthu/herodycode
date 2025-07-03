<?php
namespace App\Http\Controllers\Api;

use App\CampaignDescription;
use App\Http\Controllers\Controller;
use App\CamQuestion;
use App\User;
use App\Referral;
use Illuminate\Http\Request;

class ReferralFormController extends Controller
{
//     public function publicIndex(Request $request)
// {
//     $employee_id = $request->input('employer_id');

//     $query = \App\CampaignDescription::with(['questions' => function ($q) {
//         $q->select('id', 'text', 'type', 'required', 'referral_code', 'campaign_id');
//     }]);

//     if ($employee_id) {
//         $query->where('employer_id', $employee_id);
//     }

//     $campaigns = $query->get();

//     if ($campaigns->isEmpty()) {
//         return response()->json([
//             'status' => false,
//             'message' => 'No campaigns found.',
//         ]);
//     }

//     // Format the campaigns with the form_url for each referral_code
//     $formattedCampaigns = $campaigns->map(function ($campaign) {
//         $campaign->questions = $campaign->questions->map(function ($question) {
//             // Add the form_url to each question based on the referral_code
//             $question->form_url = url('/form?ref=' . $question->referral_code);
//             return $question;
//         });

//         return $campaign;
//     });

//     return response()->json([
//         'status' => true,
//         'message' => 'Campaigns with related questions and form links fetched successfully.',
//         'data' => $formattedCampaigns
//     ]);
// }

// public function publicIndex(Request $request)
// {
//     $employee_id = $request->input('employee_id');

//     // Auto-fetch employee_id if not provided
//     if (!$employee_id) {
//         $firstQuestion = CamQuestion::first();
//         if ($firstQuestion) {
//             $employee_id = $firstQuestion->employee_id;
//         } else {
//             return response()->json([
//                 'status' => false,
//                 'message' => 'Unable to determine employee_id from CamQuestion table.',
//             ]);
//         }
//     }

//     // Fetch campaigns with questions
//     $campaigns = CampaignDescription::with(['questions' => function ($q) use ($employee_id) {
//         $q->where('employee_id', $employee_id);
//     }])->where('employer_id', $employee_id)->get();

//     if ($campaigns->isEmpty()) {
//         return response()->json([
//             'status' => false,
//             'message' => 'No campaigns found for this employee.',
//         ]);
//     }

//     // Process each campaign
//     $formattedCampaigns = $campaigns->map(function ($campaign) {
//         $questions = $campaign->questions;

//         if ($questions->isEmpty()) {
//             $campaign->referral_code = null;
//             $campaign->form_url = null;
//             return $campaign;
//         }

//         // Just generate a referral code and send it back
//         $referralCode = $this->generateReferralCode();

//         // Store the referral code in a separate table (optional)
//         // Example:
//         Referral::create([
//             'referral_code' => $referralCode,
//             'campaign_id' => $campaign->id
//         ]);

//         $campaign->referral_code = $referralCode;
//         $campaign->form_url = url('/form?ref=' . $referralCode);
//         return $campaign;
//     });

//     return response()->json([
//         'status' => true,
//         'message' => 'Referral codes created without modifying original questions.',
//         'data' => $formattedCampaigns
//     ]);
// }

// public function publicIndex(Request $request)
// {
//     $employee_id = $request->input('employee_id');
//     $user_id = $request->input('user_id');

//     // Auto-fetch employee_id if not provided
//     if (!$employee_id) {
//         $firstQuestion = CamQuestion::first();
//         if ($firstQuestion) {
//             $employee_id = $firstQuestion->employee_id;
//         } else {
//             return response()->json([
//                 'status' => false,
//                 'message' => 'Unable to determine employee_id from CamQuestion table.',
//             ]);
//         }
//     }

//     // Fetch user if user_id is present
//     $user = $user_id ? User::find($user_id) : null;

//     // Optional: Check if user_id is invalid
//     if ($user_id && !$user) {
//         return response()->json([
//             'status' => false,
//             'message' => 'Invalid user_id.',
//         ]);
//     }

//     // Fetch campaigns with questions for this employee
//     $campaigns = CampaignDescription::with(['questions' => function ($q) use ($employee_id) {
//         $q->where('employee_id', $employee_id);
//     }])->where('employer_id', $employee_id)->get();

//     if ($campaigns->isEmpty()) {
//         return response()->json([
//             'status' => false,
//             'message' => 'No campaigns found for this employee.',
//         ]);
//     }

//     // Process each campaign
//     $formattedCampaigns = $campaigns->map(function ($campaign) use ($user) {
//         $questions = $campaign->questions;

//         if ($questions->isEmpty()) {
//             $campaign->referral_code = null;
//             $campaign->form_url = null;
//             $campaign->user_id = null;
//             $campaign->user_name = null;
//             return $campaign;
//         }

//         // Generate referral code
//         $referralCode = $this->generateReferralCode();

//         // Save referral with user_id
//         Referral::create([
//             'referral_code' => $referralCode,
//             'campaign_id' => $campaign->id,
//             'user_id' => $user ? $user->id : null
//         ]);

//         // Attach info to campaign object
//         $campaign->referral_code = $referralCode;
//         $campaign->form_url = url('/form?ref=' . $referralCode);
//         $campaign->user_id = $user ? $user->id : null;
//         $campaign->user_name = $user ? $user->name : null;

//         return $campaign;
//     });

//     return response()->json([
//         'status' => true,
//         'message' => 'Referral codes created and user info added.',
//         'data' => $formattedCampaigns
//     ]);
// }

//     public function publicIndex(Request $request)
// {
//     $employee_id = $request->input('employee_id');
//     $user_id = $request->input('user_id');
    
//     \Log::info('Request received with employee_id: ' . $employee_id . ' and user_id: ' . $user_id);
    
//     // Auto-fetch employee_id if not provided
//     if (!$employee_id) {
//         $firstQuestion = CamQuestion::first();
//         if ($firstQuestion) {
//             $employee_id = $firstQuestion->employee_id;
//             \Log::info('Auto-fetched employee_id: ' . $employee_id);
//         } else {
//             return response()->json([
//                 'status' => false,
//                 'message' => 'Unable to determine employee_id from CamQuestion table.',
//             ]);
//         }
//     }
    
//     // Fetch user if user_id is present
//     $user = null;
//     if ($user_id) {
//         $user = User::find($user_id);
//         \Log::info('User found: ', $user ? ['id' => $user->id, 'name' => $user->name] : ['No user found']);
//     }
    
//     // Optional: Check if user_id is invalid
//     if ($user_id && !$user) {
//         return response()->json([
//             'status' => false,
//             'message' => 'Invalid user_id.',
//         ]);
//     }
    
//     // Fetch campaigns with questions for this employee
//     $campaigns = CampaignDescription::with(['questions' => function ($q) use ($employee_id) {
//         $q->where('employee_id', $employee_id);
//     }])->where('employer_id', $employee_id)->get();
    
//     \Log::info('Campaigns found: ' . $campaigns->count());
    
//     if ($campaigns->isEmpty()) {
//         return response()->json([
//             'status' => false,
//             'message' => 'No campaigns found for this employee.',
//         ]);
//     }
    
//     // Process each campaign
//     $formattedCampaigns = $campaigns->map(function ($campaign) use ($user) {
//         $questions = $campaign->questions;
        
//         \Log::info('Processing campaign ID: ' . $campaign->id . ' with ' . $questions->count() . ' questions');
        
//         if ($questions->isEmpty()) {
//             $campaign->referral_code = null;
//             $campaign->form_url = null;
//             $campaign->user_id = null;
//             $campaign->user_name = null;
//             $campaign->campaign_id = $campaign->id; // Add campaign_id here
//             return $campaign;
//         }
        
//         // Generate referral code
//         $referralCode = $this->generateReferralCode();
//         \Log::info('Generated referral code: ' . $referralCode);
        
//         // Prepare user ID for referral
//         $userId = $user ? $user->id : null;
//         \Log::info('User ID for referral: ' . ($userId ?? 'null'));
        
//         try {
//             // First, verify the Referral model's fillable attributes
//             $referralFillable = (new Referral())->getFillable();
//             \Log::info('Referral fillable attributes: ', $referralFillable);
            
//             // Create the referral record using the two-step approach to avoid mass assignment issues
//             $referral = new Referral();
//             $referral->referral_code = $referralCode;
//             $referral->campaign_id = $campaign->id;
//             $referral->user_id = $userId;
//             $referral->save();
            
//             // Verify the saved referral
//             \Log::info('Saved referral: ', $referral->fresh()->toArray());
            
//         } catch (\Exception $e) {
//             \Log::error('Failed to create referral: ' . $e->getMessage());
//             \Log::error($e->getTraceAsString());
//         }
        
//         // Attach info to campaign object
//         $campaign->referral_code = $referralCode;
//         $campaign->form_url = url('/form?ref=' . $referralCode);
//         $campaign->user_id = $userId;
//         $campaign->user_name = $user ? $user->name : null;
//         $campaign->campaign_id = $campaign->id; // Add campaign_id here
        
//         return $campaign;
//     });
    
//     \Log::info('Completed processing campaigns');
    
//     return response()->json([
//         'status' => true,
//         'message' => 'Referral codes created and user info added.',
//         'data' => $formattedCampaigns
//     ]);
// }

public function getAllCampaigns(Request $request)
{
    if ($request->has('campaign_id')) {
        $campaign = CampaignDescription::with(['questions', 'employers'])  // Changed from 'employer' to 'employers'
            ->where('id', $request->campaign_id)
            ->first();

        if (!$campaign) {
            return response()->json([
                'status' => false,
                'message' => 'Campaign not found.',
            ], 404);
        }

        // Check if the employer exists and assign profile photo URL
        if ($campaign->employers) {
            $campaign->profile_photo = $campaign->employers->profile_photo_url;
        } else {
            $campaign->profile_photo = null;
        }

        return response()->json([
            'status' => true,
            'message' => 'Campaign fetched successfully.',
            'data' => $campaign,
        ]);
    }

    $campaigns = CampaignDescription::with(['questions', 'employers'])  // Changed from 'employer' to 'employers'
        ->orderBy('id', 'desc')
        ->get()
        ->map(function ($campaign) {
            // Add profile photo URL to each campaign
            if ($campaign->employers) {
                $campaign->profile_photo = $campaign->employers->profile_photo_url;
            } else {
                $campaign->profile_photo = null;
            }
            return $campaign;
        });

    return response()->json([
        'status' => true,
        'message' => 'All campaigns fetched successfully.',
        'data' => $campaigns,
    ]);
}


 public function publicIndex(Request $request)
{
    // Validate required inputs
    $validator = \Validator::make($request->all(), [
        'employee_id' => 'required|integer',
        'user_id' => 'required|integer|exists:users,id',
        'campaign_id' => 'required|integer|exists:campaign_descriptions,id',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation failed.',
            'errors' => $validator->errors()
        ], 422);
    }

    $employee_id = $request->input('employee_id');
    $user_id     = $request->input('user_id');
    $campaign_id = $request->input('campaign_id');

    \Log::info('Request with employee_id: ' . $employee_id . ', user_id: ' . $user_id . ', campaign_id: ' . $campaign_id);

    $user = User::find($user_id);

    $query = CampaignDescription::with(['questions'])->where('id', $campaign_id);

    if ($employee_id) {
        $query->where('employer_id', $employee_id);
    }

    $campaign = $query->first();

    if (!$campaign) {
        return response()->json([
            'status' => false,
            'message' => 'Campaign not found.',
        ]);
    }

    // Filter questions based on employee
    if ($employee_id) {
        $campaign->questions = $campaign->questions->where('employee_id', $employee_id)->values();
    }

    $formattedCampaign = $this->processCampaign($campaign, $user);

    return response()->json([
        'status' => true,
        'message' => 'Campaign fetched successfully.',
        'data' => $formattedCampaign,
    ]);
}


   
  private function processCampaign($campaign, $user = null)
{
    $questions = $campaign->questions;

    if ($questions->isEmpty()) {
        $campaign->referral_code = null;
        $campaign->form_url = null;
        $campaign->user_id = null;
        $campaign->user_name = null;
        $campaign->campaign_id = $campaign->id;
        return $campaign;
    }

    $userId = $user ? $user->id : null;

    // Check if referral already exists
    $existingReferral = Referral::where('campaign_id', $campaign->id)
                                ->where('user_id', $userId)
                                ->first();

    if ($existingReferral) {
        $referralCode = $existingReferral->referral_code;
    } else {
        $referralCode = $this->generateReferralCode();

        try {
            $referral = new Referral();
            $referral->referral_code = $referralCode;
            $referral->campaign_id = $campaign->id;
            $referral->user_id = $userId;
            $referral->referral_status = 1;
            $referral->save();
        } catch (\Exception $e) {
            \Log::error('Failed to create referral: ' . $e->getMessage());
        }
    }

    $campaign->referral_code = $referralCode;
    $campaign->form_url = url('/form?ref=' . $referralCode);
    $campaign->user_id = $userId;
    $campaign->user_name = $user ? $user->name : null;
    $campaign->campaign_id = $campaign->id;

    return $campaign;
}



    
   private function generateReferralCode($length = 8)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';

    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }

    // Make sure it's unique
    if (Referral::where('referral_code', $code)->exists()) {
        return $this->generateReferralCode($length); // Try again
    }

    return $code;
}


 
}
