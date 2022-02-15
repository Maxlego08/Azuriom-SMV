<?php

return [
    'title' => 'Paramètres - Serveur Minecraft Vote',
    'permission' => 'Gestion du plugin Serveur Minecraft Vote',
    'nav' => [
        'title' => 'Serveur Minecraft Vote'
    ],
    'info' => 'Vous devez créer votre clé API sur cette page <a href="https://serveur-minecraft-vote.fr/members/developers/keys" target="_blank">https://serveur-minecraft-vote.fr/members/developers/keys</a>. Le webhook va ensuite se créer automatiquement.',
    'fields' => [
        'key' => 'Clé secrète',
        'webhook' => 'Webhook',
        'limit' => 'Limite',
        'player' => 'Joueur',
        'server' => 'Serveur',
        'chances' => 'Chances',
        'rewards' => 'Récompenses',
        'commands' => 'Commandes',
        'votes' => 'Votes',
    ],
    'limit' => 'Vous pouvez ajouter une limite de récompense par utilisateur. Pour ne pas avoir de limite vous devez mettre 0.',
    'webhook' => [
        'success' => 'Vous venez de créer le webhook sur Serveur Minecraft Vote.',
        'error' => 'Une erreur est survenue lors de la création du webhook. :error',
        'already' => 'Le webhook existe déjà, vous ne pouvez pas le recréer.',
        'info' => 'Vous pouvez retrouver la liste des webhooks sur cette page <a href="https://docs.serveur-minecraft-vote.fr/webhook">https://docs.serveur-minecraft-vote.fr/webhook</a>',
    ],
    'rewards_info' => 'Donnez des récompenses à vos joueurs lorsqu\'ils suivent votre serveur, envoyer un message d\'informations lorsque le train de la hype est actif.',
    'logs' => 'Historique',
    'rewards' => [
        'title' => 'Récompenses',
        'title-edit' => 'Modifier la récompense :reward',
        'title-create' => 'Créer une récompense',

        'need-online' => 'L\'utilisateur doit être en ligne pour recevoir la récompense (uniquement disponible avec AzLink)',
        'enable' => 'Activer la récompense',

        'commands-info' => 'Vous pouvez utiliser <code>{player}</code> pour utiliser le nom du joueur et <code>{reward}</code> pour utiliser le nom de la récompense. La commande ne doit pas contenir de <code>/</code> au début.',

        'status' => [
            'created' => 'La récompense a été créée.',
            'updated' => 'La récompense a été mise à jour.',
            'deleted' => 'La récompense a été supprimée.',
        ],
    ],
];
