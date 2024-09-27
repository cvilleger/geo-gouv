#!/bin/bash

DEPARTEMENTS_URL="https://geo.api.gouv.fr/departements?fields=nom,code,codeRegion,region"
DEPARTEMENTS_FILENAME="./resources/departements.json"
COMMUNE_DEPARTEMENT_FILENAME_START="./resources/commune-departement"
COMMUNES_URL_START="https://geo.api.gouv.fr/departements/"
COMMUNES_URL_END="/communes?fields=nom,code,codesPostaux,centre,surface,population,departement,region"

curl "$DEPARTEMENTS_URL" -o "$DEPARTEMENTS_FILENAME"

# Use jq to extract all the 'code' attributes into a bash array
DEPARTEMENTS_CODES=($(jq -r '.[].code' "$DEPARTEMENTS_FILENAME"))

# Print the array to verify the extracted codes
echo "DEPARTEMENTS_CODES: ${DEPARTEMENTS_CODES[@]}"

for DEP_CODE in "${DEPARTEMENTS_CODES[@]}"; do
  curl "$COMMUNES_URL_START""$DEP_CODE""$COMMUNES_URL_END" -o "$COMMUNE_DEPARTEMENT_FILENAME_START"-"$DEP_CODE".json
  sleep 0.1
done
