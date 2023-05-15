FROM bitnami/laravel:9-debian-11

RUN curl -sS https://getcomposer.org/installer​ | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash - && sudo apt update -y && sudo apt dist-upgrade -y && \
  sudo apt install -y nodejs git wait-for-it python3-dev python3-setuptools libtiff5-dev libjpeg62-turbo-dev libopenjp2-7-dev zlib1g-dev\
  libfreetype6-dev liblcms2-dev libwebp-dev tcl8.6-dev tk8.6-dev python3-tk\
  libharfbuzz-dev libfribidi-dev libxcb1-dev

RUN sudo rm -R /app && sudo mkdir /app && sudo chown -R bitnami:bitnami /app
WORKDIR /app

RUN git clone -b dev https://github.com/SemioDigital/qrman .
COPY ./entrypoint.sh ./entrypoint.sh

USER bitnami
RUN sudo mkdir ./storage/app/public/qrs && sudo chown -R bitnami:bitnami ./* && sudo chmod -R 755 ./*

WORKDIR /opt/bitnami/python/lib/python3.8/
RUN python3 -m ensurepip --upgrade && python3 -m pip install pillow qrcode

WORKDIR /app
# RUN composer update
RUN sudo composer self-update --2 && composer install

RUN npm i && npm run dev
ENTRYPOINT [ "./entrypoint.sh" ]
