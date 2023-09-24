FROM node:18.15.0

WORKDIR /var/www

ARG USER_ID

RUN yarn add \
    @symfony/webpack-encore \
    sass-loader \
    node-sass \
    --dev

RUN usermod -u 1000 node
USER node


