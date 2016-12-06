#!/usr/bin/env bash

echo "Publishing the shared kernel..."
if [ $# -eq 0 ]; then
    echo "No tag argument provided"
    exit 1
fi

git tag -d $1

git subtree split -P SharedKernel/ -b shared-kernel
git tag -a $1 -m $1 shared-kernel
git push git@github.com:kreta/SharedKernel.git shared-kernel:master
git push git@github.com:kreta/SharedKernel.git shared-kernel:master --follow-tags
git branch -D shared-kernel
git tag -d $1
