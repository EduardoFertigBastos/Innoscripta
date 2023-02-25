FROM node:alpine AS builder

WORKDIR /user/app

COPY package*.json ./
RUN npm install

COPY . .

RUN yarn build
EXPOSE 3000


FROM nginx:1.19-alpine AS server
COPY --from=builder ./app/build /usr/share/nginx/html