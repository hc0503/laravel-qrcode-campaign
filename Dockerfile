FROM bitnami/laravel:7-debian-10

RUN curl -sS https://getcomposer.org/installer​ | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN sudo apt update -y && sudo apt upgrade -y

RUN curl -fsSL https://deb.nodesource.com/setup_19.x | sudo -E bash - &&\
sudo apt-get install -y nodejs git php wait-for-it

RUN sudo rm -R /app && sudo mkdir /app && sudo chown -R bitnami:bitnami /app
WORKDIR /app
RUN git clone https://github.com/SemioDigital/qrman .
COPY ./artisan.sh ./artisan.sh
RUN sudo chown -R bitnami:bitnami ./*
RUN sudo chmod -R 755 ./*

# RUN composer update --ignore-platform-reqs
USER bitnami
RUN sudo composer self-update --2
RUN composer install
RUN composer require predis/predis
#RUN php artisan migrate --seed
#RUN php artisan key:generate
RUN npm i
RUN npm run dev
CMD [ "./artisan.sh" ]
#CMD [ "/usr/bin/tail -f /dev/null" ]
#/opt/bitnami/php/bin/php artisan serve --host=0.0.0.0 || 
# Must command with different container "php artisan key:generate && php artisan migrate --seed" 
# and "php artisan serve --host=0.0.0.0"