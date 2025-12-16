package com.auth.mvc.models;

import java.sql.ResultSet;
import java.sql.PreparedStatement;

import com.auth.mvc.functions.SuperFuncs;

public class LoginMod {
	public static boolean retrieveUser(String name, String pwd){
		boolean result = false;
		
		try {
			PreparedStatement stmt = SuperFuncs.con.prepareStatement(
                "SELECT username, password FROM security WHERE username = ?"
            );
			stmt.setString(1, name);
            ResultSet rs = stmt.executeQuery();

			if (rs.next()) {
                String dbuser = rs.getString("username");
                String dbpass = rs.getString("password");

				if(name.equals(dbuser)&& pwd.equals(dbpass))
						result = true;
			}

			rs.close();
			stmt.close();
		}
    		catch(Exception e) {
			System.out.println(e);
		}
		return result;
	}
}
