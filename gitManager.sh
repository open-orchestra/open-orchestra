#!/bin/bash

function usage(){
    printf "Script usage:\n"
    printf " -h     Print script help\n"
    printf " -c     Give the git command to execute on all repository\n"
    printf " -r     Do only a rebase of all the repos\n"
    printf " -t     Give the tag version\n"
    printf " -m     Add a commit or tag message (mandatory to commit or tag)\n"
    printf " -b     Add a branch name (mandatory to commit)\n"
    printf " -a     Add all the modified file to the commit\n"
    printf " -f     Do a force commit\n"
}

if [ $# -eq 0 ]
then
    usage

    exit 1
fi

all=false
command=false
rebase=false
tag=false
message='noMessage'
branch_name='noBranch'
force_param=''
titleColor=`tput setaf 3`
reset=`tput sgr0`

while getopts "shrafm:b:c:t:" arg; do
    case $arg in
        h)
            usage
            ;;
        c)
            command=$OPTARG
            ;;
        a)
            all=true
            ;;
        m)
            message=$OPTARG
            ;;
        r)
            rebase=true
            ;;
        b)
            branch_name=$OPTARG
            ;;
        f)
            force_param=' -f'
            ;;
        t)
            tag=$OPTARG
            ;;
        esac
    done

cd vendor/open-orchestra
list=`ls | grep open-orchestra`

if [ $command != false ]
then
    for i in $list
    do
        printf "\n"
        echo "${titleColor}$i${reset}"
        printf "\n"
        cd $i
        git $command
        cd ..
    done
elif $rebase = true
then
    for i in $list
    do
        printf "\n"
        echo "${titleColor}$i${reset}"
        printf "\n"
        cd $i
        git status
        git stash
        git fetch -p
        git pull --rebase origin master
        git stash pop
        git status
        cd ..
    done
elif [ $message = 'noMessage' ] && [ $branch_name = 'noBranch' ]
then
    printf "Impossible d'utiliser le script avec les parametres '${message}' et '${branch_name}' \n"
elif [ $tag != false ]
then
    for i in $list
    do
        printf "\n"
        echo "${titleColor}$i${reset}"
        printf "\n"
        cd $i
        git status
        git tag -a $tag -m "$message"
        git push origin --tags
        cd ..
    done
else
    for i in $list
    do
        printf "\n"
        echo "${titleColor}$i${reset}"
        printf "\n"
        cd $i
        git fetch -p
        git status
        git add -p
        if $all = true
        then
            git add ./
        fi
        git commit -m "$message"
        git pull --rebase origin master
        git push origin master:$branch_name $force_param
        cd ..
    done
fi
