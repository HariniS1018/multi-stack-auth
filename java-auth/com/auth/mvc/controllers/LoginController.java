package com.auth.mvc.controllers;

import com.auth.mvc.functions.SuperFuncs;
import com.auth.mvc.models.LoginMod;

public class LoginController {
	public static void loginUser(){
		System.out.println("Enter your registered username: ");
		String user = SuperFuncs.input.nextLine();
		System.out.println("Enter your password: ");
		String pwd = SuperFuncs.input.nextLine();
		String securedPwd = SuperFuncs.getMd5(pwd);
		if(LoginMod.retrieveUser(user,securedPwd))
			System.out.println("The entered username and password is valid");
		else
			System.out.println("The entered username and password is invalid");
	}	
}

