#!/bin/bash

sudo apt install python3-dev python3-setuptools libtiff5-dev libjpeg62-turbo-dev libopenjp2-7-dev zlib1g-dev \
    libfreetype6-dev liblcms2-dev libwebp-dev tcl8.6-dev tk8.6-dev python3-tk \
    libharfbuzz-dev libfribidi-dev libxcb1-dev -y
python3 -m ensurepip --upgrade
cd /opt/bitnami/python/lib/python3.8/
python3 -m pip install pillow qrcode
