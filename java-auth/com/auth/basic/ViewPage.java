package com.auth.basic;

import java.math.BigInteger;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.sql.DriverManager;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.Statement;
import java.util.Scanner;


public class ViewPage {
	static Scanner input = new Scanner(System.in);
	static Connection con;
	static Statement st;
	static ResultSet rs;

	static {
		try {
			String url = System.getenv("DB_URL");        // e.g. jdbc:mysql://HOST_NAME:PORT/DATABASE_NAME
			String user = System.getenv("DB_USER");      
			String password = System.getenv("DB_PASS");  

			con = DriverManager.getConnection(url, user, password);
			st = con.createStatement();
		} catch (Exception e) {
			e.printStackTrace();
		}
	}
	public static void main(String[] args)
	{
		System.out.println("new user? Enter yes or no: ");
		String yes = input.next();
		String yes2 = yes.toLowerCase();
		if(yes2.equals("yes")) {
			Registration.register();
		}
		else {
			LoginPage.log_in();
		}		
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