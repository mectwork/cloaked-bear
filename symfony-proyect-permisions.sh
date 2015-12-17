#!/bin/bash

#-----------------------------------------------------------------------------
# Variables declaration
#-----------------------------------------------------------------------------

# Colors constants
NONE="$(tput sgr0)"
RED="$(tput setaf 1)"
GREEN="$(tput setaf 2)"
YELLOW="\n$(tput setaf 3)"
BLUE="\n$(tput setaf 4)"

USERNAME="root"
APACHE_USERNAME="www-data"
#-----------------------------------------------------------------------------
# Functions
#-----------------------------------------------------------------------------

message () {
    # $1 : Message
    # $2 : Color
    # return : Message colorized
    local NOW="[$(date +%H:%M:%S)]"

    echo -e "${2}${NOW}${1}${NONE}"
}

execute() {
	# NodeJS command
    echo " -> Looking for ACL command..."
    if ! type setfacl 2>/dev/null ; then
        message "[ERROR] setfacl command not found. Please install it." ${RED}
        exit 1
    fi

	# Check Symfony console command
    echo " -> Looking for Symfony Console Command"
    local SF=$(php app/console 2>&1 | grep 2.[3-7].[0-9]*)
    if test "${SF}" ; then
    	message "[INFO] Found ${SF}" ${BLUE}
    else
        php -v
        message "[ERROR] Not Found or Found an Incompatible Symfony version." ${RED}
        exit 1
    fi

    # Check main operating system
    case "$OSTYPE" in
        freebsd*)
            message "[INFO] Running on FreeBSD" ${GREEN}
            OS="FREEBSD"
            ;;
        linux*)
            message "[INFO] Running on GNU/LINUX" ${GREEN}
            OS="GNULINUX"
            # Check for GNU/Linux Distros
            GNU_LINUX_DISTRO=$(lsb_release -i -s)
            message "[INFO] GNU / Linux distro: $GNU_LINUX_DISTRO" ${GREEN}
            ;;
        *)
            message "[INFO] Running on Other OS: $OSTYPE" ${YELLOW}
            ;;
    esac

	message "[INFO] Deleting cache and logs..." ${YELLOW}
    sudo rm -r app/cache/*
	sudo rm -r app/logs/*
	message "[INFO] Appling permissions to the developer user(${USERNAME}) and Apache user ${APACHE_USERNAME}..." ${YELLOW}
	sudo chown -R ${USERNAME}:${APACHE_USERNAME} app/cache app/logs
	message "[INFO] Appling access permissions 775..." ${YELLOW}
	sudo chmod -R 775 app/cache app/logs
	message "[INFO] Appling ACL permissions..." ${YELLOW}
	sudo setfacl -ndR -m u:root:rwx -m u:www-data:rwx app/cache app/logs
	sudo setfacl -nR -m u:root:rwx -m u:www-data:rwx app/cache app/logs
}

#-----------------------------------------------------------------------------
# Main
#-----------------------------------------------------------------------------

main() {
    message "[INFO] Starting appling permissions..." ${BLUE}

    # (1) Execute.
    execute

    message "[INFO] Applied permissions successfully." ${GREEN}
}

main "$@"
