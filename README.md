# WEB

Bundle réalisé par Alexandre VILLA et Alexandre RASTEL
======================================================

Voici les composants exploités :

Symfony pour la gestion de l'application PHP
Twig comme moteur PHP
bootstrap comme framework css
assetics pour la gestion des fichiers annexes
Doctrine Fixtures pour la génération de contenu

##INSTALLATION##

###Installation Symfony :###

`php app/console generate:bundle --namespace=WEB/CrowdBundle --format=yml`

Remplacez le dossier WEB par celui que vous venez de télécharger

Ajoutez une route vers ce Bundle en modifiant le fichier app/config/rounting.yml.
Voici un exemple : 

`web_crowd:
    resource: "@WEBCrowdBundle/Resources/config/routing.yml"
    prefix:   /`

Publiez les fichiers de ce bondle dans votre dossier web grâce à la commande : `php app/console assets:install web/ --symlink`

Exporter le schéma d'entités vers votre base de données avec les commandes `php app/console doctrine:database:create   
php app/console doctrine:schema:update --dump-sql   
php app/console doctrine:schema:update --force`

Vous pouvez à présent lancer votre projet avec la commande `php app/console server:run`


En cas de souci, videz le cache grâce à php app/console cache:clear puis relancez le serveur


###Installation en dur :###

Créez le Namespace WEB (app/src/WEB/) et intégrez-y le Bundle que vous venez de télécharger.

Ajoutez la ligne `new WEB\CrowdBundle\WEBCrowdBundle(),` à votre fichier AppKernel.php

Ajoutez une route vers ce Bundle en modifiant le fichier app/config/rounting.yml.
Voici un exemple : 

`web_crowd:
    resource: "@WEBCrowdBundle/Resources/config/routing.yml"
    prefix:   /`

Publiez les fichiers de ce bondle dans votre dossier web grâce à la commande : `php app/console assets:install web/ --symlink`

En cas de souci, videz le cache grâce à `php app/console cache:clear` puis relancez le serveur
