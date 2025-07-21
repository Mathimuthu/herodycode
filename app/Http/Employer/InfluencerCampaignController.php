<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\GigCategory;
use App\Employer;
use App\InfluencerCampaign;
use App\InfluencerProfile;
use App\ManagerInfluencercampaign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class InfluencerCampaignController extends Controller
{
    public function index()
    {
        $campaigns = InfluencerCampaign::where('employe_id', Auth::guard('employer')->id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    
        return view('employer.influencercampaign.index', compact('campaigns'));
    }
    public function statusHistory($id)
    {
        $campaign = InfluencerCampaign::findOrFail($id);
    
        $statuses = ManagerInfluencercampaign::where('influencer_campaign_id', $id)
            ->with('manager') // assuming you have a relationship defined
            ->latest()
            ->get();
    
        return view('employer.influencercampaign.status-history', compact('campaign', 'statuses'));
    }
     public function creater(){
        $emp = Employer::find(Auth::guard('employer')->id());
        return view('employer.influencercampaign.create')->with([
            'employer' => $emp,
        ]);
    }
    public function create(Request $request){
         $request->validate([
            'campaign_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'upload' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,mp4|max:10240',
            'youtubeUrl' => 'nullable|url',
            'instagramUrl' => 'nullable|url',
            'twitterUrl' => 'nullable|url',
            'linkedinUrl' => 'nullable|url',
            'collab_type' => 'required|in:Barter,paid',
            'employer_id' => 'required|exists:employers,id',
        ]);
    
       $filePath = null;

        if ($request->hasFile('upload')) {
            $relativePath = "assets/influencer_campaign/";
            $basePath = dirname(public_path()) . '/';
            $fullPath = $basePath . $relativePath;
            $filename = time() . '.' . $request->file('upload')->getClientOriginalExtension();
    
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }
    
            if (move_uploaded_file($request->file('upload')->getRealPath(), $fullPath . $filename)) {
                $filePath = $relativePath . $filename;
            }
        }
        
        InfluencerCampaign::create([
            'employe_id' => $request->employer_id,
            'title' => $request->campaign_title,
            'description' => $request->description,
            'upload' => $filePath,
            'youtube' => $request->youtubeUrl,
            'instagram' => $request->instagramUrl,
            'twitter' => $request->twitterUrl,
            'linkedin' => $request->linkedinUrl,
            'collab_type' => strtolower($request->collab_type),
        ]);

        Session()->flash('success', 'Campaign created successfully.');
        return redirect()->back();
    }
    
     public function editer($id)
    {
        $emp = Employer::find(Auth::guard('employer')->id());
        $camp = InfluencerCampaign::find($id);

        if ($camp && $camp->employe_id == Auth::guard('employer')->id()) {
            return view('employer.influencercampaign.edit')->with([
                'employer' => $emp,
                'camp' => $camp
            ]);
        } else {
            session()->flash('error', "You are not allowed to edit this campaign");
            return redirect()->back();
        }
    }

    // Handle update form submission
    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:influencer_campaign,id',
            'campaign_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'upload' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,mp4|max:10240',
            'youtubeUrl' => 'nullable|url',
            'instagramUrl' => 'nullable|url',
            'twitterUrl' => 'nullable|url',
            'linkedinUrl' => 'nullable|url',
            'collab_type' => 'required|in:Barter,paid',
            'employer_id' => 'required|exists:employers,id',
        ]);

        $campaign = InfluencerCampaign::find($request->id);

        if (!$campaign || $campaign->employe_id != Auth::guard('employer')->id()) {
            session()->flash('error', 'Unauthorized access');
            return redirect()->back();
        }

       if ($request->hasFile('upload')) {
            $relativePath = "assets/influencer_campaign/";
            $basePath = dirname(public_path()) . '/';
            $fullPath = $basePath . $relativePath;
            $filename = time() . '.' . $request->file('upload')->getClientOriginalExtension();
        
            // Delete old upload file if exists
            if ($campaign->upload && file_exists($basePath . $campaign->upload)) {
                unlink($basePath . $campaign->upload);
            }
        
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }
        
            if (move_uploaded_file($request->file('upload')->getRealPath(), $fullPath . $filename)) {
                $campaign->upload = $relativePath . $filename;
            }
        }

        // Update campaign data
        $campaign->title = $request->campaign_title;
        $campaign->description = $request->description;
        $campaign->youtube = $request->youtubeUrl;
        $campaign->instagram = $request->instagramUrl;
        $campaign->twitter = $request->twitterUrl;
        $campaign->linkedin = $request->linkedinUrl;
        $campaign->collab_type = strtolower($request->collab_type);
        $campaign->save();

        session()->flash('success', 'Campaign updated successfully.');
        return redirect()->back();
    }
 
     public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:influencer_campaign,id',
        ]);

        // Find the campaign by id
        $campaign = InfluencerCampaign::find($request->id);

        if (!$campaign) {
            Session::flash('error', 'Campaign not found.');
            return redirect()->back();
        }

        // Check if the logged-in employer owns this campaign
        if ($campaign->employe_id !== Auth::guard('employer')->id()) {
            Session()->flash('error', 'You are not authorized to delete this campaign.');
            return redirect()->back();
        }

        // Delete the campaign
        $campaign->delete();

        Session()->flash('success', 'Campaign deleted successfully.');
        return redirect()->back();
    }
    public function showInfluencerData($campaignId,$managerId)
    {
        $campaign = InfluencerCampaign::findOrFail($campaignId);
        $influencers = InfluencerProfile::where('influencer_campaign_id', $campaignId)->where('manager_id',$managerId)
            ->get();

        return view('employer.influencercampaign.influencer_data', compact('campaign', 'influencers'));
    }
   public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,accepted,rejected',
    ]);

    $influencer = InfluencerProfile::findOrFail($id);
    $influencer->status = $request->input('status');
    $influencer->save();

    return redirect()->back()->with('success', 'Influencer status updated.');
}

    public function bulkUpdateStatus(Request $request)
{
    $request->validate([
        'influencer_ids' => 'required|array',
        'bulkstatus' => 'required|in:pending,accepted,rejected',
    ]);
    InfluencerProfile::whereIn('id', $request->influencer_ids)
        ->update(['status' => $request->bulkstatus]);

    return redirect()->back()->with('success', 'Statuses updated successfully!');
}

public function UploadLiveStatus($id)
{
    $influencer = InfluencerProfile::findOrFail($id);
    $influencer->upload_file_status = $influencer->upload_file_status === 'live' ? 'not_live' : 'live';
    $influencer->save();

    return back()->with('success', 'Upload file status updated successfully.');
}



}
