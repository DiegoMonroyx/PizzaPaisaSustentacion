# Etapa de construcción
FROM node:18-alpine AS builder

WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm install -g @angular/cli@15

# Build con verificación explícita
RUN ng build --configuration production && \
    ls -la /app/dist/la-pizza/browser/  # Verifica los archivos generados

# Etapa de producción
FROM nginx:1.25-alpine

# Limpieza y configuración
RUN rm -rf /usr/share/nginx/html/* /etc/nginx/conf.d/default.conf
COPY nginx-custom.conf /etc/nginx/conf.d/

# Copia SOLO los archivos del frontend (desde /browser)
COPY --from=builder /app/dist/la-pizza/browser /usr/share/nginx/html

# Verificación y permisos (ahora en una sola capa)
RUN ls -la /usr/share/nginx/html && \
    chown -R nginx:nginx /usr/share/nginx/html && \
    chmod -R 755 /usr/share/nginx/html

EXPOSE 4200
CMD ["nginx", "-g", "daemon off;"]