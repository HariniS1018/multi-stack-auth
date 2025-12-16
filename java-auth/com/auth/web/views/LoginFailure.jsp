<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Login Failed</title>
</head>
<body>
    <div style="color:red">
        Sorry ${uname}, you have failed to log in :(
    </div>
    <form action="Login.jsp">
        <input type="submit" value="Back"/>
    </form>
</body>
</html>