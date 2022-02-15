<?php

namespace Azuriom\Plugin\ServeurMinecraftVote\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $name
 * @property int $webhook_reward_id
 * @property WebhookReward $webhook
 *
 * @method static WebhookHistory create(array $values)
 */
class WebhookHistory extends Model
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
        'webhook_reward_id', 'name',
    ];

    /**
     * Relation of the history to the reward
     *
     * @return BelongsTo
     */
    public function webhook(): BelongsTo
    {
        return $this->belongsTo(WebhookReward::class, 'webhook_reward_id');
    }
}
