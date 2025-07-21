<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\CampaignDescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Session;

class CampaignDescriptionController extends Controller
{
    public function index()
    {
        $employer_id = Auth::guard('employer')->id();
        $descriptions = CampaignDescription::where('employer_id', $employer_id)->get();
        return view('employer.campaign_descriptions.index', compact('descriptions'));
    }

    public function create()
    {
        return view('employer.campaign_descriptions.create');
    }

    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'task_name' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'sample_screenshot' => 'nullable|file|image|max:2048',
    //         'youtube_link' => 'nullable|url',
    //         'gig_id' => 'nullable|numeric',
    //     ]);
    
    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }
    
    //     $data = [
    //         'task_name' => $request->task_name,
    //         'description' => $request->description,
    //         'youtube_link' => $request->youtube_link,
    //         'employer_id' => Auth::guard('employer')->id(),
    //         'gig_id' => $request->gig_id,
    //         'referral_code' => $this->generateReferralCode(),
    //     ];
    
    //     // Handle file upload
    //     if ($request->hasFile('sample_screenshot')) {
    //         $tpath = "assets/campaign_screenshots/";
    //         $name = $_FILES['sample_screenshot']['name'];
    //         $tmp = $_FILES['sample_screenshot']['tmp_name'];
    //         $name = idate('U') . $name;
    //         $fullPath = public_path($tpath . $name);
    
    //         if (!file_exists(public_path($tpath))) {
    //             mkdir(public_path($tpath), 0755, true);
    //         }
    
    //         if (move_uploaded_file($tmp, $fullPath)) {
    //             $data['sample_screenshot'] = $tpath . $name;
    //         } else {
    //             Session()->flash('error', 'There was a problem uploading the screenshot');
    //             return redirect()->back()->withInput();
    //         }
    //     }
    
    //     // Save campaign
    //     $campaign = CampaignDescription::create($data);
    
    //     // Redirect to create questions for this campaign
    //     Session()->flash('success', 'Campaign description created successfully. Now add questions to your task.');
    //     return redirect()->route('employer.campaign-descriptions.index', ['campaign_id' => $campaign->id]);
    // }
    
  public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'task_name' => 'required|string|max:255',
        'description' => 'required|string',
        'sample_screenshot' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'youtube_link' => 'nullable|url',
        'gig_id' => 'nullable|numeric',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $data = [
        'task_name' => $request->task_name,
        'description' => $request->description,
        'youtube_link' => $request->youtube_link,
        'employer_id' => Auth::guard('employer')->id(),
        'gig_id' => $request->gig_id,
        'referral_code' => $this->generateReferralCode(),
    ];

    // Handle file upload
    if ($request->hasFile('sample_screenshot')) {
        $image = $request->file('sample_screenshot');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $relativePath = "assets/campaign_screenshots/";
        
        // Set custom base path to publichtml directory (one level up from public)
        $basePath = dirname(public_path()) . '/';
        $fullPath = $basePath . $relativePath;
        
        // Create directory if it doesn't exist
        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }
        
        // Move the file manually since we're using a custom path outside Laravel's public directory
        try {
            if (move_uploaded_file($image->getRealPath(), $fullPath . $filename)) {
                $data['sample_screenshot'] = $relativePath . $filename;
            } else {
                return redirect()->back()
                    ->with('error', 'There was a problem uploading the screenshot')
                    ->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'There was a problem uploading the screenshot: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Save campaign
    $campaign = CampaignDescription::create($data);

    // Redirect to create questions for this campaign
    return redirect()
        ->route('employer.campaign-descriptions.index', ['campaign_id' => $campaign->id])
        ->with('success', 'Campaign description created successfully. Now add questions to your task.');
}

    
    // Helper method to generate a unique referral code
    private function generateReferralCode($length = 8)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        if (CampaignDescription::where('referral_code', $code)->exists()) {
            return $this->generateReferralCode($length); // Try again if code exists
        }
        
        return $code;
    }
    public function edit($id)
    {
        $employer_id = Auth::guard('employer')->id();
        $description = CampaignDescription::where('employer_id', $employer_id)->findOrFail($id);
        return view('employer.campaign_descriptions.edit', compact('description'));
    }

    public function update(Request $request, $id)
    {
        $employer_id = Auth::guard('employer')->id();
        $description = CampaignDescription::where('employer_id', $employer_id)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'task_name' => 'required|string|max:255',
            'description' => 'required|string',
            'sample_screenshot' => 'nullable|file|image|max:2048',
            'youtube_link' => 'nullable|url',
            'gig_id' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'task_name' => $request->task_name,
            'description' => $request->description,
            'youtube_link' => $request->youtube_link,
            'gig_id' => $request->gig_id,
        ];

        // Handle file upload
     // Handle file upload
     if ($request->hasFile('sample_screenshot')) {
        $tpath = "assets/campaign_screenshots/";
        $name = $_FILES['sample_screenshot']['name'];
        $tmp = $_FILES['sample_screenshot']['tmp_name'];
        $name = idate('U') . $name;
        $fullPath = public_path($tpath . $name);

        // Ensure directory exists
        if (!file_exists(public_path($tpath))) {
            mkdir(public_path($tpath), 0755, true);
        }

        // Delete old screenshot if exists
        if ($description->sample_screenshot && file_exists(public_path($description->sample_screenshot))) {
            unlink(public_path($description->sample_screenshot));
        }

        if (move_uploaded_file($tmp, $fullPath)) {
            $data['sample_screenshot'] = $tpath . $name;
        } else {
            Session()->flash('error', 'There was a problem uploading the screenshot');
            return redirect()->back()->withInput();
        }
    }

        $description->update($data);

        Session()->flash('success', 'Campaign description updated successfully.');
        return redirect()->route('employer.campaign-descriptions.index');
    }

    public function destroy($id)
    {
        $employer_id = Auth::guard('employer')->id();
        $description = CampaignDescription::where('employer_id', $employer_id)->findOrFail($id);

        // Delete file if exists
        if ($description->sample_screenshot) {
            Storage::disk('public')->delete($description->sample_screenshot);
        }

        $description->delete();

        Session()->flash('success', 'Campaign description deleted successfully.');
        return redirect()->route('employer.campaign-descriptions.index');
    }

    // API endpoint for Flutter
    public function getDescriptions(Request $request)
    {
        $employer_id = $request->query('employer_id');

        if (!$employer_id) {
            return response()->json([
                'status' => false,
                'message' => 'Missing employer_id'
            ], 400);
        }

        $descriptions = CampaignDescription::where('employer_id', $employer_id)->get();

        $formatted = $descriptions->map(function ($desc) {
            return [
                'id' => $desc->id,
                'task_name' => $desc->task_name,
                'description' => $desc->description,
                'sample_screenshot' => $desc->sample_screenshot
                    ? asset('assets/campaign_screenshots/' . basename($desc->sample_screenshot))
                    : null,
                'youtube_link' => $desc->youtube_link,
                'gig_id' => $desc->gig_id,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Campaign Descriptions Fetched Successfully',
            'data' => $formatted
        ]);
    }
  public function toggleStatus($id)
    {
        $campaign = CampaignDescription::findOrFail($id);
        $campaign->referral_status = $campaign->referral_status ? 0 : 1;
        $campaign->save();

        return response()->json(['newStatus' => $campaign->referral_status]);
    }

}