<?php

use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\UserRewardController;
// use App\Http\Controllers\API\UserRewardController as APIUserRewardController;
use App\Http\Controllers\Api\WalletTransactionController;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\HelpLinkController;
use App\Http\Controllers\Api\ReferralController;
use App\Http\Controllers\Api\ReferralFormController;
use App\Http\Controllers\Api\AnswerController;
use App\Http\Controllers\Employer\CampaignDescriptionController;
use App\Http\Controllers\Employer\QuestionController;
use App\Http\Controllers\API\GigController;
use App\Http\Controllers\API\CampaignController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::namespace('API\User')->prefix('user')->group(function(){
//     Route::post('login','MainController@login');
//     Route::get('userexist','MainController@userexist');
//     Route::post('register','MainController@register');
//     Route::post('details','DetailController@details');
//     Route::post('skills','DetailController@skills');
//     Route::post('edu','DetailController@edu');
//     Route::post('exp','DetailController@exp');
//     Route::post('projects','DetailController@projects');
//     Route::post('skillsUpdate','DetailController@skillsUpdate');
//     Route::post('eduUpdate','DetailController@eduUpdate');
//     Route::post('expUpdate','DetailController@expUpdate');
//     Route::post('projectsUpdate','DetailController@projectsUpdate');
//     Route::post('skillsDelete','DetailController@skillsDelete');
//     Route::post('eduDelete','DetailController@eduDelete');
//     Route::post('expDelete','DetailController@expDelete');
//     Route::post('projectsDelete','DetailController@projectsDelete');
//     Route::post('hobbiesUpdate','DetailController@hobbyUpdate');
//     Route::post('achievementsUpdate','DetailController@achUpdate');
//     Route::post('socialUpdate','DetailController@socialUpdate');
//     Route::post('profileUpdate','DetailController@profileUpdate');
//     Route::post('profileImage','DetailController@profileImage');
//     Route::post('passUpdate','DetailController@passUpdate');
//     Route::post('loginTC','MainController@loginTC');
//     Route::post('verifyMobile','MainController@verifyMobile');
//     Route::post('forgot-password','MainController@forgotPassword');
//     Route::post('email-verified','MainController@emailVerified');
//     Route::post('storeRef','DetailController@storeRef');
//     Route::post('get-session','MainController@getSession');

//     Route::post('jprojects','DetailController@jprojects');
//     Route::post('gigs','DetailController@gigs');
//     Route::post('campaigns','DetailController@campaigns');

//     Route::post('withdrawMethod','DetailController@withdrawMethod');
//     Route::post('bannerMethod','DetailController@bannerMethod');
//     Route::post('withdraw','DetailController@withdraw');
//     Route::post('transactions','DetailController@transactions');
//     Route::post('allTransactions','DetailController@allTransactions');
// });
// Route::namespace('API')->group(function(){
//     Route::post('projects','ProjectController@list');
//     Route::post('project/details','ProjectController@details');
//     Route::post('project/apply','ProjectController@apply');
//     Route::post('project/proofs','ProjectController@proofs');
//     Route::post('mobileContent','ProjectController@mobile');

       Route::get('/gigs',[GigController::class,'list'])->name('gigs');
       Route::get('/gig/details',[GigController::class,'details'])->name('gig/details');
       Route::get('/gig/apply',[GigController::class,'apply'])->name('gig/apply');

       Route::get('/gig/proof/fb',[GigController::class,'prooffb'])->name('gig/proof/fb');
       Route::get('/gig/proof/wa',[GigController::class,'proofwa'])->name('gig/proof/wa');
       Route::get('/gig/proof/insta',[GigController::class,'proofinsta'])->name('gig/proof/insta');
       Route::get('/gig/proof/yt',[GigController::class,'proofyt'])->name('gig/proof/yt');
       Route::get('/gig/proof/instap',[GigController::class,'proofinstap'])->name('gig/proof/instap');
       Route::get('/gig/proof/os',[GigController::class,'proofos'])->name('gig/proof/os');
       Route::get('/gig/proof/ar',[GigController::class,'proofar'])->name('gig/proof/ar');
       Route::get('/gig/proof/ls',[GigController::class,'proofls'])->name('gig/proof/ls');
       Route::get('/gig/proofs',[GigController::class,'proofs'])->name('gig/proofs');

       Route::get('/campaigns',[CampaignController::class,'list'])->name('campaigns');
       Route::get('/campaign/details',[CampaignController::class,'details'])->name('campaign/details');
       Route::get('/campaign/apply',[CampaignController::class,'apply'])->name('campaign/apply');
       Route::get('/campaign/proof',[CampaignController::class,'proofs'])->name('campaign/proof');

//     Route::post("telecallings","TelecallingController@list");
//     Route::post("telecalling/details","TelecallingController@details");
//     Route::post("telecalling/apply","TelecallingController@apply");
//     Route::post("telecalling/applications","TelecallingController@applications");
//     Route::post("telecalling/status","TelecallingController@status");
//     Route::post("telecalling/feedback","TelecallingController@feedback");

//     Route::post("razorp/addc","RazorpayController@add_contact");
//     Route::post("razorp/fundid","RazorpayController@get_fund_id");
//     Route::post("razorp/withdraw","RazorpayController@withdraw");
//     Route::post('wallet-transactions',[WalletTransactionController::class,'store']);
//     Route::post('transactions','TransactionController@store');
//     Route::post('offerwall-users','OfferwallUserController@store');
//     Route::post('offerwall-user-offer','OfferwallUserOfferController@store');
//     Route::post('user-rewards', [UserRewardController::class, 'store']);
//     Route::get('/games', [GameController::class, 'fetchGames']);

// });
// // Create a new reward record
// Route::post('test','TrueCallerController@login');
// Route::get("config", "ConfigurationController@fetchConfiguration");

// Route::get('/help-links', [HelpLinkController::class, 'apiIndex']);
// Route::post('/generate-referral', [ReferralController::class, 'generateReferral']);

// Route::get('/employer/referral-codes', 'Employer\QuestionController@getReferralCodes');

// Route::get('/referral-forms', [ReferralFormController::class, 'publicIndex']);
// Route::get('acc_details',"RazorpayController@create_contact");
// Route::post('acc_details',"RazorpayController@add_contact");
// Route::post('givereward/',"RazorpayController@givereward");
Route::get('/campaign-descriptions', [CampaignDescriptionController::class, 'getDescriptions']);
Route::get('/campaign-descriptions/{id}', [CampaignDescriptionController::class, 'Descriptions']);
Route::post('/update-descriptions/{id}', [CampaignDescriptionController::class, 'updateDescriptions']);
Route::delete('/delete-descriptions/{id}', [CampaignDescriptionController::class, 'deleteDescriptions']);
// //pubscale
// Route::post('transactions', [TransactionController::class, 'store']);
// Route::post('offerwall-users', [OfferwallUserController::class, 'store']);
// Route::post('offerwall-user-offer', [OfferwallUserOfferController::class, 'store']);

Route::get('/referral-forms', [ReferralFormController::class, 'publicIndex']);
Route::get('/campaigns', [ReferralFormController::class, 'getAllCampaigns']);
Route::get('/user-answers', [AnswerController::class, 'getUserAnswers']);
Route::get('/referral', [AnswerController::class, 'getAllReferrals']);
Route::post('/answer/status', [QuestionController::class, 'answerStatus']);
