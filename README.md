# cacti
cacti host template

## Installation

1. copy scripts file to under cacti's scripts directory
2. import xml files
3. edit some values as your needs

## Nginx

1. for nginx status, put below config to nginx conf file

```
location /nginx-status {
        stub_status on;
        access_log  off;
        allow       10.0.0.0/8;
        deny        all;
    }
```

## Tomcat

1. import xml file
2. go to cacti console menu
3. click data input method
4. find & select "Tomcat status"
5. change tomcat manager account information in Input strings
6. done.
