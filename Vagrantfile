Vagrant.configure(2) do |config|

  config.vm.box = "ubuntu/trusty64"
  config.vm.network "private_network", ip: "192.168.222.103"
  config.vm.synced_folder "./", "/var/www", owner: "www-data", group: "www-data"
  config.vm.synced_folder "./", "/vagrant", owner: "root", group: "root"


  config.vm.provider "virtualbox" do |vb|
     vb.memory = "1024"
     vb.cpus = 2
  end

  config.vm.provision "shell", inline: <<-SHELL
     sudo su

     DBNAME=abms
     DBUSERNAME=db_user
     DBPASSWORD=db_pass
     DBHOST=localhost

     #UPDATE DEPENDENCIES
     apt-get update
     apt-get install software-properties-common
     add-apt-repository -y ppa:ondrej/php
     apt-get update

     #INSTALL DEPENDENCIES
     apt-get install -y --force-yes apache2 mcrypt mc git zip unzip postgresql-9.3 curl\
     php7.0 php7.0-pgsql php7.0-cgi php7.0-fpm  php7.0-mcrypt  php7.0-intl php7.0-curl\
     php7.0-bcmath php7.0-mbstring php7.0-xml php7.0-soap


     #GET COMPOSER
     curl -sS https://getcomposer.org/installer | php
     mv composer.phar /bin/composer


     #CREATE DATABASE
     sudo -u postgres psql -c "ALTER USER postgres with encrypted password 'postgres'" -U postgres
     sudo -u postgres psql -c "CREATE ROLE "$DBUSERNAME" CREATEDB CREATEUSER LOGIN Encrypted PASSWORD '$DBPASSWORD';" -U postgres
     sudo -u postgres service postgresql restart
     sudo -u postgres psql -c "CREATE DATABASE \"$DBNAME\"  WITH OWNER \"$DBUSERNAME\";" -U postgres


     #COPY CONFIGS
     cp /vagrant/vagrant_conf/pg_hba.conf /etc/postgresql/9.3/main/
     cp /vagrant/vagrant_conf/postgresql.conf /etc/postgresql/9.3/main/
     ln -s /vagrant/vagrant_conf/vhost.conf /etc/apache2/sites-enabled/vhost.conf


     #ENABLE APACHE MODS
     a2enmod proxy_fcgi
     a2enmod rewrite
     a2enmod headers

     #CHANGE FPM LISTEN IP AND PORT
     echo Listen=127.0.0.1:9000 >> /etc/php/7.0/fpm/pool.d/www.conf


     service apache2 restart
     service postgresql restart
     service php7.0-fpm restart



     #SET ENVIROMENTAL VARIABLES
     echo "" >> /etc/environment
     echo DB_HOST=$DBHOST >> /etc/environment
     echo DB_DATABASE=$DBNAME >> /etc/environment
     echo DB_USERNAME=$DBUSERNAME >> /etc/environment
     echo DB_PASSWORD=$DBPASSWORD >> /etc/environment
     for i in $(cat /etc/environment); do export $i; done


     #INSTALLL APPLICATION
     cd /var/www
     cp config/development.config.php.dist  config/development.config.php
     composer install --no-interaction --profile
     php public/index.php development enable
     cp config/autoload/local.php.dist config/autoload/local.php
     php public/index.php migration apply
     wget https://www.adminer.org/static/download/4.2.3/adminer-4.2.3.php -O /var/www/public/adminer.php


     exit

  SHELL


   config.vm.provision "shell", run: "always", inline: <<-SHELL
     sudo su
     service php7.0-fpm restart
     service apache2 restart
     cd /var/www
     for i in $(cat /etc/environment); do export $i; done
     composer update --no-interaction --profile
     php public/index.php migration apply

   SHELL
end