package com.auth.mvc.models;

import java.sql.PreparedStatement;
import com.auth.mvc.functions.SuperFuncs;

public class RegisterMod {
	public static void storeUser(String name,String pwd) {
    	try {
			PreparedStatement stmt = SuperFuncs.con.prepareStatement("insert into security values(?,?)");
			stmt.setString(1, name);
			stmt.setString(2, pwd);
			int rows = stmt.executeUpdate(); // actually performs the insert

            if (rows > 0) {
                System.out.println("Your account has been successfully created.");
            } else {
                System.out.println("Account creation failed.");
            }
			stmt.close();

		}
		catch(Exception e){
			System.out.println("Error during registration: " + e.getMessage());
		}
  	}
}
