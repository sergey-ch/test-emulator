# our base image
FROM nginx

RUN mkdir -p /var/www/dev
WORKDIR /var/www/dev

RUN apt-get update && apt-get install -y \
curl tar git nano

RUN mkdir -p /var/go && cd /var/go
RUN curl -O https://storage.googleapis.com/golang/go1.11.2.linux-amd64.tar.gz
RUN tar -C /usr/local -xzf go1.11.2.linux-amd64.tar.gz && rm go1.11.2.linux-amd64.tar.gz
ENV PATH $PATH:/usr/local/go/bin
ENV GOPATH $HOME/work
ENV PATH $PATH:$GOPATH/bin
RUN go get github.com/jsha/minica