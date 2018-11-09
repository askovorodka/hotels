FROM reg.bigln.ru/hotels/php:0.0.1

WORKDIR /srv/api-platform

COPY composer.json ./
COPY composer.lock ./
COPY codeception.yml ./
COPY behat.yml ./

RUN mkdir -p \
		var/cache \
		var/logs \
		var/sessions \
		var/jwt \
#	&& composer install --prefer-dist --no-dev --no-autoloader --no-scripts --no-progress --no-suggest \
#	&& composer clear-cache \
# Permissions hack because setfacl does not work on Mac and Windows
	&& chown -R www-data var

COPY deploy/ansible/roles/setup/files/private.pem ./var/jwt/
COPY deploy/ansible/roles/setup/files/public.pem ./var/jwt/

COPY app app/
COPY bin bin/
COPY src src/
COPY web web/
COPY features features/
COPY tests tests/

RUN composer install

COPY docker/app/docker-entrypoint.sh /usr/local/bin/docker-app-entrypoint
RUN chmod +x /usr/local/bin/docker-app-entrypoint

#ENTRYPOINT ["docker-app-entrypoint"]
#CMD ["php-fpm"]
