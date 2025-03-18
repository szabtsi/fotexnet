# Use an official Node runtime as the base image
FROM node:20-alpine

# Set the working directory in the container to /app
WORKDIR /app

# Copy package.json and package-lock.json to the working directory
COPY package*.json ./

# Install any needed packages specified in package.json
RUN npm install

# Bundle app source
COPY . .

# Make port 5174 available to the world outside this container
EXPOSE 5174

# Run the command to start the app
CMD ["npm", "run", "dev"]
