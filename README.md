# WEB

Bundle réalisé par Alexandre VILLA et Alexandre RASTEL

Voici les composants exploités :

Symfony pour la gestion de l'application PHP
Twig comme moteur PHP
bootstrap comme framework css
assetics pour la gestion des fichiers annexes
Doctrine Fixtures pour la génération de contenu


Installation : Créez le Namespace WEB (app/src/WEB/) et intégrez-y le Bundle que vous venez de télécharger.

Ajoutez une route vers ce Bundle en modifiant le fichier app/config/rounting.yml.
Voici un exemple : 

web_crowd:
    resource: "@WEBCrowdBundle/Resources/config/routing.yml"
    prefix:   /

Publiez les fichiers de ce bondle dans votre dossier web grâce à la commande : php app/console assets:install web/ --symlink

En cas de souci, videz le cache grâce à php app/console cache:clear puis relancez le serveur
