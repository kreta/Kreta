#!/usr/bin/env bash

export PASS_PHRASE='kretataskmanager'

openssl genrsa -passout env:PASS_PHRASE -out var/jwt/private.pem -aes256 4096
openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem -passin env:PASS_PHRASE
