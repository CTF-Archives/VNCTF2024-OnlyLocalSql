FROM php:7.3-fpm-bullseye

# 制作者信息
LABEL auther_template="CTF-Archives"

# apt更换镜像源，并更新软件包列表信息
RUN sed -i 's/deb.debian.org/mirrors.tuna.tsinghua.edu.cn/g' /etc/apt/sources.list && \
    sed -i 's/security.debian.org/mirrors.tuna.tsinghua.edu.cn/g' /etc/apt/sources.list
RUN apt-get update
RUN apt-get install -y nginx bash netcat openssh-server

# 拷贝容器入口点脚本
COPY ./service/docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

# 复制nginx配置文件
COPY ./config/nginx.conf /etc/nginx/nginx.conf

# 配置 PHP PDO 相关配置

COPY ./config/php-pdo.ini /usr/local/etc/php/conf.d/php-pdo.ini

WORKDIR /usr/src

RUN docker-php-ext-install pdo pdo_mysql

# 复制web项目源码
COPY src /var/www/html

# 重新设置源码路径的用户所有权
RUN chown -R www-data:www-data /var/www/html

# 设置shell的工作目录
WORKDIR /var/www/html

RUN useradd -m ctf && echo "ctf:ctf" && \
    echo "ctf:ctf" | chpasswd

RUN ssh-keygen -A && \
    /etc/init.d/ssh start && \
    chsh -s /bin/bash ctf

COPY ./config/sshd_config /etc/ssh/sshd_config

# 设置容器入口点
ENTRYPOINT [ "/docker-entrypoint.sh" ]