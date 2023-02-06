FROM node:12

# Create app directory
WORKDIR /meuzm-app

# Install app dependencies
# A wildcard is used to ensure both package.json AND package-lock.json are copied
# where available (npm@5+)
#COPY package*.json ./
COPY . /meuzm-app

# If you are building your code for production
# RUN npm ci --only=production



# # Bundle app source
# COPY . .

EXPOSE 8005
CMD [ "npm", "run", "start" ]