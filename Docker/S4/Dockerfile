# Specify base image
FROM node:alpine

# WORKDIR --> TO PREVENT OVERRIDES
WORKDIR /usr/app

# Install some devs
COPY ./package.json ./
RUN npm install
COPY ./ ./

# Default commad
CMD ["npm","start"]