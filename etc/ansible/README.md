# Ansible to configure production server

## Getting started
For this process Ansible version should be >= 2.0. The v2.3.0.0 has a bug that the process emits a timeout so please,
avoid this concrete version. The recommended way is to install Ansible by Python's PIP package manager:
```bash
$ sudo pip install ansible 2.2.1.0
```
Then, it is required to install some dependencies so, `requirements.yml` file can automatize this tedious process:
```bash
$ sudo ansible-galaxy install -r requirements.yml
```
> Some Ansible roles are quite unstable so, the recommended way is before to execute the command above, you should 
> remove the previously installed roles to avoid version conflicts.
```bash
$ sudo ansible-galaxy remove \
geerlingguy.certbot \
geerlingguy.firewall \
geerlingguy.git \
geerlingguy.mysql \
geerlingguy.nginx \
geerlingguy.php \
geerlingguy.repo-remi \
geerlingguy.security \
kbrebanov.unzip \
openstack-ansible-galaxy.rabbitmq
```

## SSL certificate
When the current is a clean installation of the server you have to generate the certificate executing the following
command inside the server with su privileges:
```bash
$ certbot certonly --webroot \
    -w /var/www/kreta.io/current/CompositeUi/build \
    -d kreta.io -d www.kreta.io \
    -w /var/www/kreta.io/current/IdentityAccess/src/Kreta/IdentityAccess/Infrastructure/Ui/Http/Symfony/public \
    -d identityaccess.kreta.io \
    -w /var/www/kreta.io/current/TaskManager/src/Kreta/TaskManager/Infrastructure/Ui/Http/Symfony/public \
    -d taskmanager.kreta.io
```

Then you can test the renewal command:
```bash
$ certbot renew --dry-run
```

if the above command goes well you can arrange for automatic renewal by adding a cron.
```bash
# /etc/crontab

0 6 * * * certbot renew
```
