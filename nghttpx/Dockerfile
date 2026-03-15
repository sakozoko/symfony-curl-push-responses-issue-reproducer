FROM alpine:latest

RUN apk add --no-cache \
    nghttp2 \
    ca-certificates \
    openssl

WORKDIR /etc/nghttpx

RUN openssl req -x509 -nodes -days 365 \
    -newkey rsa:2048 \
    -keyout server.key \
    -out server.crt \
    -subj "/C=US/ST=State/L=City/O=Org/OU=Unit/CN=localhost"

CMD ["nghttpx", "--help"]
