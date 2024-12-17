<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\GeneralSetting;
use App\Models\SocialNetwork;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

class AdminSettings extends Component
{
    use WithFileUploads;

    public $tab = null;
    public $default_tab = 'general_settings';
    protected $queryString = ['tab'];

    public $site_name, $site_email, $site_phone, $site_meta_keywords, $site_meta_description, $site_logo, $site_favicon;

    public $facebook_url, $instagram_url, $twitter_url, $tiktok_url, $shoppee_url, $lazada_url;

    public function selectTab($tab)
    {
        $this->tab = $tab;
    }

    public function mount()
    {
        $this->tab = request()->tab ? request()->tab : $this->default_tab;

        // Populate
        $this->site_name = get_settings()->site_name;
        $this->site_email = get_settings()->site_email;
        $this->site_phone = get_settings()->site_phone;
        $this->site_meta_keywords = get_settings()->site_meta_keywords;
        $this->site_meta_description = get_settings()->site_meta_description;
        $this->site_logo = get_settings()->site_logo;
        $this->site_favicon = get_settings()->site_favicon;

        // Populate social networks
        $this->facebook_url = get_social_network()->facebook_url;
        $this->instagram_url = get_social_network()->instagram_url;
        $this->twitter_url = get_social_network()->twitter_url;
        $this->tiktok_url = get_social_network()->tiktok_url;
        $this->shoppee_url = get_social_network()->shoppee_url;
        $this->lazada_url = get_social_network()->lazada_url;
    }

    public function updateGeneralSettings()
    {
        $this->validate([
            'site_name' => 'required',
            'site_email' => 'required|email'
        ]);

        $settings = new GeneralSetting();
        $settings = $settings->first();
        $settings->site_name = $this->site_name;
        $settings->site_email = $this->site_email;
        $settings->site_phone = $this->site_phone;
        $settings->site_meta_keywords = $this->site_meta_keywords;
        $settings->site_meta_description = $this->site_meta_description;
        $update = $settings->save();

        if ($update) {
            Log::info("General settings updated successfully.", [
                'time_stamp' => now()->format('F j, Y g:i A'),
                'general settings details' => [
                    'site_name' => $this->site_name,
                    'site_email' => $this->site_email,
                    'site_phone' => $this->site_phone,
                    'site_meta_keywords' => $this->site_meta_keywords,
                    'site_meta_description' => $this->site_meta_description
                ]
            ]);
            $this->dispatch('toast', type: 'success', message: "General settings have been successfully updated.");
        } else {
            $this->dispatch('toast', type: 'danger', message: "Something went wrong.");
        }
    }

    public function updateSocialNetworks()
    {
        $social_network = new SocialNetwork();
        $social_network = $social_network->first();
        $social_network->facebook_url = $this->facebook_url;
        $social_network->instagram_url = $this->instagram_url;
        $social_network->twitter_url = $this->twitter_url;
        $social_network->tiktok_url = $this->tiktok_url;
        $social_network->shoppee_url = $this->shoppee_url;
        $social_network->lazada_url = $this->lazada_url;
        $update = $social_network->save();

        if ($update) {
            Log::info("Social network updated successfully", [
                'time_stamp' => now()->format('F j, Y g:i A'),
                'social network details' => [
                    'facebook_url' => $this->facebook_url,
                    'instagram_url' => $this->instagram_url,
                    'twitter_url' => $this->twitter_url,
                    'tiktok_url' => $this->tiktok_url,
                    'shoppee_url' => $this->shoppee_url,
                    'lazada_url' => $this->lazada_url
                ]
            ]);
            $this->dispatch('toast', type: 'success', message: "Social network settings have been successfully updated.");
        } else {
            $this->dispatch('toast', type: 'danger', message: "Something went wrong.");
        }
    }

    public function render()
    {
        return view('livewire.admin.admin-settings');
    }
}
