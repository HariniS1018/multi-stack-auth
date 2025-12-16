package com.auth.basic;

import java.sql.PreparedStatement;


public class LoginPage extends ViewPage {
	public static void log_in(){
		System.out.println("Enter your registered username: ");
		String user = input.next();
		System.out.println("Enter your password: ");
		String pwd = input.next();
		String pwd2 = getMd5(pwd);
		String dbuser = null, dbpass = null;
		try {
			PreparedStatement stmt = con.prepareStatement("SELECT username, password FROM security WHERE username = ?");
			stmt.setString(1, user);
			rs = stmt.executeQuery();
			if(rs.next()) {
				dbuser = rs.getString(1);
				dbpass = rs.getString(2);
				if(user.equals(dbuser)&& pwd2.equals(dbpass))
					System.out.println("The entered username and password is valid");
				else
					System.out.println("The entered username and password is invalid");
			} else {
				System.out.println("No such user found.");
			}
		}
		catch(Exception e){
			System.out.println(e);
		}
	}	
}

