#Installation

To run Kreta locally we highly recommend using our Docker environment. It provides all you need kreta with ease. Before
starting make sure you have already installed [Docker](https://www.docker.com/) in your machine.

## Installation

1. Copy the file located at `<kreta-root>/etc/docker/.env.dist` to `<kreta-root>/etc/docker/.env` and change the values
according to your needs.

2. Update your system host file

    Add this line to /etc/hosts 
    ```bash
    127.0.0.1 kreta.localhost taskmanager.localhost identityaccess.localhost
    ```

3. Execute this command 

    ```
    sh etc/bash/docker.sh [-f This optional flag load fixtures with fake data]
    ```

4. Enjoy :-)

> You can have more info if you visit [Creating dev environment with docker docs](../etc/docker/README.md) 
