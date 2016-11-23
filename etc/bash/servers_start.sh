#!/usr/bin/env bash

cd IdentityAccess
sh etc/bash/server_start.sh
cd ..

cd TaskManager
sh etc/bash/server_start.sh
cd ..
