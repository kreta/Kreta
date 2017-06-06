#!/usr/bin/env bash
envsubst '${COMPOSITE_UI_HOST}' < /etc/nginx/sites-available/compositeui.template > /etc/nginx/sites-enabled/compositeui.conf
envsubst '${TASK_MANAGER_HOST} ${SYMFONY_ENV}' < /etc/nginx/sites-available/taskmanager.template > /etc/nginx/sites-enabled/taskmanager.conf
envsubst '${IDENTITY_ACCESS_HOST} ${SYMFONY_ENV}' < /etc/nginx/sites-available/identityaccess.template > /etc/nginx/sites-enabled/identityaccess.conf
envsubst '${NOTIFIER_HOST} ${SYMFONY_ENV}' < /etc/nginx/sites-available/notifier.template > /etc/nginx/sites-enabled/notifier.conf
nginx
