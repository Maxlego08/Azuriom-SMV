<?php

return [
    'title' => 'Settings - Serveur Minecraft Vote',
    'permission' => 'Manage Serveur Minecraft Vote plugin',
    'nav' => [
        'title' => 'Serveur Minecraft Vote'
    ],
    'discord' => 'Invitation to support discord',
    'info' => 'You must create your API key on this page <a href="https://serveur-minecraft-vote.fr/members/developers/keys" target="_blank">https://serveur-minecraft-vote.fr/members/developers/keys</a>. The webhook will then be created automatically.',
    'fields' => [
        'key' => 'Secret key',
        'webhook' => 'Webhook',
        'limit' => 'Limit',
        'player' => 'Player',
        'server' => 'Server',
        'chances' => 'Chances',
        'rewards' => 'Rewards',
        'commands' => 'Commands',
        'votes' => 'Votes',
    ],
    'limit' => 'You can add a reward limit per user. To have no limit you must put 0.',
    'webhook' => [
        'success' => 'You have just created the webhook on Serveur Minecraft Vote.',
        'error' => 'An error occurred while creating the webhook. :error',
        'already' => 'The webhook already exists, you can\'t recreate it.',
        'info' => 'You can find the list of webhooks on this page <a href="https://docs.serveur-minecraft-vote.fr/webhook">https://docs.serveur-minecraft-vote.fr/webhook</a>',
    ],
    'rewards_info' => 'Give rewards to your players when they follow your server, send an information message when the hype train is active.',
    'logs' => 'History',
    'rewards' => [
        'title' => 'Rewards',
        'title-edit' => 'Edit reward :reward',
        'title-create' => 'Create reward',

        'need-online' => 'The user must be online to receive the reward (only available with AzLink)',
        'enable' => 'Enable the reward',

        'commands-info' => 'You can use <code>{player}</code> to use the player name and <code>{reward}</code> to use the reward name. The command must not start with <code>/</code>',

        'status' => [
            'created' => 'The reward has been created.',
            'updated' => 'This reward has been updated.',
            'deleted' => 'This reward has been deleted.',
        ],
    ],
];
