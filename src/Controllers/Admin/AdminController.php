<?php

namespace Azuriom\Plugin\ServeurMinecraftVote\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;
use Azuriom\Plugin\ServeurMinecraftVote\Models\WebhookHistory;
use Azuriom\Plugin\ServeurMinecraftVote\Models\WebhookReward;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use ServeurMinecraftVote\Exceptions\WebhookCreateException;
use ServeurMinecraftVote\ServeurMinecraftVote;

class AdminController extends Controller
{

    const SETTINGS_KEY = 'smv.key';
    const SETTINGS_WEBHOOK = 'smv.webhook';

    const WEBHOOK_EVENTS = [
        'user.follow',
        'user.unfollow',
        'train.start',
        'train.finish',
        'train.levelup',
        'train.vote',
    ];

    /**
     * Show the home admin page of the plugin.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $key = Str::limit(setting(self::SETTINGS_KEY), 20);
        return view('serveurminecraftvote::admin.index', [
            'key' => $key,
            'rewards' => WebhookReward::with('server')->get(),
            'logs' => WebhookHistory::with('webhook')->latest()->paginate(),
        ]);
    }

    /**
     * Create Webhook with API of https://serveur-minecraft-vote.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'key' => ['required', 'min:30', 'starts_with:smv_sk_'],
        ]);

        $secretKey = $request['key'];
        try {
            $smv = new ServeurMinecraftVote($secretKey);

            $url = route('serveurminecraftvote.api.webhooks');
            $webhooks = $smv->getWebhooks();

            foreach ($webhooks as $webhook) {
                if ($webhook->endpoint == $url) {
                    return redirect()->route('serveurminecraftvote.admin.index')
                        ->with('error', trans('serveurminecraftvote::admin.webhook.already'));
                }
            }

            $webhook = $smv->createWebhook($url, self::WEBHOOK_EVENTS, setting('name', 'Azuriom'));

            $setting = [
                self::SETTINGS_KEY => $secretKey,
                self::SETTINGS_WEBHOOK => $webhook->secretKey,
            ];
            Setting::updateSettings($setting);

            return redirect()->route('serveurminecraftvote.admin.index')
                ->with('success', trans('serveurminecraftvote::admin.webhook.success'));
        } catch (GuzzleException|WebhookCreateException $e) {
            return redirect()->route('serveurminecraftvote.admin.index')
                ->with('error', trans('serveurminecraftvote::admin.webhook.error'));
        }
    }
}
