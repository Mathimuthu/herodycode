<?php

namespace App\Http\Controllers\Employer;

use App\Answer;
use App\User;
use App\Referral;
use App\CampaignDescription;
use App\Transition;
use App\CamQuestion;
use App\Choice;
use App\Http\Controllers\Controller;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    
    public function index()
    {
        $employee_id = Auth::guard('employer')->id();
    
        $groupedQuestions = CamQuestion::where('employee_id', $employee_id)
            ->with('choices')
            ->get()
            ->groupBy('referral_code');
    
        return view('questions.index', compact('groupedQuestions'));
    }
        

    public function create(Request $request)
    {
        $questionTypes = [
            'text' => 'Short Text',
            'paragraph' => 'Paragraph',
            'choice' => 'Multiple Choice',
            'checkbox' => 'Checkboxes',
            'dropdown' => 'Dropdown',
            'file' => 'File Upload',
            'date' => 'Date',
            'time' => 'Time'
        ];
        
        $employee_id = Auth::guard('employer')->id();
        $existingReferrals = CamQuestion::where('employee_id', $employee_id)
            ->select('referral_code')
            ->distinct()
            ->pluck('referral_code');
        
        $campaigns = CampaignDescription::where('employer_id', $employee_id)->get();
        $campaign_id = $request->query('campaign_id'); // Optional pre-selected campaign
    
        return view('questions.create', compact('questionTypes', 'existingReferrals', 'campaigns', 'campaign_id'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text.*' => 'required|string',
            'type.*' => 'required|in:text,paragraph,choice,checkbox,dropdown,file,date,time',
            'required.*' => 'nullable|boolean',
            'choices.*' => 'nullable|array',
            'choices.*.*' => 'nullable|string',
            'referral_code' => 'nullable|string', // Changed to require referral_code input
            'campaign_id' => 'nullable|exists:campaign_descriptions,id'
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $texts = $request->input('text', []);
        $types = $request->input('type', []);
        $requiredFlags = $request->input('required', []);
        $choicesAll = $request->input('choices', []);
        $campaign_id = $request->input('campaign_id');
        $referral_code = $request->input('referral_code');
    
        // Get the current employee ID
        $employee_id = Auth::guard('employer')->id();
    
        foreach ($texts as $index => $text) {
            $type = $types[$index] ?? 'text';
            $isRequired = isset($requiredFlags[$index]) ? true : false;
    
            $question = CamQuestion::create([
                'text' => $text,
                'type' => $type,
                'required' => $isRequired,
                'referral_code' => $referral_code,
                'employee_id' => $employee_id,
                'status' => 'pending',
                'campaign_id' => $campaign_id
            ]);
    
            if (in_array($type, ['choice', 'checkbox', 'dropdown']) && isset($choicesAll[$index])) {
                foreach ($choicesAll[$index] as $choiceText) {
                    if (!empty($choiceText)) {
                        Choice::create([
                            'question_id' => $question->id,
                            'text' => $choiceText
                        ]);
                    }
                }
            }
        }
    
        $message = 'Questions created successfully.';
        if ($campaign_id) {
            $message .= ' Associated with campaign.';
        }
        $message .= ' Form referral code: ' . $referral_code;
    
        return back()->with('success', $message);
    }
    // Helper method to generate a unique referral code
    // private function generateReferralCode($length = 8)
    // {
    //     $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //     $code = '';
        
    //     for ($i = 0; $i < $length; $i++) {
    //         $code .= $characters[rand(0, strlen($characters) - 1)];
    //     }
        
    //     // Check if code already exists
    //     if (CamQuestion::where('referral_code', $code)->exists()) {
    //         return $this->generateReferralCode($length); // Try again
    //     }
        
    //     return $code;
    // }

    public function show($id)
    {
        $employee_id = Auth::guard('employer')->id();
        $question = CamQuestion::with('choices')
            ->where('employee_id', $employee_id)
            ->findOrFail($id);
            
        return view('questions.show', compact('question'));
    }

    public function edit($id)
    {
        $employee_id = Auth::guard('employer')->id();
        $question = CamQuestion::with('choices')
            ->where('employee_id', $employee_id)
            ->findOrFail($id);
        
        // Define question types for the dropdown
        $questionTypes = [
            'text' => 'Short Text',
            'paragraph' => 'Paragraph',
            'choice' => 'Multiple Choice',
            'checkbox' => 'Checkboxes',
            'dropdown' => 'Dropdown',
            'file' => 'File Upload',
            'date' => 'Date',
            'time' => 'Time'
        ];
        
        return view('questions.edit', compact('question', 'questionTypes'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required',
            'type' => 'required|in:text,paragraph,choice,checkbox,dropdown,file,date,time',
            'required' => 'boolean'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $employee_id = Auth::guard('employer')->id();
        $question = CamQuestion::where('employee_id', $employee_id)->findOrFail($id);
        
        $question->update([
            'text' => $request->text,
            'type' => $request->type,
            'required' => $request->has('required'),
            // Status remains unchanged unless explicitly modified
        ]);
        
        // Check if this question type uses choices
        if (in_array($request->type, ['choice', 'checkbox', 'dropdown'])) {
            // Delete existing choices
            $question->choices()->delete();
            
            // Create new choices
            if (!empty($request->choices)) {
                foreach ($request->choices as $choiceText) {
                    if (!empty($choiceText)) {
                        Choice::create([
                            'question_id' => $question->id,
                            'text' => $choiceText
                        ]);
                    }
                }
            }
        }

        return redirect()->route('employer.questions.index')->with('success', 'Question updated successfully');
    }

    public function destroy($id)
    {
        $employee_id = Auth::guard('employer')->id();
        $question = CamQuestion::where('employee_id', $employee_id)->findOrFail($id);
        
        // Delete associated choices
        $question->choices()->delete();
        
        // Delete associated answers if that relationship exists
        if (method_exists($question, 'answers')) {
            $question->answers()->delete();
        }
        
        // Delete question
        $question->delete();

        return redirect()->route('employer.questions.index')->with('success', 'Question deleted successfully');
    }
//   public function viewAnswers($campaign_id)
// {
//     $employee_id = Auth::guard('employer')->id();
    
//     // Verify campaign belongs to this employer
//     $campaign = CampaignDescription::where('employer_id', $employee_id)
//         ->findOrFail($campaign_id);

//     // Get questions for this campaign
//     $questions = CamQuestion::where('employee_id', $employee_id)
//         ->where('campaign_id', $campaign_id)
//         ->with('choices')
//         ->get();

//     // Get referral codes from the referrals table for this campaign
//     $referralCodes = \App\Referral::where('campaign_id', $campaign_id)
//         ->pluck('referral_code')
//         ->toArray();

//     if (empty($referralCodes)) {
//         return view('questions.answer', [
//             'questions' => $questions,
//             'groupedAnswers' => collect(),
//             'campaign' => $campaign
//         ])->with('error', 'No referral codes found for this campaign.');
//     }

//     // Get all answers that belong to these referral codes
//     $answers = Answer::whereIn('referral_code', $referralCodes)
//         ->orderBy('created_at', 'desc')
//         ->get();

//     // Group answers by referral code + created time to represent submissions
//     $groupedAnswers = $answers->groupBy(function ($answer) {
//         return $answer->referral_code . '_' . $answer->created_at->format('Y-m-d H:i:s');
//     });

//     return view('questions.answer', compact('questions', 'groupedAnswers', 'campaign'));
// }

public function viewAnswers($campaign_id)
{
    $employee_id = Auth::guard('employer')->id();
    
    // Verify campaign belongs to this employer
    $campaign = CampaignDescription::where('employer_id', $employee_id)
        ->findOrFail($campaign_id);
    
    // Get questions for this campaign
    $questions = CamQuestion::where('employee_id', $employee_id)
        ->where('campaign_id', $campaign_id)
        ->with('choices')
        ->get();
    
    // Get referrals for this campaign along with user information
    $referrals = \App\Referral::where('campaign_id', $campaign_id)
        ->with('user') // Assuming you have a relationship set up
        ->get();
    
    $referralCodes = $referrals->pluck('referral_code')->toArray();
    
    if (empty($referralCodes)) {
        return view('questions.answer', [
            'questions' => $questions,
            'groupedAnswers' => collect(),
            'campaign' => $campaign
        ])->with('error', 'No referral codes found for this campaign.');
    }
    
    // Get all answers that belong to these referral codes
    $answers = Answer::whereIn('referral_code', $referralCodes)
        ->orderBy('created_at', 'desc')
        ->get();
    
    // Group answers by referral code + created time to represent submissions
    $groupedAnswers = $answers->groupBy(function ($answer) {
        return $answer->referral_code . '_' . $answer->created_at->format('Y-m-d H:i:s');
    });
    
    // Create a simpler array mapping of referral codes to user info
    $referralUserMap = [];
    foreach($referrals as $referral) {
        $referralUserMap[$referral->referral_code] = [
            'user_id' => $referral->user_id,
            'is_evaluated' => $referral->is_evaluated,
            'name' => $referral->user ? $referral->user->name : 'Unknown'
        ];
    }
    
    return view('questions.answer', compact('questions', 'groupedAnswers', 'campaign', 'referralUserMap'));
}
// public function addBalance(Request $request)
// {
//     $request->validate([
//         'user_id' => 'required|exists:users,id',
//         'amount' => 'required|numeric|min:1'
//     ]);
    
//     $user = User::find($request->user_id);
//     $task = CampaignDescription::latest()->first(); // Gets the most recent task
    
//     $user->balance += $request->amount;
//     $user->save();
    
//     $tr = new Transition;
//     $tr->uid = $user->id;
//     $tr->reason = $request->reason ?? "Campaign Adding Rewards - {$task->task_name}";
//     $tr->transition = '+' . $request->amount;
//     $tr->addm = $request->amount;
//     $tr->save();
    
//     return back()->with('success', 'Balance added successfully.');
// }
public function addBalance(Request $request)
{
    $request->validate([
        'user_id'  => 'required|exists:users,id',
        'task_id'  => 'required|exists:campaign_descriptions,id',
        'amount'   => 'required|numeric|min:1',
    ]);
    
    $user = User::find($request->user_id);
    $task = CampaignDescription::find($request->task_id);

    $user->balance += $request->amount;
    $user->save();

    $tr = new Transition;
    $tr->uid = $user->id;
    $tr->reason = $request->reason ?? "Campaign Adding Rewards - " . ($task->task_name ?? 'Unknown Task');
    $tr->transition = '+' . $request->amount;
    $tr->addm = $request->amount;
    $tr->save();

    $referral = Referral::where('user_id', $user->id)->first();
    if ($referral) {
        $referral->reward_amount = ($referral->reward_amount ?? 0) + $request->amount;
        $referral->save();
    }

    return back()->with('success', 'Balance added and referral updated successfully.');
}


public function updateStatus(Request $request)
{
    $request->validate([
        'answer_id' => 'required|exists:answers,id',
        'status' => ['nullable', 'in:0,1'],
    ]);
    $status = $request->status === '' ? null : $request->status;
    $answer = Answer::findOrFail($request->answer_id);
    $answer->status = $status;
    $answer->save();

    return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
}

public function referralStatus(Request $request)
{
    $request->validate([
        'referral_code' => 'required',
        'is_evaluated' => 'required|in:0,1',
    ]);

    $referral = Referral::where('referral_code', $request->referral_code)->firstOrFail();

    $referral->is_evaluated = $request->is_evaluated;
    $referral->save();

    return back()->with('success', 'Status changed to ' . ($request->is_evaluated ? 'Evaluated' : 'Not Evaluated'));
}


}