<?php

return [
    'bookmark' => [
        'error' => 'Impossible d\'effectuer cette action.',
        'tutorial' => [
            'warning' => 'Déjà ajouté dans votre liste de favoris.',
            'success' => 'Nous avons ajouté dans votre liste de favoris.',
        ],
        'question' => [
            'success' => 'Vous suivez maintenant la question.',
            'warning' => 'Vous suivez déjà cett question.',
        ],
        'challenge' => [
            'warning' => 'Vous suivez déjà cette question.',
            'success' => 'Nous avons ajouté le challenge dans votre liste de favoris.',
        ],
        'curriculum' => [
            'warning' => 'Vous suivez déjà cette formation.',
            'success' => 'Nous avons ajouté la formation dans votre liste de favoris.',
        ],
        'podcast' => [
            'warning' => 'Vous suivez déjà ce podcast.',
            'success' => 'Nous avons ajouté le podcast dans votre liste de favoris.',
        ],
    ],
    'comment' => [
        'create' => [
            'error' => 'Impossible d\'envoyer votre commentaire.',
            'warning' => 'Les données du commentaire ne sont pas correct.',
            'success' => 'Merci pour votre commentaire.',
        ],
        'update' => [
            'error' => 'Désolé, impossible de mettre à jour le commentaire.',
            'success' => 'Votre commentaire a été mis à jour',
        ],
    ],
    'author' => [
        'delete' => [
            'success' => 'Auteur supprimé!',
            'error' => 'Impossible de supprimer cette auteur. Veuillez retirer les tutoriels qui lui sont assignés.',
        ],
        'update' => [
            'success' => 'Auteur mise à jour!',
            'error' => 'Impossible de mettre à jour les informations de l\'auteur.',
            'pseudo_error' => 'Impossible de mettre à jour les informations de l\'auteur. Le pseudo est déjà utilisé.',
        ],
        'create' => [
            'error' => 'Impossible de valider les informations de l\'auteur.',
            'success' => 'Auteur a été créer!',
        ],
    ],
    'podcast' => [
        'delete' => [
            'success' => 'Podcast supprimé!',
            'error' => 'Impossible de supprimer cette podcast.',
        ],
        'update' => [
            'success' => 'Podcast mise à jour!',
            'error' => 'Impossible de mettre à jour les informations le podcast.',
        ],
        'create' => [
            'error' => 'Impossible de valider les informations du podcast.',
            'success' => 'Podcast a été créer!',
        ],
    ],
    'auth' => [
        'validation' => 'Les informations de connexion ne sont pas correctes',
        'connexion' => 'Nouvelle connexion sur :name',
    ],
    'technologie' => [
        'create' => [
            'validation' => 'Impossible de créer cette technologie.',
            'success' => 'Technologie créée avec succes.',
        ],
        'update' => [
            'validation' => 'Impossible de mettre à jour cette technologie.',
            'validation2' => 'Impossible de modifier cette technologie. Le slug exists déjà.',
            'success' => 'Mise à jour effectuée.',
        ],
        'delete' => [
            'success' => 'Technologie supprimé.',
        ],
    ],
    'curriculum' => [
        'create' => [
            'validation' => 'Impossible de créer ce curriculum.',
            'success' => 'Curriculum créée avec succes.',
        ],
        'update' => [
            'validation' => 'Impossible de mettre à jour ce curriculum.',
            'validation2' => 'Impossible de modifier ce curriculum. Le slug exists déjà.',
            'success' => 'Mise à jour effectuée.',
        ],
        'delete' => [
            'success' => 'Curriculum supprimé.',
        ],
    ],
];
