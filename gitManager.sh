#!/bin/bash

function usage(){
    printf "Script usage:\n"
    printf " -h     Print script help\n"
    printf " -c     Give the git command to execute on all repository\n"
    printf " -r     Do only a rebase of all the repos\n"
    printf " -m     Add a commit message (mandatory to commit)\n"
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
message='noMessage'
branch_name='noBranch'
force_param=''

while getopts "shrafm:b:c:" arg; do
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
        esac
    done

cd vendor/itkg
list=`ls | grep phporchestra`

if [ $command != false ]
then
    for i in $list
    do
        printf "\n"
        echo $i
        printf "\n"
        cd $i/PHPOrchestra
        git $command
        cd ../..
    done
elif $rebase = true
then
    for i in $list
    do
        printf "\n"
        echo $i
        printf "\n"
        cd $i/PHPOrchestra
        git status
        git stash
        git pull --rebase origin master
        git stash pop
        git status
        cd ../..
    done
elif [ $message = 'noMessage' ] && [ $branch_name = 'noBranch' ]
then
    printf "Impossible d'utiliser le script avec les parametres '${message}' et '${branch_name}' \n"
else
    for i in $list
    do
        printf "\n"
        echo $i
        printf "\n"
        cd $i/PHPOrchestra
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
        cd ../..
    done
fi
