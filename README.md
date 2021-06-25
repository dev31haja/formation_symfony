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

=> Evenements
	php bin/console make:subscriber
	php bin/console debug:event-dispatcher

=> API :D
	composer require "lexik/jwt-authentication-bundle"
	php bin/console lexik:jwt:generate-keypair
	curl -X POST -H "Content-Type: application/json" http://localhost:8000/api/login_check -d '{"username":"manager@formation.com","password":"password"}'
	composer require api

	https://api-platform.com/docs/core/serialization/

	