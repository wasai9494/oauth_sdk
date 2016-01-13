#	单一入口登陆php版sdk
index.php为入口文件，调用login方法重定向到登陆页面，调用checkToken验证返回的token是否有效.
###使用之前需要先和服务器端确认好key和回调方法

使用方法 
##第一步
```PHP
//使用命名空间 
use btldapsdk\Bt_ldap_sdk; 

//载入入口文件 
require_once 'index.php'; 
```
##第二步
```
//获取一个登陆sdk的实例 
$bt = new Bt_ldap_sdk({appid},{加密key},{回调地址}); 

//调用login方法直接跳转到登陆页面进行授权，授权成功后会返回token 
$bt->login(); 
登陆成功后会调转到 回调地址 并带有一个token串
```
##第三步
```
//调用checkToken方法，检测token的合法性，并返回值 
$result = $bt->checkToken($_GET['token']); 
```
```
返回值为json格式: 
成功: $result = {"status":true,"info":{"username":"test"}} 
失败: $result = {"status":false,"info":{"username":"null"}} 
```

status|是否成功|bool
--------|---------|-----
username	|成功后的用户名|string Or Null


##第四步
使用返回回来的username进行用户权限认证

##nginx配置

```NGINX
server {
        listen       3000;
        root         /var/www/html/OAuth_SDK/;
        index       example.php;

        location ~ \.php$ {
                fastcgi_pass   phpfpm:9000;
                include        fastcgi_params;
                fastcgi_param  SCRIPT_FILENAME  $document_root/example.php;

        }
}
```

