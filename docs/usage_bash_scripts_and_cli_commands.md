# Bash scripts and CLI commands

Each Kreta bounded context has many bash scripts and CLI commands that
provide access to many actions. In order to standardize the usage of
them, these are the steps you have to follow:

To access Symfony CLI application you should execute something like
this from the root directory of Kreta:
```bash
$ <bounded-context>/etc/bin/symfony-console
```

To simplify the process of database loading or web server start you can
execute ready to use bash scripts in the following way, from the root
directory too:
```bash
$ <bounded-context>/etc/bash/load_databse.sh
$ <bounded-context>/etc/bash/server_start.sh

$ <bounded-context>/etc/bash/<any-existant-bash-script>
```

## Global scripts
To make batch processes like the installation of all Bounded Contexts,
pass tests across the project or check the CS you can execute
the bash scripts that are located inside `etc/bash` directory:
```bash
$ etc/bash/install.sh
$ etc/bash/tests.sh
$ etc/bash/cs.sh

... (check the directory to discover more interesting scripts)
```
