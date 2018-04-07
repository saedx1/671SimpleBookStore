function showMenu()
{
    var username = getCookie('username');
    if(username)
    {
        if(username == 'admin')
        {
            document.getElementById('admin').style.display = '';
            document.getElementById('signout').style.display = '';      
        }
        else
        {
            document.getElementById('myaccount').style.display = '';
            document.getElementById('signout').style.display = '';            
        }
    }
    else
    {
        document.getElementById('signin').style.display = '';
        document.getElementById('register').style.display = '';
    }
}
function signin(username)
{   
    createCookie("username", username, 0);
    redirect("index.php");
}
function signout()
{
    deleteCookie("username");
}
function createCookie(name, value, expires) {
  var cookie = name + "=" + escape(value) + ";";

  if (expires == -1) {
    expires = new Date(new Date().getTime() + parseInt(expires) * 1000 * 60 * 60 * 24);
    cookie += "expires=" + expires.toGMTString() + ";";
  }
  cookie += "path=/;";
  document.cookie = cookie;
}
function deleteCookie(name) {
  // If the cookie exists
  if (getCookie(name))
    createCookie(name, "", -1);
}
function getCookie(name) {
  var regexp = new RegExp("(?:^" + name + "|;\s*"+ name + ")=(.*?)(?:;|$)", "g");
  var result = regexp.exec(document.cookie);
  return (result === null) ? null : result[1];
}



function redirect(page)
{
    window.location = page;
}
