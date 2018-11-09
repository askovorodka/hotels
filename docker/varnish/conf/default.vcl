vcl 4.0;

import std;

backend default {
  .host = "nginx";
  .port = "80";
}

sub vcl_backend_response {
  set beresp.http.url = bereq.url;
  set beresp.grace = 1h;
}

sub vcl_deliver {
  unset resp.http.url;
}

sub vcl_recv {
  unset req.http.forwarded;

  # Don't cache in dev mode
  if (req.url ~ "^/app_dev.php") {
    return(pass);
  }

  # Don't cache admin
  if (req.url ~ "^/admin") {
    return(pass);
  }
}

sub vcl_hit {

}