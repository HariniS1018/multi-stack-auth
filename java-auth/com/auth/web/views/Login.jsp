<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Login Page</title>
<style>
    body { background-color: #73716d; }
    .outer-box {
        margin: auto;
        width: 30%;
        background-color: #242322;
        padding: 30px;
        margin-top: 150px;
        border-radius: 20px;
        border: 5px solid #ffc400;
        color: white;
    }
    #uname, #pword { width: 98%; margin-top: 10px; }
    #heading { text-align: center; font-size: 24px; font-weight: 1000; }
    #but { width: 45%; margin-top: 30px; height: 30px; background-color: #ffc400; border: none; }
    #but:hover { border: 2px solid black; background-color: #cc9d00; }
</style>
</head>
<body>
<form action="LoginServlet" method="post">
    <div class="outer-box">
        <div id="heading">LOGIN</div>
        <label for="uname">Username</label>
        <input type="text" id="uname" name="uname" required />
        <label for="pword">Password</label>
        <input type="password" id="pword" name="pword" required />
        <div>
            <input type="reset" id="but" value="Reset"/>
            <input type="submit" value="Submit" id="but" style="margin-left:30px"/>
        </div>
    </div>
</form>
</body>
</html>