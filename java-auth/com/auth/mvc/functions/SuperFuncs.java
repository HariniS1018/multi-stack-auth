package com.auth.mvc.functions;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.math.BigInteger;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

import java.util.Scanner;
import java.util.regex.Pattern;

public class SuperFuncs{
	public static Scanner input = new Scanner(System.in);
	public static Connection con;
	
	static {
		try {
			String url = System.getenv("DB_URL");        // e.g. jdbc:mysql://HOST_NAME:PORT/DATABASE_NAME
			String user = System.getenv("DB_USER");      
			String password = System.getenv("DB_PASS");  

			con = DriverManager.getConnection(url, user, password);
		} catch (SQLException e) {
			e.printStackTrace();
		}
	}

	public static boolean checkPattern(String name,String pwd) {
		String pattern1 = "[A-Za-z0-9_]{5,20}";
		String pattern2 = "(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[_@!#$%]).{5,20}";
		boolean result = false;
		if(Pattern.matches(pattern1,name) && Pattern.matches(pattern2,pwd))
       		result = true;
		else
			result = false;
		return result;
	}
  
  	public static String getMd5(String input) {
		try {
			MessageDigest md = MessageDigest.getInstance("MD5");
			byte[] messageDigest = md.digest(input.getBytes());
			BigInteger no = new BigInteger(1,messageDigest);
			String hashtext = no.toString(16);
			while(hashtext.length()<32)
				hashtext = "0" + hashtext;
			return hashtext;
		}
		catch(NoSuchAlgorithmException e) {
			throw new RuntimeException (e);
		}
	}
}
