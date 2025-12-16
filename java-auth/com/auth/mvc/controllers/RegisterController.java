package com.auth.mvc.controllers;

import com.auth.mvc.functions.SuperFuncs;
import com.auth.mvc.models.RegisterMod;

public class RegisterController {
	public static void registerUser() {
		System.out.println("Enter your user name: ");
		String name = SuperFuncs.input.nextLine();
		System.out.println("Enter a valid password: ");
		String pwd = SuperFuncs.input.nextLine();
		if(SuperFuncs.checkPattern(name,pwd)) {
			String securePwd = SuperFuncs.getMd5(pwd);
			RegisterMod.storeUser(name, securePwd);
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
