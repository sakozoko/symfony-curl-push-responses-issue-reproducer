from http.server import SimpleHTTPRequestHandler, HTTPServer

class Handler(SimpleHTTPRequestHandler):
    def end_headers(self):
        if self.path == "/" or self.path == "/index.html":
            self.send_header("Link", "</style.css>; rel=preload; as=style")
            self.send_header("Link", "</style1.css>; rel=preload; as=style")
            self.send_header("Link", "</style2.css>; rel=preload; as=style")
            self.send_header("Link", "</style3.css>; rel=preload; as=style")
        super().end_headers()


HTTPServer(("0.0.0.0", 8080), Handler).serve_forever()
