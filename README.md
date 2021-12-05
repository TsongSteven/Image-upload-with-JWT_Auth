# Image-upload-with-JWT_Auth_Symfony_5
This is Simple Application(with Heroku Config) to upload image(base64) to SqLite<br>
https://task-pranan.herokuapp.com/<br>
Please use Postman to check this API,<br>
following are the url<br>
<h3>Login</h3><br>
https://task-pranan.herokuapp.com/api/login<br>

```json
{
  "username":"admin",
  "password":"admin"
}
```
<h3>Register</h3><br>
https://task-pranan.herokuapp.com/api/register<br>

```json
{
  "username":"uname",
  "password":"upassword"
}
```
<h3>Get Image(s)</h3><br>
https://task-pranan.herokuapp.com/api/fetch/{search_by_name_or_image_tag}<br>
<h3>Admin Login with JWT Token</h3><br>
https://task-pranan.herokuapp.com/api/admin/post

```
  form_data:
    image_name: select_from_device
    tags: tag1 tag2 tag3 (Use Space to Separate the tags)
```
