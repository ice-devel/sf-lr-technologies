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
On peut utiliser les ParamConverter pour récupérer automatiquement une entité depuis
un paramètre d'url :
``   #[Route('/doctrine/read/{id}', name: 'doctrine_read')] ``
`` function read(Topic $topic)``
L'entité Topic sera automatiquement injectée : elle est recherché en base par son id,
dont la valeur se trouve dans l'url :
https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html

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

On peut appliquer des filtres pour modifier l'affichage de variable :
raw | upper | lower | date | u.truncate (StringExtension)

- Créer ses extensions :
console make:twig-extension
  
# IV Doctrine : ORM
Les entités représentent les données métier qu'on veut persister. C'est une couche d'abstraction qui nous permet
de ne pas nous soucier comment fonctionne techniquement le moteur de base qu'on utilise.

## Création / Structure BDD
1- Configurer les accès de la DB dans le fichier .env
2- Création base : console doctrine:database:create
3- Créer une entité console make:entity
4- Mettre à jour la structure de la base
    - soit avec les migrations
        - console make:migration
        - console doctrine:migrations:migrate
    - soit directement avec console doctrine:schema:update --force

Vous pouvez également créer des objets à partir d'une base (reverse engineering), dans une certaine mesure :
https://symfony.com/doc/current/doctrine/reverse_engineering.html

## Utilisation CRUD
### READ 
Pour récupérer des entités en BDD, on utilise les repositories associés aux entités.
Méthodes existantes par défaut : find, findAll, findBy, findOneBy, count
On peut ajouter nos propres dans le repo associé.

### CREATE / UPDATE/ DELETE
On utilise le manager de Doctrine (EntityManagerInterface)
- persist()
- remove()
- flush()

### Relations entre entités
ManyToOne / OneToMany
ManyToMany / ManyToMany
OneToOne

### Ecouteur d'évenement

# Formulaires
## Association avec entité
On utilise les formulaires pour hydrater des entités : on utilise le service form.factory pour créer un form
d'un certain type (make:form).
Au lieu de faire un form en html on utilise les fonctions pour afficher ces formulaires, le reste sera fait automatiquement.

## Validation

## Options des formulaires
On peut configurer :
- type de champ
- label, required, attr
- constraints

## Générer un crud
A partir d'une entité, on peut générer un crud de base entier :
make:crud

## Relation entre entité


# API / API Platform
## API
- normalization / serialization
- gestion des erreurs (try catch)
- gestion des routes : c'est la méthode qui définit l'action

## API Platform
- ApiResource
- normalizationContext / denormalizationContext / groups
- datapersister
- pagination
- filter
- subresource

# Tests automatisés fonctionnels / unitaires
Tests automatisés : code qui permet de tester du code
PHPUnit par défaut
Permettre l'évolution de l'app en évitant les régressions

Quand ?
- On écrit le code en entier puis on teste : pas terrible
- On écrit une méthode et on la teste
- TDD : test driven development : on écrit le test : il marche pas - on écrit le code - le test marche
- On rencontre un bug : on écrit qui le reproduit

Tests de fumée / smoke test
Tests critiques dans une app, comme vérifier que les pages principales répondent

Tests unitaires
Tester unitaire une function

Tests functional
Tester de manière globale une feature, comme la validation d'un formulaire dans un controller

Bundles pratiques
Tests : hautelook/AliceBundle (Alice + faker)
