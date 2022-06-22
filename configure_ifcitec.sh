curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php && \
	HASH=`curl -sS https://composer.github.io/installer.sig` && php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
	php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer && composer install

composer install
composer update
cp .env.example .env
clear
echo "Ambiente configurado com sucesso - agora basta rodar: \"docker-compose build && docker-compose up\" e tudo estará ok!"
