# Ansible to configure production server

## Getting started
For this process Ansible version should be >= 2.0. The v2.3.0.0 has a bug that the process emits a timeout so please,
avoid this concrete version. The recommended way is to install Ansible by Python's PIP package manager:
```bash
$ sudo pip install ansible 2.2.1.0
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

Then, it is required to install some dependencies so, `requirements.yml` file can automatize this tedious process:
```bash
$ sudo ansible-galaxy install -r requirements.yml
```

Now you can start provisioning the server:
```bash
$ sudo ansible-playbook main.yml -i hosts
```

## SSL certificate
When the current is a clean installation of the server you have to generate the certificate executing the following
Ansible command that will change Nginx to SSL mode and add required certificates:

```bash
$ sudo ansible-playbook certbot.yml -i hosts
```

> Make sure you have a running app (check /etc/deploy) before running the command above, otherwise it wont work
