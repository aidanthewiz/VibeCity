#!/bin/bash

temp=/var/www/temp
case $DEPLOYMENT_GROUP_NAME in
	developmentVibeCity)
		folder=/var/www/vibecity.us
		;;
	*)
		>&2 echo "ERROR: DEPLOYMENT GROUP NAME NOT VALID"
		exit 1
		;;
esac

function set_permissions() {
	sudo chown ubuntu:www-data -R ${folder:?}
	sudo find ${folder:?} -type f -exec chmod 664 {} \;
	sudo find ${folder:?} -type d -exec chmod 775 {} \;
	sudo chmod -R 777 ${folder:?}/storage ${folder:?}/bootstrap/cache
}

if [ -n "$folder" ]; then
	sudo cp ${folder:?}/.env ${temp:?}/
	sudo rm -rf ${folder:?}/* ${folder:?}/.??*
	sudo mv ${temp:?}/* ${temp:?}/.??* ${folder:?}/
	set_permissions
	composer install --working-dir ${folder:?}/ --no-ansi --no-interaction --no-progress --prefer-dist --quiet
	php ${folder:?}/artisan cache:clear --no-ansi --no-interaction
	npm install --prefix ${folder:?}/ --quiet
	npm run --prefix ${folder:?}/ development --quiet
	php ${folder:?}/artisan migrate --no-ansi --no-interaction
	php ${folder:?}/artisan storage:link --no-ansi --no-interaction
    sudo php ${folder:?}/artisan optimize:clear --no-ansi --no-interaction
	sudo php ${folder:?}/artisan config:clear --no-ansi --no-interaction
    sudo php ${folder:?}/artisan cache:clear --no-ansi --no-interaction
	set_permissions
	sudo service php8.0-fpm restart
	sudo service nginx reload
fi

exit 0
