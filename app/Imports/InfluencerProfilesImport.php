<?php
namespace App\Imports;

use App\InfluencerProfile;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InfluencerProfilesImport implements ToModel, WithHeadingRow
{
    protected $campaignId;
    protected $managerId;

    public function __construct($campaignId,$managerId)
    {
        $this->campaignId = $campaignId;
        $this->managerId = $managerId;
    }

    public function model(array $row)
    {
        return new InfluencerProfile([
            'influencer_campaign_id' => $this->campaignId,
            'manager_id' => $this->managerId,
            'link' => $row['link'],
            'follower' => $row['followers'],
            'platform' => $row['platform'],
            'engagement' => $row['engagement'],
            'collaboration_type' => $row['collaboration'],
            'city' => $row['city'],
            'gender' => $row['gender'],
            'past_work' => $row['past_work'],
        ]);
    }
}
