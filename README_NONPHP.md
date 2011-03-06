This project attempts to benchmark the baseline level of responsiveness of various PHP and non-PHP frameworks to discover the overhead involved in using each one.

The previous version of this project is at Google Code here: <http://code.google.com/p/web-framework-benchmarks/>. This version supersedes the previous version at Google Code.


Benchmarking Server Setup
=========================

Hardware and Operating System
-----------------------------

The benchmark is performed on an Amazon EC2 `m1.large` instance. This provides 4 EC2 compute units and 7.5 G of RAM.  The operating system is a stock 64-bit Ubuntu 10.10 image provided by <http://alestic.com/>.

Installation instructions for EC2 are beyond the scope of this project. Once you have an EC2 account at Amazon and the appropriate EC2 shell tools, run a new instance under your own username ...

    ec2-run-instances ami-688c7801 --instance-type=m1.large -k {$USERNAME}

... then SSH into the running instance to continue.

    ssh -i /path/to/id_rsa-{$USERNAME} ubuntu@{$SUBDOMAIN}.amazonaws.com


Software Installation
---------------------

After the instance comes online, issue the following shell commands to install and configure the necessary packages. The backslash (\) indicates that the current shell command is continued on the next line.

    # become root
    sudo -s

    # initial updates
    aptitude update
    aptitude dist-upgrade -y

    # apache2, php, git, siege, mod_php5
    aptitude install -y apache2-mpm-prefork libapache2-mod-php5 php-apc \
        php5-cli php5-common php5-dev git-all siege build-essential \
        apache2-prefork-dev libapr1-dev libaprutil1-dev

    # edit php apc configuration and append line "apc.stat=0"
    nano /etc/php5/apache2/conf.d/apc.ini

    # create local user .siegerc configuration file
    siege.config

    # install http_load
    cd /root
    wget http://www.acme.com/software/http_load/http_load-12mar2006.tar.gz
    tar -zxvf http_load-12mar2006.tar.gz
    cd http_load-12mar2006
    make
    make install

    # turn off mod_deflate, turn on mod_rewrite
    a2dismod deflate
    a2enmod rewrite

    # ruby, phusion passenger, rails and bundler
    # replace "ubuntu" with your normal user name, and select option 1 when asked
    # take a coffee break because it will take a while. you may need to re-enter
    # your password for sudo
    su ubuntu
    cd ~
    wget --no-check-certificate \
        https://github.com/joshfng/railsready/raw/master/railsready.sh
    sudo bash railsready.sh
    sudo -s
    gem install sqlite3
    passenger-install-apache2-module

    # the last above suggests passenger module configuration values (see passenger.load-dist)
    # paste these values into the following file to allow for a2enmod/a2dismod use
    nano /etc/apache2/mods-available/passenger.load

    # python django
    aptitude install libapache2-mod-wsgi python-setuptools python-pip
    pip install django

    # perl catalyst
    aptitude install libapache2-mod-perl2 libcatalyst-perl

    # replace /var/www with the project checkout
    rm -rf /var/www
    git clone git://github.com/padraic/php-framework-benchmarks.git /var/www

    # switch to /var/www, switch branches, and open all permissions (e.g. for caches)
    cd /var/www
    git checkout remotes/origin/rails_django_catalyst
    chmod -R 777 htdocs

    # create real config file from the distribution copy
    cp config.ini-dist config.ini

    # replace the default virtual host configuration with the project copy
    cp vhost.example /etc/apache2/sites-available/default

    # restart apache
    /etc/init.d/apache2 restart

Now you can run the benchmarks against a series of framework targets.


Running the Benchmarks
======================

Check the config.ini file for any changes, e.g. username in siege_file option.

At the EC2 command line, issue the following:

    cd /var/www
    ./bench/ab target/<target>.ini

(There are other bench scripts and target files as well.)

The script will do the following for each framework target:

- Enable/Disable Apache modules as necessary for the framework to be tested
- Restart Apache
- Browse to the framework once to warm up caches (i.e. php apc)
- Benchmark the the framework 5 times for 1 minute each with 10 users
- Log the results

At the end of the benchmarking, the script will collate the logged benchmark results and print a report on the framework responsiveness.

