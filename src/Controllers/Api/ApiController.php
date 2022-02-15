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
     * Allows you to receive the webhook sent by https://serveur-minecraft-vote
     * The request will be checked and if the request is valid then it will be processed and a reward will be given
     *
     * @param Request $request
     * @return string
     *
     * @throws Exception
     */
    public function webhooks(Request $request): string
    {

        $site = 'smv';

        try {
            // Create Serveur Minecraft Vote
            $smv = new ServeurMinecraftVote();

            // Recovery of the secret key
            $key = setting(AdminController::SETTINGS_WEBHOOK);

            // If the key is empty then we return an error message
            if (empty($key)) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'Impossible to recover the secret key of the webhook.',
                ]);
            }

            // We will get the secret key from the header
            $header = $request->header('X-SMV-Signature');

            // We will check if the header is correct
            $smv->verifyHeader($request->getContent(), $header, $key);

            // Data recovery to be able to generate a random reward
            $type = $request['type'];
            $data = $request['data'];
            $reward = WebhookReward::getRandomReward($type, $data['user']['name'] ?? '');

            // If the reward is not found we send an error message
            if (empty($reward)) {
                return json_encode([
                    'status' => 'error',
                    'message' => "No reward found for $type",
                ]);
            }

            // Otherwise, we will give the reward to the player
            WebhookHistory::create([
                'webhook_reward_id' => $reward->id,
                'name' => $data['user']['name'] ?? '',
            ]);
            $reward->giveTo($data['user']['name'] ?? '');

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
