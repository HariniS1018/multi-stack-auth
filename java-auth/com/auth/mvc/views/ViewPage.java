package com.auth.mvc.views;

import com.auth.mvc.controllers.RegisterController;
import com.auth.mvc.controllers.LoginController;
import static com.auth.mvc.functions.SuperFuncs.input;

public class ViewPage {
	public static void main(String[] args)
	{
		System.out.println("Are you a new user? Enter yes or no: ");
		String response = input.next();
		String lowerResponse = response.toLowerCase();
		if(lowerResponse.startsWith("y")) {
			RegisterController.registerUser();
		}
		else {
			LoginController.loginUser();
		}		
	}
}
