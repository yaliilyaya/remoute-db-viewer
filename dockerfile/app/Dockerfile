FROM php:7.1-fpm

RUN apt-get update && apt-get install -y \
    wget \
    openssl \
    git \
    unzip \
    openssh-server

#composer install
RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN docker-php-ext-install pdo \
    pdo_mysql \
    pcntl

#ADD ./php.ini /usr/local/etc/php/php.ini
# install sshd for phpshtorm
RUN mkdir /var/run/sshd
RUN echo 'root:developer' | chpasswd
RUN sed -i 's/#PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config

# SSH login fix. Otherwise user is kicked off after login
RUN sed 's@session\s*required\s*pam_loginuid.so@session optional pam_loginuid.so@g' -i /etc/pam.d/sshd

ENV NOTVISIBLE "in users profile"
RUN echo "export VISIBLE=now" >> /etc/profile

EXPOSE 22

RUN echo 'alias gtw-app="php /var/www/symfony/app/console"' >> ~/.bashrc \
&& echo 'alias gtw="php /var/www/symfony/bin/console"' >> ~/.bashrc

WORKDIR /var/www/symfony

CMD ["/usr/sbin/sshd", "-D"]
