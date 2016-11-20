#Bash scripts and CLI commands

Each Kreta bounded context has many bash scripts and CLI commands that
provide access to many actions. In order to standardize the usage of
them, this is the way that you have to follow:

To access Symfony CLI application you should execute from the root
directory of Kreta something like this:
```bash
$ <bounded-contetx>/etc/bin/symfony-console
```

To simplify the process of load database or the web server start you can
execute ready to use bash scripts in the following way, from the root
directory too:
```bash
$ <bounded-contetx>/etc/bash/load_databse.sh
$ <bounded-contetx>/etc/bash/server_start.sh

$ <bounded-contetx>/etc/bash/<any-existant-bash-script>
```
