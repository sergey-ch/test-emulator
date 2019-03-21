#!/bin/bash

base_path="$(cd "$(dirname "$0")" && pwd)/ssl"
domain="dev,dev.local"

cd "${base_path}"

if [ ! -f ${base_path}"/dev/cert.pem" ]
then
    echo "Gen ssl certs for domains "${domain}
    minica --domains ${domain}
fi