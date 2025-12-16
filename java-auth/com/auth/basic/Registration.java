package com.auth.basic;

import java.sql.PreparedStatement;
import java.util.Scanner;


public class Registration extends ViewPage {
	public static String pwd = "";
	public static void register() {
		try (Scanner input = new Scanner(System.in)) {
			System.out.println("Enter your user name: ");
			String name = input.next();
			System.out.println("Enter a valid password: ");
			pwd = input.next();
			if(Check.checking(name,pwd) == true) {
				String pwd2 = getMd5(pwd);
				try {
					PreparedStatement stmt = con.prepareStatement("INSERT INTO security(username, password) VALUES(?, ?)");
					stmt.setString(1, name);
					stmt.setString(2, pwd2);
					stmt.executeUpdate();
					System.out.println("your account has been successfully created to use....");
				}
				catch(Exception e){
					System.out.println(e);
				}
			}
			else {
				System.out.println("Your username or password is not in required format");
				System.out.println("Your username must contain a lowercase, an uppercase and a digit");
				System.out.println("Your password must satisfy the following criteria:");
				System.out.println("\n 1.Your password length must be above 8 and below 20 characters\n 2.Your pwd should contain a lowercase an uppercase and a digit");
				System.out.println("3. It must also contain a special character excluding whitespaces\n");
			}
		}
	}
}
