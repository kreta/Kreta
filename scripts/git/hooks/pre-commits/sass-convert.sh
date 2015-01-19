#!/bin/sh

# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

function check_sass() {
    if [[ -a `which sass-convert` ]]; then
        has_scss_modifications=$(git status  -sb |grep  -E "^(A|M).*\.(scss|sass)"|awk '{split($0,a,/\ +/);print a[2]}')
        if [[ -n "$has_scss_modifications" ]]; then
            echo "Checking to ensure your Sass changes are totally rad…"
            for f in $has_scss_modifications
            do
                echo "Sass cleaning: $f"
                sass-convert -F scss -T scss -i $f
                git add $f
                if [[ $? != 0 ]]; then
                    printf "${RED}✘ Hrmmm… Looks like we found an error with '$f'\nPlease address the error(s) before continuing with the commit ${NORMAL}\n\n"
                    exit 1
                 fi
            done
            printf "${GREEN}✔ Congrats! You've written some sassy Sass!${NORMAL}\n\n"

        fi
    fi
}

check_sass
