# frontend/Dockerfile
FROM node:20-alpine

WORKDIR /app

# копируем package.json сначала для кеширования
COPY package*.json ./

# ставим зависимости
RUN npm ci --no-audit --no-fund

# копируем проект
COPY . .

EXPOSE 3000

ENV NODE_ENV=development
ENV NUXT_HOST=0.0.0.0
ENV NUXT_PORT=3000

CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0", "--port", "3000"]
