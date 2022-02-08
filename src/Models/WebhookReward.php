<?php

namespace Azuriom\Plugin\ServeurMinecraftVote\Models;

use Azuriom\Models\Server;
use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property string $webhook
 * @property string $site
 * @property int $server_id
 * @property int $chances
 * @property int $limit
 * @property int|null $money
 * @property bool $need_online
 * @property array $commands
 * @property bool $is_enabled
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Server|null $server
 *
 * @method static Builder enabled()
 * @method static WebhookReward create(array $values)
 */
class WebhookReward extends Model
{
    use HasTablePrefix;
    use HasFactory;

    /**
     * The table prefix associated with the model.
     *
     * @var string
     */
    protected $prefix = 'smv_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'site', 'webhook', 'name', 'server_id', 'chances', 'money', 'commands', 'need_online', 'is_enabled', 'limit',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'commands' => 'array',
        'is_enabled' => 'boolean',
    ];

    /**
     * Return a reward.
     *
     * @param string $type
     * @param $user
     * @return WebhookReward|null
     *
     * @throws Exception
     */
    public static function getRandomReward(string $type, $user): ?WebhookReward
    {
        // We get the list of rewards for the same type
        $rewards = self::where('webhook', $type)->where('is_enabled', true)->get();
        $total = $rewards->sum('chances');
        $random = random_int(0, $total);

        $sum = 0;

        // We will get a random reward
        foreach ($rewards as $reward) {
            $sum += $reward->chances;

            if ($sum >= $random) {
                $historyCount = WebhookHistory::where('webhook_reward_id', $reward->id)->where('name', $user)->count();

                if ($reward->limit !== 0 && $historyCount >=
                    $reward->limit) {
                    continue;
                }
                return $reward;
            }
        }
        return null;
    }

    /**
     * Relationship with the model Server
     *
     * @return BelongsTo
     */
    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    /**
     * Allows you to give the reward and execute commands on the server
     *
     * @param $userName
     * @return void
     */
    public function giveTo($userName)
    {
        // We will give the money and check that the user exists
        if ($this->money > 0) {
            $user = User::where('name', $userName)->first();

            if (isset($user)) {
                $user->addMoney($this->money);
                $user->save();
            }
        }

        $commands = $this->commands ?? [];

        $commands = array_map(function ($el) {
            return str_replace('{reward}', $this->name, $el);
        }, $commands);

        if ($this->server !== null && !empty($commands)) {
            $this->server->bridge()->executeCommands($commands, $userName, $this->need_online);
        }
    }
}
