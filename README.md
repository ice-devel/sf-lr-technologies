# Symfony
https://github.com/ice-devel/sf-lr-technologies.git

## 1 - Présentation

## 2 - Installation
Pré-requis
- Serveur web, serveur bdd, et PHP 
- Composer : gestionnaire de dépendance
- Symfony installer 
- Variables d'environnement : php, composer, symfony

Pour le serveur web  
- On peut utiliser son serveur apache, nginx (création le vhost, faux domaine host)
- On peut utiliser serveur web built-in : symfony serve -d

On crée un projet :
symfony new project_name --full 4.4

## 3 Architecture 
- bin :  console pour faire les commandes / phpunit pour les tests
- config : configuration sous format yaml des composants
- migrations : évolution de la bdd
- public : controller frontal (index.php) : point d'entrée de l'app + assets
- src : notre code source
- templates : templates twig (moteur de template)
- tests : unitaires / fonctionnels / e2e
- translations : fichiers de traductions
- var : ce qui évolue pendant la vie de l'app : cache, logs
- vendor : bibliothèque externe / gérées avec composer / jamais on touche

## 4 - Utilisation
### Création première page
- controller
- route
- template / response

# I Controller
Le controller frontal : le point d'entrée
On instancie le kernel de symfony, création d'une Request puis envoi d'une Response

On définit une route et on l'associe à un controller. Les routes sont définies soit avec les attributs PHP,
soit avec des annotations.
Il faut écrire l'attribut juste avant la fonction à appelée.