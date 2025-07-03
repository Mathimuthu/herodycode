<?php

namespace App\Http\Controllers;

use App\Answer;
use App\CamQuestion;
use App\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    public function showForm(Request $request)
    {
        $referral_code = $request->query('ref');

        if (!$referral_code) {
            return redirect()->back()->with('error', 'Referral code is required.');
        }

        // Use referral table to get campaign questions
        $referral = Referral::where('referral_code', $referral_code)->first();

        if (!$referral) {
            return redirect()->back()->with('error', 'Invalid referral code.');
        }

        // Fetch questions for the campaign without altering them
        $questions = CamQuestion::with('choices')
            ->where('campaign_id', $referral->campaign_id)
            ->get();

        if ($questions->isEmpty()) {
            return redirect()->back()->with('error', 'No questions found for this referral.');
        }

        return view('form.show', compact('questions', 'referral_code'));
    }

    // public function submitForm(Request $request)
    // {
    //     $referral_code = $request->input('referral_code');

    //     if (!$referral_code) {
    //         return redirect()->back()->with('error', 'Referral code is required.');
    //     }

    //     $referral = Referral::where('referral_code', $referral_code)->first();

    //     if (!$referral) {
    //         return redirect()->back()->with('error', 'Invalid referral code.');
    //     }

    //     $questions = CamQuestion::with('choices')
    //         ->where('campaign_id', $referral->campaign_id)
    //         ->get();

    //     if ($questions->isEmpty()) {
    //         return redirect()->back()->with('error', 'No questions found for this referral.');
    //     }

    //     $rules = [];
    //     $messages = [];

    //     foreach ($questions as $question) {
    //         $key = "q_{$question->id}";

    //         if ($question->required) {
    //             switch ($question->type) {
    //                 case 'text':
    //                 case 'paragraph':
    //                 case 'choice':
    //                 case 'dropdown':
    //                 case 'time':
    //                     $rules[$key] = 'required';
    //                     break;
    //                 case 'checkbox':
    //                     $rules[$key] = 'required|array';
    //                     $rules["$key.*"] = 'string';
    //                     break;
    //                 case 'file':
    //                     $rules[$key] = 'required|file|max:10240';
    //                     break;
    //                 case 'date':
    //                     $rules[$key] = 'required|date';
    //                     break;
    //             }

    //             $messages["$key.required"] = "The question '{$question->text}' is required.";
    //         } elseif ($question->type === 'file') {
    //             $rules[$key] = 'nullable|file|max:10240';
    //         }
    //     }

    //     $validator = Validator::make($request->all(), $rules, $messages);

    //     if ($validator->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     foreach ($questions as $question) {
    //         $fieldName = "q_{$question->id}";

    //         if ($request->has($fieldName)) {
    //             $answerData = [
    //                 'question_id' => $question->id,
    //                 'referral_code' => $referral_code,
    //             ];

    //             if ($question->type === 'file' && $request->hasFile($fieldName)) {
    //                 $file = $request->file($fieldName);
    //                 $path = $file->store('form_uploads');
    //                 $answerData['response'] = $file->getClientOriginalName();
    //                 $answerData['file_path'] = $path;
    //             } elseif ($question->type === 'checkbox' && is_array($request->$fieldName)) {
    //                 $answerData['response'] = json_encode($request->$fieldName);
    //             } else {
    //                 $answerData['response'] = $request->$fieldName;
    //             }

    //             Answer::create($answerData);
    //         }
    //     }

    //     return redirect()->back()->with('success', 'Form submitted successfully');
    // }
    public function submitForm(Request $request)
{
    $referral_code = $request->input('referral_code');

    if (!$referral_code) {
        return redirect()->back()->with('error', 'Referral code is required.');
    }

    $referral = Referral::where('referral_code', $referral_code)->first();

    if (!$referral) {
        return redirect()->back()->with('error', 'Invalid referral code.');
    }

    $questions = CamQuestion::with('choices')
        ->where('campaign_id', $referral->campaign_id)
        ->get();

    if ($questions->isEmpty()) {
        return redirect()->back()->with('error', 'No questions found for this referral.');
    }

    $rules = [];
    $messages = [];

    foreach ($questions as $question) {
        $key = "q_{$question->id}";

        if ($question->required) {
            switch ($question->type) {
                case 'text':
                case 'paragraph':
                case 'choice':
                case 'dropdown':
                case 'time':
                    $rules[$key] = 'required';
                    break;
                case 'checkbox':
                    $rules[$key] = 'required|array';
                    $rules["$key.*"] = 'string';
                    break;
                case 'file':
                    $rules[$key] = 'required|file|max:10240';
                    break;
                case 'date':
                    $rules[$key] = 'required|date';
                    break;
            }

            $messages["$key.required"] = "The question '{$question->text}' is required.";
        } elseif ($question->type === 'file') {
            $rules[$key] = 'nullable|file|max:10240';
        }
    }

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    foreach ($questions as $question) {
        $fieldName = "q_{$question->id}";

        if ($request->has($fieldName) || $request->hasFile($fieldName)) {
            $answerData = [
                'question_id' => $question->id,
                'referral_code' => $referral_code,
            ];

            if ($question->type === 'file' && $request->hasFile($fieldName)) {
                $file = $request->file($fieldName);
                $filename = time() . '_' . $file->getClientOriginalName();
                $relativePath = "assets/campaign_screenshots/";
                $basePath = dirname(public_path()) . '/';
                $fullPath = $basePath . $relativePath;

                // Ensure directory exists
                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0755, true);
                }

                try {
                    if (move_uploaded_file($file->getRealPath(), $fullPath . $filename)) {
                        $answerData['response'] = $file->getClientOriginalName(); // original filename
                        $answerData['file_path'] = $relativePath . $filename; // saved path
                    } else {
                        return redirect()->back()
                            ->with('error', 'There was a problem uploading the file: ' . $file->getClientOriginalName())
                            ->withInput();
                    }
                } catch (\Exception $e) {
                    return redirect()->back()
                        ->with('error', 'File upload error: ' . $e->getMessage())
                        ->withInput();
                }
            } elseif ($question->type === 'checkbox' && is_array($request->$fieldName)) {
                $answerData['response'] = json_encode($request->$fieldName);
            } else {
                $answerData['response'] = $request->$fieldName;
            }

            Answer::create($answerData);
        }
    }

    return redirect()->back()->with('success', 'Form submitted successfully');
}

}
