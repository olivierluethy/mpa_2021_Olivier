# Mini PA – PHP/Apache web app
# PHP 7.4 matches the runtime the app was written for (originally PHP 7.4.10).
FROM php:7.4-apache

# PHP extensions the app uses: PDO (core/database.php) and mysqli (login).
RUN docker-php-ext-install pdo_mysql mysqli

# The app relies on .htaccess RewriteRule -> enable mod_rewrite and AllowOverride.
RUN a2enmod rewrite
COPY docker/apache/app.conf /etc/apache2/conf-available/app.conf
RUN a2enconf app

# The app is served from a sub-path so its relative asset/link paths
# (../public, ../images, ../rechnungen/...) resolve exactly like the original.
# The actual code is bind-mounted here via docker-compose.
WORKDIR /var/www/html/mpa_2021_Olivier
