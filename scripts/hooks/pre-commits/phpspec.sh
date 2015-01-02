#!/bin/sh

# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

if [[ -f ./bin/phpspec ]]; then
    ./bin/phpspec run
    if [[ $? != 0 ]]; then
       printf "${RED}✘ PHPSpec has failed - commit aborted${NORMAL}\n\n"
       exit 1
    fi
    printf "${GREEN}✔ The specs successfully passed!${NORMAL}\n\n"
fi
