# Introduction au Behavior Driven Development
___________________________________________

Le **Behavior Driven Development (BDD)** est un concept défini en 2003 par Dan North. traduction de tont article ici : http://philippe.poumaroux.free.fr/index.php?post/2012/02/06/Introduction-au-Behaviour-Driven-Developement

Il s’agit d’une continuité naturelle du **Test Driven Development (TDD)** dans le sens où il ne s’agit finalement que d’une formalisation d’un certain nombre de concepts auxquels aboutissent souvent les développeurs ayant acquis une bonne expérience de TDD.

Le BDD vise principalement à simplifier la compréhension de la finalité du TDD et à rendre plus cohérent les tests dans un environnement Agile où les experts métiers ont un rôle prépondérant.

Les prémisses, ou pourquoi il est si compliqué d’expliquer le TDD aux autres

En tant que personne pratiquant le TDD depuis quelques temps, vous avez sans doute eu à faire à ce cas de figure : comment expliquer le TDD à quelqu’un qui ne connait pas le principe et qui souvent débute en développement ? Et comment vous l’a-t-on expliqué à vous pour que vous trouviez ça si génial et que vous cherchiez à propager l’idée ?

Le constat de Dan North, et ce que j’ai pu voir autour de moi confirme ce point, est qu’il est extrêmement compliqué de faire comprendre la philosophie derrière le TDD à un néophyte. A peine le concept présenté surgissent des tas de questions :

Ça sert à quoi d’écrire les tests en premier ?
Ok, j’écris les tests en premier mais quel est le premier test que j’écris ?
Je dois tout tester ou seulement certaines choses ?
S’en suivent des réponses pas toujours très éclairantes, principalement basées sur l’expérience personnelle, et une phase intermédiaire où notre interlocuteur à compris que c’était probablement génial et essaie de son coté en se fabriquant ses propres règles au fil de l’eau.

Dan North a ainsi défini un profil type d’adoption de TDD :

>1. Le développeur continue d’écrire son code et fait des tests autour de celui-ci
>2. Au fur et à mesure que le nombre de tests augmentent, la confiance du développeur fait de même
>3. A un moment (souvent via quelqu’un d’autre), le développeur réalise qu’écrire le test avant le code permet de se concentrer plus facilement sur le code
>4. Lorsqu’il revient sur un code testé, le développeur se rend compte que celui-ci sert également de documentation pour se rappeler comment tout fonctionne
>5. Le développeur commence a se mettre dans la peau de la personne utilisant son code et le conçoit pour cette personne. Le TDD fait partie intégrante de la conception
Suit en général le constat que TDD n’est pas que simplement du test mais permet de définir le comportement du code
>6. Le comportement défini des interactions entre objets et donc l’utilisation de Mocks devient indispensable
>7. La progression jusqu’au point 4 se fait assez naturellement, cependant les points suivants posent beaucoup plus de problèmes. Le but du BDD est de casser ce schéma en intégrant dès le début les problématiques de comportement au centre de la philosophie de développement.

Ainsi, on ne teste plus du code, on valide que le comportement d’une fonctionnalité est conforme au contrat initial.

Il s’agit au final de la même chose dite différemment mais cette approche est particulièrement intéressante pour plusieurs raisons :

> Elle est beaucoup plus simple à comprendre pour un néophyte
> Nous sommes sorti du vocabulaire de développement et pouvons intégrer dans le processus de test d’autres personnes
> Elle va permettre de se concentrer sur ce qui est vraiment primordial au niveau fonctionnel

## Poser les bonnes questions aux bonnes personnes avant de faire son test
_______________________________________________________________________
Le but du TDD est de faire en sorte que le développeur se pose les bonnes questions avant de développer son code.

Le but du BDD est de faire en sorte que ce ne soit pas le développeur seul dans son coin qui se pose ces questions.

En effet le BDD est particulièrement ancré dans la méthodologie Agile et met en  avant la participation des utilisateurs métiers et des QAs qui sont les mieux placés pour savoir ce que doit vraiment faire notre code et surtout dans quel but.

Se dégage ainsi une symbiose plus naturelle entre la définition de la user story (ou d’un cas d’utilisation) et la rédaction des tests. Symbiose qui se fait au final également avec le TDD pur mais qui n’est pas facile à appréhender pour un débutant et qui en général n’implique que l’équipe technique.

La définition des user stories est en général déjà drivée par le comportement. Il est important de comprendre qui à besoin de quoi, pourquoi et ce qui est plus important que le reste.

Le BDD reprend ces principes afin de découper une story en scénarii concrets en se concentrant  sur le comportement :

    Quand j'ai [conditions initiales]
    et que je fais [action]
    alors j'obtiens [résultat]

### Et soudainement, les réponses aux questions posées par notre utilisateur initial sont très claires :

> Ça sert à quoi d’écrire les tests en premier ? On n’écrit pas des tests mais on définit le comportement fonctionnel de notre code
Ok, j’écris les tests en premier mais quel est le premier test que j’écris ? Les scénarii sont implémentés par ordre d’importance
> Je dois tout tester où seulement certaines choses ? On ne test pas, on vérifie que notre code est conforme à la story métier, la liste des choses à tester est définie par les scenarii.

## Un vocabulaire unique pour les gouverner tous et, dans les ténèbres, les lier


Nous arrivons dans la dernière étape du BDD, probablement l’évolution la plus significative par rapport au TDD : la mise en place d’un vocabulaire unifié et généralisé pour décrire ce que doit faire notre application.

Un des travers que tente de réparer l’agilité est le manque de communication entre les différents participants d’un projet. Pire, dans la plupart des cas, ils emploient des vocabulaires différents pour parler de la même chose.

Nous avons vu dans la rubrique précédente que le comportement doit être défini en collaboration étroite avec les utilisateurs métier et la QA afin qu’il ait du sens. Ces personnes ne sont en général pas capable d’écrire des tests unitaires en Java, .Net ou autre, par contre il n’ont aucun problème à définir leur besoin dans les termes que nous avons vu juste avant :
#### BDD : écrire en Gherkin
    Quand j'ai [conditions initiales]
    et que je fais [action]
    alors j'obtiens [résultat]
    
Une fois tous nos scénarii écrits dans ce langage, il suffit de les transformer en tests en utilisant soit en les transcrivant un par un soit en utilisant des frameworks de BDD tels que JBehave ou NBehave.

Nous avons donc tout un cycle de développement partant de la définition de la user story jusqu’à ses tests de validation, défini dans un langage commun à tous les interlocuteurs, compris et validés par tous et ce dès le début. Et comme tout est centralisé dans nos scénarii, si un scénario évolue il y a très peu d’impact sur le cycle de développement ce qui renforce l’aspect Agile du projet.

### Un exemple pour illustrer tout ca

Reprenons un exemple simple et modélisons un transfert d’argent entre deux comptes bancaires.

#### Le scénario le plus évident et donc important est :

    Quand j'ai un compte A avec 10€
    Et un compte B avec 0€
    Si je transferts 5€ de A vers B
    Alors j'obtiens un compte A avec 5€
    Et un compte B avec 5€

#### Un autre scénario possible :

    Quand j'ai un compte A avec 10€
    Et un compte B avec 0€
    Si je transferts 15€ de A vers B
    Alors j'obtiens une erreur m'interdisant le transfert

Chaque scénario donnera un test, ou une série de tests regroupés selon les préférences.

#### Un exemple avec un web service : 

    Fonctionnalité: Ajouter une categorie
        Scénario: ajoute une categorie
        Quand J'ajoute l'en-tête "Content-Type" égal à "application/json"
        Et J'ajoute l'en-tête "Accept" égal à "application/json"
        Et J'envoie une demande de "POST" à "/api/category" avec le corps
        """
        {
            "name": "Behat"
        }
        """
        Alors le code d'état de la réponse doit être 201
        Et la réponse doit être en JSON
        Et l'en-tête "Content-Type" doit être égal à "application/json"
        Et les nœuds JSON doivent contenir:
        | name | Behat |

Source : https://blog.soat.fr/2011/06/introduction-au-behavior-driven-development/
