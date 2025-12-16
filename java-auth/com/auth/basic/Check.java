package com.auth.basic;

import java.util.regex.Pattern;


public class Check {
	public static boolean checking(String name,String pwd) {
		String pattern1 = "[A-Za-z0-9_]{5,20}";
		String pattern2 = "(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[_@!#$%]).{5,20}";
		boolean valid = Pattern.matches(pattern1,name) && Pattern.matches(pattern2,pwd);
		if(valid) {
			System.out.println("Valid !");
		}
		else {
			System.out.println("invalid");
		}
		return valid;
	}
}

