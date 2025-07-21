<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InfluencerProfilesImport;
use App\InfluencerProfile;
use App\Manager;
use App\InfluencerCampaign;
use App\Project;
use App\Gig;
use App\Pending;
use App\GigCategory;
use App\CompletedGig as CJ;
use App\User;
use App\Employer;
use App\PendingGig;
use App\Task;
use App\PendingTask;
use App\ManagerInfluencercampaign;
use App\Mail\GlobalMail;
use Illuminate\Support\Facades\Mail;
use App\PendingQuestion as PQ;
use App\Question as Qs;

class MainController extends Controller
{
public function dashboard()
{
    $managerId = Auth::guard('manager')->id();
    $manager = Manager::find($managerId);
    $campaigns = InfluencerCampaign::latest()->get();

    // Load statuses per campaign for this manager
    $statuses = ManagerInfluencercampaign::where('updated_by', $managerId)
                    ->pluck('status', 'influencer_campaign_id')
                    ->toArray();

    return view('manager.pages.dashboard')->with([
        'manager' => $manager,
        'campaigns' => $campaigns,
        'statuses' => $statuses,
    ]);
}

    //Projects Controller
    public function pendingjobs(){
        $jobs = Pending::orderBy('created_at','asc')->paginate(15);
        return view('manager.pages.pendingjobs')->with([
            'pending' => $jobs,
        ]);
    }
    
    public function jobApprove(Request $request){
        $pending = Pending::find($request->id);
        $job = new Project;

        $emp = Employer::find($pending->user);

        $job->title = $pending->title;
        $job->des = $pending->des;
        $job->cat = $pending->cat;
        $job->start = $pending->start;
        $job->end = $pending->end;
        $job->duration = $pending->duration;
        $job->stipend = $pending->stipend;
        $job->benefits = $pending->benefits;
        $job->place = $pending->place;
        $job->count = $pending->count;
        $job->skills = $pending->skills;
        $job->user = $pending->user;
        $job->proofs = $pending->proofs;
        $job->save();
        $pid = $pending->id;
        $pending->delete();
        $questions = PQ::where('pid',$pid)->get();
        foreach($questions as $qus){
            $q = new Qs;
            $q->pid = $job->id;
            $q->question = $qus->question;
            $q->save();
            $qus->delete();
        }

        // Mail
        $sub = "Your Project has been accepted";
        $message="<p>Dear {$emp->name},</p><p>Your project, {$job->title}, has been accepted by a manager.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($emp->email)->send(new GlobalMail($data));
        
        Session()->flash('success','Project Approved');
        return redirect()->back();
    }

    public function jobReject(Request $request){
        $pending = Pending::find($request->id);

        $emp = Employer::find($pending->user);
        $job = $pending;
        $pending->delete();

        // Mail
        $sub = "Your Project has been rejected";
        $message="<p>Dear {$emp->name},</p><p>Your project, {$job->title}, has been rejected by a manager.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($emp->email)->send(new GlobalMail($data));

        Session()->flash('success','Project Deleted');
        return redirect()->back();
    }
    
    public function jobAll(){
        $jobs = Project::orderBy('updated_at')->paginate(15);
        return view('manager.pages.alljobs')->with([
            'jobs' => $jobs
        ]);
    }


    //Gigs Controller

    public function pendingGigs(){
        $campaigns = PendingGig::orderBy('created_at','asc')->paginate(15);
        return view('manager.pages.pendinggigs',compact('campaigns'));
    }
    public function allGigs(){
        $campaigns = Gig::orderBy('created_at','desc')->paginate(15);
        return view('manager.pages.allgigs',compact('campaigns'));
    }
    
    public function approveCampaign($id){
        $pending = PendingGig::find($id);
        $campaign = new Gig;
        $cat = GigCategory::find($pending->campaign_category);
        $campaign->cats = $pending->cats;
        $campaign->per_cost = $pending->per_cost;
        $campaign->campaign_title = $pending->campaign_title;
        $campaign->description = $pending->description;
        $campaign->brand = $pending->brand;
        $campaign->logo = $pending->logo;

        $campaign->user_id = $pending->user_id;
        $campaign->save();
        
        $tasks = PendingTask::where('cid',$pending->id)->get();
        foreach($tasks as $taske){
            $task = new Task;
            $task->cid = $campaign->id;
            $task->task = $taske->task;
            $task->save();
            $taske->delete();
        }
        $emp = Employer::find($pending->user_id);

        // Mail
        $sub = "Your gig has been approved";
        $message="<p>Dear {$emp->name},</p><p>Your gig, {$pending->campaign_title}, has been approved by a manager.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($emp->email)->send(new GlobalMail($data));

        $pending->delete();
        Session()->flash('success','Gig Approved');
        return redirect()->back();
    }
    public function rejectCampaign($id){
        PendingTask::where('cid',$id)->delete();
        $pending = PendingGig::find($id);
        PendingGig::find($id)->delete();
        $emp = Employer::find($pending->user_id);

        // Mail
        $sub = "Your gig has been rejected";
        $message="<p>Dear {$emp->name},</p><p>Your gig, {$pending->campaign_title}, has been rejected by a manager.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($emp->email)->send(new GlobalMail($data));
        Session()->flash('success','Gig Deleted');
        return redirect()->back();
    }

    // Create Gigs

    public function createGig(){
        $campaignCategory = GigCategory::get();
        return view('manager.pages.createGig')->with([
            'campaignCategory' => $campaignCategory
        ]);
    }
    public function storeGig(Request $request){

        //validation
        $this->validate($request, [
            'cat' => 'required',
            'per_cost' => 'required|numeric',
            'description' => 'required',
            'campaign_title' => 'required',
            'brand' => 'required',
            'tasks' => 'required',
            'filess' => 'required',
            'logo' => 'required|image',
        ]);
        $campaign = new Gig();
        $campaign->per_cost = $request->per_cost;
        $campaign->campaign_title = $request->campaign_title;
        $campaign->description = $request->description;
        $cat = "";
        foreach($request->cat as $cate){
            $cat = $cate.", ".$cat;
        }
        $campaign->cats = $cat;
        $campaign->brand = $request->brand;
        if($request->hasFile('logo')){
            $name = $_FILES['logo']['name'];
            $tmp = $_FILES['logo']['tmp_name'];
            $path = "assets/admin/img/gig-brand-logo/";
            $name = "Gig_Brand_".$name;
            if(move_uploaded_file($tmp,$path.$name)){
                $campaign->logo = $name;
            }
            else{
                $request->session()->flash('error', 'There is some problem in uploading the image');
                return redirect()->back();
            }
        }
        $campaign->user_id = "Admin";
        $campaign->save();
        $i=0;

        foreach($request->tasks as $taske){
            $files[$i]= "<a href=\"".$request->filess[$i]."\" class=\"btn btn-link\">Click here to download the file(s)</a>";
            $taske = $taske."<br/>".$files[$i];
            $task = new Task;
            $task->cid = $campaign->id;
            $task->task = $taske;
            $task->save();
            $i++;
        }

        //redirect
        Session()->flash('success', 'Your gig successfully created');
        return redirect()->back();
    }
   public function updateStatus(Request $request)
{
    $request->validate([
        'id' => 'required|integer|exists:influencer_campaign,id',
        'status' => 'required|in:pending,accepted,rejected',
    ]);

    $managerId = Auth::guard('manager')->id();

    $existing = ManagerInfluencercampaign::where('influencer_campaign_id', $request->id)
        ->where('updated_by', $managerId)
        ->first();

    if ($existing) {
        // Update status
        $existing->status = $request->status;
        $existing->save();
    } else {
        // Insert new record
        ManagerInfluencercampaign::create([
            'influencer_campaign_id' => $request->id,
            'status' => $request->status,
            'updated_by' => $managerId,
        ]);
    }
    
        return response()->json(['success' => true]);
    }
    public function uploadExcel(Request $request)
    {
        if (!$request->hasFile('excel_file')) {
            return back()->with('error', 'No file uploaded.');
        }
    
        $file = $request->file('excel_file');
        $ext = strtolower($file->getClientOriginalExtension());
    
        if (!in_array($ext, ['xlsx', 'xls'])) {
            return back()->with('error', 'Invalid file type. Only .xlsx or .xls allowed.');
        }
    
        $campaignId = $request->input('campaign_id');
    
        if (!\DB::table('influencer_campaign')->where('id', $campaignId)->exists()) {
            return back()->with('error', 'Invalid campaign ID.');
        }
        $managerId = Auth::guard('manager')->id();
        try {
            Excel::import(new InfluencerProfilesImport($campaignId,$managerId), $file);
            return back()->with('success', 'Excel imported successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
    public function viewProfiles($campaignId)
    {
        $managerId = auth('manager')->id();
    
        $campaign = InfluencerCampaign::with(['profiles' => function ($query) use ($managerId) {
            $query->where('manager_id', $managerId);
        }])->findOrFail($campaignId);
    
        $profiles = $campaign->profiles;
    
        return view('manager.pages.view-profiles', compact('campaign', 'profiles'));
    }
    public function updateContentStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:influencer_profiles,id',
            'content_status' => 'required|string|max:255'
        ]);
    
        $profile = InfluencerProfile::find($request->id);
        $profile->content_status = $request->content_status;
        $profile->save();
    
        return back()->with('success', 'Status Updated successfully!');
    }
     public function uploadFile(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:influencer_profiles,id',
            'upload_file' => 'required|file|mimes:mp4,mov,jpg,jpeg,png,webp,avif,gif,doc,docx,pdf|max:20480'
        ]);
         $filePath = null;
        if ($request->hasFile('upload_file')) {
            $relativePath = "assets/influencer_profile/";
            $basePath = dirname(public_path()) . '/';
            $fullPath = $basePath . $relativePath;
            $filename = time() . '.' . $request->file('upload_file')->getClientOriginalExtension();
    
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }
    
            if (move_uploaded_file($request->file('upload_file')->getRealPath(), $fullPath . $filename)) {
                $filePath = $relativePath . $filename;
            }
        }
        $profile = InfluencerProfile::find($request->id);
        $profile->upload_file = $filePath;
        $profile->save();
    
        return back()->with('success', 'File Uploaded successfully!');
    }

}
