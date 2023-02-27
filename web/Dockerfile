FROM node:alpine AS builder

WORKDIR /app

COPY . .
RUN npm install

RUN yarn build

FROM nginx:1.19-alpine AS server
COPY --from=builder /app/build /usr/share/nginx/html
EXPOSE 80