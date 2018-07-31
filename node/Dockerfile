FROM node:latest
RUN apt-get update -qq && apt-get install -y build-essential libpq-dev libkrb5-dev
RUN mkdir /nodeapitest
WORKDIR /nodeapitest
ADD package.json /nodeapitest/package.json
RUN npm install
RUN npm install socket.io
ADD . /nodeapitest
CMD [ "npm", "start" ]
