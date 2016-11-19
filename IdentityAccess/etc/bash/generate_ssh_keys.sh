#!/usr/bin/env bash

export PASS_PHRASE='kretataskmanager'

openssl genrsa -passout env:PASS_PHRASE -out IdentityAccess/var/jwt/private.pem -aes256 4096
openssl rsa -pubout -in IdentityAccess/var/jwt/private.pem -out IdentityAccess/var/jwt/public.pem -passin env:PASS_PHRASE
