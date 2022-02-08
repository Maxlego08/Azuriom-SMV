<?php

namespace Azuriom\Plugin\ServeurMinecraftVote\Controllers\Api;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServeurMinecraftVote\Controllers\Admin\AdminController;
use Azuriom\Plugin\ServeurMinecraftVote\Models\WebhookHistory;
use Azuriom\Plugin\ServeurMinecraftVote\Models\WebhookReward;
use Exception;
use Illuminate\Http\Request;
use ServeurMinecraftVote\Exceptions\SignatureVerificationException;
use ServeurMinecraftVote\ServeurMinecraftVote;

class ApiController extends Controller
{
    /**
     * @param  Request  $request
     * @param  string  $site
     * @return string
     *
     * @throws Exception
     */
    public function webhooks(Request $request, string $site): string
    {
        if ($site !== 'smv') {
            return json_encode([
                'status' => 'error',
                'message' => 'Website not found',
            ]);
        }

        try {
            $smv = new ServeurMinecraftVote();

            $key = setting(AdminController::SETTINGS_WEBHOOK);

            if (empty($key)) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'Impossible to recover the secret key of the webhook.',
                ]);
            }

            $header = $request->header('X-SMV-Signature');
            $smv->verifyHeader($request->getContent(), $header, $key);

            $type = $request['type'];
            $data = $request['data'];
            $reward = WebhookReward::getRandomReward($type, $data['user']['name'] ?? '');

            if (empty($reward)) {
                return json_encode([
                    'status' => 'error',
                    'message' => "No reward found for $type",
                ]);
            }

            $reward->giveTo($data['user']['name'] ?? '');

            if ($reward->limit !== 0) {
                WebhookHistory::create([
                    'webhook_reward_id' => $reward->id,
                    'name' => $data['user']['name'] ?? '',
                ]);
            }

            return json_encode([
                'status' => 'success',
                'message' => 'OK',
            ]);
        } catch (SignatureVerificationException $exception) {
            return json_encode([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
