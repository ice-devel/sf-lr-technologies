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

# II Routing
Le controller associé à la route est appelé quand le pattern matche.

Les patterns peuvent être dynamiques : paramètres d'URL que l'on met entre {}
- user/update/{id}
- public function methodName($id) : injecté dans la variable php du même nom

Options :
- requirements : on peut forcer les paramètres à respecter un certain format pour que la route ne matche pas si ce n'est pas le cas
- defaults : valeurs par défaut des paramètres : plus obligé de lui mettre une valeur dans l'url
- methods : forcer des méthodes HTTP (GET,POST,PATCH,DELETE,PUT)
- priority : pour définir une priorité dans le cas où plusieurs routes ont des patterns en collision

ParamConverter
todo

# III Templates
Le moteur de template par défaut est Twig.
Il sert à générer une vue depuis un controller (ou un service).

Pour ça, on a un raccourci (provenant de AbstractController) :
- $this->render()
- premier paramètre : le chemin du template depuis le dossier "templates"
- deuxième paramètre : un tableau associatif pour passer des valeurs du controller au template

En twig, on peut :
- afficher quelque-chose : {{ }}
- faire quelque-chose : {% %}
- commenter : {# #}

On peut :
- hériter d'un template avec extends : reprendre le contenu du template parent et on peut le contenu des blocks qui y étaient définis
- redéfinir les blocks dans l'ordre que l'on souhaite
- on peut reprendre le contenu d'un block avec {{ parent() }}

Inclure des assets (css, js, images)
- asset("chemin/vers/ressource") (chemin depuis le dossier public)

Faire un lien vers un controller
- path('nom_de_la_route')