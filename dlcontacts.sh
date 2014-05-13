#!/bin/sh
fname=contacts.csv
if [ $# -eq 1 ]; then
    fname=$1
fi

flds=name,email,address,birthday,event,notes,organization,phone,relation,title,website

echo $flds > $fname
google -u timmy.whelan@gmail.com -n '.*' --fields="$flds" contacts list >> $fname
