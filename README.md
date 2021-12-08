# wild-series

## Créer nouveau projet Symfony

```terminal
symfony new --full <name_project> --version=lts
```
> **_N'oubli pas de te déplacer dans ton projet après sa création !_**

## Installation de Webpack

[Documentation Webpack/Symfony](https://symfony.com/doc/current/frontend/encore/installation.html)

#### Installer Encore dans les applications Symfony

```terminal
composer require symfony/webpack-encore-bundle
```

>Remarque : dans toute cette quête, tu utiliseras **[yarn](https://classic.yarnpkg.com/en/docs/install/#debian-stable)**, car c’est l’outil recommandé par Symfony dans la documentation officielle, mais note que tu peux aussi utiliser un outil équivalent qui s’appelle **[npm](https://www.npmjs.com/get-npm)**. Les deux sont équivalents (mais si tu commences un projet avec l’un, il ne faut plus que tu en changes en cours de route, au risque d’avoir des conflits) et nécessitent également d’installer **[nodejs](https://nodejs.org/en/)**. Si tu n’as pas déjà ces outils sur ton poste, il faudra donc les installer avant de continuer.

Installation de nodejs via la doc **[ubuntu](https://doc.ubuntu-fr.org/nodejs)**

```terminal
yarn install
```

#### Installer Encore dans les applications non Symfony

```terminal
yarn add @symfony/webpack-encore --dev
```

### Liens assets dans twig

Pour intégrer ces fichiers générés par Encore dans Symfony, il faut ajouter les chemins dans le HTML du fichier base.html.twig.

```twig
{% block stylesheets %}
        {{ encore_entry_link_tags('app') }}
{% endblock %}

{% block javascripts %}
           {{ encore_entry_script_tags('app') }}
{% endblock %}
```

## Installation du SCSS dans ton projet

Décoche la suivante dans le fichier _webpack.config.js_

```javascript
.enableSassLoader()
```

## installation de Bootstrap

[Guide installation Bootstrap (Symfony)](https://symfony.com/doc/current/frontend/encore/bootstrap.html)

#### Bootstrap CSS

```terminal
yarn add bootstrap --dev
```

Importe Bootstrap dans le fichier scss

```SCSS
@import "~bootstrap/scss/bootstrap";
```

#### Bootstrap JS

```terminal
yarn add jquery popper.js --dev
```

Dans le fichier Javascript

```javascript
// app.js

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

```

## Installation de Fontawesome

```terminal
yarn add @fortawesome/fontawesome-free
```

Importe Font awesome dans ton fichier SCSS

```SCSS
$fa-font-path: '~@fortawesome/fontawesome-free/webfonts';
@import '~@fortawesome/fontawesome-free/scss/fontawesome';
@import '~@fortawesome/fontawesome-free/scss/solid';
@import '~@fortawesome/fontawesome-free/scss/regular';
@import '~@fortawesome/fontawesome-free/scss/brands';
```

## Relancer le _build_ Webpack

```terminal
yarn encore dev --watch
```
