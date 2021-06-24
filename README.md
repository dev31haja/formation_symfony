Commandes pratiques.

=> Encore
    composer require encore
    yarn encore dev
    yarn run encore dev --watch

=> Entity & migration
	php bin/console make:entity
	php bin/console make:migration
	php bin/console doctrine:migrations:migrate

	https://www.doctrine-project.org/projects/doctrine-orm/en/2.9/reference/annotations-reference.html

=> Fixtures : saisir des données dans la BDD
	composer require orm-fixtures
	php bin/console make:fixtures
	php bin/console doctrine:migrations:migrate first -n
	php bin/console doctrine:fixtures:load

=> Valitadeurs et contraintes d'entités
	composer require symfony/validator doctrine/annotations
	php bin/console make:validator