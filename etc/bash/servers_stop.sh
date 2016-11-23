#!/usr/bin/env bash

cd IdentityAccess
sh etc/bash/server_stop.sh
cd ..

cd TaskManager
sh etc/bash/server_stop.sh
cd ..
